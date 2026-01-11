<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;


class PerfilEntity  extends Entity
{
    protected $attributes = [
        'idperfil'        => null,
        'idestado'         => null,
        'nombre'         => null,
        'abr'     => null,
        'descripcion'        => null,
        'fecha'          => null,
    ];
}
