<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoAquisicaoModel extends Model
{
    protected $table            = 'pedidos_aquisicao';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true; // Vamos usar soft deletes para não perder histórico
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ensaio_id', 
        'item_id', 
        'user_id', 
        'nome_contato', 
        'meio_contato', 
        'mensagem', 
        'status'
    ];

    // Datas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
