<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\BaseController;
use App\Entities\ProductoImagenEntity;
use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\ParametroModel;

use App\Models\ProductoModel;
use App\Models\ProductoTallaModel;

use App\Transformadores\ProductoTallaCollectionTransformer;
use App\Transformadores\ProductoTallaTransformer;

use CodeIgniter\RESTful\ResourceController;

class ProductoTallaPublicoController extends ResourceController
{

    protected $productotalla;
    protected $producto;
    protected $estado;
    protected $parametro;
    protected $permiso;
    public function __construct()
    {
        $this->productotalla = new ProductoTallaModel();
        $this->producto = new ProductoModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
        $this->permiso = new Permisos();
    }

    public  function obtenerPorId($idproductotalla)
    {

        $productotalla = $this->productotalla->obtenerPorId($idproductotalla);

        if (!$productotalla) {
            return $this->respond(['mensaje' => 'No existe el producto talla  solicitado'], 404);
        } else {


            $resultado = ProductoTallaTransformer::transform($productotalla);

            return $this->respond(['status' => 200, 'data' => $resultado], 200);
        }
    }

    public function listar()
    {

        if (!$this->request->is('post')) {
            return $this->fail('Método no permitido. Se requiere POST.', 405);
        }

        $request = $this->request;

        // Parámetros de búsqueda y orden
        $ordencriterio = $request->getVar('ordenCriterio') ?? 'fecha';
        $ordentipo = $request->getVar('ordenTipo') ?? 'asc';
        $parametro = $request->getVar('parametro') ?? '';
        $valor = $request->getVar('valor') ?? '';
        $idestado = (int) ($request->getVar('idEstado') ?? 0);
        $idproductocolor = (int) ($request->getVar('idProductoColor') ?? 0);
        $idproducto = (int) ($request->getVar('idProducto') ?? 0);
        $idcupones = (int) ($request->getVar('idCupon') ?? 0);
        $idtalla = (int) ($request->getVar('idTalla') ?? 0);




        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->productotalla->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idproductocolor,
            $idtalla,
            $idproducto,
            $idcupones

        );

        $paginator = new Paginator($pagina, $registros, $total);
        // $ordencriterio, $ordentipo, $parametro, $valor, $idestado, $idproducto, $idpdestacado, $idcolor, $inicio, $registros
        // Consulta paginada
        $productoImagens = $this->productotalla->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idproductocolor,
            $idtalla,
            $idproducto,
            $idcupones,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad

        $resultado = ProductoTallaCollectionTransformer::transform($productoImagens);


        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
}
