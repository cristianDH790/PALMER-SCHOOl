<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ContenidoWebEntity extends Entity
{
    // Propiedades principales (campos directos de la tabla)
   

    protected $attributes = [
        'idcontenidoweb'        => null,
        'idestado'        => null,
        'idcontenidowebcategoria'         => null,
        'idptipo'         => null,
        'idpbanner'     => null,
        'urlamigable'        => null,
        'urlimagen'        => null,
        'urlimagen2'          => null,
        'resumen'          => null,
        'contenido'          => null,
        'seccion'          => null,
        'urlbanner'          => null,
        'orden'          => null,
        'tituloseo'          => null,
        'descripcionseo'          => null,
        'palabrasclaveseo'          => null,
        'fecha'          => null,
    ];
}
