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