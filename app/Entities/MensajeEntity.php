<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MensajeEntity     extends Entity
{

    protected $attributes = [
        'idmensaje'        => null,
        'idestado'         => null,
        'idclase'         => null,
        'nombre'     => null,
        'asunto'        => null,
        'contenido'        => null,
        'variables'        => null,
        'observacion'        => null,
        'fecha'          => null,
    ];
}
