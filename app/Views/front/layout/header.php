<!DOCTYPE html>
<html lang="es">

<head>
    <!--Title-->
    <title><?= ((isset($titulo)) ? $titulo : ((isset($tituloGeneral)) ? $tituloGeneral : 'Palmer School')) ?></title>
    <meta name="description" content="<?= ((isset($descripcion)) ? strip_tags($descripcion) : ((isset($descripcionGeneral)) ? $descripcionGeneral : 'Palmer School es una Institución Educativa que trabaja aplicando el método S.I.A brindando enseña de calidad')) ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <!--description-->
    <meta property="og:title" content="<?= ((isset($titulo)) ? $titulo : ((isset($tituloGeneral)) ? $tituloGeneral : 'Palmer School')) ?>" />
    <meta property="og:description" content="<?= ((isset($descripcion)) ? $descripcion : ((isset($descripcionGeneral)) ? $descripcionGeneral : '')) ?>" />
    <meta property="og:url" content="<?= base_url() ?><?= ((isset($url)) ? $url : '') ?>" />
    <!--Key Words-->
    <meta name="keywords" content="<?= ((isset($keywords)) ? $keywords : ((isset($keywordsGeneral)) ? $keywordsGeneral : '')) ?>">

    <meta property="og:image" content="<?= isset($imagen1) ? $imagen1 : (isset($imagenGeneral) ? $imagenGeneral : '') ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="icon" href="logo-palmer.ico" type="image/x-icon">

    <!--bootstrap-->
    <script src="<?= base_url(); ?>template/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/owl.carousel.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>template/paginator/paginator.css">
    <link rel="stylesheet" href="<?= base_url(); ?>template/css/responsive.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/template/css/aos.css">
    <script src="<?= base_url(); ?>template/js/owl.carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!-- GetButton.io widget -->
   	<script>
		const BASE_URL = "<?= base_url() ?>";
	</script>
   <script type="text/javascript">
        (function() {
            var options = {
                whatsapp: "51950579323", // WhatsApp (sin +)
                facebook: "tu_pagina_facebook", // ID o usuario de la página
                instagram: "tu_usuario_instagram", // Usuario sin @
                youtube: "https://www.youtube.com/@tucanal",

                call_to_action: "Escríbenos",
                button_color: "#2e3090",
                position: "right",
                order: "whatsapp,facebook,instagram,youtube",
                pre_filled_message: "Hola, quiero contactarme con un asesor"
            };

            var proto = 'https:',
                host = "getbutton.io",
                url = proto + '//static.' + host;

            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function() {
                WhWidgetSendButton.init(host, proto, options);
            };

            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })();
    </script>
    <!-- /GetButton.io widget -->
</head>

<body>
    <div class="top-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 ">
                    <a href="mailto:<?= $correo->valor ?>" class="correo"><?= $correo->valor ?></a>
                </div>
                <div class="col-md-4 ">
                    <ul class="redes">
                        <li><a href="<?= $facebook->valor ?>" target="_blank"><svg class="svg-inline--fa fa-facebook-f" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"></path>
                                </svg></a></li>
                        <!-- <li><a href="#" target="_blank"><svg class="svg-inline--fa fa-x-twitter" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="x-twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                                </svg></a></li> -->
                        <li><a href="<?= $tiktok->valor ?>" target="_blank" aria-label="TikTok">
                                <i class="fa-brands fa-tiktok"></i></a></li>

                        <li><a href="<?= $instagram->valor ?>" target="_blank"><svg class="svg-inline--fa fa-instagram" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                                </svg></a></li>
                        <!-- <li><a href="#" target="_blank"><svg class="svg-inline--fa fa-youtube" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                                </svg></a></li> -->
                    </ul>
                </div>
                <div class="col-md-4 ">
                    <a href="<?= $cubicol->valor ?>" target="_blank" class="cubicol">Cubicol</a>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary menuweb">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>archivos/configuracion/<?= $logoheader->urlimagen ?>" alt="<?= $logoheader->urlimagen ?>"></a>
            <!-- <div class="box-usuario-movil">
                <div class="box-buscar">
                    <a href="#"><img src="<?= base_url(); ?>template/images/buscar.svg" alt=""></a>
                </div>
                <div class="box-usuario">
                    <a href="#"><img src="<?= base_url(); ?>template/images/user.svg" alt=""></a>
                </div>
                <div class="box-carrito">
                    <a href="#"><img src="<?= base_url(); ?>template/images/carrito.svg" alt=""></a>
                    <span class="contador">1</span>
                </div>
                <div class="box-cora">
                    <a href="#"><img src="<?= base_url(); ?>template/images/corazon.svg" alt=""></a>
                    <span class="contador">1</span>
                </div>
            </div> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    class="navbar-toggler-icon"
                    stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <?php if ($menus): ?>
                        <?php foreach ($menus as $menu): ?>
                            <?php
                            $tieneSubmenu = false;
                            if ($submenus) {
                                foreach ($submenus as $sm) {
                                    if ($sm->idrmenu == $menu->idmenu) {
                                        $tieneSubmenu = true;
                                        break;
                                    }
                                }
                            }
                            ?>

                            <li class="nav-item <?= $tieneSubmenu ? 'dropdown' : '' ?>">
                                <a <?= $tieneSubmenu ? 'data-bs-toggle="dropdown"' : '' ?>
                                    class="<?= strtolower($seccion)  == strtolower($menu->seccion) ? 'active' : '' ?> nav-link <?= $tieneSubmenu ? 'dropdown-toggle' : '' ?>" aria-current="page" <?= $menu->idpdestino == 549 ? "target='_blank'" : "" ?> href="<?= $menu->destino == "#" ? "#" : ($menu->idpdestino == 549 ? $menu->destino : base_url() . $menu->destino) ?>"><?= $menu->nombre ?></a>
                                <? if ($submenus): ?>

                                    <? foreach ($submenus as $submenu):
                                        if ($submenu->idrmenu == $menu->idmenu): ?>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item">
                                                    <a class="nav-link" <?= $submenu->idpdestino == 549 ? "target='_blank'" : "" ?> href="<?= $submenu->destino == "#" ? "#" : ($submenu->idpdestino == 549 ? $submenu->destino : base_url() . $submenu->destino) ?>"><?= $submenu->nombre ?></a>
                                                </li>
                                            </ul>
                                    <? endif;
                                    endforeach; ?>

                                <? endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link <?= ($seccion == 'inicio') ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccion == 'nosotros') ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccion == 'pagos') ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>pagos-en-linea">Pagos en linea</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccion == 'matricula') ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>">Matricula</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccion == 'block') ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>blog">Blog</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccion == 'niveles') ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>niveles">Niveles</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>