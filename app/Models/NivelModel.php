<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\NivelEntity;

class NivelModel extends Model
{
    protected $table            = 'nivel';
    protected $primaryKey       = 'idnivel';
    protected $useAutoIncrement = true;

    protected $returnType       = NivelEntity::class;
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'idestado',

        'idpdestacado',
        'nombre',
        'urlamigable',
        'descripcionseo',
        'resumen',
        'contenido',
        'urlimagen',
        'orden',
        'fechapublicacion',
        'fecha'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'fecha';

    /* ===============================
       OBTENER POR ID
    ================================ */
    public function obtenerPorId(int $idnivel)
    {
        return $this->find($idnivel);
    }

    /* ===============================
       OBTENER POR URL AMIGABLE
    ================================ */
    public function obtenerPorUrlAmigable(string $urlamigable)
    {
        return $this->where('urlamigable', $urlamigable)->first();
    }

    /* ===============================
       BUSCAR (LISTADO)
    ================================ */
    public function buscarPor(
        string $ordencriterio = '',
        string $ordentipo = '',
        string $parametro = '',
        string $valor = '',
        int $idestado = 0,
        int $idpdestacado = 0,
        ?int $inicio = null,
        ?int $registros = null
    ) {
        $builder = $this->builder();

        if ($parametro && $valor) {
            $builder->like($parametro, trim($valor));
        }

        if ($idestado > 0) {
            $builder->where('idestado', $idestado);
        }

        if ($idpdestacado > 0) {
            $builder->where('idpdestacado', $idpdestacado);
        }

        if ($ordencriterio && $ordentipo) {
            $builder->orderBy($ordencriterio, $ordentipo);
        }

        if ($registros !== null) {
            $builder->limit($registros, $inicio ?? 0);
        }

        return $builder->get()->getResult(NivelEntity::class);
    }

    /* ===============================
       TOTAL REGISTROS
    ================================ */
    public function buscarPorTotal(
        string $parametro = '',
        string $valor = '',
        int $idestado = 0,
        int $idpdestacado = 0
    ): int {
        $builder = $this->builder();

        if ($parametro && $valor) {
            $builder->like($parametro, trim($valor));
        }

        if ($idestado > 0) {
            $builder->where('idestado', $idestado);
        }

        if ($idpdestacado > 0) {
            $builder->where('idpdestacado', $idpdestacado);
        }

        return $builder->countAllResults();
    }

    /* ===============================
       GUARDAR (INSERT / UPDATE)
    ================================ */
    public function guardar(array $data): int
    {
        $this->db->transStart();

        try {
            if (empty($data['idnivel'])) {
                $this->insert($data);
                $id = $this->getInsertID();
            } else {
                $this->update($data['idnivel'], $data);
                $id = $data['idnivel'];
            }
            // echo $this->db->getLastQuery();
            $this->db->transComplete();
            return $id;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            // echo $this->db->getLastQuery();
            log_message('error', 'Error al guardar nivel: ' . $e->getMessage());
            throw $e;
        }
    }

    /* ===============================
       ELIMINAR
    ================================ */
    public function eliminar(int $idnivel): bool
    {
        if (!$this->find($idnivel)) {
            return false;
        }

        return $this->delete($idnivel);
    }
}
