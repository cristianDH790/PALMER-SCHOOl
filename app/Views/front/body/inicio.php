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
    <section class="anta-emba" data-aos="flip-up">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3>Nuestros Niveles</h3>
                </div>
                <? foreach ($nivelesinicios as $nivelesinicio): ?>
                    <div class="col-md-4 caja">
                        <a href="<?= base_url(); ?>nivel/<?= $nivelesinicio->urlamigable ?>"><img src="<?= base_url(); ?>archivos/nivel/<?= $nivelesinicio->urlimagen ?>" alt="<?= $nivelesinicio->nombre ?>"></a>
                        <div class="box-texto">
                            <h4><?= $nivelesinicio->nombre ?></h4>
                            <p><?= $nivelesinicio->resumen ?></p>
                            <a href="<?= base_url(); ?>nivel/<?= $nivelesinicio->urlamigable ?>">Ver mas</a>
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