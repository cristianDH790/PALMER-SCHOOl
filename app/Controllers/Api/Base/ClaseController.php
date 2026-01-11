<?php

namespace App\Controllers\Api\Base;

use App\Entities\ClaseEntity;
use App\Helpers\Paginator;
use App\Models\ClaseModel;
use App\Transformadores\ClaseCollectionTransformer;
use CodeIgniter\RESTful\ResourceController;

class ClaseController extends ResourceController
{
    protected $clase;
    protected $session;
    public function __construct()
    {
        $this->clase = new ClaseModel();
        $this->session = session();
    }



    public function listar()
    {

        $data = $this->request->getJSON(true);

        $ordencriterio = $data['ordenCriterio'] ?? '';
        $ordentipo = $data['ordenTipo'] ?? '';
        $parametro = $data['parametro'] ?? '';
        $valor = $data['valor'] ?? '';

        $idclase = isset($data['idClase']) ? (int)$data['idClase'] : 0;
        $registros = isset($data['registros']) ? (int)$data['registros'] : 10;
        $pagina = isset($data['pagina']) ? (int)$data['pagina'] : 1;


        
        $total = $this->clase->buscarPorTotal(
            $parametro,
            $valor,
            $idclase,
        );
        $paginator = new Paginator($pagina, $registros, $total);
        // $ordencriterio,$ordentipo,$parametro, $valor, $idclase, $inicio, $registros
        $clases = $this->clase->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idclase,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );
         $resultado = ClaseCollectionTransformer::transform($clases);

        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
}
