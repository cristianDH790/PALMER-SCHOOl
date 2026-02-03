<section class="bg_menu_page">
	<div class="inner_subpage_banner">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="text-banner">
						<h2>Nosotros</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="miga">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<p><a href="<?= base_url(); ?>">Inicio</a> <span>></span> Nosotros</p>
			</div>
		</div>
	</div>
</section>

<? if ($nosotros): ?>
    <?= $nosotros->contenido ?>
<? endif; ?>
<!-- 
<section class="nosotros-home">
<div class="container-fluid">
<div class="row justify-content-around align-items-center">
<div class="col-md-6 texto">
<h3>Nosotros</h3>
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software.</p>

</div>
<div class="col-md-6 contenedor-img">
<img class="img-nosotros-home" src="<?= base_url(); ?>template/images/slide1.jpeg" alt="">
</div>
</div>
</div>
</section>



<section class="mision-home">
<div class="container-fluid">
<div class="row">
<div class="col-md-12 titulo">
<h3>Pilares Institucionales</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident blanditiis, voluptatem voluptate.</p>
</div>
<div class="col-4 caja">
<div class="card">
<img src="<?= base_url(); ?>template/images/mision.jpg" class="card-img-top" alt="...">
<div class="card-body">
<h4 class="card-title">Mision</h4>
<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content and make up the bulk of the card’s content. content and make up the bulk of the card’s content.</p>

</div>
</div>
</div>
<div class="col-4 caja">
<div class="card">
<img src="<?= base_url(); ?>template/images/vision.jpg" class="card-img-top" alt="...">
<div class="card-body">
<h4 class="card-title">Vision</h4>
<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content and make up the bulk of the card’s content. content and make up the bulk of the card’s content.</p>

</div>
</div>
</div>
<div class="col-4 caja">
<div class="card">
<img src="<?= base_url(); ?>template/images/mision.jpg" class="card-img-top" alt="...">
<div class="card-body">
<h4 class="card-title">Mision</h4>
<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content and make up the bulk of the card’s content. content and make up the bulk of the card’s content.</p>

</div>
</div>
</div>
</div>
</div>
</section>


<section class="primer-paso-home">
<div class="container">
<div class="row">
<div class="col-md-12">
<h2>Construimos tu futuro desde hoy</h2>
<p>Formamos estudiantes con valores, conocimiento y visión para el mañana</p>
<a href="#">¡Matricúlate aquí!</a>
</div>
</div>
</div>
</section>

<section class="mapa">
<div class="container-fluid"></div>
<div class="row">
<div class="col-md-12 caja-mapa">
<h3>Visitanos</h3>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31223.859937856436!2d-77.12313670134894!3d-11.975713166433898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105ce03bdf34491%3A0xccece198497fa3d7!2sPalmer%20School!5e0!3m2!1ses-419!2spe!4v1766557526566!5m2!1ses-419!2spe" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</div>
</section>

<section class="trayectoria-home">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<h3>Trayectoria</h3>

<div class="box-trayectoria">
<div class="contador-box">
<div class="box-img">
<img src="<?= base_url(); ?>template/images/estudiante.svg" alt="">
<h2>+</h2>
<div class="numero" data-target="500">0</div>
</div>
<div class="texto">Estudiantes formados</div>
</div>

<div class="contador-box">
<div class="box-img">
<img src="<?= base_url(); ?>template/images/familia.svg" alt="">
<h2>+</h2>
<div class="numero" data-target="60">0</div>
</div>
<div class="texto">Años formando generaciones</div>
</div>

<div class="contador-box">
<div class="box-img">
<img src="<?= base_url(); ?>template/images/beneficio.svg" alt="">
<h2>+</h2>
<div class="numero" data-target="10">0</div>
</div>
<div class="texto">Beneficios educativos</div>
</div>
</div>

</div>
</div>
</div>
</section> -->


<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Configuración del contador
		const contadores = document.querySelectorAll('.numero');
		const velocidad = 200; // Velocidad en milisegundos

		// Función para animar el contador
		const animarContador = () => {
			contadores.forEach(contador => {
				const actualizarContador = () => {
					const target = +contador.getAttribute('data-target');
					const incremento = target / velocidad;
					let valorActual = 0;

					const intervalo = setInterval(() => {
						if (valorActual < target) {
							valorActual += incremento;
							// Redondear para números enteros
							contador.textContent = Math.ceil(valorActual);
						} else {
							contador.textContent = target;
							clearInterval(intervalo);
						}
					}, 10);
				};

				// Crear un Intersection Observer para activar la animación cuando sea visible
				const observer = new IntersectionObserver((entries) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							actualizarContador();
							observer.unobserve(contador);
						}
					});
				}, {
					threshold: 0.5
				});

				observer.observe(contador);
			});
		};

		// Iniciar la animación
		animarContador();
	});
</script>