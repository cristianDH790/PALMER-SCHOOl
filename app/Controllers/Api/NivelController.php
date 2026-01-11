<?php

namespace App\Controllers\Api;

use App\Helpers\Paginator;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\NoticiaCategoriaModel;
use App\Models\NivelModel;
use App\Models\ParametroModel;
use App\Transformadores\NivelCollectionTransformer;
use App\Transformadores\NivelTransformer;
use App\Validation\NivelValidation;
use CodeIgniter\RESTful\ResourceController;

class NivelController extends ResourceController
{

    protected $nivel;

    public function __construct()
    {

        $this->nivel = new NivelModel();
    }


    public  function obtenerPorId($idnivel)
    {

        $nivel = $this->nivel->obtenerPorId($idnivel);

        if (!$nivel) {
            return $this->respond(['mensaje' => 'No existe la nivel solicitada'], 404);
        } else {

            // Convertir a array
            $resultado = NivelTransformer::transform($nivel);

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

        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->nivel->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idpdestacado,
        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $niveles = $this->nivel->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idpdestacado,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad
        $resultado = NivelCollectionTransformer::transform($niveles);

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
        $noticiaRequest = new NivelValidation();
        $errores = $noticiaRequest->NivelGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados =
            [
                'idestado'             => $data['estado']['idEstado'] ?? null,
                'idpdestacado'         => $data['pDestacado']['idParametro'] ?? null,
                'nombre'               => $data['nombre'] ?? null,
                'urlamigable'          => $data['urlAmigable'] ?? null,
                'descripcionseo'       => $data['descripcionSeo'] ?? null,
                'resumen'              => $data['resumen'] ?? null,
                'contenido'            => $data['contenido'] ?? null,
                'urlimagen'            => $data['urlImagen'] ?? null,
                'orden'                => $data['orden'] ?? null,
                // 'fechapublicacion'     => $data['fechaPublicacion'] ?? null,
            ];



        $nivelId = $this->nivel->guardar($datosValidados);
        $nivel = $this->nivel->find($nivelId);
        if ($nivel) {

            $resultado = NivelTransformer::transform($nivel);

            return $this->respond([
                "mensaje" => 'nivel registrado con éxito',
                "nivel" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar nivel"], 500);
        }
    }

    public function actualizar()
    {
        $request = $this->request;

        $data = $request->getJSON(true);
        $noticiaRequest = new NivelValidation();
        $errores = $noticiaRequest->NivelActualizarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }
        $datosValidados = [
            'idnivel' => (int) $data['idNivel'] ?? null,
            'idestado'             => $data['estado']['idEstado'] ?? null,
            'idpdestacado'         => $data['pDestacado']['idParametro'] ?? null,
            'nombre'               => $data['nombre'] ?? null,
            'urlamigable'          => $data['urlAmigable'] ?? null,
            'descripcionseo'       => $data['descripcionSeo'] ?? null,
            'resumen'              => $data['resumen'] ?? null,
            'contenido'            => $data['contenido'] ?? null,
            'urlimagen'            => $data['urlImagen'] ?? null,
            'orden'                => $data['orden'] ?? null,
            // 'fechapublicacion'     => $data['fechaPublicacion'] ?? null,
        ];



        $nivelId = $this->nivel->guardar($datosValidados);
        $nivel = $this->nivel->find($nivelId);
        if ($nivel) {

            $resultado = NivelTransformer::transform($nivel);

            return $this->respond([
                "mensaje" => 'nivel actualizado con éxito',
                "nivel" =>  $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el nivel"], 500);
        }
    }

    public function eliminar($idnivel)
    {

        if ($this->nivel->eliminar($idnivel)) {
            return $this->respond(['mensaje' => 'nivel eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró la nivel');
        }
    }


    public function uploadImagen()
    {
        $idNivel = $this->request->getPost('idNivel');

        if (!$idNivel) {
            return $this->response->setJSON([
                'mensaje' => 'idNivel es obligatorio'
            ])->setStatusCode(400);
        }

        // 🔹 ENTITY (igual que slider)
        $nivel = $this->nivel->find($idNivel);

        if (!$nivel) {
            return $this->response->setJSON([
                'mensaje' => 'No existe el nivel solicitado'
            ])->setStatusCode(404);
        }

        $file = $this->request->getFile('archivo');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'mensaje' => 'No se recibió archivo válido'
            ])->setStatusCode(400);
        }

        // 🧹 Eliminar imagen anterior
        if (!empty($nivel->urlimagen)) {
            $imgPath = FCPATH . env('URL_IMAGE') . '/nivel/' . $nivel->urlimagen;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // 📝 Nombre amigable (campo REAL de Nivel)
        $nombre = trim($nivel->nombre ?? 'nivel');
        $urlamigable = Util::urls_amigables($nombre);

        $nombreArchivo = $idNivel . '-' . $urlamigable . '-' . time() . '.' . $file->getExtension();

        // 📁 Carpeta
        $destino = FCPATH . env('URL_IMAGE') . '/nivel';
        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        // 📦 Mover archivo
        $file->move($destino, $nombreArchivo);

        // 💾 Actualizar DB
        $this->nivel->update($idNivel, [
            'urlimagen' => $nombreArchivo
        ]);

        $nivelActualizado = $this->nivel->find($idNivel);

        return $this->response->setJSON([
            'nivel'   => NivelTransformer::transform($nivelActualizado),
            'mensaje' => 'Imagen cargada con éxito'
        ])->setStatusCode(200);
    }


    public function eliminarImagen()
    {
        $idNivel = $this->request->getPost('idNivel')
            ?? $this->request->getJSON(true)['idNivel']
            ?? null;

        if (!$idNivel) {
            return $this->response->setJSON([
                'mensaje' => 'idNivel es obligatorio'
            ])->setStatusCode(400);
        }

        // 🔹 ENTITY
        $nivel = $this->nivel->find($idNivel);

        if (!$nivel) {
            return $this->response->setJSON([
                'mensaje' => 'No existe el nivel solicitado'
            ])->setStatusCode(404);
        }

        // 🧹 Eliminar imagen física
        if (!empty($nivel->urlimagen)) {
            $imgPath = FCPATH . env('URL_IMAGE') . '/nivel/' . $nivel->urlimagen;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // 💾 Limpiar campo en BD
        $this->nivel->update($idNivel, [
            'urlimagen' => null
        ]);

        $nivelActualizado = $this->nivel->find($idNivel);

        return $this->response->setJSON([
            'nivel'   => NivelTransformer::transform($nivelActualizado),
            'mensaje' => 'Imagen de nivel eliminada con éxito'
        ])->setStatusCode(200);
    }
    public function obtenerMaxOrden()
    {
        $maxOrden = $this->nivel->selectMax('orden')->first();
        $maxValue = $maxOrden ? $maxOrden->orden : 0;
        $maxValue += 1;
        return $this->response->setJSON(['max_orden' => $maxValue]);
    }

    public function actualizarOrden()
    {
        $data = $this->request->getJSON(true);

        foreach ($data as $item) {
            $this->nivel->update($item['idNivel'], ['orden' => $item['orden']]);
        }

        return $this->response->setJSON([
            'mensaje' => 'Orden actualizado correctamente'
        ]);
    }
    public function actualizarDestacado()
    {
        $data = $this->request->getJSON(true); // Array de objetos [{idProducto, idParametro}]

        foreach ($data as $item) {
            $this->nivel
                ->where('idnivel', $item['idNivel'])
                ->set(['idpdestacado' => $item['idParametro']])
                ->update();
        }

        return $this->respond([
            'status' => true,
            'message' => 'Testimonios destacados actualizados correctamente',
            'data' => $data
        ]);
    }
}
