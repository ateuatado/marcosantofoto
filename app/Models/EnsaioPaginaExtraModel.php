<?php

namespace App\Models;

use CodeIgniter\Model;

class EnsaioPaginaExtraModel extends Model
{
    protected $table            = 'ensaio_paginas_extras';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['ensaio_id', 'tipo', 'titulo', 'conteudo', 'configuracoes'];
    
    // FIX: Desativamos o uso de timestamps automáticos porque a tabela não tem 'updated_at'
    protected $useTimestamps    = false; 

    protected array $casts = [
        'configuracoes' => '?json',
    ];

    public function getPorEnsaio(int $ensaioId)
    {
        return $this->where('ensaio_id', $ensaioId)->findAll();
    }
}
