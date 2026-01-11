<?php

namespace App\Controllers\Api\Publico;

use App\Helpers\Util as HelpersUtil;
use App\Models\PedidoModel;
use App\Models\PedidoDetalleModel;
use App\Models\UsuarioModel;
use App\Models\ProductoModel;
use App\Models\ComprobanteModel;
use App\Models\DestinoModel;
use App\Models\RecojoModel;
use App\Models\AgenciaModel;
use App\Models\CuponModel;
use App\Models\ProductoBaseModel;
use App\Models\EmpresaModel;
use App\Models\ProductoColorModel;
use App\Models\ProductoTallaModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

/**
 * Controlador para gestión de pedidos públicos vía API.
 */
class PedidoPublicoController extends ResourceController
{
    use ResponseTrait;

    protected $productoTalla;
    protected $pedidoDetalle;
    public function __construct()
    {
        date_default_timezone_set('America/Lima');
        $this->productoTalla = new ProductoTallaModel();
        $this->pedidoDetalle = new PedidoDetalleModel();
    }
    /**
     * Registra o actualiza un pedido público.
     * Valida datos, controla stock, guarda detalles, preferencias, comprobante, entrega y cupon.
     */
    public function GuardarPedidoNormal()
    {
        helper('filesystem');
        $request = service('request');
        log_message('info', 'Guardar pedido iniciado.');
        //CAPTURANDO DATOS DEL PEDIDO
        $referencia    = $request->getPost('referencia');
        $entrega       = $request->getPost('entrega');
        $fechaEntrega  = $request->getPost('fechaEntrega');
        $tienda        = $request->getPost('tienda');
        $formapago     = $request->getPost('formapago');
        $cupon         = $request->getPost('cupon');
        $observaciones = $request->getPost('observaciones');
        $terminos      = $request->getPost('terminos') ? true : false;
        $total         = $request->getPost('total');
        $subtotal      = $request->getPost('subtotal');
        $comision      = $request->getPost('comision');
        $descuento     = $request->getPost('descuento');
        $costoEnvio    = $request->getPost('costoenvio');
        $codigo        = $request->getPost('codigo');


        $idProductos        = $request->getPost('idProductos');        // Array
        $idProductoTallas   = $request->getPost('idProductoTallas');   // Array
        $cantidades         = $request->getPost('cantidades');         // Array
        $descuentoProductos = $request->getPost('descuentoProductos'); // Array


        // --- Normalizar arrays que llegan como strings separados por coma ---
        if (count($idProductoTallas) === 1 && strpos($idProductoTallas[0], ',') !== false) {
            $idProductoTallas = explode(',', $idProductoTallas[0]);
        }

        if (count($cantidades) === 1 && strpos($cantidades[0], ',') !== false) {
            $cantidades = explode(',', $cantidades[0]);
        }

        if (count($descuentoProductos) === 1 && strpos($descuentoProductos[0], ',') !== false) {
            $descuentoProductos = explode(',', $descuentoProductos[0]);
        }

        // Asegurar que no existan espacios
        $idProductoTallas   = array_map('trim', $idProductoTallas);
        $cantidades         = array_map('trim', $cantidades);
        $descuentoProductos = array_map('trim', $descuentoProductos);


        $constancia = $request->getFile('constancia');

        $destino = [
            'idDestino'  => $request->getPost('anteriores'),
            'alias'      => $request->getPost('ddireccion'),
            'nombres'    => $request->getPost('dnombres'),
            'apellidos'  => $request->getPost('dapellidos'),
            'idubigeo'  => $request->getPost('ddistrito'),
            'dni'        => $request->getPost('ddocumento'),
            'direccion'  => $request->getPost('ddireccion'),
            'referencia' => $request->getPost('dreferencia'),
            'telefono'   => $request->getPost('dtelefono'),
            'latitud'    => $request->getPost('dlatitud'),
            'longitud'   => $request->getPost('dlongitud'),
            'ubigeo'     => $request->getPost('dubigeo'),
        ];

        $usuario = [
            'idUsuario' => $request->getPost('usuario[idUsuario]') ?? null
        ];

        $comprobante = [
            'razonSocial' => $request->getPost('fnombres'),
            'documento'   => $request->getPost('bdocumento'),
            'nombres'     => $request->getPost('bnombres'),
            'ruc'         => $request->getPost('fdocumento'),
            'direccion'   => $request->getPost('fdireccion'),
            'ptipo'       => $request->getPost('tipocomprobante'),
            'ubigeo'      => $request->getPost('fdistrito'),
        ];

        $recojo = [
            'dni'      => $request->getPost('rdocumento'),
            'nombres'  => $request->getPost('rnombres'),
            'apellidos' => $request->getPost('rapellidos'),
            'telefono' => $request->getPost('rtelefono'),
            'tienda'     => $request->getPost('tienda'),
        ];

        $agencia = [
            'idAgencia' => $request->getPost('anteriores'),
            'agencia'   => $request->getPost('agencia'),
            'direccion' => $request->getPost('adireccion'),
            'nombres'   => $request->getPost('anombres'),
            'apellidos' => $request->getPost('aapellidos'),
            'dni'       => $request->getPost('adocumento'),
            'telefono'  => $request->getPost('atelefono'),
            'ubigeo'    => $request->getPost('adistrito'),
        ];

        try {
            //INICIAMOS EL PROCESO
            // --- Guardar o actualizar pedido principal ---
            $pedido = $this->guardarOrActualizarPedido($referencia, $usuario, $entrega, $costoEnvio, $comision, $subtotal, $descuento, $total, $fechaEntrega, $observaciones, $formapago);

            // --- Procesar archivo de constancia si existe ---
            if ($constancia && $constancia->isValid() && !$constancia->hasMoved()) {
                $this->procesarConstanciaArchivo($pedido, $constancia);
            } else {
                log_message('info', 'No se recibió archivo constancia o no es válido.');
            }


            // PROCESAMOS LOS PRODUCTOS DETALLES
            // --- Guardar detalles del pedido y controlar stock ---
            $this->procesarDetallesPedido($pedido, $idProductoTallas, $cantidades, $descuentoProductos);

            // PROCESAMOS LOS COMPROBANTES
            $this->procesarComprobante($pedido, $comprobante);


            // --- Procesar entrega según tipo ---
            $this->procesarEntrega($entrega, $pedido, $destino, $recojo, $agencia);

            // --- Procesar cupón si existe ---
            $this->procesarCupon($pedido, $cupon);

            $util = new HelpersUtil();

            $util->mailPedido($pedido->idpedido, 5);

            return $this->respond([
                "status" => "exito",
                "pedido" => $pedido,
                "mensaje" => "Pedido registrado con exito"
            ], 200);
        } catch (\Throwable $th) {
            log_message('error', 'Error en checkPedido: ' . $th->getMessage());
            log_message('error', 'Stack trace: ' . $th->getTraceAsString());
            return $this->fail([
                'errors' => ['Ocurrió un error inesperado: ' . $th->getMessage()],
                'status' => 'error'
            ], 500);
        }
        // var_dump($idProductoTallas);
        // die();
    }

    /**
     * Procesa el archivo de constancia si se adjunta en el pedido.
     */
    private function procesarConstanciaArchivo($pedido, $file)
    {
        log_message('info', 'Archivo constancia recibido: ' . $file->getName());
        log_message('info', 'Tamaño archivo: ' . $file->getSize() . ' bytes');
        log_message('info', 'Error código: ' . $file->getError() . ' (' . $file->getErrorString() . ')');

        if ($file->isValid() && !$file->hasMoved()) {
            $urlamigable = HelpersUtil::urls_amigables($pedido->referencia);
            $nombreArchivo = $pedido->idpedido . '-' . $urlamigable . '.' . $file->getExtension();

            $file->move(FCPATH . 'archivos/pedido', $nombreArchivo);
            log_message('info', 'Archivo constancia movido: ' . $nombreArchivo);

            $pedidoModel = new PedidoModel();
            $pedidoModel->update($pedido->idpedido, ['urlconstancia' => $nombreArchivo]);

            // Opcional: actualizar la variable local para que el objeto $pedido tenga la info
            $pedido->urlconstancia = $nombreArchivo;
        } else {
            log_message('error', 'Archivo constancia no válido o ya movido.');
        }
    }

    /**
     * Procesa los detalles del pedido, controla stock y guarda preferencias si existe y  actualiza si no
     */
    private function procesarDetallesPedido($pedido, $idProductoTallas, $cantidades, $descuentoProductos)
    {
        $pedidoDetalleModel = new PedidoDetalleModel();
        $productoTallaModel = new ProductoTallaModel();
        $productoColorModel = new ProductoColorModel();
        $productoModel = new ProductoModel();

        foreach ($idProductoTallas as $key => $productoTallaId) {
            $productoTallaIdLimpio = trim($productoTallaId, '"');
            log_message('info', 'Buscando producto con ID: ' . $productoTallaIdLimpio);

            $productoTalla = $productoTallaModel->find($productoTallaIdLimpio);
            if (!$productoTalla) {
                log_message('error', 'Producto talla no encontrada con ID: ' . $productoTallaIdLimpio);
                continue;
            }

            $productoColor = $productoColorModel->find($productoTalla->idproductocolor);
            if (!$productoColor) {
                log_message('error', 'Producto color no encontrado para idproductocolor: ' . $productoTalla->idproductocolor);
                continue;
            }

            $producto = $productoModel->find($productoColor->idproducto);
            if (!$producto) {
                log_message('error', 'Producto no encontrado con ID: ' . $productoColor->idproducto);
                continue;
            }

            $cantidad = intval($cantidades[$key]);
            $descuentoProducto = isset($descuentoProductos[$key]) && $descuentoProductos[$key] ? floatval($descuentoProductos[$key]) : 0;
            $precioUnitario = floatval($producto->precioventa);
            $totalProducto = ($precioUnitario * $cantidad) - $descuentoProducto;

            // --- Verificar si el detalle ya existe ---
            $detalleExistente = $pedidoDetalleModel
                ->where('idpedido', $pedido->idpedido)
                ->where('idproductotalla', $productoTalla->idproductotalla)
                ->first();

            if ($detalleExistente) {
                $pedidoDetalleModel->update($detalleExistente->idpedidodetalle, [
                    'cantidad'  => $cantidad,
                    'peso'      => floatval($producto->peso),
                    'precio'    => $precioUnitario,
                    'descuento' => $descuentoProducto,
                    'total'     => $totalProducto,
                ]);
                log_message('info', "Detalle actualizado - idpedidodetalle: {$detalleExistente->idpedidodetalle}, idproductotalla: {$productoTalla->idproductotalla}");
            } else {
                $idPedidoDetalle = $pedidoDetalleModel->insert([
                    'idpedido'        => $pedido->idpedido,
                    'idproductotalla' => $productoTalla->idproductotalla,
                    'cantidad'        => $cantidad,
                    'peso'            => floatval($producto->peso),
                    'precio'          => $precioUnitario,
                    'descuento'       => $descuentoProducto,
                    'total'           => $totalProducto,
                ], true);
                log_message('info', "Detalle insertado - idpedidodetalle: {$idPedidoDetalle}, idproductotalla: {$productoTalla->idproductotalla}");
            }

            // --- DESCONTAR STOCK REAL ---
            if ($productoTalla->stock >= $cantidad) {
                $nuevoStock = $productoTalla->stock - $cantidad;
                $productoTallaModel->update($productoTalla->idproductotalla, [
                    'stock' => $nuevoStock
                ]);

                log_message('info', "Stock descontado: ProductoTalla {$productoTalla->idproductotalla}, Nuevo stock: {$nuevoStock}");
            } else {
                log_message('error', "Stock insuficiente para ProductoTalla {$productoTalla->idproductotalla}");
                throw new \Exception("Stock insuficiente para el producto '{$producto->nombre}' (talla {$productoTalla->talla}).");
            }
        }
    }



    /**
     * Procesa el comprobante y lo asocia al pedido.
     */
    private function procesarComprobante($pedido, $comprobante)
    {
        $comprobanteModel = new ComprobanteModel();
        log_message('info', '📄 Datos comprobante recibidos: ' . json_encode($comprobante));

        // --- Aseguramos que ptipo sea un entero ---
        $idPtipo = isset($comprobante['ptipo']) ? intval($comprobante['ptipo']) : null;

        // --- Lógica según tipo de comprobante ---
        if ($idPtipo === 445) { // Boleta
            $razonSocial = $comprobante['nombres'] ?? null;
            $ruc = $comprobante['documento'] ?? null;
        } elseif ($idPtipo === 446) { // Factura
            $razonSocial = $comprobante['razonSocial'] ?? null;
            $ruc = $comprobante['ruc'] ?? null;
        } else { // Otros tipos
            $razonSocial = $comprobante['razonSocial'] ?? $comprobante['nombres'] ?? null;
            $ruc = $comprobante['ruc'] ?? $comprobante['documento'] ?? null;
        }

        $comprobanteData = [
            'idusuario'   => $pedido->idusuario,
            'idestado'    => 363,
            'idptipo'     => $idPtipo,
            'razonsocial' => $razonSocial,
            'ruc'         => $ruc,
            'direccion'   => $comprobante['direccion'] ?? null,
            'idubigeo'    => $comprobante['ubigeo']['idUbigeo'] ?? null,
            'fecha'       => date('Y-m-d H:i:s'),
        ];

        // --- Insertar o actualizar comprobante ---
        if (!empty($comprobante['idcomprobante'])) {
            $comprobanteModel->update($comprobante['idcomprobante'], $comprobanteData);
            $idComprobante = $comprobante['idcomprobante'];
            log_message('info', '✅ Comprobante actualizado: ' . $idComprobante);
        } else {
            $idComprobante = $comprobanteModel->insert($comprobanteData);
            log_message('info', '🆕 Comprobante insertado con ID: ' . $idComprobante);
        }

        // --- Asociar comprobante con el pedido ---
        $db = \Config\Database::connect();
        $db->table('pedido_comprobante')->replace([
            'idpedido'      => $pedido->idpedido,
            'idcomprobante' => $idComprobante,
        ]);
        log_message('info', '🔗 Relación pedido_comprobante insertada o actualizada correctamente.');

        return $idComprobante;
    }


    /**
     * Procesa la entrega según el tipo (Destino, Recojo, Agencia).
     */
    private function procesarEntrega($entrega, $pedido, $destino, $recojo, $agencia)
    {
        $db = \Config\Database::connect();
        switch ($entrega) {
            case 1: // Destino
                $destinoModel = new \App\Models\DestinoModel();
                log_message('info', 'Datos destino: ' . json_encode($destino));
                $destinoData = [
                    'idusuario' => $pedido->idusuario ?? 0,
                    'idestado'  => 243,
                    'idubigeo'  => $destino['idubigeo'] ?? null,
                    'alias'     => $destino['alias'] ?? '',
                    'nombres'   => $destino['nombres'] ?? '',
                    'apellidos' => $destino['apellidos'] ?? '',
                    'dni'       => $destino['dni'] ?? '',
                    'direccion' => $destino['direccion'] ?? '',
                    'referencia' => $destino['referencia'] ?? '',
                    'telefono'  => $destino['telefono'] ?? '',
                    'latitud'   => $destino['latitud'] ?? null,
                    'longitud'  => $destino['longitud'] ?? null,
                    'fecha'     => $destino['fecha'] ?? date('Y-m-d H:i:s'),
                ];
                if (!empty($destino['idpedido'])) {
                    $destinoModel->update($destino['idpedido'], $destinoData);
                    $idDestino = $destino['idpedido'];
                    log_message('info', 'Destino actualizado para pedido: ' . $destino['idpedido']);
                } else {
                    $idDestino = $destinoModel->insert($destinoData);
                    log_message('info', 'Destino insertado nuevo con ID: ' . $idDestino);
                }
                $db->table('pedido_destino')->replace([
                    'idpedido'  => $pedido->idpedido,
                    'iddestino' => $idDestino,
                ]);
                log_message('info', 'Relación pedido_destino insertada/actualizada con idusuario');
                break;

            case 2: // Recojo
                $recojoModel = new \App\Models\RecojoModel();
                log_message('info', 'Datos recojo antes de ajuste: ' . json_encode($recojo));

                $recojoData = [
                    'idusuario' => $pedido->idusuario ?? 0,
                    'idestado'  => 335,
                    'idtienda'    =>  $recojo['tienda'] ?? '',
                    'dni'       => $recojo['dni'] ?? '',
                    'nombres'   => $recojo['nombres'] ?? '',
                    'apellidos' => $recojo['apellidos'] ?? '',
                    'telefono'  => $recojo['telefono'] ?? '',
                    'fecha'     => $recojo['fecha'] ?? date('Y-m-d H:i:s'),
                ];
                if (!empty($recojo['idpedido'])) {
                    $recojoModel->update($recojo['idpedido'], $recojoData);
                    $idRecojo = $recojo['idpedido'];
                    log_message('info', 'Recojo actualizado para pedido: ' . $recojo['idpedido']);
                } else {
                    $idRecojo = $recojoModel->insert($recojoData);
                    log_message('info', 'Recojo insertado nuevo con ID: ' . $idRecojo);
                }
                $db->table('pedido_recojo')->replace([
                    'idpedido'  => $pedido->idpedido,
                    'idrecojo'  => $idRecojo,
                ]);
                log_message('info', 'Relación pedido_recojo insertada/actualizada con idusuario');
                break;

            case 3: // Agencia
                $agenciaModel = new \App\Models\AgenciaModel();
                log_message('info', 'Datos agencia: ' . json_encode($agencia));

                $agenciaData = [
                    'idusuario' => $agencia['usuario']['idUsuario'] ?? $pedido->idusuario ?? 0,
                    'idestado'  => 367,
                    'idubigeo'  => $agencia['ubigeo'] ?? '',
                    'agencia'   => $agencia['agencia'] ?? '',
                    'direccion' => $agencia['direccion'] ?? '',
                    'referencia' => $agencia['referencia'] ?? '',
                    'nombres'   => $agencia['nombres'] ?? '',
                    'apellidos' => $agencia['apellidos'] ?? '',
                    'dni'       => $agencia['dni'] ?? '',
                    'telefono'  => $agencia['telefono'] ?? '',
                ];
                if (!empty($agencia['idpedido'])) {
                    $agenciaModel->update($agencia['idpedido'], $agenciaData);
                    $idAgencia = $agencia['idpedido'];
                    log_message('info', 'Agencia actualizada para pedido: ' . $agencia['idpedido']);
                } else {
                    $idAgencia = $agenciaModel->insert($agenciaData);
                    log_message('info', 'Agencia insertada nueva con ID: ' . $idAgencia);
                }
                $db->table('pedido_agencia')->replace([
                    'idpedido'  => $pedido->idpedido,
                    'idagencia' => $idAgencia,
                ]);
                log_message('info', 'Relación pedido_agencia insertada/actualizada');
                break;

            default:
                log_message('warning', 'No se reconoce el idpcodigo para asignación de entrega. IDPCodigo recibido: ' . json_encode($entrega));
                break;
        }
    }

    /**
     * Procesa el cupón si se envía en el pedido.
     */
    private function procesarCupon($pedido, $cupon)
    {
        if (!empty($cupon) && trim($cupon, '"') !== '') {
            $codigoCupon = trim($cupon, '"');
            $cuponModel = new CuponModel();
            $existeCupon = $cuponModel->where('codigo', $codigoCupon)->first();
            if (!$existeCupon) {
                $cuponModel->insert([
                    'idpedido' => $pedido->idpedido,
                    'codigo'   => $codigoCupon,
                ]);
                log_message('info', 'Cupón insertado: ' . $codigoCupon);
            } else {
                log_message('info', 'El cupón ya existe: ' . $codigoCupon);
            }
        } else {
            log_message('info', 'No se recibió cupón válido (vacío o null).');
        }
    }

    // --- MÉTODOS CRUD Y UTILIDADES ---

    /**
     * Actualiza los productos de un pedido existente.
     */
    private function actualizarProductosPedido($idpedido, $productos)
    {
        $pedidoDetalleModel = new PedidoDetalleModel();

        // Eliminar los detalles anteriores del pedido
        $pedidoDetalleModel->where('idpedido', $idpedido)->delete();

        // Insertar los nuevos detalles
        foreach ($productos as $producto) {
            $dataDetalle = [
                'idpedido' => $idpedido,
                'idproducto' => $producto['idproducto'],
                'cantidad' => $producto['cantidad'],
                'peso' => $producto['peso'] ?? 0,
                'precio' => $producto['precio'],
                'descuento' => $producto['descuento'] ?? 0,
                'total' => $producto['total'],
                'fecha' => date('Y-m-d H:i:s')
            ];
            $pedidoDetalleModel->insert($dataDetalle);
        }
    }

    /**
     * Guarda o actualiza el pedido principal.
     */
    private function guardarOrActualizarPedido($referencia, $usuario, $identrega, $costoenvio, $comision, $subtotal, $descuento, $total, $fechaentrega, $observacion, $formapago)
    {
        $pedidoModel = new PedidoModel();
        $data = [
            'referencia' => trim($referencia, '"'),
            'idusuario' => $usuario,
            'identrega' => $identrega ?? null,
            'idformapago' => $formapago ?? null,
            'costoenvio' => floatval($costoenvio),
            'comision' => floatval($comision),
            'subtotal' => floatval($subtotal),
            'descuento' => floatval($descuento),
            'peso' => 0,
            'total' => floatval($total),
            'fechaentrega' => !empty($fechaentrega)
                ? date('Y-m-d H:i:s', strtotime(str_replace('-', '/', trim($fechaentrega, '"'))))
                : null,


            'observacion' => trim($observacion, '"'),
            'fechapedido' => date('Y-m-d H:i:s'),
            'fechareporte' => date('Y-m-d H:i:s'),
            'idppago' => ($formapago ?? 0) == 1 ? 452 : 454,
            'idestado' => 403,
            'fecha' => date('Y-m-d H:i:s'),
        ];

        log_message('info', 'Datos de inserción del pedido: ' . json_encode($data));

        $pedido = $pedidoModel->where('referencia', $data['referencia'])->first();

        if ($pedido) {
            $pedidoModel->update($pedido->idpedido, $data);
            return $pedidoModel->find($pedido->idpedido);
        } else {
            $pedidoModel->insert($data);
            $id = $pedidoModel->getInsertID();
            return $pedidoModel->find($id);
        }
    }


    /**
     * Crea un destino para el pedido.
     */
    private function crearDestino(array $destino)
    {
        $destinoModel = new \App\Models\DestinoModel();

        $data = [
            'idestado' => 243,
            'idusuario' => $destino['usuario']['idUsuario'],
            'idubigeo' => $destino['ubigeo']['idUbigeo'],
            'alias' => $destino['alias'],
            'nombres' => $destino['nombres'],
            'apellidos' => $destino['apellidos'],
            'dni' => $destino['dni'],
            'direccion' => $destino['direccion'],
            'referencia' => $destino['referencia'],
            'telefono' => $destino['telefono'],
            'latitud' => $destino['latitud'],
            'longitud' => $destino['longitud'],
        ];

        $id = $destinoModel->insert($data);
        return $destinoModel->find($id);
    }

    /**
     * Crea un recojo para el pedido.
     */
    private function crearRecojo(array $recojo)
    {
        $recojoModel = new \App\Models\RecojoModel();

        $data = [
            'idestado' => 335,
            'idusuario' => $recojo['usuario']['idUsuario'],
            'idtienda' => $recojo['tienda']['idTienda'],
            'dni' => $recojo['dni'],
            'nombres' => $recojo['nombres'],
            'apellidos' => $recojo['apellidos'],
            'telefono' => $recojo['telefono'],
        ];

        $id = $recojoModel->insert($data);
        return $recojoModel->find($id);
    }

    /**
     * Crea una agencia para el pedido.
     */
    private function crearAgencia(array $agencia)
    {
        $agenciaModel = new \App\Models\AgenciaModel();

        $data = [
            'idusuario' => $agencia['usuario']['idUsuario'],
            'idestado' => 367,
            'idubigeo' => $agencia['ubigeo']['idUbigeo'],
            'agencia' => $agencia['agencia'],
            'direccion' => $agencia['direccion'],
            'referencia' => null,
            'nombres' => $agencia['nombres'],
            'apellidos' => $agencia['apellidos'],
            'dni' => $agencia['dni'],
            'telefono' => $agencia['telefono'],
            'latitud' => null,
            'longitud' => null,
        ];

        $id = $agenciaModel->insert($data);
        return $agenciaModel->find($id);
    }

    /**
     * Crea un comprobante para el pedido.
     */
    private function crearComprobante(array $comprobante, array $usuario)
    {
        $comprobanteModel = new \App\Models\ComprobanteModel();

        $ruc = $comprobante['ptipo']['idParametro'] == 445 ? $comprobante['documento'] : $comprobante['ruc'];
        $razonSocial = $comprobante['ptipo']['idParametro'] == 445 ? $comprobante['nombres'] : $comprobante['razonSocial'];

        $data = [
            'idestado' => 363,
            'idusuario' => $usuario['idUsuario'],
            'idubigeo' => null,
            'idptipo' => $comprobante['ptipo']['idParametro'],
            'ruc' => $ruc,
            'razonsocial' => $razonSocial,
            'direccion' => $comprobante['direccion'],
        ];

        $id = $comprobanteModel->insert($data);
        return $comprobanteModel->find($id);
    }

    // --- MÉTODOS DE PAGO Y CONSULTA ---


    /**
     * Obtiene un pedido por su ID.
     */
    public function obtenerPorId()
    {
        $request = service('request');
        $idPedido = $request->getPost('idPedido');

        log_message('info', '[PedidoPublicoController] Solicitud de obtenerPorId para Pedido ID: ' . $idPedido);

        if (empty($idPedido)) {
            log_message('error', '[PedidoPublicoController] obtenerPorId: ID de Pedido no proporcionado.');
            return $this->fail(['errors' => ['ID de Pedido no proporcionado.'], 'status' => 'error'], 400);
        }

        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($idPedido);

        if (!$pedido) {
            log_message('error', '[PedidoPublicoController] obtenerPorId: Pedido no encontrado con ID: ' . $idPedido);
            return $this->fail(['errors' => ['Pedido no encontrado.'], 'status' => 'error'], 404);
        }

        return $this->respond(['status' => 'exito', 'pedido' => $pedido], 200);
    }

    //METODOS PARA PODER IMPLEMENTAR IZI PAY

    public function generaToken()
    {
        try {
            helper('filesystem');
            $session = session();

            // Capturar datos FORM DATA
            $data = $this->request->getPost();

            // var_dump($data);
            // die();



            $session->set('pedido', $data);

            // Asignar variables
            $operacion  = $data['codigo']     ?? null;
            $documento  = $data['documento']  ?? null;
            $correo     = $data['correo']     ?? null;
            $telefono   = $data['telefono']   ?? null;
            $nombres    = $data['nombres']    ?? null;
            $pApellido  = $data['pApellido']  ?? null;
            $total      = $data['total']      ?? null;

            if (empty($operacion) || empty($total)) {
                log_message('error', '❌ [IZIPAY] Código o total vacío.');
                return $this->response->setJSON([
                    'status' => 'error',
                    'mensaje' => 'Datos insuficientes.'
                ]);
            }
            $amount = number_format(floatval($total), 2, "", "");




            $key    = getenv('IZIPAY_SECRET_KEY');
            $pubKey = getenv('IZIPAY_PUBLIC_KEY');


            if (empty($key) || empty($pubKey)) {
                log_message('error', '❌ [IZIPAY] Claves de entorno vacías. Verifica KEY y PUBLIC_KEY en .env');
                return $this->response->setJSON(['status' => 'error', 'mensaje' => 'Faltan credenciales de Izipay.']);
            }

            log_message('debug', '🔑 KEY cargada correctamente.');

            $pedidoTemporal = $this->guardarPedidoIzipay($data);

            // var_dump($pedidoTemporal);
            // die();

            if (!isset($pedidoTemporal['status']) || $pedidoTemporal['status'] !== 'exito') {
                log_message('error', '❌ [IZIPAY] Error al guardar pedido temporal: ' . json_encode($pedidoTemporal));
                return $this->response->setJSON(['status' => 'error', 'mensaje' => 'No se pudo guardar el pedido temporal.']);
            }

            log_message('debug', '📝 Pedido temporal guardado correctamente: ' . json_encode($pedidoTemporal));

            $idProductoTallas = explode(',', $data['idProductoTallas'][0] ?? '');
            $cantidades       = explode(',', $data['cantidades'][0] ?? '');

            // Construir carrito Izipay
            $cartItems = [];

            foreach ($idProductoTallas as $index => $idTalla) {

                // Cantidad del pedido
                $cantidad = intval($cantidades[$index] ?? 1);

                // Traer detalle del pedido
                $detalle = $this->pedidoDetalle
                    ->where('idproductotalla', $idTalla)
                    ->where('idpedido', $pedidoTemporal['pedido']->idpedido)
                    ->first();

                if (!$detalle) continue;

                // PRECIO REAL DEL PEDIDO
                $precio = floatval(str_replace(',', '.', $detalle->precio));
                $precioIzi = intval(round($precio * 100));

                // TRAER NOMBRE + COLOR + TALLA
                $productoData = $this->productoTalla
                    ->select(
                        'producto.nombre AS nombreProducto,
             productocolor.nombre AS nombreColor,
             talla.nombre AS nombreTalla'
                    )
                    ->join('productocolor', 'productocolor.idproductocolor = productotalla.idproductocolor')
                    ->join('producto', 'producto.idproducto = productocolor.idproducto')
                    ->join('talla', 'talla.idtalla = productotalla.idtalla')
                    ->where('productotalla.idproductotalla', $detalle->idproductotalla)
                    ->first();

                // Construir etiqueta final
                $label = $productoData->nombreProducto
                    . ' - ' . $productoData->nombreColor
                    . ' - Talla ' . $productoData->nombreTalla;

                // Agregar item al carrito
                $cartItems[] = [
                    "productRef"    => (string)$idTalla,
                    "productAmount" => $precioIzi,
                    "productLabel"  => $label,
                    "productQty"    => (int)$cantidad
                ];
            }





            // $filtro = [
            //     "amount"   => $amount,
            //     "currency" => 'PEN',
            //     "orderId"  => $operacion,
            //     "customer" => [
            //         "email" => $correo,
            //         "reference" => $documento,
            //         "billingDetails" => [
            //             "cellPhoneNumber" => $telefono,
            //             "firstName" => $nombres,
            //             "lastName" => $pApellido,
            //         ],
            //         "shoppingCart" => [
            //             "cartItemInfo" => [
            //                 [
            //                     "productRef"    => $operacion,
            //                     "productAmount" => $amount,
            //                     "productLabel"  => $operacion,
            //                     "productQty"    => "1"
            //                 ]
            //             ]
            //         ]
            //     ]
            // ];
            $filtro = [
                "amount"   => $amount,  // total en centavos general
                "currency" => 'PEN',
                "orderId"  => $operacion,
                "customer" => [
                    "email" => $correo,
                    "reference" => $documento,
                    "billingDetails" => [
                        "cellPhoneNumber" => $telefono,
                        "firstName" => $nombres,
                        "lastName" => $pApellido,
                    ],
                    "shoppingCart" => [
                        "cartItemInfo" => $cartItems
                    ]
                ]
            ];


            log_message('debug', '📤 Enviando solicitud a Izipay: ' . json_encode($filtro));

            // Generar token Izipay usando cURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment',
                // CURLOPT_URL => 'https://sandbox.api.izipay.pe/v4/WebService/Charge/CreatePayment',

                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Content-Type: application/json",
                    'Authorization: Basic ' . base64_encode($key)
                ],
                CURLOPT_POSTFIELDS => json_encode($filtro)
            ]);

            $responseRaw = curl_exec($curl);
            $curlError   = curl_error($curl);
            curl_close($curl);

            if ($curlError) {
                log_message('error', '❌ [IZIPAY] Error CURL: ' . $curlError);
                return $this->response->setJSON(['status' => 'error', 'mensaje' => 'Error de conexión con Izipay.']);
            }

            log_message('debug', '📥 Respuesta cruda de Izipay: ' . $responseRaw);

            $response = json_decode($responseRaw);

            if (!isset($response->answer->formToken)) {
                log_message('error', '❌ [IZIPAY] Respuesta inválida de Izipay: ' . json_encode($response));
                return $this->response->setJSON(['status' => 'error', 'mensaje' => 'Error al generar token.']);
            }

            log_message('debug', '✅ Token generado correctamente: ' . $response->answer->formToken);

            $data = [
                'peticion'      => $response,
                'token'         => $response->answer->formToken,
                'publicKey'     => $pubKey,
                'lenguajeform'  => 'es-ES',
                'status'        => 'exito',
                'pedido'        => $pedidoTemporal['pedido'] ?? null
            ];

            return $this->response->setJSON($data);
        } catch (\Throwable $th) {
            log_message('critical', '💥 [IZIPAY] Excepción en generaToken(): ' . $th->getMessage());
            log_message('critical', '🧱 Trace: ' . $th->getTraceAsString());

            return $this->response->setJSON([
                'status' => 'error',
                'mensaje' => 'Error interno en el servidor'
            ]);
        }
    }



    public function guardarPedidoIzipay($data)
    {
        log_message('info', '🟢 Guardar pedido Izipay iniciado.');

        try {
            // --- CAPTURAR DATOS DEL PEDIDO desde $data ---
            $referencia    = $data['referencia'] ?? null;
            $entrega       = $data['entrega'] ?? null;
            $fechaEntrega  = $data['fechaEntrega'] ?? null;
            $tienda        = $data['tienda'] ?? null;
            $formapago     = $data['formapago'] ?? null;
            $cupon         = $data['cupon'] ?? null;
            $observaciones = $data['observaciones'] ?? null;
            $terminos      = isset($data['terminos']) && $data['terminos'] === 'on' ? true : false;
            $total         = $data['total'] ?? 0;
            $subtotal      = $data['subtotal'] ?? 0;
            $comision      = $data['comision'] ?? 0;
            $descuento     = $data['descuento'] ?? 0;
            $costoEnvio    = $data['costoenvio'] ?? 0;
            $codigo        = $data['codigo'] ?? null;

            $idProductoTallas   = $data['idProductoTallas'] ?? [];
            $cantidades         = $data['cantidades'] ?? [];
            $descuentoProductos = $data['descuentoProductos'] ?? [];

            // --- Normalizar arrays si vienen como strings separados por coma ---
            if (count($idProductoTallas) === 1 && strpos($idProductoTallas[0], ',') !== false) {
                $idProductoTallas = explode(',', $idProductoTallas[0]);
            }

            if (count($cantidades) === 1 && strpos($cantidades[0], ',') !== false) {
                $cantidades = explode(',', $cantidades[0]);
            }

            if (count($descuentoProductos) === 1 && strpos($descuentoProductos[0], ',') !== false) {
                $descuentoProductos = explode(',', $descuentoProductos[0]);
            }

            $idProductoTallas   = array_map('trim', $idProductoTallas);
            $cantidades         = array_map('trim', $cantidades);
            $descuentoProductos = array_map('trim', $descuentoProductos);

            // --- Preparar arrays anidados ---
            $destino = [
                'idDestino'  => $data['anteriores'] ?? null,
                'alias'      => $data['ddireccion'] ?? null,
                'nombres'    => $data['dnombres'] ?? null,
                'apellidos'  => $data['dapellidos'] ?? null,
                'idubigeo'   => $data['ddistrito'] ?? null,
                'dni'        => $data['ddocumento'] ?? null,
                'direccion'  => $data['ddireccion'] ?? null,
                'referencia' => $data['dreferencia'] ?? null,
                'telefono'   => $data['dtelefono'] ?? null,
                'latitud'    => $data['dlatitud'] ?? null,
                'longitud'   => $data['dlongitud'] ?? null,
                'ubigeo'     => $data['dubigeo'] ?? null,
            ];

            $usuario = [
                'idUsuario' => $data['usuario']['idUsuario'] ?? null
            ];

            $comprobante = [
                'razonSocial' => $data['fnombres'] ?? null,
                'documento'   => $data['bdocumento'] ?? null,
                'nombres'     => $data['bnombres'] ?? null,
                'ruc'         => $data['fdocumento'] ?? null,
                'direccion'   => $data['fdireccion'] ?? null,
                'ptipo'       => $data['tipocomprobante'] ?? null,
                'ubigeo'      => $data['fdistrito'] ?? null,
            ];

            $recojo = [
                'dni'       => $data['rdocumento'] ?? null,
                'nombres'   => $data['rnombres'] ?? null,
                'apellidos' => $data['rapellidos'] ?? null,
                'telefono'  => $data['rtelefono'] ?? null,
                'tienda'    => $data['tienda'] ?? null,
            ];

            $agencia = [
                'idAgencia' => $data['anteriores'] ?? null,
                'agencia'   => $data['agencia'] ?? null,
                'direccion' => $data['adireccion'] ?? null,
                'nombres'   => $data['anombres'] ?? null,
                'apellidos' => $data['aapellidos'] ?? null,
                'dni'       => $data['adocumento'] ?? null,
                'telefono'  => $data['atelefono'] ?? null,
                'ubigeo'    => $data['adistrito'] ?? null,
            ];

            // --- Guardar o actualizar pedido principal ---
            $pedido = $this->guardarOrActualizarPedido(
                $referencia,
                $usuario,
                $entrega,
                $costoEnvio,
                $comision,
                $subtotal,
                $descuento,
                $total,
                $fechaEntrega,
                $observaciones,
                $formapago
            );

            // --- Procesar detalles de productos ---
            $this->procesarDetallesPedido($pedido, $idProductoTallas, $cantidades, $descuentoProductos);

            // --- Procesar comprobante ---
            $this->procesarComprobante($pedido, $comprobante);

            // --- Procesar entrega según tipo ---
            $this->procesarEntrega($entrega, $pedido, $destino, $recojo, $agencia);

            // --- Procesar cupón si existe ---
            $this->procesarCupon($pedido, $cupon);
            log_message('info', '✅ Pedido Izipay guardado correctamente con ID: ' . $pedido->idpedido);
            return [
                'status' => 'exito',
                'pedido' =>  $pedido
            ];
        } catch (\Throwable $th) {
            log_message('error', '💥 Error en guardarPedidoIzipay: ' . $th->getMessage());
            log_message('error', '🧱 Stack trace: ' . $th->getTraceAsString());

            return [
                'status' => 'error',
                'errors' => ['Ocurrió un error inesperado: ' . $th->getMessage()]
            ];
        }
    }

    /**
     * IPN para pagos Izipay. Actualiza estado y stock tras pago exitoso.
     */
    public function ipnIzipay()
    {
        // Capturar el cuerpo crudo (por si llega en JSON)
        $rawInput = $this->request->getBody();
        $input = $this->request->getPost('kr-answer') ?? $rawInput;

        log_message('info', '🔔 IPN recibido: ' . $input);

        $respuesta = json_decode($input);

        if (!$respuesta) {
            log_message('error', '❌ No se pudo decodificar el JSON del IPN.');
            return $this->response->setStatusCode(400)->setBody('Bad Request');
        }

        // Verificar estado del pedido
        if (isset($respuesta->orderStatus) && $respuesta->orderStatus === "PAID") {
            $pedidoModel = new \App\Models\PedidoModel();

            $pedido = $pedidoModel->where('referencia', $respuesta->orderDetails->orderId)->first();

            if ($pedido) {
                $pedidoModel->update($pedido->idpedido, [
                    'idestado' => 329, // Estado "Pagado"
                    'idppago' => 453,  // Método de pago (tarjeta, etc.)
                    'fechaconfirmacion' => date('Y-m-d H:i:s'),
                ]);

                log_message('info', '✅ Pedido actualizado correctamente: ' . $pedido->referencia);

                // ⬇️ Actualizar stock de productos después de un pago exitoso
                $pedidoDetalleModel = new \App\Models\PedidoDetalleModel();
                $productoTallaModel = new \App\Models\ProductoTallaModel();

                $detallesPedido = $pedidoDetalleModel->where('idpedido', $pedido->idpedido)->findAll();

                foreach ($detallesPedido as $detalle) {
                    $productoTalla = $productoTallaModel->find($detalle->idproductotalla);
                    if ($productoTalla) {
                        $nuevoStock = intval($productoTalla->stock) - intval($detalle->cantidad);
                        $productoTallaModel->update($productoTalla->idproductotalla, ['stock' => $nuevoStock]);
                        log_message('info', 'Stock actualizado para ProductoID: ' . $productoTalla->idproductotalla . ', Nuevo stock: ' . $nuevoStock);
                    } else {
                        log_message('error', 'Producto no encontrado al actualizar stock para ID: ' . $detalle->idproductotalla);
                    }
                }

                // ✉️ Enviar notificación por correo
                $util = new HelpersUtil();
                $util->mailPedido($pedido->idpedido, 5);
            } else {
                log_message('error', '⚠️ Pedido no encontrado para la referencia: ' . $respuesta->orderDetails->orderId);
            }
        } else {
            log_message('info', 'ℹ️ Notificación IPN recibida pero no es PAID.');
        }

        // Siempre responder 200 OK a Izipay
        return $this->response->setStatusCode(200)->setBody('OK');
    }

    public function procesarPagoParaPedidoExistente()
    {
        helper('filesystem');
        $request = service('request');

        $idPedido = $request->getPost('idPedido');
        $idFormaPago = $request->getPost('idFormaPago');
        $comprobanteFile = $this->request->getFile('constancia');

        if (empty($idPedido) || empty($idFormaPago)) {
            return $this->fail(['errors' => ['Datos insuficientes para procesar el pago.'], 'status' => 'error'], 400);
        }

        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($idPedido);
        if (!$pedido) return $this->fail(['errors' => ['Pedido no encontrado.'], 'status' => 'error'], 404);

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($pedido->idusuario);
        if (!$usuario) return $this->fail(['errors' => ['Usuario no encontrado.'], 'status' => 'error'], 500);

        // Validar stock usando ProductoModelTalla
        $pedidoDetalleModel = new PedidoDetalleModel();
        $productoTallaModel = new ProductoTallaModel();
        $detalles = $pedidoDetalleModel->where('idpedido', $idPedido)->findAll();

        foreach ($detalles as $detalle) {
            $productoTalla = $productoTallaModel->find($detalle->idproductotalla);
            if (!$productoTalla)
                return $this->respond(['status' => 'error', 'errors' => ['Producto no encontrado.']], 200);

            if ($productoTalla->stock < $detalle->cantidad)
                return $this->respond(['status' => 'error', 'errors' => ['Stock insuficiente.']], 200);
        }

        // ============================================
        //              PAGO IZIPAY
        // ============================================

        if ($idFormaPago == 1) {

            $key    = getenv('IZIPAY_SECRET_KEY');
            $pubKey = getenv('IZIPAY_PUBLIC_KEY');

            if (empty($key) || empty($pubKey)) {
                log_message('error', '❌ [IZIPAY] Claves de entorno vacías.');
                return $this->fail(['errors' => ['Faltan credenciales de IziPay.'], 'status' => 'error'], 500);
            }

            // Construir carrito IziPay
            $cartItems = [];
            foreach ($detalles as $detalle) {

                // Precio real
                $precio = floatval(str_replace(',', '.', $detalle->precio));
                $precioIzi = intval(round($precio * 100));

                // Obtener producto completo: producto + color + talla
                $productoData = $productoTallaModel
                    ->select("
            producto.nombre AS nombreProducto,
            productocolor.nombre AS nombreColor,
            talla.nombre AS nombreTalla
        ")
                    ->join('productocolor', 'productocolor.idproductocolor = productotalla.idproductocolor')
                    ->join('producto', 'producto.idproducto = productocolor.idproducto')
                    ->join('talla', 'talla.idtalla = productotalla.idtalla')
                    ->where('productotalla.idproductotalla', $detalle->idproductotalla)
                    ->first();

                // Armar label completo
                $label = $productoData->nombreProducto
                    . ' - ' . $productoData->nombreColor
                    . ' - Talla ' . $productoData->nombreTalla;

                // Agregar item al carrito
                $cartItems[] = [
                    "productRef"    => (string)$detalle->idproductotalla,
                    "productAmount" => $precioIzi,
                    "productLabel"  => $label,
                    "productQty"    => (int)$detalle->cantidad
                ];
            }


            // Total general en centavos
            $amountTotal = array_reduce(
                $cartItems,
                fn($carry, $item) => $carry + ($item['productAmount'] * $item['productQty']),
                0
            );

            // Datos enviados a IziPay
            $filtro = [
                "amount"   => $amountTotal,
                "currency" => 'PEN',
                "orderId"  => $pedido->referencia,
                "customer" => [
                    "email" => $usuario->correo,
                    "reference" => $usuario->documento,
                    "billingDetails" => [
                        "cellPhoneNumber" => $usuario->telefono,
                        "firstName" => $usuario->nombres,
                        "lastName" => trim($usuario->papellido . ' ' . $usuario->sapellido)
                    ],
                    "shoppingCart" => [
                        "cartItemInfo" => $cartItems
                    ]
                ]
            ];

            // Ejecutar CURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Content-Type: application/json",
                    'Authorization: Basic ' . base64_encode($key)
                ],
                CURLOPT_POSTFIELDS => json_encode($filtro)
            ]);

            $responseRaw = curl_exec($curl);
            $curlError   = curl_error($curl);
            curl_close($curl);

            if ($curlError)
                return $this->fail(['errors' => ['Error de conexión con IziPay.'], 'status' => 'error'], 500);

            $response = json_decode($responseRaw);

            if (!isset($response->answer->formToken))
                return $this->fail(['errors' => ['Error al generar token de IziPay.'], 'status' => 'error'], 500);

            return $this->respond([
                'status' => 'exito',
                'token' => $response->answer->formToken,
                'publicKey' => $pubKey,
                'lenguajeform' => 'es-ES',
                'idpedido' => $pedido->idpedido
            ], 200);
        }

        // ============================================
        //        OTROS MÉTODOS DE PAGO
        // ============================================

        if (!$comprobanteFile || !$comprobanteFile->isValid() || $comprobanteFile->hasMoved()) {
            return $this->fail(['errors' => ['Debe adjuntar un comprobante válido.'], 'status' => 'error'], 400);
        }

        $urlamigable = HelpersUtil::urls_amigables($pedido->referencia);
        $nombreArchivo = $pedido->idpedido . '-' . $urlamigable . '.' . $comprobanteFile->getExtension();
        $comprobanteFile->move(FCPATH . 'archivos/pedido', $nombreArchivo);

        $pedidoModel->update($idPedido, [
            'idformapago' => $idFormaPago,
            'urlconstancia' => $nombreArchivo,
            'idppago' => 454,
            'fechareporte' => date('Y-m-d H:i:s')
        ]);

        return $this->respond(['status' => 'exito', 'mensaje' => 'Comprobante y forma de pago actualizados correctamente.'], 200);
    }
}
