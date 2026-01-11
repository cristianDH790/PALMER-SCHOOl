<?php

namespace App\Models;


use App\Entities\ProductoEntity;
use App\Entities\TestimonioEntity;
use CodeIgniter\Model;

class TestimonioModel extends Model
{
    protected $table      = 'testimonio';
    protected $primaryKey = 'idtestimonio';

    protected $useAutoIncrement = true;

    protected $returnType     = TestimonioEntity::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'idestado',
        'idpdestacado',
        'nombre',
        'descripcion',
        'urlimagen',
        'dni',
        'orden',
        'fecha'
    ];


    protected $useTimestamps = false;
    protected $createdField  = 'fecha';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;



    // Obtener curso por ID
    public  function obtenerPorId($idtestimonio)
    {
        return $this->where('idtestimonio', $idtestimonio)->first();
    }



    public function buscarPor(
        $ordencriterio,
        $ordentipo,
        $parametro,
        $valor,
        $idestado,
        $idpdestacado,
        $inicio,
        $registros
    ) {
        $builder = $this->db->table($this->table . ' t');
        $builder->select('t.*');

        // ===============================
        // BUSCADOR
        // ===============================
        if (!empty($parametro) && !empty($valor)) {
            $builder->like('t.' . $parametro, trim($valor), 'both');
        }

        // ===============================
        // FILTROS
        // ===============================
        if ($idestado > 0) {
            $builder->where('t.idestado', $idestado);
        }

        if ($idpdestacado > 0) {
            $builder->where('t.idpdestacado', $idpdestacado);
        }

        // ===============================
        // ORDEN
        // ===============================
        if (!empty($ordencriterio) && !empty($ordentipo)) {
            $builder->orderBy('t.' . $ordencriterio, $ordentipo);
        }

        // ===============================
        // PAGINACIÓN
        // ===============================
        if ($registros > 0) {
            $builder->limit($registros, $inicio);
        }

        return $builder->get()->getResult(TestimonioEntity::class);
    }


    public function buscarPorTotal(
        $parametro,
        $valor,
        $idestado,
        $idpdestacado
    ) {
        $builder = $this->db->table($this->table . ' t');

        // COUNT SIMPLE
        $builder->select('COUNT(t.idtestimonio) as total');

        // ===============================
        // BUSCADOR
        // ===============================
        if (!empty($parametro) && !empty($valor)) {
            $builder->like('t.' . $parametro, trim($valor), 'both');
        }

        // ===============================
        // FILTROS
        // ===============================
        if ($idestado > 0) {
            $builder->where('t.idestado', $idestado);
        }

        if ($idpdestacado > 0) {
            $builder->where('t.idpdestacado', $idpdestacado);
        }

        return (int) $builder->get()->getRow()->total;
    }





    public function eliminar($idtestimonio): bool
    {
        $this->db->transStart();
        try {
            if (!$this->where('idtestimonio', $idtestimonio)->first()) {
                return false;
            }

            $resultado = $this->delete($idtestimonio);

            $this->db->transComplete();
            return $resultado;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Eliminar testimonio base falló: ' . $e->getMessage());
            return false;
        }
    }

    public function guardar($data)
    {
        $this->db->transStart();

        try {

            // Guardar o actualizar producto
            if (!empty($data['idtestimonio'])) {
                $this->update($data['idtestimonio'], $data);
                $productoId = $data['idtestimonio'];
            } else {
                $this->insert($data);
                $productoId = $this->getInsertID();
            }
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Error al guardar el testimonio');
            }

            return $productoId;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Error en guardar Testimonio: ' . $e->getMessage());
            throw $e;
        }
    }

   
}
