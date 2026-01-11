<?php

namespace App\Controllers\Api\Publico;


use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\ParametroModel;
use App\Models\ProductoBaseModel;
use App\Models\ProductoImagenModel;
use App\Models\ProductoModel;
use App\Transformadores\ProductoImagenCollectionTransformer;
use App\Transformadores\ProductoImagenTransformer;
use App\Validation\ProductoImagenValidation;
use CodeIgniter\RESTful\ResourceController;

class ProductoImagenPublicoController extends ResourceController
{

    protected $productoImagen;
    protected $producto;
    protected $estado;
    protected $parametro;
    protected $permiso;
    public function __construct()
    {
        $this->productoImagen = new ProductoImagenModel();
        $this->producto = new ProductoModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
        $this->permiso = new Permisos();
    }

    public  function obtenerPorId($idproductoImagen)
    {

        $productoImagen = $this->productoImagen->obtenerPorId($idproductoImagen);

        if (!$productoImagen) {
            return $this->respond(['mensaje' => 'No existe la producto Imagen solicitada'], 404);
        } else {


            $resultado = ProductoImagenTransformer::transform($productoImagen);


            return $this->respond($resultado, 200);
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
        $idpdestacado = (int) ($request->getVar('idpDestacado') ?? 0);
        $idptipo = (int) ($request->getVar('idpTipo') ?? 0);



        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->productoImagen->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idproductocolor,
            $idproducto,
            $idptipo,
            $idpdestacado
        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $productoImagens = $this->productoImagen->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idproductocolor,
            $idproducto,
            $idptipo,
            $idpdestacado,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad
        $resultado = ProductoImagenCollectionTransformer::transform($productoImagens);


        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
}
