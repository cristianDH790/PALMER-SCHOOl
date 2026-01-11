<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class NoticiaEntity extends Entity
{

    protected $attributes = [
        'idnoticia'        => null,
        'idestado'        => null,
        'idnoticiacategoria'         => null,
        'nombre'         => null,
        'urlamigable'         => null,
        'resumen'         => null,
        'contenido'         => null,
        'urlimagen'         => null,
        'orden'     => null,
        'descripcionseo'     => null,
        'fecha'          => null,
    ];
}
