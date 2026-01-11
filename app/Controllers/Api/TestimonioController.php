<?php

namespace App\Controllers\Api;

use App\Helpers\Paginator;
use App\Helpers\Permisos;
use App\Helpers\Util;

use App\Models\EstadoModel;
use App\Models\ParametroModel;

use App\Models\TestimonioModel;

use App\Transformadores\ProductoCollectionTransformer;
use App\Transformadores\TestimoniCollectionTransformer;
use App\Transformadores\TestimonioCollectionTransformer;
use App\Transformadores\TestimonioTransformer;
use App\Validation\TestimonioValidation;
use CodeIgniter\RESTful\ResourceController;



class TestimonioController extends ResourceController
{

    protected $testimonio;
    protected $productocategoria;
    protected $estado;
    protected $promocion;
    protected $parametro;
    protected $marca;
    protected $permiso;

    public function __construct()
    {
        $this->testimonio = new TestimonioModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
    }


    public  function obtenerPorId($idtestimonio)
    {

        $testimonio = $this->testimonio->obtenerPorId(
            $idtestimonio
        );

        if (!$testimonio) {
            return $this->respond(['mensaje' => 'No existe el testimonio solicitado'], 404);
        } else {

            $resultado = TestimonioTransformer::transform($testimonio);

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


        $idpdestacado = (int) ($request->getVar('idpDestacado') ?? 0);

        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->testimonio->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idpdestacado
        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $productobases = $this->testimonio->buscarPor(
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
        $resultado = TestimonioCollectionTransformer::transform($productobases);
        // Respuesta JSON con paginación y datos
        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
    public function guardar()
    {
        // if ($respuesta = $this->verificarPermiso('api_producto_guardar')) {
        //     return $respuesta;
        // }
        $request = $this->request;

        $data = $request->getJSON(true);
        $productobaseRequest = new TestimonioValidation();
        $errores = $productobaseRequest->testimonioGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados =
            [
                'idestado' => $data['estado']['idEstado'] ?? null,
                'idpdestacado' => $data['pDestacado']['idParametro'] ?? null,
                'nombre' => $data['nombre'] ?? null,
                'descripcion' => $data['descripcion'] ?? null,
                'urlimagen' => $data['urlImagen'] ?? null,
                'dni' => $data['dni'] ?? null,
                'orden' => $data['orden'] ?? null,

            ];



        $productobaseId = $this->testimonio->guardar($datosValidados);
        $testimonio = $this->testimonio->find($productobaseId);
        if ($testimonio) {

            $resultado = TestimonioTransformer::transform($testimonio);
            return $this->respond([
                "mensaje" => 'forma pago registrado con éxito',
                "testimonio" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar testimonio"], 500);
        }
    }

    public function actualizar()
    {
        // if ($respuesta = $this->verificarPermiso('api_producto_actualizar')) {
        //     return $respuesta;
        // }
        $request = $this->request;

        $data = $request->getJSON(true);
        $productobaseRequest = new TestimonioValidation();
        $errores = $productobaseRequest->testimonioActualizarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados = [
            'idtestimonio' => (int) $data['idTestimonio'] ?? null,
            'idestado' => $data['estado']['idEstado'] ?? null,
            'idpdestacado' => $data['pDestacado']['idParametro'] ?? null,
            'nombre' => $data['nombre'] ?? null,
            'descripcion' => $data['descripcion'] ?? null,
            'urlimagen' => $data['urlImagen'] ?? null,
            'dni' => $data['dni'] ?? null,
            'orden' => $data['orden'] ?? null,


        ];


        $productobaseId = $this->testimonio->guardar($datosValidados);
        $testimonio = $this->testimonio->find($productobaseId);
        if ($testimonio) {

            $resultado = TestimonioTransformer::transform($testimonio);
            return $this->respond([
                "mensaje" => 'Testimonio base actualizado con éxito',
                "testimonio" =>  $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el testimonio base"], 500);
        }
    }

    public function eliminar($idtestimonio)
    {

        if ($this->testimonio->eliminar(
            $idtestimonio
        )) {
            return $this->respond(['mensaje' => 'Producto base eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró la testimonio base');
        }
    }



    public function uploadImagen1()
    {

        $idTestimonioImagen = $this->request->getPost('idTestimonio');
        $testimonioImagen = $this->testimonio->find($idTestimonioImagen);

        if (!$testimonioImagen) {
            return $this->response->setJSON(["mensaje" => 'No existe testimonio solicitado'])->setStatusCode(404);
        }

        // Convierte a array para evitar errores (si quieres)
        if (!is_array($testimonioImagen)) {
            $testimonioImagen = (array) $testimonioImagen;
        }

        $file = $this->request->getFile('archivo');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(["mensaje" => 'Debe de seleccionar una imagen'])->setStatusCode(400);
        }

        // Elimina imagen anterior
        $imgPath = FCPATH . env('URL_IMAGE') . '/testimonio/' . ($testimonioImagen['urlimagen'] ?? '');
        if (!empty($testimonioImagen['urlimagen']) && file_exists($imgPath)) {
            unlink($imgPath);
        }

        // Genera nombre amigable
        $nombreCompleto = trim($testimonioImagen['nombre'] ?? '');
        $urlamigable = Util::urls_amigables($nombreCompleto ?: 'testimonio');

        // Usa el id para formar nombre único
        $nombrearchivo = $idTestimonioImagen . '-' . $urlamigable . '-' . time() . '.' . $file->getExtension();

        // Asegura carpeta destino
        $destino = FCPATH . env('URL_IMAGE') . '/testimonio';
        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        // Mueve el archivo
        $file->move($destino, $nombrearchivo);

        // Actualiza en DB
        $this->testimonio->update($idTestimonioImagen, ['urlimagen' => $nombrearchivo]);

        // Obtener actualizado y convertir si es necesario
        $testimonioImagenActualizado = $this->testimonio->find($idTestimonioImagen);
        $resultado = TestimonioTransformer::transform($testimonioImagenActualizado);


        return $this->response->setJSON([
            "testimonio" =>  $resultado,
            "mensaje" => "Imagen cargada con éxito",
            "request" => $this->request->getPost()
        ])->setStatusCode(200);
    }



    public function eliminarImagen($idtestimonio)
    {

        if (empty($idtestimonio)) {
            return $this->response->setJSON(['errors' => ['ID de testimonio no recibido']])->setStatusCode(400);
        }

        $testimonioImagen = $this->testimonio->find($idtestimonio);

        if (!$testimonioImagen) {
            return $this->response->setJSON(['errors' => ['No existe el testimonioImagen solicitado']])->setStatusCode(404);
        }

        $urlimagen = is_array($testimonioImagen) ? ($testimonioImagen['urlimagen'] ?? null) : $testimonioImagen->urlimagen;
        $imgPath = FCPATH . env('URL_IMAGE') . '/testimonio/' . $urlimagen;
        if (!empty($urlimagen) && file_exists($imgPath)) {
            unlink($imgPath);
        }

        // Aquí $idproductoImagen nunca será null
        $this->testimonio->update($idtestimonio, ['urlimagen' => null]);

        $productoImagenActualizado = $this->testimonio->find($idtestimonio);
        $resultado = TestimonioTransformer::transform($productoImagenActualizado);

        return $this->response->setJSON([
            "testimonio" => $resultado,
            "mensaje" => "Imagen de testimonio eliminada con éxito"
        ])->setStatusCode(200);
    }

    public function obtenerMaxOrden()
    {
        $maxOrden = $this->testimonio->selectMax('orden')->first();
        $maxValue = $maxOrden ? $maxOrden->orden : 0;
        $maxValue += 1;
        return $this->response->setJSON(['max_orden' => $maxValue]);
    }

    public function actualizarOrden()
    {
        $data = $this->request->getJSON(true);

        foreach ($data as $item) {
            $this->testimonio->update($item['idTestimonio'], ['orden' => $item['orden']]);
        }

        return $this->response->setJSON([
            'mensaje' => 'Orden actualizado correctamente'
        ]);
    }
    public function actualizarDestacado()
    {
        $data = $this->request->getJSON(true); // Array de objetos [{idProducto, idParametro}]

        foreach ($data as $item) {
            $this->testimonio
                ->where('idtestimonio', $item['idTestimonio'])
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
