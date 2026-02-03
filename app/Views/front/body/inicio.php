<section class="slider-home" data-aos="fade-right">
    <div class="owl-carousel2 owl-theme">
        <? if ($sliders):
            foreach ($sliders as $slider): ?>
                <? if ($slider->idprecurso != 567): ?>
                    <div class="item">
                        <a href="<?= $slider->urlrecurso ?>">
                            <img src="<?= base_url(); ?>archivos/slider/<?= $slider->urlarchivo1 ?>" alt="">
                        </a>
                    </div>

                <? else: ?>
                    <a href="<?= $slider->urlrecurso ?>">
                        <video autoplay loop muted playsinline>
                            <source src="<?= base_url(); ?>archivos/slider/<?= $slider->urlarchivo1 ?>" type="video/mp4" />
                        </video>
                    </a>
                <? endif; ?>

        <? endforeach;
        endif; ?>
    </div>

    <div class="owl-carousel3 owl-theme  d-none">
        <? if ($sliders):
            foreach ($sliders as $slider): ?>
                <? if ($slider->idprecurso != 567): ?>
                    <div class="item">
                        <a href="<?= $slider->urlrecurso ?>">
                            <img src="<?= base_url(); ?>archivos/slider/<?= $slider->urlarchivo2 ?>" alt="">
                        </a>
                    </div>

                <? else: ?>
                    <div class="item">
                        <a href="<?= $slider->urlrecurso ?>">
                            <video autoplay loop muted playsinline>
                                <source src="<?= base_url(); ?>archivos/slider/<?= $slider->urlarchivo2 ?>" type="video/mp4" />
                            </video>
                        </a>
                    </div>
                <? endif; ?>

        <? endforeach;
        endif; ?>
    </div>
</section>

<? if ($nosotrosinicio): ?>
    <?= $nosotrosinicio->contenido ?>
<? endif; ?>

<? if ($instalacionesinicio): ?>
    <?= $instalacionesinicio->contenido ?>
<? endif; ?>

<? if ($bannerinicio): ?>
    <?= $bannerinicio->contenido ?>
<? endif; ?>

<? if ($nivelesinicios): ?>
    <section class="anta-emba" data-aos="fade-right">
        <div class="container-fluid">
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-12">
                    <h3>Nuestros Niveles</h3>
                </div>
                <? foreach ($nivelesinicios as $nivelesinicio): ?>
                    <div class="col-md-3 caja">
                        <a href="<?= base_url(); ?>nivel/<?= $nivelesinicio->urlamigable ?>"><img src="<?= base_url(); ?>archivos/nivel/<?= $nivelesinicio->urlimagen ?>" alt="<?= $nivelesinicio->nombre ?>"></a>
                        <div class="box-texto">
                            <h4><?= $nivelesinicio->nombre ?></h4>
                            <p></p>
                            <a href="<?= base_url(); ?>niveles">Ver mas</a>
                            <!-- <a href="<?= base_url(); ?>nivel/<?= $nivelesinicio->urlamigable ?>">Ver mas</a> -->
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </section>
<? endif; ?>

<? if ($tipopagos): ?>
    <?= $tipopagos->contenido ?>
<? endif; ?>
<div class="modal fade show" id="popupModal" tabindex="-1"
    style="
        display:flex;
        align-items:center;
        justify-content:center;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.6);
     ">

    <div class="modal-dialog"
        style="
            width:90vmin;
            max-width:650px !important;
            aspect-ratio:1 / 1;
            margin:0;
            position:relative;
         ">

        <div class="modal-content"
            style="
                width:100%;
                height:100%;
                border-radius:20px;
                overflow:hidden;
                background:url('<?= base_url(); ?>archivos/configuracion/<?= $publicidad->urlimagen ?>')
                          center / cover no-repeat;
                position:relative;
             ">

            <!-- BOTÓN CERRAR -->
            <button type="button"
                id="cerrarModal"
                aria-label="Close"
                style="
                    position:absolute;
                    top:12px;
                    right:12px;
                    z-index:5;
                    width:30px;
                    height:30px;
                    background:white;
                    border-radius:50%;
                    border:none;
                    font-size: 20px;
                    box-shadow:0 2px 6px rgba(0,0,0,.4);
                    font-weight:bold;
                    cursor:pointer;
                ">
                ×
            </button>

            <!-- ÁREA CLICKEABLE -->
            <a href="<?= $urlpublicidad->valor ?>"
                style="
                    position:absolute;
                    inset:0;
                    z-index:1;
               ">
            </a>

        </div>

    </div>
</div>
<script>
    $(document).ready(function() {

        $("#popupModal").show();

        $("#cerrarModal").on("click", function() {
            $("#popupModal").fadeOut(200);
        });

    });
</script>