<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\ContenidoWebModel;
use App\Models\NivelModel;
use App\Models\NoticiaCategoriaModel;
use App\Models\NoticiaModel;
use App\Models\SliderModel;

class Front extends BaseController
{
    protected $slider;
    protected $contenidoweb;
    protected $niveles;
    protected $blog;
    protected $noticiaCategoria;
    protected $mantenimiento;
    protected $configuracion;
    public function __construct()
    {
        $this->slider = new SliderModel();
        $this->configuracion = new ConfiguracionModel();
        $this->contenidoweb = new ContenidoWebModel();
        $this->niveles = new NivelModel();
        $this->blog = new NoticiaModel();
        $this->noticiaCategoria = new NoticiaCategoriaModel;
        $this->mantenimiento = $this->configuracion->obtenerPorId(27);
    }

    public function mantenimiento()
    {
        $data["seccion"] = "mantenimiento";
        $data["titulo"] = "Palmer School - Mantenimiento";
        $data["url"] = "";
        return view('front/body/mantenimiento');
    }
    public function inicio()
    {

        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }
        $data["seccion"] = "inicio";
        $data["titulo"] = "Palmer School - Inicio";
        $data["url"] = "";

        $data["nosotrosinicio"] = $this->contenidoweb->obtenerPorId(2);
        $data["instalacionesinicio"] = $this->contenidoweb->obtenerPorId(3);
        $data["bannerinicio"] = $this->contenidoweb->obtenerPorId(4);
        $data["nivelesinicios"] = $this->niveles->buscarPor("orden", "asc", "", "", 414, 583, 0, 3);
        $data["tipopagos"] = $this->contenidoweb->obtenerPorId(6);

        $data['sliders'] = $this->slider->buscarPor("orden", "asc", "", "", 304, 0, 0, 0, 0);
        // var_dump($data['sliders']);
        $this->front_views('front/body/inicio', $data);
    }
    public function nosotros()
    {
        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }
        $data["seccion"] = "nosotros";
        $data["titulo"] = "Palmer School - Nosotros";
        $data["url"] = "";

        $data["nosotros"] = $this->contenidoweb->obtenerPorId(7);
        $this->front_views('front/body/nosotros', $data);
    }
    public function pagos()
    {
        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }
        $data["seccion"] = "pagos";
        $data["titulo"] = "Palmer School - Pagos en linea";
        $data["url"] = "";
        $data["pagos"] = $this->contenidoweb->obtenerPorId(8);
        $this->front_views('front/body/pago', $data);
    }
    public function blog()
    {
        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }
        $data["seccion"] = "blog";
        $data["titulo"] = "Palmer School - Blog";
        $data["url"] = "";
        $data["noticiacategorias"] = $this->noticiaCategoria->buscarPor('orden', 'asc', '', '', 410, 0, 0);
        $this->front_views('front/body/blog', $data);
    }
    public function blogDetalle($url = "")
    {
        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }
        if ($url) {
            $data["seccion"] = "blog";
            $data["titulo"] = "Palmer School - Blog Detalle";
            $data["url"] = "";
            $data["blog"] = $this->blog->obtenerPorUrlAmigable($url);
            $data["blogcategoria"] = $this->noticiaCategoria->obtenerPorId($data["blog"]->idnoticiacategoria);
            $data["blogrelacionadas"] = $this->blog->buscarPor("orden", "asc", "", "", 412,  $data["blog"]->idnoticiacategoria, 581, 0, 0);
           
            $this->front_views('front/body/blogDetalle', $data);
        }
    }
    public function niveles()
    {
        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }
        $data["seccion"] = "niveles";
        $data["titulo"] = "Palmer School - Niveles";
        $data["url"] = "";
        $data["nivelesinicios"] = $this->niveles->buscarPor("orden", "asc", "", "", 414, 583, 0, 3);
        $this->front_views('front/body/niveles', $data);
    }
    public function nivelDetalle($url = "")
    {
        if ($this->mantenimiento->valor == 'si' || $this->mantenimiento->valor == 'Si' || $this->mantenimiento->valor == 'SI') {
            $data["seccion"] = "mantenimiento";
            $data["titulo"] = "Palmer School - Mantenimiento";
            $data["url"] = "";
            return view('front/body/mantenimiento', $data);
        }

        if ($url) {
            $data["seccion"] = "niveles";
            $data["titulo"] = "Palmer School - Niveles";
            $data["url"] = "";
            $data["nivel"] = $this->niveles->obtenerPorUrlAmigable($url);
            $this->front_views('front/body/nivelDetalle', $data);
        }
    }
    public function contactenos()
    {
        $data["seccion"] = "contactenos";
        $data["titulo"] = "Palmer School - Contactenos";
        $data["url"] = "";

        $this->front_views('front/body/contactenos', $data);
    }
    public function libroReclamaciones()
    {
        $data["seccion"] = "libro";
        $data["titulo"] = "Palmer School - Libro reclamaciones";
        $data["url"] = "";

        $this->front_views('front/body/libroReclamaciones', $data);
    }
}
