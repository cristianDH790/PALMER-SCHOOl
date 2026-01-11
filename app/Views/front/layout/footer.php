<footer>
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-3">
				<a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>archivos/configuracion/<?= $logofooter->urlimagen ?>" alt="<?= $logofooter->urlimagen ?>"></a>
				<div class="d-flex">
					<ul>
						<li><a href="<?= $facebook->valor ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
						<li><a href="<?= $instagram->valor ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
						<li><a href="<?= $tiktok->valor ?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a></li>
					</ul>
				</div>
			</div>



			<div class="col-md-3">
				<div class="empresa2">
					<h4>Palmer school</h4>
					<ul>
						<?php foreach ($menus as $menu): ?>
							<li class="nav-item">
								<a class="<?= strtolower($seccion)  == strtolower($menu->seccion) ? 'active' : '' ?>" aria-current="page" <?= $menu->idpdestino == 549 ? "target='_blank'" : "" ?> href="<?= $menu->destino == "#" ? "#" : ($menu->idpdestino == 549 ? $menu->destino : base_url() . $menu->destino) ?>"><?= $menu->nombre ?></a>
							</li>
						<?php endforeach; ?>
						<li><a target="_blank" href="<<?= $cubicol->valor ?>">Cubicol</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-3">
				<div class="empresa2">
					<h4>Soporte</h4>
					<ul>
						<li><a href="<?= base_url(); ?>contactenos">Contactenos</a></li>
						<!-- <li><a href="<?= base_url(); ?>">Preguntas frecuentes</a></li> -->
						<li><a href="<?= base_url(); ?>libro-reclamaciones">Libro de reclamaciones</a></li>
						<li><a href="<?= base_url(); ?>">Reglamento interno</a></li>
						<li><a target="_blank" href="<?= base_url(); ?>pagos-en-linea">Pagos en linea</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="empresa2">
					<h4>Palmer school</h4>
					<ul>
						<li><a target="_blank" href="mailto:<?= $correo->valor ?>"><?= $correo->valor ?></a></li>
						<li><a target="_blank" href="https//wa.me/<?= $telefono->valor ?>">+ <?= $telefono->valor ?></a></li>
						<li><a target="_blank" href="https://www.google.com/maps/place/<?= $direccion->valor ?>"><?= $direccion->valor ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>

<section class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-dm-12">
				<p>
					<a href="<?= getenv('ADMIN_SITE') ?>" target="_blank">
						<i class="fa-solid fa-cog"></i></a>
					© PALMER SCHOOL 2026. Todos los derechos reservados | Desarrollado por <a href="https://github.com/cristianDH790">CRISTIAN DH</a>
				</p>
			</div>
		</div>
	</div>
</section>
<div class="carga" style=" display:none;opacity: 1;pointer-events: auto;position: fixed;top: 0;bottom: 0;left: 0;right: 0;text-align: center;font-size: 0;overflow-y: scroll;background-color: rgba(0,0,0,.4);z-index: 10000;transition: opacity .3s;">
	<div class="gif">
		<img src="<?= base_url() ?>template/images/loader.svg" style="margin-top: 20%;width: 5%;">
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url(); ?>template/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>template/js/jquery.validate.js"></script>
<script src="<?= base_url(); ?>template/js/owl.carousel.js"></script>
<script>
	const autoplayTimeoutValue = <?= $timeout; ?>;
</script>
<script src="<?= base_url(); ?>template/js/carrusel.js"></script>
<script src="<?= base_url(); ?>template/js/all.min.js"></script>
<script src="<?= base_url(); ?>template/js/fontawesome.min.js"></script>
<script src="<?= base_url(); ?>template/js/aos.js"></script>
<script src="<?= base_url(); ?>template/js/aos.js"></script>

<script>
	AOS.init({
		duration: 1000,
		once: true
	});

	window.addEventListener("scroll", function() {
		var nav = document.querySelector("nav");
		nav.classList.toggle("abajo", window.scrollY > 0);
	})
</script>
</body>

</html>