<section class="bg_menu_page">
    <div class="inner_subpage_banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-banner">
                        <h2>Nivel detalle</h2>
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
                <p><a href="<?= base_url(); ?>">Inicio</a><span>></span><a href="<?= base_url(); ?>niveles"> Nivel</a><span>></span> <?= $nivel->nombre ?></p>
            </div>
        </div>
    </div>
</section>




<? if ($nivel): ?>
    <?= $nivel->contenido ?>
<? endif; ?>




<!-- 
<section class="nivel-detalle">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12 caja">


                <h3>Nivel inicial</h3>
                <div class="contenido">

                    <div class="container-fluid py-5">
                       
                        <div class="text-center mb-5">
                            <h4 class="fw-bold mb-4" style="color:#094886 !important;">SEMBRANDO LAS BASES DEL FUTURO</h4>
                            <p style="color:#000 !important; max-width:800px; margin:auto; font-size: 18px;">
                                Experiencia educativa que fomenta la curiosidad natural de los niños, su desarrollo emocional y social, y sus primeras habilidades cognitivas.
                            </p>
                        </div>

                       
                        <div class="d-flex flex-wrap justify-content-center" style="gap:2rem;">

                           
                            <div class="card shadow-lg flex-grow-1" style="max-width:350px; border-radius:20px; border:none; transition: transform 0.3s;">
                                <img src="https://static.vecteezy.com/system/resources/previews/026/765/485/non_2x/square-school-banner-group-of-children-and-school-building-back-to-school-illustration-vector.jpg"
                                    class="card-img-top"
                                    style="width:100%; height:250px; object-fit:cover;" alt="Metodología">
                                <div class="card-body text-center">
                                    <h5 style="color:#094886; font-weight:bold; margin-bottom:1rem;">Metodología</h5>
                                    <ul style="color:#000; padding-left:1.25rem; text-align:left;">
                                        <li>Aprendizaje a través del juego.</li>
                                        <li>Enfoque en actividades lúdicas y artísticas.</li>
                                        <li>Desarrollo de habilidades motoras finas y gruesas.</li>
                                    </ul>
                                </div>
                            </div>

                           
                            <div class="card shadow-lg flex-grow-1" style="max-width:350px; border-radius:20px; border:none; transition: transform 0.3s;">
                                <img src="https://static.vecteezy.com/system/resources/previews/026/765/485/non_2x/square-school-banner-group-of-children-and-school-building-back-to-school-illustration-vector.jpg"
                                    class="card-img-top"
                                    style="width:100%; height:250px; object-fit:cover;" alt="Beneficios">
                                <div class="card-body text-center">
                                    <h5 style="color:#094886; font-weight:bold; margin-bottom:1rem;">Beneficios</h5>
                                    <ul style="color:#000; padding-left:1.25rem; text-align:left;">
                                        <li>Aulas seguras y equipadas con materiales educativos innovadores.</li>
                                        <li>Desarrollo cognitivo integral.</li>
                                        <li>Actividades que fortalecen el vínculo entre la familia y el colegio.</li>
                                    </ul>
                                </div>
                            </div>

                           
                            <div class="card shadow-lg flex-grow-1" style="max-width:350px; border-radius:20px; border:none; transition: transform 0.3s;">
                                <img src="https://static.vecteezy.com/system/resources/previews/026/765/485/non_2x/square-school-banner-group-of-children-and-school-building-back-to-school-illustration-vector.jpg"
                                    class="card-img-top"
                                    style="width:100%; height:250px; object-fit:cover;" alt="Instalaciones">
                                <div class="card-body text-center">
                                    <h5 style="color:#094886; font-weight:bold; margin-bottom:1rem;">Instalaciones</h5>
                                    <ul style="color:#000; padding-left:1.25rem; text-align:left;">
                                        <li>Espacios recreativos especializados.</li>
                                        <li>Salones coloridos y estimulantes para el aprendizaje.</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    </div>
</section>
<section class="requisitos" style="background-color: #edf2f2 ; padding-top: 60px; padding-bottom: 60px;">

    <div class="accordion accordion-fullwidth" id="accordionExample" style="max-width:1300px; margin:auto; ">

     
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne" style="font-size: 1.1rem;">
                    REQUISITOS &nbsp;NUEVO
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body" style="color:#000; font-size: 1rem; line-height: 1.5;">
                    <p class="mb-3"><strong>¡Forma Parte de la Familia Palmer School!</strong></p>
                    <ul>
                        <li>Copia de DNI del menor</li>
                        <li>Copia de DNI de los padres</li>
                        <li>Boleta de notas del IV Bim.</li>
                        <li>Tarjeta de vacunación (alumnos de 3 años)</li>
                        <li>No reservamos el derecho a admisión</li>
                        <li>No existe devolución de matrícula, una vez cancelado.</li>
                    </ul>

                    <div class="bg-light rounded p-3 my-4" style="border-left: 6px solid #42ad22;">
                        <h5 class="text-center mb-1" style="color:#42ad22; font-weight: 700;">MATRÍCULA</h5>
                        <p class="text-center fs-5 fw-semibold mb-0">S/ 250.00</p>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap" style="gap:1rem;">
                        <div style="flex: 1 1 45%;">
                            <h6 class="text-primary fw-bold">Pensiones</h6>
                            <p class="mb-1"><strong>Inicial:</strong> S/ 280.00</p>
                            <p class="mb-1"><strong>Primaria:</strong> S/ 290.00</p>
                            <p class="mb-0"><strong>Secundaria:</strong> S/ 300.00</p>
                        </div>
                        <div style="flex: 1 1 45%;">
                            <h6 class="text-primary fw-bold">Material Educativo</h6>
                            <p class="mb-0"><strong>Costo:</strong> S/ 300.00</p>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="fs-5 fw-bold text-primary mb-0">INICIO DE CLASES:</p>
                        <p class="fs-3 fw-bold" style="color:#42ad22; letter-spacing: 2px;">04 MARZO</p>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo" style="font-size: 1.1rem;">
                    REQUISITOS &nbsp;TRASLADO
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body" style="color:#000; font-size: 1rem; line-height: 1.5;">
                    <p><strong>Documentos necesarios para traslado:</strong></p>
                    <ul>
                        <li>Copia de DNI del menor</li>
                        <li>Copia de DNI de los padres</li>
                        <li>Boleta de notas actualizada</li>
                        <li>Certificado de conducta</li>
                        <li>Constancia de estudios</li>
                    </ul>

                    <div class="bg-light rounded p-3 my-4" style="border-left: 6px solid #42ad22;">
                        <h5 class="text-center mb-1" style="color:#42ad22; font-weight: 700;">MATRÍCULA</h5>
                        <p class="text-center fs-5 fw-semibold mb-0">S/ 250.00</p>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap" style="gap:1rem;">
                        <div style="flex: 1 1 45%;">
                            <h6 class="text-primary fw-bold">Pensiones</h6>
                            <p class="mb-1"><strong>Inicial:</strong> S/ 280.00</p>
                            <p class="mb-1"><strong>Primaria:</strong> S/ 290.00</p>
                            <p class="mb-0"><strong>Secundaria:</strong> S/ 300.00</p>
                        </div>
                        <div style="flex: 1 1 45%;">
                            <h6 class="text-primary fw-bold">Material Educativo</h6>
                            <p class="mb-0"><strong>Costo:</strong> S/ 300.00</p>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="fs-5 fw-bold text-primary mb-0">INICIO DE CLASES:</p>
                        <p class="fs-3 fw-bold" style="color:#42ad22; letter-spacing: 2px;">04 MARZO</p>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree" style="font-size: 1.1rem;">
                    REQUISITOS &nbsp;REGULAR
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body" style="color:#000; font-size: 1rem; line-height: 1.5;">
                    <p><strong>Requisitos para inscripción regular:</strong></p>
                    <ul>
                        <li>Constancia de estudios</li>
                        <li>Boleta de notas del ciclo anterior</li>
                        <li>Copia de DNI del alumno</li>
                        <li>Copia de DNI de los padres</li>
                    </ul>

                    <div class="bg-light rounded p-3 my-4" style="border-left: 6px solid #42ad22;">
                        <h5 class="text-center mb-1" style="color:#42ad22; font-weight: 700;">MATRÍCULA</h5>
                        <p class="text-center fs-5 fw-semibold mb-0">S/ 250.00</p>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap" style="gap:1rem;">
                        <div style="flex: 1 1 45%;">
                            <h6 class="text-primary fw-bold">Pensiones</h6>
                            <p class="mb-1"><strong>Inicial:</strong> S/ 280.00</p>
                            <p class="mb-1"><strong>Primaria:</strong> S/ 290.00</p>
                            <p class="mb-0"><strong>Secundaria:</strong> S/ 300.00</p>
                        </div>
                        <div style="flex: 1 1 45%;">
                            <h6 class="text-primary fw-bold">Material Educativo</h6>
                            <p class="mb-0"><strong>Costo:</strong> S/ 300.00</p>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="fs-5 fw-bold text-primary mb-0">INICIO DE CLASES:</p>
                        <p class="fs-3 fw-bold" style="color:#42ad22; letter-spacing: 2px;">04 MARZO</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
<section class="video">
    <div class="container-fluid py-5">
      
        <div class="text-center mb-5">
            <h4 class="fw-bold mb-4" style="color:#094886 !important;">Conoce Nuestra Experiencia</h4>
            <p style="color:#000 !important; max-width:800px; margin:auto; font-size:18px;">
                Mira nuestro video y descubre cómo fomentamos el desarrollo integral de los niños a través de experiencias educativas únicas.
            </p>
        </div>

       
        <div class="d-flex justify-content-center">
            <div class="ratio ratio-16x9" style="max-width:800px; width:100%;">
                <iframe src="https://www.youtube.com/embed/VIDEO_ID" title="YouTube video" allowfullscreen style="border-radius:20px;"></iframe>
            </div>
        </div>
    </div>
</section> -->


<!-- 
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
</section> -->


<? if ($bannerinicio): ?>
    <?= $bannerinicio->contenido ?>
<? endif; ?>

<? if ($tipopagos): ?>
    <?= $tipopagos->contenido ?>
<? endif; ?>

<!-- Hover effect para tarjetas -->
<style>
    .card:hover {
        transform: translateY(-10px) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25) !important;
    }
</style>