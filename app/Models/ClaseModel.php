<?php

namespace App\Models;

use App\Entities\ClaseEntity;
use CodeIgniter\Model;

class ClaseModel extends Model
{
    protected $table            = 'clase';
    protected $primaryKey       = 'idclase';
    protected $useAutoIncrement = true;
    protected $returnType       = ClaseEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idrclase',
        'nombre',
        'descripcion',
        'orden',
        'fecha'
    ];


    // Timestamps
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha';

    public function obtenerPorId($idClase)
    {
        return $this->where('idclase', $idClase)->first();
    }


    public function buscarPor($ordencriterio, $ordentipo, $parametro, $valor, $idclase, $inicio, $registros)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        // Filtro por búsqueda
        if (!empty($parametro) && !empty($valor)) {
            $builder->like($parametro, $valor);
        }
        // Filtros por ID
        if ($idclase > 0) $builder->where('idclase', $idclase);
        // Ordenamiento
        if (!empty($ordencriterio) && !empty($ordentipo)) $builder->orderBy($ordencriterio, $ordentipo);

        // Paginación
        if ($registros > 0) {
            $builder->limit($registros, $inicio);
        }

        return $builder->get()->getResult(ClaseEntity::class);
    }

   

    public function buscarPorTotal($parametro, $valor, $idclase)
    {
        $this->select('idclase');

        if (!empty($parametro) && !empty($valor)) {
            $this->like($parametro, trim($valor));
        }
        if ($idclase > 0) {
            $this->where('idestado', $idclase);
        }

          return $this->countAllResults(false); 
    }
}
