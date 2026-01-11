<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class NoticiaCategoriaEntity extends Entity
{

    protected $attributes = [
        'idnoticiacategoria'        => null,
        'idestado'        => null,
        'idrnoticiacategoria'         => null,
        'nombre'         => null,
        'orden'     => null,
        'fecha'          => null,
    ];
}
