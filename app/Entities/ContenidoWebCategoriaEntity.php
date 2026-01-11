<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;


class ContenidoWebCategoriaEntity extends Entity
{

    protected $attributes= [
        'idcontenidowebcategoria'=> null,
        'idrcontenidowebcategoria'=> null,
        'idestado'=> null,
        'nombre'=> null,
        'orden'=> null,
        'urlamigable'=> null,
        'descripcionseo'=> null,
        'fecha'=> null,
    ];

}
