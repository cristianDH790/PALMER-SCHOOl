<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\BaseController;
use App\Entities\ProductoImagenEntity;
use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\ParametroModel;
use App\Models\ProductoBaseModel;
use App\Models\ProductoColorModel;
use App\Models\ProductoImagenModel;
use App\Models\ProductoModel;
use App\Transformadores\ProductoCollectionTransformer;
use App\Transformadores\ProductoColorCollectionTransformer;
use App\Transformadores\ProductoColorTransformer;
use App\Transformadores\ProductoTransformer;
use App\Validation\ProductoColorValidation;
use App\Validation\ProductoImagenValidation;
use CodeIgniter\RESTful\ResourceController;

class ProductoColorPublicoController extends ResourceController
{

    protected $productoColor;
    protected $producto;
    protected $estado;
    protected $parametro;
    protected $permiso;
    public function __construct()
    {
        $this->productoColor = new ProductoColorModel();
        $this->producto = new ProductoModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
        $this->permiso = new Permisos();
    }
  
    public  function obtenerPorId($idproductocolor)
    {
       
        $productoColor = $this->productoColor->obtenerPorId($idproductocolor);

        if (!$productoColor) {
            return $this->respond(['mensaje' => 'No existe el producto  solicitado'], 404);
        } else {


            $resultado = ProductoColorTransformer::transform($productoColor);

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
        $idproducto = (int) ($request->getVar('idProducto') ?? 0);
        $idpdestacado = (int) ($request->getVar('idpDestacado') ?? 0);
        $idcolor = (int) ($request->getVar('idcolor') ?? 0);



        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->productoColor->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idproducto,
            $idpdestacado,
            $idcolor
        );

        $paginator = new Paginator($pagina, $registros, $total);
        // $ordencriterio, $ordentipo, $parametro, $valor, $idestado, $idproducto, $idpdestacado, $idcolor, $inicio, $registros
        // Consulta paginada
        $productoImagens = $this->productoColor->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idproducto,
            $idpdestacado,
            $idcolor,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad

        $resultado = ProductoColorCollectionTransformer::transform($productoImagens);


        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
   
}
