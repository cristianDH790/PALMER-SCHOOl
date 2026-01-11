<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Front::mantenimiento');
$routes->get('inicio', 'Front::inicio');
$routes->get('nosotros', 'Front::nosotros');
$routes->get('pagos-en-linea', 'Front::pagos');
$routes->get('blogs', 'Front::blog');
$routes->get('blog/(:any)', 'Front::blogDetalle/$1');
$routes->get('contactenos', 'Front::contactenos');
$routes->get('libro-reclamaciones', 'Front::libroReclamaciones');
$routes->get('niveles', 'Front::niveles');
$routes->get('nivel/(:any)', 'Front::nivelDetalle/$1');






$routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
    $routes->group('api', function ($routes) {

        //rutas publicas


        /** RUTAS PARA EL USO DE LOS CONTROLADORES DE FRONT **/

        $routes->post('NoticiaController/noticias', 'Api\Publico\NoticiaPublicoController::listar');

        //ruta de logueo administrador
        $routes->post('login', 'Api\\Auth\\AuthController::login');
        $routes->get('pass', 'Api\\Auth\\AuthController::pass');
        $routes->post('usuario/recuperarclave', 'Api\\Auth\\AuthController::recuperarClave');


        //producto cupon asociacion  eliminarAsociacion
        $routes->delete('producto-cupon/eliminar-asociacion-cupon-producto', 'Api\\ProductoCuponController::eliminarAsociacion', ['filter' => 'jwtfilter']);
        $routes->delete('producto-cupon/eliminar-asociacion/(:num)', 'Api\\ProductoCuponController::eliminarCuponDeProducto/$1', ['filter' => 'jwtfilter']);
        $routes->post('producto-cupon/asociar', 'Api\\ProductoCuponController::asociarCupon', ['filter' => 'jwtfilter']);
        $routes->get('producto-cupon/listarPorIdProducto/(:num)', 'Api\\ProductoCuponController::listarCuponesAsociados/$1', ['filter' => 'jwtfilter']);

        $routes->post('noticiaCategoria/listar', 'Api\\NoticiaCategoriaController::listar', ['filter' => 'jwtfilter']);
        $routes->get('noticiaCategoria/obtenerPorId/(:num)', 'Api\\NoticiaCategoriaController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('noticiaCategoria/guardar', 'Api\NoticiaCategoriaController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('noticiaCategoria/actualizar/(:num)', 'Api\\NoticiaCategoriaController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('noticiaCategoria/eliminar/(:num)', 'Api\\NoticiaCategoriaController::eliminar/$1', ['filter' => 'jwtfilter']);
        //noticia
        $routes->post('noticia/listar', 'Api\\NoticiaController::listar', ['filter' => 'jwtfilter']);
        $routes->get('noticia/obtenerPorId/(:num)', 'Api\\NoticiaController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('noticia/guardar', 'Api\NoticiaController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('noticia/actualizar/(:num)', 'Api\\NoticiaController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('noticia/eliminar/(:num)', 'Api\\NoticiaController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->post('noticia/upload', 'Api\\NoticiaController::uploadImagen', ['filter' => 'jwtfilter']);
        $routes->post('noticia/eliminar-imagen', 'Api\\NoticiaController::eliminarImagen', ['filter' => 'jwtfilter']);
        $routes->get('noticia/max-orden', 'Api\NoticiaController::obtenerMaxOrden', ['filter' => 'jwtfilter']);
        $routes->put('noticia/orden', 'Api\\NoticiaController::actualizarOrden', ['filter' => 'jwtfilter']);
        $routes->put('noticia/destacado', 'Api\\NoticiaController::actualizarDestacado', ['filter' => 'jwtfilter']);
        //nivel
        $routes->post('nivel/listar', 'Api\\NivelController::listar', ['filter' => 'jwtfilter']);
        $routes->get('nivel/obtenerPorId/(:num)', 'Api\\NivelController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('nivel/guardar', 'Api\NivelController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('nivel/actualizar/(:num)', 'Api\\NivelController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('nivel/eliminar/(:num)', 'Api\\NivelController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->post('nivel/upload', 'Api\\NivelController::uploadImagen', ['filter' => 'jwtfilter']);
        $routes->post('nivel/eliminar-imagen', 'Api\\NivelController::eliminarImagen', ['filter' => 'jwtfilter']);
        $routes->get('nivel/max-orden', 'Api\NivelController::obtenerMaxOrden', ['filter' => 'jwtfilter']);
        $routes->put('nivel/orden', 'Api\\NivelController::actualizarOrden', ['filter' => 'jwtfilter']);
        $routes->put('nivel/destacado', 'Api\\NivelController::actualizarDestacado', ['filter' => 'jwtfilter']);
        //contenidoWebs
        $routes->post('contenidoWebs/listar', 'Api\\ContenidoWebController::listar', ['filter' => 'jwtfilter']);
        $routes->get('contenidoWebs/obtenerPorId/(:num)', 'Api\\ContenidoWebController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('contenidoWebs/guardar', 'Api\ContenidoWebController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('contenidoWebs/actualizar/(:num)', 'Api\\ContenidoWebController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('contenidoWebs/eliminar/(:num)', 'Api\\ContenidoWebController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->post('contenidoWebs/upload', 'Api\\ContenidoWebController::uploadImagen', ['filter' => 'jwtfilter']);
        $routes->post('contenidoWebs/eliminar-imagen', 'Api\\ContenidoWebController::eliminarImagen', ['filter' => 'jwtfilter']);
        $routes->post('contenidoWebs/upload2', 'Api\\ContenidoWebController::uploadImagen2', ['filter' => 'jwtfilter']);
        $routes->post('contenidoWebs/eliminar-imagen2', 'Api\\ContenidoWebController::eliminarImagen2', ['filter' => 'jwtfilter']);

        //categoriacontenidoWebs
        $routes->post('contenidoWebCategorias/listar', 'Api\\ContenidoWebCategoriaController::listar', ['filter' => 'jwtfilter']);
        $routes->get('contenidoWebCategorias/obtenerPorId/(:num)', 'Api\\ContenidoWebCategoriaController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('contenidoWebCategorias/guardar', 'Api\ContenidoWebCategoriaController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('contenidoWebCategorias/actualizar/(:num)', 'Api\\ContenidoWebCategoriaController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('contenidoWebCategorias/eliminar/(:num)', 'Api\\ContenidoWebCategoriaController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->get('contenidoWebCategorias/max-orden', 'Api\ContenidoWebCategoriaController::obtenerMaxOrden', ['filter' => 'jwtfilter']);

        //sliders 
        $routes->post('sliders/listar', 'Api\\SliderController::listar', ['filter' => 'jwtfilter']);
        $routes->get('sliders/obtenerPorId/(:num)', 'Api\\SliderController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('sliders/guardar', 'Api\SliderController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('sliders/actualizar/(:num)', 'Api\\SliderController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('sliders/eliminar/(:num)', 'Api\\SliderController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->post('sliders/reporte', 'Api\\SliderController::reporte', ['filter' => 'jwtfilter']);
        $routes->post('sliders/upload', 'Api\\SliderController::uploadImagen1', ['filter' => 'jwtfilter']);
        $routes->post('sliders/upload2', 'Api\\SliderController::uploadImagen2', ['filter' => 'jwtfilter']);
        $routes->post('sliders/eliminar-imagen', 'Api\\SliderController::eliminarImagen', ['filter' => 'jwtfilter']);
        $routes->get('sliders/max-orden', 'Api\SliderController::obtenerMaxOrden', ['filter' => 'jwtfilter']);
        $routes->put('sliders/orden', 'Api\\SliderController::actualizarOrden', ['filter' => 'jwtfilter']);
        //menu
        $routes->post('menus/listar', 'Api\\MenuController::listar', ['filter' => 'jwtfilter']);
        $routes->get('menus/obtenerPorId/(:num)', 'Api\\MenuController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('menus/guardar', 'Api\MenuController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('menus/actualizar/(:num)', 'Api\\MenuController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('menus/eliminar/(:num)', 'Api\\MenuController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->get('menus/max-orden', 'Api\MenuController::obtenerMaxOrden', ['filter' => 'jwtfilter']);
        $routes->put('menus/orden', 'Api\\MenuController::actualizarOrden', ['filter' => 'jwtfilter']);
        //mensaje
        $routes->get('mensajes/obtenerPorId/(:num)', 'Api\Base\MensajeController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('mensajes/listar', 'Api\Base\MensajeController::listar', ['filter' => 'jwtfilter']);
        $routes->post('mensajes/guardar', 'Api\Base\MensajeController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('mensajes/actualizar/(:num)', 'Api\Base\MensajeController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('mensajes/eliminar/(:num)', 'Api\Base\MensajeController::eliminar/$1', ['filter' => 'jwtfilter']);

        //configuracion
        $routes->post('configuraciones/listar', 'Api\\Base\\ConfiguracionController::listar', ['filter' => 'jwtfilter']);
        $routes->get('configuraciones/obtenerPorId/(:num)', 'Api\\Base\\ConfiguracionController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('configuraciones/guardar', 'Api\\Base\\ConfiguracionController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('configuraciones/actualizar/(:num)', 'Api\\Base\\ConfiguracionController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('configuraciones/eliminar/(:num)', 'Api\\Base\\ConfiguracionController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->post('configuraciones/upload', 'Api\\Base\\ConfiguracionController::uploadImagen', ['filter' => 'jwtfilter']);
        $routes->delete('configuraciones/eliminar-imagen/(:num)', 'Api\\Base\\ConfiguracionController::eliminarImagen/$1', ['filter' => 'jwtfilter']);


        //suscripcion
        $routes->post('suscripcion/listar', 'Api\\SuscripcionController::listar', ['filter' => 'jwtfilter']);
        $routes->get('suscripcion/obtenerPorId/(:num)', 'Api\\SuscripcionController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('suscripcion/guardar', 'Api\SuscripcionController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('suscripcion/actualizar/(:num)', 'Api\\SuscripcionController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('suscripcion/eliminar/(:num)', 'Api\\SuscripcionController::eliminar/$1', ['filter' => 'jwtfilter']);

        /// DASHBOARD
        $routes->post('dashboard', 'Api\Base\DashboardController::dashboardStats', ['filter' => 'jwtfilter']);

        //usuarios
        $routes->post('usuario/listar', 'Api\\UsuarioController::listar', ['filter' => 'jwtfilter']);
        $routes->get('usuario/obtenerPorId/(:num)', 'Api\\UsuarioController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('usuario/guardar', 'Api\UsuarioController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('usuario/actualizar/(:num)', 'Api\\UsuarioController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('usuario/eliminar/(:num)', 'Api\\UsuarioController::eliminar/$1', ['filter' => 'jwtfilter']);
        $routes->post('usuario/reporte', 'Api\\UsuarioController::reporte', ['filter' => 'jwtfilter']);

        //perfil
        $routes->post('perfiles/listar', 'Api\\PerfilController::listar', ['filter' => 'jwtfilter']);
        $routes->get('perfiles/obtenerPorId/(:num)', 'Api\\PerfilController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('perfiles/guardar', 'Api\\PerfilController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('perfiles/actualizar/(:num)', 'Api\\PerfilController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('perfiles/eliminar/(:num)', 'Api\\PerfilController::eliminar/$1', ['filter' => 'jwtfilter']);
        //parametro
        $routes->post('parametro/listar', 'Api\\Base\\ParametroController::listar', ['filter' => 'jwtfilter']);
        $routes->get('parametro/obtenerPorId/(:num)', 'Api\\Base\\ParametroController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('parametro/guardar', 'Api\\Base\\ParametroController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('parametro/actualizar/(:num)', 'Api\\Base\\ParametroController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('parametro/eliminar/(:num)', 'Api\\Base\\ParametroController::eliminar/$1', ['filter' => 'jwtfilter']);

        //estado
        $routes->post('estado/listar', 'Api\\Base\\EstadoController::listar', ['filter' => 'jwtfilter']);
        $routes->get('estado/obtenerPorId/(:num)', 'Api\\Base\\EstadoController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('estado/guardar', 'Api\\Base\\EstadoController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('estado/actualizar/(:num)', 'Api\\Base\\EstadoController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('estado/eliminar/(:num)', 'Api\\Base\\EstadoController::eliminar/$1', ['filter' => 'jwtfilter']);

        //tipo
        $routes->post('tipo/listar', 'Api\\Base\\TipoController::listar', ['filter' => 'jwtfilter']);
        $routes->get('tipo/obtenerPorId/(:num)', 'Api\\Base\\TipoController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('tipo/guardar', 'Api\\Base\\TipoController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('tipo/actualizar/(:num)', 'Api\\Base\\TipoController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('tipo/eliminar/(:num)', 'Api\\Base\\TipoController::eliminar/$1', ['filter' => 'jwtfilter']);

        //clase
        $routes->post('clases/listar', 'Api\\Base\\ClaseController::listar', ['filter' => 'jwtfilter']);
        $routes->get('clases/obtenerPorId/(:num)', 'Api\\Base\\ClaseController::obtenerPorId/$1', ['filter' => 'jwtfilter']);
        $routes->post('clases/guardar', 'Api\\Base\\ClaseController::guardar', ['filter' => 'jwtfilter']);
        $routes->put('clases/actualizar/(:num)', 'Api\\Base\\ClaseController::actualizar/$1', ['filter' => 'jwtfilter']);
        $routes->delete('clases/eliminar/(:num)', 'Api\\Base\\ClaseController::eliminar/$1', ['filter' => 'jwtfilter']);

        //filemanager
        $routes->get('carpetas', 'Api\Base\FileManagerController::getCarpetasTodas', ['filter' => 'jwtfilter']);
        $routes->post('archivos', 'Api\Base\FileManagerController::getArchivos', ['filter' => 'jwtfilter']);


        $routes->post('nuevo-directorio', 'Api\Base\FileManagerController::nuevoDirectorio', ['filter' => 'jwtfilter']);
        $routes->post('archivoUpload', 'Api\Base\FileManagerController::archivoSubirImagen', ['filter' => 'jwtfilter']);
        $routes->post('eliminarArchivoCarpeta', 'Api\Base\FileManagerController::eliminarArchivoCarpeta', ['filter' => 'jwtfilter']);
        $routes->post('descargarArchivo', 'Api\Base\FileManagerController::descargarArchivo', ['filter' => 'jwtfilter']);
        $routes->post('renombrar-archivo', 'Api\Base\FileManagerController::renombrarArchivo', ['filter' => 'jwtfilter']);
        $routes->post('copiar-archivo', 'Api\Base\FileManagerController::copiarArchivo', ['filter' => 'jwtfilter']);
    });
    $routes->options('api/(:any)', function () {
        return service('response')
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization,X-Authorization')
            ->setStatusCode(200);
    });
});
