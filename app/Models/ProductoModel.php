<?php

namespace App\Models;


use App\Entities\ProductoEntity;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table      = 'producto';
    protected $primaryKey = 'idproducto';

    protected $useAutoIncrement = true;

    protected $returnType     = ProductoEntity::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'idestado',
        'idpdestacado',
        'nombre',
        'urlamigable',
        'urlimagen',
        'resumen',
        'contenido',
        'orden',
        'fechapublicacion',
        'fecha'
    ];


    protected $useTimestamps = false;
    protected $createdField  = 'fecha';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;



    // Obtener curso por ID
    public  function obtenerPorId($idproducto)
    {
        return $this->where('idproducto', $idproducto)->first();
    }

    public function obtenerPorUrlAmigable($urlamigable)
    {
        return $this->where('urlamigable', $urlamigable)->first();
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
        $builder = $this->db->table($this->table . ' p');

        // SELECT SOLO PRODUCTO
        $builder->select('p.*');

        // ===============================
        // BUSCADOR
        // ===============================
        if (!empty($parametro) && !empty($valor)) {
            $builder->like('p.' . $parametro, trim($valor), 'both');
        }

        // ===============================
        // FILTROS
        // ===============================
        if ($idestado > 0) {
            $builder->where('p.idestado', $idestado);
        }

        if ($idpdestacado > 0) {
            $builder->where('p.idpdestacado', $idpdestacado);
        }

        // ===============================
        // ORDEN
        // ===============================
        if (!empty($ordencriterio) && !empty($ordentipo)) {
            $builder->orderBy('p.' . $ordencriterio, $ordentipo);
        }

        // ===============================
        // PAGINACIÓN
        // ===============================
        if ($registros > 0) {
            $builder->limit($registros, $inicio);
        }

        return $builder->get()->getResult(ProductoEntity::class);
    }


    public function buscarPorTotal(
        $parametro,
        $valor,
        $idestado,
        $idpdestacado
    ) {
        $builder = $this->db->table($this->table . ' p');

        // COUNT SIMPLE
        $builder->select('COUNT(p.idproducto) as total');

        // ===============================
        // BUSCADOR
        // ===============================
        if (!empty($parametro) && !empty($valor)) {
            $builder->like('p.' . $parametro, trim($valor), 'both');
        }

        // ===============================
        // FILTROS
        // ===============================
        if ($idestado > 0) {
            $builder->where('p.idestado', $idestado);
        }

        if ($idpdestacado > 0) {
            $builder->where('p.idpdestacado', $idpdestacado);
        }

        return (int) $builder->get()->getRow()->total;
    }





    public function eliminar($idproducto): bool
    {
        $this->db->transStart();
        try {
            if (!$this->where('idproducto', $idproducto)->first()) {
                return false;
            }

            $resultado = $this->delete($idproducto);

            $this->db->transComplete();
            return $resultado;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Eliminar producto base falló: ' . $e->getMessage());
            return false;
        }
    }

    public function guardar($data)
    {
        $this->db->transStart();

        try {

            // Guardar o actualizar producto
            if (!empty($data['idproducto'])) {
                $this->update($data['idproducto'], $data);
                $productoId = $data['idproducto'];
            } else {
                $this->insert($data);
                $productoId = $this->getInsertID();
            }
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Error al guardar el producto');
            }

            return $productoId;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Error en guardar Producto: ' . $e->getMessage());
            throw $e;
        }
    }

   
}
