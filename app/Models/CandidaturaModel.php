<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidaturaModel extends Model
{
    protected $table            = 'candidaturas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'nome',
        'email',
        'telefone',
        'nascimento',
        'sexo',
        'redes_sociais',
        'lattes',
        'historia',
        'status',
        'notas_admin',
        'created_at',
    ];

    /**
     * @return list<object>
     */
    public function pendentes(): array
    {
        return $this->where('status', 'pendente')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * @return list<object>
     */
    public function todas(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}
