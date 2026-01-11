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
                <p><a href="<?= base_url(); ?>">Inicio</a><span>></span><a href="<?= base_url(); ?>"> Nivel</a><span>></span> <?= $nivel->nombre ?></p>
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


<h3>Nivel Primario</h3>   
<div class="contenido">
<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veritatis, voluptate eius, aspernatur non officia a ex vero placeat dicta nobis suscipit maiores impedit enim laudantium magni, ipsam dolores sit. Suscipit.
Temporibus in quo, expedita fuga, adipisci porro pariatur cupiditate neque hic dolore non iste asperiores officia aliquid saepe autem accusamus error ullam, dolores nostrum laudantium incidunt placeat fugit dolorem. Error.
Culpa cumque dolore reiciendis, accusantium quidem optio odio eos suscipit dolor aliquid sequi incidunt similique, quibusdam tempora id nesciunt ipsam dolores consectetur voluptatum atque.</p>
<div class="accordion" id="accordionExample">
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
REQUISITOS  NUEVO
</button>
</h2>
<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
<div class="accordion-body">
<strong>This is the first item’s accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
REQUISITOS  TRANSLADO
</button>
</h2>
<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
<div class="accordion-body">
<strong>This is the second item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
REQUISITOS  REGULAR
</button>
</h2>
<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
<div class="accordion-body">
<strong>This is the third item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
</div>
</div>
</div>


</div>
</div>
</section> -->