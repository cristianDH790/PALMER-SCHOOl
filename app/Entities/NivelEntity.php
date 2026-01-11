<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class NivelEntity extends Entity
{
    protected $attributes = [
        'idnivel'         => null,
        'idestado'        => null,
        'idpdestacado'    => null,
        'nombre'          => null,
        'urlamigable'     => null,
        'resumen'         => null,
        'contenido'       => null,
        'urlimagen'       => null,
        'orden'           => null,
        'descripcionseo'  => null,
        'fecha'           => null,
    ];
}
