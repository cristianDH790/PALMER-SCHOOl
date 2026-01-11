<section class="bg_menu_page">
    <div class="inner_subpage_banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-banner">
                        <h2>Pagos en linea</h2>

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
                <p><a href="<?= base_url(); ?>">Inicio</a> <span>></span> Pagos en linea</p>
            </div>
        </div>
    </div>
</section>
<? if ($pagos): ?>
    <?= $pagos->contenido ?>
<? endif; ?>

