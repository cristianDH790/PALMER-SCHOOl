<?php

namespace App\Controllers\Api\Publico;

use App\Entities\UbigeoEntity;
use App\Helpers\Paginator;
use App\Models\EstadoModel;

use App\Models\UbigeoModel;
use App\Transformadores\UbigeoCollectionTransformer;
use App\Transformadores\UbigeoTransformer;
use App\Validation\UbigeoValidation;

use CodeIgniter\RESTful\ResourceController;

class UbigeoPublicoController extends ResourceController
{

    protected $ubigeo;
    protected $estado;
    protected $parametro;
    protected $ubigeoCategoria;

    public function __construct()
    {
        $this->ubigeo = new UbigeoModel();
        $this->estado = new EstadoModel();
    }

    public  function obtenerPorId($idubigeo)
    {
        $ubigeo = $this->ubigeo->obtenerPorId($idubigeo);

        if (!$ubigeo) {
            return $this->respond(['mensaje' => 'No existe la ubigeo solicitada'], 404);
        } else {

            $resultado = UbigeoTransformer::transform($ubigeo);

            return $this->respond($resultado, 200);
        }
    }

    public function listar()
    {
        // Verificar si es POST
        if (!$this->request->is('post')) {
            return $this->fail('Método no permitido. Se requiere POST.', 405);
        }

        $request = $this->request;

        // Parámetros de búsqueda y orden
        $ordencriterio = $request->getVar('ordenCriterio') ?? 'fechapublicacion';
        $ordentipo = $request->getVar('ordenTipo') ?? 'asc';
        $parametro = $request->getVar('parametro') ?? '';
        $valor = $request->getVar('valor') ?? '';
        $idestado = (int) ($request->getVar('idEstado') ?? 0);
        $idrubigeo = (int) ($request->getVar('idrUbigeo') ?? 0);


        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->ubigeo->buscarPorTotal(
            $idrubigeo,
            $idestado
        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $ubigeos = $this->ubigeo->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idrubigeo,
            $idestado,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );


        $resultado = UbigeoCollectionTransformer::transform($ubigeos);



        // Respuesta JSON con paginación y datos
        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado,
            'ubigeos1' => $ubigeos,
            // 'ubigeos2' => $nivel1
        ]);
    }
}
