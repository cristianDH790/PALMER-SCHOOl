<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EstadoEntity  extends Entity
{

    protected $attributes = [
        'idestado'        => null,
        'idclase'         => null,
        'nombre'         => null,
        'abr'     => null,
        'descripcion'        => null,
        'orden'        => null,
        'fecha'          => null,
    ];
}
