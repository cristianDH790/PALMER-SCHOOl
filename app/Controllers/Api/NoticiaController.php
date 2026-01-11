<?php

namespace App\Controllers\Api;

use App\Entities\NoticiaEntity;
use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\NoticiaCategoriaModel;
use App\Models\NoticiaModel;
use App\Models\ParametroModel;
use App\Transformadores\NoticiaCollectionTransformer;
use App\Transformadores\NoticiaTransformer;
use App\Validation\NoticiaValidation;
use CodeIgniter\RESTful\ResourceController;

class NoticiaController extends ResourceController
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
    public function guardar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $noticiaRequest = new NoticiaValidation();
        $errores = $noticiaRequest->NoticiaGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados =
            [
                'idestado'             => $data['estado']['idEstado'] ?? null,
                'idnoticiacategoria'   => $data['noticiaCategoria']['idNoticiaCategoria'] ?? null,
                'idusuario'            => $data['usuario']['idUsuario'] ?? null,
                'idpdestacado'         => $data['pDestacado']['idParametro'] ?? null,
                'nombre'               => $data['nombre'] ?? null,
                'urlamigable'          => $data['urlAmigable'] ?? null,
                'descripcionseo'       => $data['descripcionSeo'] ?? null,
                'palabrasclaveseo'     => $data['palabrasClaveSeo'] ?? null,
                'tituloseo'            => $data['tituloSeo'] ?? null,
                'resumen'              => $data['resumen'] ?? null,
                'contenido'            => $data['contenido'] ?? null,
                'urlimagen'            => $data['urlImagen'] ?? null,
                'orden'                => $data['orden'] ?? null,
                // 'fechapublicacion'     => $data['fechaPublicacion'] ?? null,
            ];



        $noticiaId = $this->noticia->guardar($datosValidados);
        $noticia = $this->noticia->find($noticiaId);
        if ($noticia) {

            $resultado = NoticiaTransformer::transform($noticia);

            return $this->respond([
                "mensaje" => 'noticia registrado con éxito',
                "noticia" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar noticia"], 500);
        }
    }

    public function actualizar()
    {
        $request = $this->request;

        $data = $request->getJSON(true);
        $noticiaRequest = new NoticiaValidation();
        $errores = $noticiaRequest->NoticiaGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }
        $datosValidados = [
            'idnoticia' => (int) $data['idNoticia'] ?? null,
            'idestado'             => $data['estado']['idEstado'] ?? null,
            'idnoticiacategoria'   => $data['noticiaCategoria']['idNoticiaCategoria'] ?? null,
            'idusuario'            => $data['usuario']['idUsuario'] ?? null,
            'idpdestacado'         => $data['pDestacado']['idParametro'] ?? null,
            'nombre'               => $data['nombre'] ?? null,
            'urlamigable'          => $data['urlAmigable'] ?? null,
            'descripcionseo'       => $data['descripcionSeo'] ?? null,
            'palabrasclaveseo'     => $data['palabrasClaveSeo'] ?? null,
            'tituloseo'            => $data['tituloSeo'] ?? null,
            'resumen'              => $data['resumen'] ?? null,
            'contenido'            => $data['contenido'] ?? null,
            'urlimagen'            => $data['urlImagen'] ?? null,
            'orden'                => $data['orden'] ?? null,
            // 'fechapublicacion'     => $data['fechaPublicacion'] ?? null,
        ];



        $noticiaId = $this->noticia->guardar($datosValidados);
        $noticia = $this->noticia->find($noticiaId);
        if ($noticia) {

            $resultado = NoticiaTransformer::transform($noticia);

            return $this->respond([
                "mensaje" => 'noticia actualizado con éxito',
                "noticia" =>  $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el noticia"], 500);
        }
    }

    public function eliminar($idnoticia)
    {

        if ($this->noticia->eliminar($idnoticia)) {
            return $this->respond(['mensaje' => 'noticia eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró la noticia');
        }
    }



    public function uploadImagen()
    {
        $idnoticia = $this->request->getPost('idNoticia');

        if (!$idnoticia) {
            return $this->response->setJSON([
                'mensaje' => 'idnoticia es obligatorio'
            ])->setStatusCode(400);
        }

        // 🔹 ENTITY (igual que slider)
        $noticia = $this->noticia->find($idnoticia);

        if (!$noticia) {
            return $this->response->setJSON([
                'mensaje' => 'No existe el noticia solicitado'
            ])->setStatusCode(404);
        }

        $file = $this->request->getFile('archivo');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'mensaje' => 'No se recibió archivo válido'
            ])->setStatusCode(400);
        }

        // 🧹 Eliminar imagen anterior
        if (!empty($noticia->urlimagen)) {
            $imgPath = FCPATH . env('URL_IMAGE') . '/noticia/' . $noticia->urlimagen;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // 📝 Nombre amigable (campo REAL de noticia)
        $nombre = trim($noticia->nombre ?? 'noticia');
        $urlamigable = Util::urls_amigables($nombre);

        $nombreArchivo = $idnoticia . '-' . $urlamigable . '-' . time() . '.' . $file->getExtension();

        // 📁 Carpeta
        $destino = FCPATH . env('URL_IMAGE') . '/noticia';
        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        // 📦 Mover archivo
        $file->move($destino, $nombreArchivo);

        // 💾 Actualizar DB
        $this->noticia->update($idnoticia, [
            'urlimagen' => $nombreArchivo
        ]);

        $noticiaActualizado = $this->noticia->find($idnoticia);

        return $this->response->setJSON([
            'noticia'   => noticiaTransformer::transform($noticiaActualizado),
            'mensaje' => 'Imagen cargada con éxito'
        ])->setStatusCode(200);
    }


    public function eliminarImagen()
    {
        $idnoticia = $this->request->getPost('idNoticia')
            ?? $this->request->getJSON(true)['idNoticia']
            ?? null;

        if (!$idnoticia) {
            return $this->response->setJSON([
                'mensaje' => 'idnoticia es obligatorio'
            ])->setStatusCode(400);
        }

        // 🔹 ENTITY
        $noticia = $this->noticia->find($idnoticia);

        if (!$noticia) {
            return $this->response->setJSON([
                'mensaje' => 'No existe el noticia solicitado'
            ])->setStatusCode(404);
        }

        // 🧹 Eliminar imagen física
        if (!empty($noticia->urlimagen)) {
            $imgPath = FCPATH . env('URL_IMAGE') . '/noticia/' . $noticia->urlimagen;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // 💾 Limpiar campo en BD
        $this->noticia->update($idnoticia, [
            'urlimagen' => null
        ]);

        $noticiaActualizado = $this->noticia->find($idnoticia);

        return $this->response->setJSON([
            'noticia'   => NoticiaTransformer::transform($noticiaActualizado),
            'mensaje' => 'Imagen de noticia eliminada con éxito'
        ])->setStatusCode(200);
    }
    public function obtenerMaxOrden()
    {
        $maxOrden = $this->noticia->selectMax('orden')->first();
        $maxValue = $maxOrden ? $maxOrden->orden : 0;
        $maxValue += 1;
        return $this->response->setJSON(['max_orden' => $maxValue]);
    }

    public function actualizarOrden()
    {
        $data = $this->request->getJSON(true);

        foreach ($data as $item) {
            $this->noticia->update($item['idNoticia'], ['orden' => $item['orden']]);
        }

        return $this->response->setJSON([
            'mensaje' => 'Orden actualizado correctamente'
        ]);
    }
    public function actualizarDestacado()
    {
        $data = $this->request->getJSON(true); // Array de objetos [{idProducto, idParametro}]

        foreach ($data as $item) {
            $this->noticia
                ->where('idnoticia', $item['idNoticia'])
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
