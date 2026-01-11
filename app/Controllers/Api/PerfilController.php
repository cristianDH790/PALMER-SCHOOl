<?php

namespace App\Controllers\Api;

use App\Entities\PerfilEntity;
use App\Helpers\Paginator;

use App\Models\EstadoModel;
use App\Models\PerfilModel;
use App\Transformadores\PerfilCollectionTransformer;
use App\Transformadores\PerfilTransformer;
use CodeIgniter\RESTful\ResourceController;

class PerfilController extends ResourceController
{
    protected $estado;
    protected $perfil;
    protected $session;
    public function __construct()
    {
        $this->estado = new EstadoModel();
        $this->perfil = new PerfilModel();
        $this->session = session();
    }
    public  function obtenerPorId($idperfil)
    {
        $perfil = $this->perfil->obtenerPorId($idperfil);
        if (!$perfil) {
            return $this->respond(['mensaje' => 'No existe el perfil solicitado'], 404);
        } else {
            $resultado[] = PerfilTransformer::transform($perfil);
            return $this->respond($resultado, 200);
        }
    }
    public function listar()
    {
        $request = $this->request;

        $ordencriterio = $request->getVar('ordenCriterio') ?? 'fecha';
        $ordentipo = $request->getVar('ordenTipo') ?? 'desc';
        $parametro = $request->getVar('parametro') ?? '';
        $valor = $request->getVar('valor') ?? '';
        $idestado = (int) ($request->getVar('idEstado') ?? 0);
        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);



        $total = $this->perfil->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
        );
        $paginator = new Paginator($pagina, $registros, $total);

        $perfil = $this->perfil->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        $resultado = PerfilCollectionTransformer::transform($perfil);
        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
}
