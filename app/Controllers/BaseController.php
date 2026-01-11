<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\MenuModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }
    public function front_views($url = "", $data = [])
    {
        $menu = new MenuModel();
        $configuracion = new ConfiguracionModel();
        $data['logoheader'] = $configuracion->obtenerPorId(35);
        $data['logofooter'] = $configuracion->obtenerPorId(36);
        $data["correo"] = $configuracion->obtenerPorId(2);
        $data["cubicol"] = $configuracion->obtenerPorId(3);
        $data["telefono"] = $configuracion->obtenerPorId(4);
        $data["direccion"] = $configuracion->obtenerPorId(1);
        $data["facebook"] = $configuracion->obtenerPorId(40);
        $data["tiktok"] = $configuracion->obtenerPorId(39);
        $data["instagram"] = $configuracion->obtenerPorId(38);
        // $data["alumnos"] = $configuracion->obtenerPorId(41);
        // $data["anos"] = $configuracion->obtenerPorId(42);
        // $data["beneficios"] = $configuracion->obtenerPorId(43);

        $data['menus'] = $menu->buscarPor("orden", "asc", "", "", 389, 0, 561, 550, 0, 0, 0);
        $data['submenus'] = $menu->buscarPor("orden", "asc", "", "", 389, 0, 562, 550, 0, 0, 0);

        $tiempo = $configuracion->obtenerPorId(26);
        $tiempo2 = ((int) $tiempo->valor) * 1000;
        $data['timeout'] = $tiempo2;
        // var_dump($data['submenus']);
        echo view("front/layout/header", $data);
        echo view($url, $data);
        echo view("front/layout/footer", $data);
    }
}
