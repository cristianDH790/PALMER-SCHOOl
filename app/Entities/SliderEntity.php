<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SliderEntity extends Entity
{

    protected $attributes = [
        'idslider' => null,
        'idestado' => null,
        'nombre' => null,
        'descripcion' => null,
        'urlimagen1' => null,
        'urlimagen2' => null,
        'idprecurso' => null,
        'idpcategoria' => null,
        'urlrecurso' => null,
        'orden' => null,
        'fecha' => null,
        'urlarchivo1' => null,
        'urlarchivo2' => null,
    ];
    


}
