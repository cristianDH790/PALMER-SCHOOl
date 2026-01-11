<?php

namespace App\Controllers\Api;

use App\Entities\ContenidoWebCategoriaEntity;
use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;
use App\Models\ContenidoWebCategoriaModel;
use App\Models\EstadoModel;
use App\Models\ParametroModel;
use App\Transformadores\ContenidoWebCategoriaCollectionTransformer;
use App\Transformadores\ContenidoWebCategoriaTransformer;
use App\Validation\ContenidoWebCategoriaValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ContenidoWebCategoriaController extends  ResourceController
{
    protected $permiso;
    protected $contenidowebcategoria;
    protected $estado;
    protected $parametro;

    public function __construct()
    {
        $this->contenidowebcategoria = new ContenidoWebCategoriaModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
    }


    public  function obtenerPorId($idcontenidowebcategoriacategoria)
    {

        $contenidowebcategoria = $this->contenidowebcategoria->obtenerPorId($idcontenidowebcategoriacategoria);
        if (!$contenidowebcategoria) {
            return $this->respond(['mensaje' => 'No existe el contenido web categoria solicitado'], 404);
        } else {

            $resultado = ContenidoWebCategoriaTransformer::transform($contenidowebcategoria);

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
        $ordencriterio = $request->getVar('ordenCriterio') ?? 'nombre';
        $ordentipo = $request->getVar('ordenTipo') ?? 'asc';
        $parametro = $request->getVar('parametro') ?? '';
        $valor = $request->getVar('valor') ?? '';
        $idestado = (int) ($request->getVar('idEstado') ?? 0);
        $idrcontenidowebcategoria = (int) ($request->getVar('idrContenidoWebCategoria') ?? 0);


        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->contenidowebcategoria->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idrcontenidowebcategoria
        );

        $paginator = new Paginator($pagina, $registros, $total);

        // Consulta paginada
        $contenidowebcategorias = $this->contenidowebcategoria->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idrcontenidowebcategoria,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad

        $resultado = ContenidoWebCategoriaCollectionTransformer::transform($contenidowebcategorias);

        // Respuesta JSON con paginación y datos
        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
    public function guardar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $contenidowebcategoriaRequest = new ContenidoWebCategoriaValidation();
        $errores = $contenidowebcategoriaRequest->contenidoWebCategoriaGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados = [
            'idestado' => (int) $data['estado']['idEstado'] ?? null,
            'nombre' => $data['nombre'] ?? null,
            'idrcontenidowebcategoria' =>  $data['rContenidoWebCategoria']['idContenidoWebCategoria'] != 0 ? $data['rContenidoWebCategoria']['idContenidoWebCategoria'] : null,
            'orden' => $data['orden'] ?? null,
        ];



        $contenidowebcategoriaId = $this->contenidowebcategoria->guardar($datosValidados);
        $contenidowebcategoria = $this->contenidowebcategoria->find($contenidowebcategoriaId);
        if ($contenidowebcategoria) {
            $resultado = ContenidoWebCategoriaTransformer::transform($contenidowebcategoria);
            return $this->respond([
                "mensaje" => 'contenido web categoria registrado con éxito',
                "contenidowebcategoria" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar contenido web categoria"], 500);
        }
    }

    public function actualizar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $contenidowebcategoriaRequest = new ContenidoWebCategoriaValidation();
        $errores = $contenidowebcategoriaRequest->contenidowebcategoriaActualizarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }
        $datosValidados = [
            'idcontenidowebcategoria' => (int) $data['idContenidoWebCategoria'] ?? null,
            'idestado' => (int) $data['estado']['idEstado'] ?? null,
            'nombre' => $data['nombre'] ?? null,
            'idrcontenidowebcategoria' =>  $data['rContenidoWebCategoria']['idContenidoWebCategoria'] != 0 ? $data['rContenidoWebCategoria']['idContenidoWebCategoria'] : null,
            'orden' => $data['orden'] ?? null,
        ];

        $contenidowebcategoriaId = $this->contenidowebcategoria->guardar($datosValidados);
        $contenidowebcategoria = $this->contenidowebcategoria->find($contenidowebcategoriaId);
        if ($contenidowebcategoria) {

            $resultado = ContenidoWebCategoriaTransformer::transform($contenidowebcategoria);

            return $this->respond([
                "mensaje" => 'contenido web categoria actualizado con éxito',
                "contenidowebcategoria" =>   $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el contenido web categoria"], 500);
        }
    }

    public function eliminar($idcontenidowebcategoriacategoria)
    {
        if ($this->contenidowebcategoria->eliminar($idcontenidowebcategoriacategoria)) {
            return $this->respond(['mensaje' => 'contenido web categoria eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró el contenido web categoria');
        }
    }
    public function obtenerMaxOrden()
    {
        $maxOrden = $this->contenidowebcategoria->selectMax('orden')->first();
        $maxValue = $maxOrden ? $maxOrden->orden : 0;
        $maxValue += 1;
        return $this->response->setJSON(['max_orden' => $maxValue]);
    }
}
