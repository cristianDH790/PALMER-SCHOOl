<?php

namespace App\Controllers\Api;


use App\Entities\NoticiaCategoriaEntity;
use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Models\EstadoModel;
use App\Models\NoticiaCategoriaModel;
use App\Transformadores\NoticiaCategoriaCollectionTransformer;
use App\Transformadores\NoticiaCategoriaTransformer;
use App\Validation\NoticiaCategoriaValidation;
use CodeIgniter\RESTful\ResourceController;

class NoticiaCategoriaController extends ResourceController
{
    protected $noticiacategoria;
    protected $estado;

    public function __construct()
    {

        $this->noticiacategoria = new NoticiaCategoriaModel();
        $this->estado = new EstadoModel();
    }



    public  function obtenerPorId($idnoticiacategoria)
    {

        $noticiacategoria = $this->noticiacategoria->obtenerPorId($idnoticiacategoria);

        if (!$noticiacategoria) {
            return $this->respond(['mensaje' => 'No existe la noticia categoria solicitada'], 404);
        } else {


            // Convertir a array
            $resultado = NoticiaCategoriaTransformer::transform($noticiacategoria);

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

        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->noticiacategoria->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,

        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $noticiacategorias = $this->noticiacategoria->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,

            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad
        $resultado = NoticiaCategoriaCollectionTransformer::transform($noticiacategorias);

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
        $noticiacategoriaRequest = new NoticiaCategoriaValidation();
        $errores = $noticiacategoriaRequest->NoticiaCategoriaGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados = [
            'idestado' => $data['estado']['idEstado'] ?? null,
            'idrnoticiacategoria' => $data['rNoticiaCategoria']['idNoticiaCategoria'] ?? null,
            'nombre' => $data['nombres'] ?? null,
            'orden' => $data['orden'] ?? null,
            // 'urlamigable' => $data['urlAmigable'] ?? null,
         

        ];



        $noticiacategoriaId = $this->noticiacategoria->guardar($datosValidados);
        $noticiacategoria = $this->noticiacategoria->find($noticiacategoriaId);
        if ($noticiacategoria) {

            $resultado = NoticiaCategoriaTransformer::transform($noticiacategoria);




            return $this->respond([
                "mensaje" => 'noticiacategoria registrado con éxito',
                "noticiacategoria" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar noticiacategoria"], 500);
        }
    }

    public function actualizar()
    {
      
        $request = $this->request;

        $data = $request->getJSON(true);
        $noticiacategoriaRequest = new NoticiaCategoriaValidation();
        $errores = $noticiacategoriaRequest->NoticiaCategoriaActualizarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }
        $datosValidados = [
            'idnoticiacategoria' => (int) $data['idNoticiaCategoria'] ?? null,
            'idestado' => $data['estado']['idEstado'] ?? null,
            'idrnoticiacategoria' => $data['rNoticiaCategoria']['idNoticiaCategoria'] ?? null,
            'orden' => $data['orden'] ?? null,
            'nombre' => $data['nombres'] ?? null,
            // 'urlamigable' => $data['urlAmigable'] ?? null,
          
        ];

        $noticiacategoriaId = $this->noticiacategoria->guardar($datosValidados);
        $noticiacategoria = $this->noticiacategoria->find($noticiacategoriaId);
        if ($noticiacategoria) {

            $resultado = NoticiaCategoriaTransformer::transform($noticiacategoria);

            return $this->respond([
                "mensaje" => 'noticia categoria actualizado con éxito',
                "noticiacategoria" =>  $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el noticiacategoria"], 500);
        }
    }

    public function eliminar($idnoticiacategoria)
    {
       
        if ($this->noticiacategoria->eliminar($idnoticiacategoria)) {
            return $this->respond(['mensaje' => 'noticiacategoria eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró la noticiacategoria');
        }
    }
}
