<?php

namespace App\Controllers\Api;

use App\Entities\SliderEntity;
use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\ParametroModel;
use App\Models\SliderModel;
use App\Transformadores\SliderCollectionTransformer;
use App\Transformadores\SliderTransformer;
use App\Validation\SliderValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class SliderController extends ResourceController
{

    protected $slider;
    protected $estado;
    protected $parametro;

    public function __construct()
    {
     
        $this->slider = new SliderModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
    }
    public  function obtenerPorId($idslider)
    {

        $slider = $this->slider->obtenerPorId($idslider);

        if (!$slider) {
            return $this->respond(['mensaje' => 'No existe la slider solicitada'], 404);
        } else {

            $resultado = SliderTransformer::transform($slider);
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
        $idpcategoria = (int) ($request->getVar('idpCategoria') ?? 0);



        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->slider->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idpcategoria,

        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $sliders = $this->slider->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idpcategoria,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );



        $resultado = SliderCollectionTransformer::transform($sliders);


        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
    public function guardar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $sliderRequest = new SliderValidation();
        $errores = $sliderRequest->sliderGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados = [
            'idestado'      => $data['estado']['idEstado'] ?? null,
            'nombre'        => $data['nombre'] ?? null,
            'descripcion'   => $data['descripcion'] ?? null,
            'idprecurso'  =>  $data['pRecurso']['idParametro'] ?? null,
            'urlrecurso'    => $data['urlRecurso'] ?? null,
            'orden'         => $data['orden'] ?? null,
        ];


        $sliderId = $this->slider->guardar($datosValidados);
        $slider = $this->slider->find($sliderId);
        if ($slider) {
            $resultado = SliderTransformer::transform($slider);
            return $this->respond([
                "mensaje" => 'slider registrado con éxito',
                "slider" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar slider"], 500);
        }
    }

    public function actualizar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $sliderRequest = new SliderValidation();
        $errores = $sliderRequest->SliderActualizarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }
        $datosValidados = [
            'idslider' => (int) $data['idSlider'] ?? null,
            'idestado'      => $data['estado']['idEstado'] ?? null,
            'nombre'        => $data['nombre'] ?? null,
            'descripcion'   => $data['descripcion'] ?? null,
            'idprecurso'  =>  $data['pRecurso']['idParametro'] ?? null,
            'urlrecurso'    => $data['urlRecurso'] ?? null,
            'orden'         => $data['orden'] ?? null,
        ];


        $sliderId = $this->slider->guardar($datosValidados);
        $slider = $this->slider->find($sliderId);
        if ($slider) {

            $resultado = SliderTransformer::transform($slider);
            return $this->respond([
                "mensaje" => 'slider actualizado con éxito',
                "slider" =>    $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el slider"], 500);
        }
    }

    public function eliminar($idslider)
    {
        if ($this->slider->eliminar($idslider)) {
            return $this->respond(['mensaje' => 'slider eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró la slider');
        }
    }


    public function uploadImagen1()
    {
        $idslider = $this->request->getPost('idSlider');

        if (!$idslider) {
            return $this->response->setJSON([
                'mensaje' => 'idSlider es obligatorio'
            ])->setStatusCode(400);
        }

        $slider = $this->slider->find($idslider);

        if (!$slider) {
            return $this->response->setJSON([
                "mensaje" => "No existe la slider solicitada"
            ])->setStatusCode(404);
        }

        $file = $this->request->getFile('archivo');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                "mensaje" => "No se recibió archivo válido"
            ])->setStatusCode(400);
        }

        // Elimina imagen anterior
        if (!empty($slider->urlimagen1)) {
            $imgPath = FCPATH . env('URL_IMAGE') . '/slider/' . $slider->urlimagen1;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // Nombre amigable
        $nombre = trim($slider->nombre ?? 'slider');
        $urlamigable = Util::urls_amigables($nombre);

        $nombrearchivo = $idslider . '-' . $urlamigable . '-escritorio-' . time() . '.' . $file->getExtension();

        // Carpeta
        $destino = FCPATH . env('URL_IMAGE') . '/slider';
        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        // Mover archivo
        $file->move($destino, $nombrearchivo);

        // Actualizar DB
        $this->slider->update($idslider, [
            'urlarchivo1' => $nombrearchivo
        ]);

        $sliderActualizado = $this->slider->find($idslider);

        return $this->response->setJSON([
            "slider" => SliderTransformer::transform($sliderActualizado),
            "mensaje" => "Imagen cargada con éxito"
        ])->setStatusCode(200);
    }

    public function uploadImagen2()
    {
        $idslider = $this->request->getPost('idSlider');

        if (!$idslider) {
            return $this->response->setJSON([
                'mensaje' => 'idSlider es obligatorio'
            ])->setStatusCode(400);
        }

        $slider = $this->slider->find($idslider);

        if (!$slider) {
            return $this->response->setJSON([
                "mensaje" => "No existe la slider solicitada"
            ])->setStatusCode(404);
        }

        $file = $this->request->getFile('archivo');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                "mensaje" => "No se recibió archivo válido"
            ])->setStatusCode(400);
        }

        // Eliminar imagen anterior
        if (!empty($slider->urlimagen2)) {
            $imgPath = FCPATH . env('URL_IMAGE') . '/slider/' . $slider->urlimagen2;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // Nombre amigable
        $nombre = trim($slider->nombre ?? 'slider');
        $urlamigable = Util::urls_amigables($nombre);

        $nombrearchivo = $idslider . '-' . $urlamigable . '-celular-' . time() . '.' . $file->getExtension();

        // Carpeta destino
        $destino = FCPATH . env('URL_IMAGE') . '/slider';
        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        // Mover archivo
        $file->move($destino, $nombrearchivo);

        // Actualizar DB
        $this->slider->update($idslider, [
            'urlarchivo2' => $nombrearchivo
        ]);

        $sliderActualizado = $this->slider->find($idslider);

        return $this->response->setJSON([
            "slider" => SliderTransformer::transform($sliderActualizado),
            "mensaje" => "Imagen cargada con éxito"
        ])->setStatusCode(200);
    }

    public function eliminarImagen()
    {
        $data = $this->request->getJSON(true); // convierte JSON a array asociativo

        $idslider = $data['idSlider'] ?? null;
        $tipo = $data['tipo'] ?? null;

        if (empty($idslider)) {
            return $this->response->setJSON(['errors' => ['ID de slider no recibido']])->setStatusCode(400);
        }

        $slider = $this->slider->find($idslider);
        if (!$slider) {
            return $this->response->setJSON(['errors' => ['No existe el slider solicitado']])->setStatusCode(404);
        }

        // Determinar qué campo actualizar según $tipo
        $campo = ($tipo === 'urlimagen2') ? 'urlimagen2' : 'urlimagen1';

        $urlimagen = is_array($slider) ? ($slider[$campo] ?? null) : ($slider->$campo ?? null);

        $imgPath = FCPATH . env('URL_IMAGE') . '/slider/' . $urlimagen;
        if (!empty($urlimagen) && file_exists($imgPath)) {
            unlink($imgPath);
        }

        $this->slider->update($idslider, [$campo => null]);

        $sliderActualizado = $this->slider->find($idslider);
        $resultado = SliderTransformer::transform($sliderActualizado);

        return $this->response->setJSON([
            "slider" => $resultado,
            "mensaje" => "Imagen eliminada con éxito"
        ])->setStatusCode(200);
    }

      public function obtenerMaxOrden()
    {
        $maxOrden = $this->slider->selectMax('orden')->first();
        $maxValue = $maxOrden ? $maxOrden->orden : 0;
        $maxValue += 1;
        return $this->response->setJSON(['max_orden' => $maxValue]);
    }

     public function actualizarOrden()
    {
        $data = $this->request->getJSON(true); 

        foreach ($data as $item) {
            $this->slider->update($item['idSlider'], ['orden' => $item['orden']]);
        }

        return $this->response->setJSON([
            'mensaje' => 'Orden actualizado correctamente'
        ]);
    }
}
