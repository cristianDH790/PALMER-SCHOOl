<?php

namespace App\Controllers\Api\Publico;

use App\Entities\NoticiaEntity;
use App\Helpers\Paginator;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\NoticiaCategoriaModel;
use App\Models\NoticiaModel;
use App\Models\ParametroModel;
use App\Transformadores\NoticiaCollectionTransformer;
use App\Transformadores\NoticiaTransformer;
use App\Validation\NoticiaValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class NoticiaPublicoController extends ResourceController
{

    protected $noticia;
    protected $estado;
    protected $parametro;
    protected $noticiaCategoria;

    public function __construct()
    {
        $this->noticia = new NoticiaModel();
        $this->estado = new EstadoModel();
        $this->noticiaCategoria = new NoticiaCategoriaModel();
        $this->parametro = new ParametroModel();
    }

    public  function obtenerPorId($idnoticia)
    {

        $noticia = $this->noticia->obtenerPorId($idnoticia);

        if (!$noticia) {
            return $this->respond(['mensaje' => 'No existe la noticia solicitada'], 404);
        } else {

            // Convertir a array
            $resultado = NoticiaTransformer::transform($noticia);

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
        $idpdestacado = (int) ($request->getVar('idPdestacado') ?? 0);
        $idnoticiacategoria = (int) ($request->getVar('idNoticiaCategoria') ?? 0);

        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->noticia->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idnoticiacategoria,
            $idpdestacado,
        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $noticias = $this->noticia->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idnoticiacategoria,
            $idpdestacado,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad
        $resultado = NoticiaCollectionTransformer::transform($noticias);

        // Respuesta JSON con paginación y datos
        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
}
