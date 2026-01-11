<?php

namespace App\Controllers\Api;


use App\Helpers\Paginator;
use App\Helpers\Permisos;

use App\Models\EstadoModel;
use App\Models\MenuModel;
use App\Models\ParametroModel;
use App\Transformadores\MenuCollectionTransformer;
use App\Transformadores\MenuTransformer;
use App\Validation\MenuValidation;
use CodeIgniter\RESTful\ResourceController;

class MenuController extends ResourceController
{

    protected $menu;
    protected $productoBase;
    protected $estado;
    protected $empresa;
    protected $parametro;

    public function __construct()
    {

        $this->menu = new MenuModel();
        $this->estado = new EstadoModel();
        $this->parametro = new ParametroModel();
    }



    public  function obtenerPorId($idmenu)
    {
        // if ($respuesta = $this->verificarPermiso('api_menu_obtenerPorId')) {
        //     return $respuesta;
        // }
        $menu = $this->menu->obtenerPorId($idmenu);

        if (!$menu) {
            return $this->respond(['mensaje' => 'No existe la menu solicitada'], 404);
        } else {

            $resultado = MenuTransformer::transform($menu);



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
        $ordencriterio = $request->getVar('ordenCriterio') ?? 'fecha';
        $ordentipo = $request->getVar('ordenTipo') ?? 'asc';
        $parametro = $request->getVar('parametro') ?? '';
        $valor = $request->getVar('valor') ?? '';
        $idestado = (int) ($request->getVar('idEstado') ?? 0);
        $idrmenu = (int) ($request->getVar('idrMenu') ?? 0);
        $idptipo = (int) ($request->getVar('idPTipo') ?? 0);
        $idpubicacion = (int) ($request->getVar('idPPublicacion') ?? 0);
        // Parámetros de paginación
        $pagina = (int) ($request->getVar('pagina') ?? 1);
        $registros = (int) ($request->getVar('registros') ?? 10);

        // Total de registros
        $total = $this->menu->buscarPorTotal(
            $parametro,
            $valor,
            $idestado,
            $idrmenu,
            $idptipo,
            $idpubicacion

        );

        $paginator = new Paginator($pagina, $registros, $total);
        // Consulta paginada
        $productoImagens = $this->menu->buscarPor(
            $ordencriterio,
            $ordentipo,
            $parametro,
            $valor,
            $idestado,
            $idrmenu,
            $idptipo,
            $idpubicacion,
            $paginator->getFirstElement(),
            $paginator->getSize()
        );

        // Convertir resultados a entidad

        $resultado = MenuCollectionTransformer::transform($productoImagens);

        return $this->respond([
            'paginator' => $paginator->enviar(),
            'content' => $resultado
        ]);
    }
    public function guardar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $menuRequest = new MenuValidation();
        $errores = $menuRequest->menuGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }

        $datosValidados = [
            'idestado'      => $data['estado']['idEstado'] ?? null,
            'idptipo'  => $data['pTipo']['idParametro'] ?? null,
            'idpubicacion'  => $data['pUbicacion']['idParametro'] ?? null,
            'idpdestino'  => $data['pDestino']['idParametro'] ?? null,
            'idrmenu'  => (!empty($data['rMenu']['idMenu']) && $data['rMenu']['idMenu'] != 0)
                ? $data['rMenu']['idMenu']
                : null,
            'nombre'        => $data['nombre'] ?? null,
            'destino'      => $data['destino'] ?? null,
            'orden'    => $data['orden'] ?? null,
            'urlrecurso'   => $data['urlrecurso'] ?? null,
            'seccion'   => $data['seccion'] ?? null,
        ];


        $menuId = $this->menu->guardar($datosValidados);
        $menu = $this->menu->find($menuId);
        if ($menu) {

            $resultado = MenuTransformer::transform($menu);

            return $this->respond([
                "mensaje" => 'menu registrado con éxito',
                "menu" => $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al registrar menu"], 500);
        }
    }

    public function actualizar()
    {

        $request = $this->request;

        $data = $request->getJSON(true);
        $menuRequest = new MenuValidation();
        $errores = $menuRequest->menuGuardarValidation($data);

        if (!empty($errores)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['errors' => $errores]);
        }
        $datosValidados = [
            'idmenu' => (int) $data['idMenu'] ?? null,
            'idestado'      => $data['estado']['idEstado'] ?? null,
            'idptipo'  => $data['pTipo']['idParametro'] ?? null,
            'idpubicacion'  => $data['pUbicacion']['idParametro'] ?? null,
            'idpdestino'  => $data['pDestino']['idParametro'] ?? null,
            'idrmenu'  => (!empty($data['rMenu']['idMenu']) && $data['rMenu']['idMenu'] != 0)
                ? $data['rMenu']['idMenu']
                : null,
            'nombre'        => $data['nombre'] ?? null,
            'destino'      => $data['destino'] ?? null,
            'orden'    => $data['orden'] ?? null,
            'urlrecurso'   => $data['urlrecurso'] ?? null,
            'seccion'   => $data['seccion'] ?? null,
        ];


        $menuId = $this->menu->guardar($datosValidados);
        $menu = $this->menu->find($menuId);
        if ($menu) {

            $resultado = MenuTransformer::transform($menu);
            return $this->respond([
                "mensaje" => 'producto Imagen actualizado con éxito',
                "menu" =>  $resultado
            ], 201);
        } else {

            return $this->respond(["mensaje" => "Error al actualizar el producto Imagen"], 500);
        }
    }

    public function eliminar($idmenu)
    {

        if ($this->menu->eliminar($idmenu)) {
            return $this->respond(['mensaje' => 'menu eliminado con éxito']);
        } else {
            return $this->failNotFound('No se encontró la producto Imagen');
        }
    }
    public function obtenerMaxOrden()
    {
        $maxOrden = $this->menu->selectMax('orden')->first();
        $maxValue = $maxOrden ? $maxOrden->orden : 0;
        $maxValue += 1;
        return $this->response->setJSON(['max_orden' => $maxValue]);
    }

     public function actualizarOrden()
    {
        $data = $this->request->getJSON(true); 

        foreach ($data as $item) {
            $this->menu->update($item['idMenu'], ['orden' => $item['orden']]);
        }

        return $this->response->setJSON([
            'mensaje' => 'Orden actualizado correctamente'
        ]);
    }
}
