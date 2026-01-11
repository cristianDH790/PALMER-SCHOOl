<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UsuarioEntity extends Entity
{
    /**
     * Campos asignables
     */
    protected $attributes = [
        'idusuario'        => null,
        'idestado'         => null,
        'idperfil'         => null,
        'idpdocumento'     => null,
        'documento'        => null,
        'nombres'          => null,
        'papellido'        => null,
        'sapellido'        => null,
        'fechanacimiento'  => null,
        'sexo'             => null,
        'correo'           => null,
        'telefono'         => null,
        'boletin'          => null,
        'login'            => null,
        'password'         => null,
        'fecha'            => null,
        'pedidos'          => null,
        'importetotal'     => null,
    ];

   



    /**
     * Campos ocultos al serializar
     */
    protected $hidden = ['password'];

    /**
     * Encripta la contraseña automáticamente
     */
    public function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Nombre completo
     */
    public function getNombreCompleto(): string
    {
        return trim("{$this->nombres} {$this->papellido} {$this->sapellido}");
    }
}
