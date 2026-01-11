<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TipoEntity    extends Entity
{
    protected $attributes = [
        'idtipo'        => null,
        'idclase'         => null,
        'idestado'         => null,
        'nombre'     => null,
        'descripcion'        => null,
        'orden'        => null,
        'fecha'          => null,
    ];
}
