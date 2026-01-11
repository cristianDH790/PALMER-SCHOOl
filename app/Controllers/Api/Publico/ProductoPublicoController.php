<?php

namespace App\Controllers\Api\Publico;


use App\Helpers\Excel\ReporteExcelProductos;
use App\Helpers\Paginator;
use App\Helpers\Permisos;

use App\Models\EstadoModel;
use App\Models\MarcaModel;
use App\Models\ParametroModel;

use App\Models\ProductoCategoriaModel;
use App\Models\ProductoModel;

use App\Transformadores\ProductoCollectionTransformer;
use App\Transformadores\ProductoTransformer;
use App\Validation\ProductoValidation;
use CodeIgniter\RESTful\ResourceController;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ProductoPublicoController extends ResourceController
{

    protected $producto;
    protected $productocategoria;
    protected $estado;
    protected $promocion;
    protected $parametro;
    protected $marca;
    protected $permiso;

    public function __construct()
    {
        $this->permiso = new Permisos();
        $this->producto = new ProductoModel();
        $this->productocategoria = new ProductoCategoriaModel();
        $this->estado = new EstadoModel();

        $this->parametro = new ParametroModel();
        $this->marca = new MarcaModel();
    }
    // private function verificarPermiso(string $permiso)


    public  function obtenerPorId($idproducto)
    {


        $producto = $this->producto->obtenerPorId(
            $idproducto
        );

        if (!$producto) {
            return $this->respond(['mensaje' => 'No existe la forma pago solicitada'], 404);
        } else {



            $resultado = ProductoTransformer::transform($producto);

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
        $idproductocategoria = (int) ($request->getVar('idProductoCategoria') ?? 0);
        $idrproductocategoria = (int) ($request->getVar('idrProductoCategoria') ?? 0);
        $idpgenero = $request->getVar('idpGenero') ?? [];
        $idtalla = $request->getVar('idTalla') ?? [];
        $idgrupo = $request->getVar('idGrupo') ?? [];

        log_message('error', 'ID GENERO RECIBIDO: ' . print_r($idpgenero, true));

        $idpdestacado = (int) ($request->getVar('idpDestacado') ?? 0);
        $idcolor = (int) ($request->getVar('idColor') ?? 0);

        $idcupon = (int) ($request->getVar('idCupon') ?? 0);
        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->producto->buscarPorTotalPublico(
            $parametro,
            $valor,
            $idestado,
            $idproductocategoria,
            $idrproductocategoria,
            $idpgenero,
            $idtalla,
            $idgrupo,
            $idpdestacado,
            $idcupon,
            $idcolor


        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada


        $productobases = $this->producto->buscarPorPublico(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idproductocategoria,
            $idrproductocategoria,
            $idpgenero,
            $idtalla,
            $idgrupo,
            $idpdestacado,
            $idcupon,
            $idcolor,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // var_dump($productobases);
        // die();

        // Convertir resultados a entidad
        $resultado = ProductoCollectionTransformer::transform($productobases);
        // Respuesta JSON con paginación y datos
        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
}
