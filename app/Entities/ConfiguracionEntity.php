<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ConfiguracionEntity extends Entity
{
    protected $attributes = [
        'idconfiguracion'        => null,
        'idptipo'         => null,
        'idprecurso'         => null,
        'nombre'     => null,
        'valor'     => null,
        'descripcion'        => null,
        'urlimagen'        => null,
        'fecha'          => null,
    ];
}
