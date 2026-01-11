<?php

namespace App\Models;

use App\Entities\TipoEntity;
use CodeIgniter\Model;

class TipoModel extends Model
{
    protected $table            = 'tipo';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = TipoEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Timestamps
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha';
    

    public function obtenerPorId($idTipo)
    {
        return $this->where('idtipo', $idTipo)->first();
    }
}
