<?php

namespace App\Models;

use App\Entities\MensajeEntity;
use CodeIgniter\Model;

class MensajeModel extends Model
{
    protected $table            = 'mensaje';
    protected $primaryKey       = 'idmensaje';
    protected $useAutoIncrement = true;
    protected $returnType       = MensajeEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idestado',
        'idclase',
        'nombre',
        'asunto',
        'contenido',
        'variables',
        'fecha',
    ];
    // Timestamps
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha';

    public function obtenerPorId($idmensaje)
    {
        return $this->where('idmensaje', $idmensaje)->first();
    }

    public function buscarPor($ordencriterio = '', $ordentipo = '', $idclase = 0, $idestado = 0, $registros = null, $inicio = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');

        if ($idclase > 0) $builder->where('idclase', $idclase);

        if ($idestado > 0) $builder->where('idestado', $idestado);


        if (!empty($ordencriterio) && !empty($ordentipo)) {
            $builder->orderBy($ordencriterio, $ordentipo);
        }

        if (!empty($registros) && !empty($inicio)) {
            $builder->limit($registros, $inicio);
        }


        if ($registros > 0) {
            $builder->limit($registros, $inicio);
        }

        return $builder->get()->getResult(MensajeEntity::class);
    }


    public function buscarPorTotal($idclase = '', $idestado = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('COUNT(*) as total');

        if ($idclase > 0) $builder->where('idclase', $idclase);

        if ($idestado > 0) $builder->where('idestado', $idestado);


        return $builder->countAllResults();
    }

    public function guardar($mensaje)
    {
        $this->db->transStart();
        try {
            if (empty($mensaje['idmensaje']) || $mensaje['idmensaje'] == 0) {
                $this->insert($mensaje);
                $id = $this->getInsertID();
            } else {
                $this->update($mensaje['idmensaje'], $mensaje);
                $id = $mensaje['idmensaje'];
            }
            $this->db->transComplete();
            return $id;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Error en guardar: ' . $e->getMessage());
            throw $e;
        }
    }

    public function eliminar($idmensaje): bool
    {
        $this->db->transStart();
        try {
            if (!$this->where('idmensaje', $idmensaje)->first()) {
                return false;
            }

            $resultado = $this->delete($idmensaje);

            $this->db->transComplete();
            return $resultado;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Eliminar usuario falló: ' . $e->getMessage());
            return false;
        }
    }
}
