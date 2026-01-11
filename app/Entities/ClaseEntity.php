<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ClaseEntity extends Entity
{

    protected $attributes = [
        'idclase'        => null,
        'idrclase'         => null,
        'nombre'         => null,
        'descripcion'     => null,
        'orden'        => null,
        'fecha'          => null,
    ];
}
