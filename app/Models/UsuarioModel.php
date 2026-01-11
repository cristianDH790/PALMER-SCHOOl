<?php

namespace App\Models;

use App\Entities\UsuarioEntity;
use CodeIgniter\Model;
use Throwable;

class UsuarioModel extends Model
{
    protected $table            = 'usuario';
    protected $primaryKey       = 'idusuario';
    protected $useAutoIncrement = true;
    protected $returnType       = UsuarioEntity::class;
    protected $protectFields    = true;

    protected $allowedFields = [
        'idestado',
        'idperfil',
        'idpdocumento',
        'documento',
        'nombres',
        'papellido',
        'sapellido',
        'fechanacimiento',
        'sexo',
        'correo',
        'telefono',
        'login',
        'password',
        'fecha',
    ];

    // Timestamps
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha';

    /* --------------------------------------------------------------------
     * CREAR / ACTUALIZAR USUARIO
     * ------------------------------------------------------------------*/
    public function guardar(array $data): int
    {
        $db = $this->db;
        $db->transStart();

        try {
            // INSERT o UPDATE usuario
            if (empty($data['idusuario'])) {
                $this->insert($data);
                $idUsuario = $this->getInsertID();
            } else {
                $idUsuario = (int) $data['idusuario'];
                $this->update($idUsuario, $data);
            }

            // Delegamos la gestión de roles
            $usuarioRolModel = new UsuarioRolModel();
            $usuarioRolModel->asignarRol($idUsuario, $data['idperfil']);

            $db->transComplete();
            return $idUsuario;
        } catch (Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error al guardar usuario: ' . $e->getMessage());
            throw $e;
        }
    }

    /* --------------------------------------------------------------------
     * ELIMINAR USUARIO
     * ------------------------------------------------------------------*/
    public function eliminar(int $idusuario): bool
    {
        $this->db->transStart();

        try {
            if (!$this->find($idusuario)) {
                return false;
            }

            $resultado = $this->delete($idusuario);
            $this->db->transComplete();

            return $resultado;
        } catch (Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Eliminar usuario falló: ' . $e->getMessage());
            return false;
        }
    }

    /* --------------------------------------------------------------------
     * BÚSQUEDA CON FILTROS Y PAGINACIÓN
     * ------------------------------------------------------------------*/
    public function buscarPor($ordencriterio, $ordentipo, $parametro, $valor, $idestado, $idperfil, $inicio, $registros)
    {
        $builder = $this->db->table($this->table); // usuario
        $builder->select('*'); // solo campos de usuario

        if (!empty($parametro) && !empty($valor)) {
            $builder->like($parametro, trim($valor), 'both');
        }

        if ($idestado > 0) $builder->where('idestado', $idestado);
        if ($idperfil > 0) $builder->where('idperfil', $idperfil);
        if ($idperfil == -100) $builder->where('idperfil !=', 3);

        $builder->distinct();

        if (!empty($ordencriterio) && !empty($ordentipo)) {
            $builder->orderBy($ordencriterio, $ordentipo);
        }

        if ($registros > 0) {
            $builder->limit($registros, $inicio);
        }


        // Traer resultados
        return $builder->get()->getResult(UsuarioEntity::class);
    }

    /* --------------------------------------------------------------------
     * CONTAR TOTAL DE REGISTROS SEGÚN FILTROS
     * ------------------------------------------------------------------*/
    public function buscarPorTotal($parametro, $valor, $idestado, $idperfil)
    {
        $builder = $this->db->table($this->table); // usuario
        $builder->select('*'); // solo este campo para contar


        if (!empty($parametro) && !empty($valor)) {
            $builder->like($parametro, trim($valor), 'both');
        }

        if ($idestado > 0) $builder->where('idestado', $idestado);
        if ($idperfil > 0) $builder->where('idperfil', $idperfil);
        if ($idperfil == -100) $builder->where('idperfil !=', 3);

        $builder->distinct(); // importante para evitar duplicados

        return $builder->countAllResults();
    }



    /* --------------------------------------------------------------------
     * CONSULTAS
     * ------------------------------------------------------------------*/
    public function autenticar(string $login)
    {
        return $this->where('login', $login)
            ->whereIn('idperfil', [1, 2])
            ->first();
    }

    public function obtenerPorEmail(string $correo)
    {
        return $this->where('correo', $correo)->first();
    }

    public function obtenerPorLogin(string $login)
    {
        return $this->where('login', $login)->first();
    }

    public function obtenerPorId(int $idusuario)
    {
        return $this->find($idusuario);
    }
}
