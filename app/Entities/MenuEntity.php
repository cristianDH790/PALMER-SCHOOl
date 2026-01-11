<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MenuEntity extends Entity
{

    protected $attributes = [
        'idparametro'        => null,
        'idtipo'         => null,
        'nombre'         => null,
        'abr'     => null,
        'descripcion'        => null,
        'orden'        => null,
        'requerido'        => null,
        'editable'        => null,
        'fecha'          => null,
    ];

    }
