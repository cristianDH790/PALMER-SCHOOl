
<section class="bg_menu_page">
    <div class="inner_subpage_banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-banner">
                        <h2>Contactenos</h2>
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
                <p><a href="<?= base_url(); ?>">Inicio</a> <span>></span> Contactenos</p>
            </div>
        </div>
    </div>
</section>
<section class="contactenos">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-12">
				<h2>Contáctenos</h2>

				<div class="bloque-contacto">
					<div class="box1">
						<h4>Whatsapp</h4>
						<a href="https//wa.me/" target="_blank"><i class="fa-brands fa-whatsapp"></i> +51 997894544</a>
					</div>
					<div class="box1">
						<h4>Correo</h4>
						<a href="mailto:" target="_blank"><i class="fa-solid fa-envelope"></i> iep.palmerschool@gmail.com</a>
					</div>
					<div class="box1">
						<h4>Dirección</h4>
						<a href="https://www.google.com/maps/place/" target="_blank"><i class="fa-solid fa-location-dot"></i> Urbanización Los reyes Mz. "C" Lt. 9. , San Martín de Porres, Peru</a>
					</div>
				</div>

				<div class="d-flex">

					<form class="form-contacto" id="formContacto">
						<h4>Escríbenos</h4>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" name="nombres" id="nombres" placeholder="Nombres y apellidos *" type="text">
									<span class="validacion nombres"></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="correo" name="correo" placeholder="Correo electrónico *" type="text">
									<span class="validacion correo"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="telefono" name="telefono" placeholder="Teléfono *" type="text">
									<span class="validacion telefono"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="asunto" name="asunto" placeholder="Asunto" type="text">
									<span class="validacion asunto"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control" name="mensaje" id="mensaje" placeholder="Mensaje" cols="30" rows="4"></textarea>
									<span class="validacion mensaje"></span>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<img class="captcha-imagen" src="<?= base_url() ?>/captcha" alt="CAPTCHA">
									<button type="button" id="refres" class="refresh-captcha">
										<i class="fa-solid fa-refresh"></i>
									</button>
									<input class="form-control" type="text" name="captcha" id="captcha" placeholder="Complete el captcha" pattern="[A-Za-z]{6}">
									<span style="color:red;" class="validacion captcha"></span>
								</div>
							</div>

							<div class="col-md-12">
								<button type="submit" class="enviar-servicios">Enviar <i class="fa fa-paper-plane"></i></button>
							</div>

						</div>
					</form>

					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31223.859937856436!2d-77.12313670134894!3d-11.975713166433898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105ce03bdf34491%3A0xccece198497fa3d7!2sPalmer%20School!5e0!3m2!1ses-419!2spe!4v1766557526566!5m2!1ses-419!2spe" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				



				</div>

			</div>

		</div>
	</div>
</section>