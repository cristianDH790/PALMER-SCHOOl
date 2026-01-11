<?php

namespace App\Models;

use App\Entities\ParametroEntity;
use CodeIgniter\Model;

class ParametroModel extends Model
{
    protected $table            = 'parametro';
    protected $primaryKey       = 'idparametro';
    protected $useAutoIncrement = true;
    protected $returnType       = ParametroEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idtipo', 'idestado', 'nombre', 'abr', 'descripcion', 'orden'];
    // Timestamps
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha';



    public function obtenerPorId($idparametro)
    {
        return $this->where('idparametro', $idparametro)->first();
    }

    public function buscarPor($ordenCampo, $ordenTipo, $idestado, $idtipo, $inicio, $registros)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');

        if ($idtipo > 0)
            $builder->where('idtipo', $idtipo);

        if ($idestado > 0)
            $builder->where('idestado', $idestado);

        if (!empty($ordenCampo) && !empty($ordenTipo))
            $builder->orderBy($ordenCampo, $ordenTipo);

        // Paginación
        if ($registros > 0) {
            $builder->limit($registros, $inicio);
        }

        return $builder->get()->getResult(ParametroEntity::class);
    }

    public function buscarPorTotal($idestado, $idtipo)
    {
        $builder = $this->db->table($this->table);

        if ($idtipo > 0) $builder->where('idtipo', $idtipo);

        if ($idestado > 0) $builder->where('idestado', $idestado);


        return $builder->countAllResults();
    }
}
