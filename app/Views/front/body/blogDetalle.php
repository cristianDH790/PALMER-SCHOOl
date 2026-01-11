<section class="bg_menu_page">
	<div class="inner_subpage_banner">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="text-banner">
						<h2>Blog detalle</h2>
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
				<p><a href="<?= base_url(); ?>">Inicio</a><span>></span><a href="<?= base_url(); ?>"> Blog</a><span>></span>La tecnologia escolar</p>
			</div>
		</div>
	</div>
</section>



<section class="noticia-detalle">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-9">
				<h6 class="cate"><?= $blogcategoria->nombre ?></h6>
				<h2><?= $blog->nombre ?></h2>

				<div class="bloque-compartir">
					<h5><i class="fa-solid fa-calendar-days"></i> <?=
																	formatearFecha($blog->fecha);
																	?></h5>
					<span>|</span>
					<div class="redes-productos">
						<h5>Compartir</h5>
						<ul>
							<li><a style="cursor:pointer;" href="" class="share-fb"><i class="fa-brands fa-facebook-f"></i></a></li>
							<li><a style="cursor:pointer;" href="" class="share-linkedin"><i class="fa-brands fa-linkedin-in"></i></a></li>
							<li><a style="cursor:'pointer';" href="" class="share-twitter"><i class="fa-brands fa-x-twitter"></i></a></li>
						</ul>
					</div>
				</div>

				<?= $blog->contenido ?>
			</div>
			<? if ($blogrelacionadas): ?>
				<div class="col-md-3">
					<div class="box-noticias">
						<div class="row">
							<? foreach ($blogrelacionadas as $blogrelacionada): ?>
								<? if ($blogrelacionada->idNoticia != $blog->idNoticia): ?>
									<div class="col-md-12">
										<div class="noti-img">
											<img src="<?= base_url('archivos/noticia/' . $blogrelacionada->urlimagen) ?>" alt="<?= $blogrelacionada->nombre ?>">
										</div>
										<div class="box-noti">
											<span class="fecha">

												<h1><?= date("d", strtotime($blogrelacionada->fecha)) ?></h1>
												<h6><?= formatearFecha2($blogrelacionada->fecha) ?></h6>
											</span>
											<h3><?= $blogrelacionada->nombre ?></h3>
											<p><?= $blogrelacionada->resumen ?></p>
											<a href="<?= base_url('noticia/' . $blogrelacionada->urlamigable) ?>">Ver más</a>
										</div>
									</div>
								<? endif; ?>
							<? endforeach; ?>

						</div>
					</div>
				</div>
			<? endif; ?>
		</div>
	</div>
</section>
<?
function formatearFecha($fecha)
{
	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
	$fecha_formateada = date("d", strtotime($fecha)) . " de " . $meses[date('n', strtotime($fecha)) - 1] . " del " . date("Y", strtotime($fecha));

	return $fecha_formateada;
}

function formatearFecha2($fecha)
{
	$meses_cortos = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
	$mes = $meses_cortos[date('n', strtotime($fecha)) - 1];

	return $mes;
}
?>