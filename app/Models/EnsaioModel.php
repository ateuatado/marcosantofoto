<?php

namespace App\Models;

use CodeIgniter\Model;

class EnsaioModel extends Model
{
    protected $table            = 'ensaios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['titulo', 'slug', 'resumo_card', 'capa_url', 'status'];
    protected $useTimestamps    = true;

    // Função auxiliar para buscar a árvore completa (Ensaio -> Etapas -> Itens)
    public function getEnsaioCompleto(string $slug)
    {
        $ensaio = $this->where('slug', $slug)->first();

        if (!$ensaio) return null;

        // Carrega etapas
        $etapaModel = new EtapaModel();
        $ensaio->etapas = $etapaModel->where('ensaio_id', $ensaio->id)
                                     ->orderBy('ordem', 'ASC')
                                     ->findAll();

        // Carrega itens de cada etapa
        $itemModel = new ItemModel();
        foreach ($ensaio->etapas as $etapa) {
            $etapa->itens = $itemModel->where('etapa_id', $etapa->id)
                                      ->orderBy('ordem', 'ASC')
                                      ->findAll();
        }

        return $ensaio;
    }
}
