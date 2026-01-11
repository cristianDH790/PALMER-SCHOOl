<section class="bg_menu_page">
    <div class="inner_subpage_banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-banner">
                        <h2>Niveles</h2>
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
                <p><a href="<?= base_url(); ?>">Inicio</a> <span>></span>Niveles</p>
            </div>
        </div>
    </div>
</section>
<!-- <section class="valores">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2>Valores</h2>
				<p>Nuestros valores creados con nuestro nombre encierran la esencia de nuestra misión y visión, como un distintivo de lo que será nuestra cultura organizacional.</p>
			</div>

			<div class="col-md-3">
				<div class="box-valores">
					<img src="<?= base_url(); ?>public/template/images/cooperacion.svg" alt="">
					<h4>Cooperación</h4>
					<p>Nuestro rol de cooperación en todo momento que nuestro asociado lo requiera.</p>
				</div>
			</div>

			<div class="col-md-3">
				<div class="box-valores">
					<img src="<?= base_url(); ?>public/template/images/resilencia.svg" alt="">
					<h4>Resiliencia</h4>
					<p>Nos adaptamos a los cambios con optimismo y siempre listos a brindar lo mejor.</p>
				</div>
			</div>

			<div class="col-md-3">
				<div class="box-valores">
					<img src="<?= base_url(); ?>public/template/images/empatia.svg" alt="">
					<h4>Empatía</h4>
					<p>Fomenta la comprensión y el apoyo mutuo entre sus miembros, impulsando el bienestar colectivo.</p>
				</div>
			</div>

			<div class="col-md-3">
				<div class="box-valores">
					<img src="<?= base_url(); ?>public/template/images/asertividad.svg" alt="">
					<h4>Asertividad</h4>
					<p>El colaborador siempre llegará con la mejor experiencia de servicio hacia nuestros asociados.</p>
				</div>
			</div>

		</div>
	</div>
</section> -->



<? if ($nivelesinicios): ?>
    <section class="nivel">
        <div class="container-fluid">
            <div class="row">
                <? foreach ($nivelesinicios as $nivelesinicio): ?>
                    <div class="col-lg-12 caja">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-lg-3">
                                    <img src="<?= base_url(); ?>archivos/nivel/<?= $nivelesinicio->urlimagen ?>" class="img-fluid rounded-start" alt="<?= $nivelesinicio->urlimagen ?>">
                                </div>
                                <div class="col-lg-9">
                                    <div class="card-body">
                                        <h3 class="card-title"><?= $nivelesinicio->nombre ?></h3>
                                        <p class="card-text"><?= $nivelesinicio->resumen ?></p>
                                        <a href="<?= base_url(); ?>nivel/<?= $nivelesinicio->urlamigable ?>">Ver mas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-12 caja">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-lg-4">
                            <img src="<?= base_url(); ?>template/images/nivel.jpeg" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-lg-8">
                            <div class="card-body">
                                <h3 class="card-title">Nivel Primaria</h3>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, magni dolorem. Rem culpa possimus, quos at nesciunt, vel doloremque repellendus hic vitae quibusdam fugit consequuntur neque quam dolorum reprehenderit quia.
                                    Accusantium impedit culpa saepe dignissimos cumque provident alias quis reiciendis laborum! Reiciendis cumque ea accusamus temporibus! Reprehenderit nam, consequuntur aut cum facilis aliquam? Quaerat maiores rerum nemo odit inventore illum.
                                    Iure, repudiandae, magni expedita assumenda adipisci exercitationem id nobis vero natus unde, aliquam ratione pariatur et. Perspiciatis neque dolorum, officia hic sed quam animi, provident non cum qui, quia porro?
                                    Dolore, doloribus. Repudiandae labore id voluptatibus reiciendis aut modi laboriosam quam rem minima accusamus officiis sed maiores similique doloremque neque sint minus iste deleniti, eum dolorum distinctio numquam nihil laborum.</p>
                                <a href="#">Ver mas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 caja">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-lg-4">
                            <img src="<?= base_url(); ?>template/images/nivel.jpeg" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-lg-8">
                            <div class="card-body">
                                <h3 class="card-title">Nivel secundario</h3>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, magni dolorem. Rem culpa possimus, quos at nesciunt, vel doloremque repellendus hic vitae quibusdam fugit consequuntur neque quam dolorum reprehenderit quia.
                                    Accusantium impedit culpa saepe dignissimos cumque provident alias quis reiciendis laborum! Reiciendis cumque ea accusamus temporibus! Reprehenderit nam, consequuntur aut cum facilis aliquam? Quaerat maiores rerum nemo odit inventore illum.
                                    Iure, repudiandae, magni expedita assumenda adipisci exercitationem id nobis vero natus unde, aliquam ratione pariatur et. Perspiciatis neque dolorum, officia hic sed quam animi, provident non cum qui, quia porro?
                                    Dolore, doloribus. Repudiandae labore id voluptatibus reiciendis aut modi laboriosam quam rem minima accusamus officiis sed maiores similique doloremque neque sint minus iste deleniti, eum dolorum distinctio numquam nihil laborum.</p>
                                <a href="#">Ver mas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
                <? endforeach; ?>
            </div>

        </div>
    </section>
<? endif; ?>