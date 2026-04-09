<?php

namespace App\Models;

use CodeIgniter\Model;

class AcessosEnsaiosModel extends Model
{
    protected $table            = 'acessos_ensaios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; // Retorna objetos para facilitar leitura
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'ensaio_slug', 'data_acesso', 'ip_address', 'user_agent'];

    // Não usaremos timestamps automáticos padrão (created_at) pois queremos controle total sobre 'data_acesso'
    protected $useTimestamps = false; 

    /**
     * Verifica se o usuário já desbloqueou este ensaio especificamente (acesso vitalício).
     */
    public function jaDesbloqueou(int $userId, string $slug)
    {
        return $this->where('user_id', $userId)
                    ->where('ensaio_slug', $slug)
                    ->first();
    }

    /**
     * Verifica se o usuário desbloqueou QUALQUER ensaio nas últimas 24 horas.
     * Se retornar algo, ele está no "período de carência" e não pode abrir um NOVO.
     */
    public function bloqueioRecente(int $userId)
    {
        // Calcula a data/hora de 24 horas atrás
        $limite = date('Y-m-d H:i:s', strtotime('-24 hours'));

        return $this->where('user_id', $userId)
                    ->where('data_acesso >=', $limite)
                    ->orderBy('data_acesso', 'DESC')
                    ->first();
    }
}
