<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'itens';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields = [
    'etapa_id', 'tipo', 'conteudo', 
    'titulo', // <--- ADICIONE ISTO
    'legenda', 'classe_css', 'ordem'
];
}
