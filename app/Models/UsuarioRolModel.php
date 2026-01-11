<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioRolModel extends Model
{
    protected $table         = 'usuario_rol';
    protected $allowedFields = ['idusuario', 'idrol'];
    protected $useAutoIncrement = false; // no necesitamos auto-increment

    /**
     * Asigna un rol a un usuario.
     * Si ya existe, no hace nada.
     */
    public function asignarRol($idUsuario, $idRol): void
    {
        $existe = $this->where('idusuario', $idUsuario)
                       ->where('idrol', $idRol)
                       ->first();

        if (!$existe) {
            // Usamos builder()->insert() en lugar de insert() del modelo
            $this->builder()->insert([
                'idusuario' => $idUsuario,
                'idrol'     => $idRol,
            ]);
        }
    }

    public function obtenerRolesPorUsuario($idUsuario): array
    {
        return $this->where('idusuario', $idUsuario)->findAll();
    }

    public function removerRol($idUsuario, $idRol = null): bool
    {
        $builder = $this->builder()->where('idusuario', $idUsuario);
        if ($idRol !== null) {
            $builder->where('idrol', $idRol);
        }
        return (bool) $builder->delete();
    }
}

