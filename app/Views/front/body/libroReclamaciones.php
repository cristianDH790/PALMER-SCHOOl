
<section class="bg_menu_page">
    <div class="inner_subpage_banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-banner">
                        <h2>Libro de reclamaciones</h2>
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
                <p><a href="<?= base_url(); ?>">Inicio</a> <span>></span> Libro de reclamaciones</p>
            </div>
        </div>
    </div>
</section>

<div id="main-content" class="main-content">

	<div class="container">
		<div class="row" style="display: block;">
			<div class="about-page">

				<div class="col-md-12 col-sm-12" id="">
					<div class="confirmacion" style="margin: 0px 0px 10px; display: none;"></div>
					<form id="reclamo-libro" method="post">
						<h2 class="irAqui">Libro de reclamaciones</h2>
						<h3>Datos de la persona que presenta el reclamo</h3>

						<div class="row" style="padding: 0;margin: 0;">

							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-lastname" class="control-label">Tipo de documento</label>
									<select name="tipodoc" id="tipodoc" tabindex="1">
										<option value="" selected="selected">Seleccione</option>
										<option value="DNI">DNI</option>
										<option value="PASAPORTE">PASAPORTE</option>
										<option value="CE">CE</option>
										<option value="RUC">RUC</option>
										<option value="Pasaporte">PASAPORTE</option>
									</select>
									<span class="validacion tipodoc"></span>

								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-password" class="control-label">Número de documento *</label>
									<input type="text" class="form-control" id="documento" placeholder="" value="" name="documento" tabindex="2">
									<span class="validacion documento"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-firstname" class="control-label">Nombres *</label>
									<input type="text" class="form-control" id="nombres" placeholder="" value="" name="nombres" tabindex="3">
									<span class="validacion nombres"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-password" class="control-label">Apellidos *</label>
									<input type="text" class="form-control" id="apellidos" placeholder="" value="" name="apellidos" tabindex="4">
									<span class="validacion apellidos"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-lastname" class="control-label">Tipo de dirección *</label>
									<select name="tipodir" id="tipodir" tabindex="5">
										<option value="" selected="selected">Seleccione</option>
										<option value="Casa">Casa</option>
										<option value="Departamento">Departamento</option>
										<option value="Condominio">Condominio</option>
										<option value="Residencial">Residencial</option>
										<option value="Oficina">Oficina</option>
										<option value="Local">Local</option>
										<option value="Centro">Centro</option>
										<option value="Mercado">Mercado</option>
										<option value="Galería">Galería</option>
										<option value="Otro">Otro</option>
									</select>
									<span class="validacion tipodir"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-password" class="control-label">Dirección de domicilio *</label>
									<input type="text" class="form-control" id="direccion" placeholder="" value="" name="direccion" tabindex="6">
									<span class="validacion direccion"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-password" class="control-label">Correo electrónico *</label>
									<input type="text" class="form-control" id="correo" placeholder="" value="" name="correo" tabindex="7">
									<span class="validacion correo"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-password" class="control-label">Número de teléfono *</label>
									<input type="text" class="form-control" id="telefono" placeholder="" value="" name="telefono" tabindex="8">
									<span class="validacion telefono"></span>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group required">
									<label for="input-lastname" class="control-label">Tipo queja o reclamo *</label>
									<select name="motivo" id="motivo" tabindex="9">
										<option value="" selected="selected">Seleccione</option>
										<option value="Queja">Queja</option>
										<option value="Reclamo">Reclamo</option>
									</select>
									<span class="validacion motivo"></span>
								</div>
							</div>


							<div class="col-md-12">
								<div class="form-group required" style="margin-bottom: 0;">
									<label for="input-lastname" class="control-label">Detalle de la queja o reclamo *</label>
									<textarea name="detalle" id="detalle" rows="6" cols="50" tabindex="10"></textarea>
									<span class="validacion detalle"></span>
								</div>
							</div>

							<div class="col-md-12" style="margin-top:10px;">
								<div class="form-group">
									<img class="captcha-imagen" src="<?= base_url() ?>/captcha" alt="CAPTCHA">

									<button style="display: inline-block; width: 40px; background: transparent; color:#d4858c; border:none " type="button" id="refres" class="refresh-captcha"><i class="fa fa-refresh " style="position: relative; top:0; right:0;"></i></button>

									<input style="width: 220px; display: inline-block; margin-left: 20px; padding-left: 20px;" type="text" name="captcha" id="captcha" placeholder="Complete el captcha" pattern="[A-Za-z]{6}">
									<span class="validacion captcha"></span>
								</div>
							</div>

							<div class="col-md-12">
								<input type="submit" class="btn btn-md btn-primary btn-libro" value="Enviar">
							</div>

						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>