<?php

namespace App\Models;

use CodeIgniter\Model;

class EtapaModel extends Model
{
    protected $table            = 'etapas';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields = [
        'parent_id', 'ensaio_id', 'titulo', 'tipo', 'ordem', 
        'descricao', 'decisao_texto', 'audio_url', 'direcao' // Adicionado 'direcao'
    ];

    public function getPrimeiraEtapa($ensaioId)
    {
        return $this->where('ensaio_id', $ensaioId)
                    ->groupStart()
                        ->where('parent_id', null) // É raiz
                        ->orWhere('parent_id', 0)  // Prevenção caso salve 0 em vez de null
                    ->groupEnd()
                    ->orderBy('ordem', 'ASC')
                    ->first();
    }

    /**
     * Retorna as possíveis próximas salas (filhos) da etapa atual
     */
    public function getProximasEtapas($etapaAtualId)
    {
        return $this->where('parent_id', $etapaAtualId)
                    ->orderBy('ordem', 'ASC') // A ordem agora define qual botão aparece primeiro
                    ->findAll();
    }
    /**
     * Retorna a etapa anterior (Pai) - para o botão "Voltar"
     */
    public function getEtapaAnterior($parentId)
    {
        if (!$parentId) return null;
        return $this->find($parentId);
    }

    public function getBifurcacao($etapaId)
    {
        $etapa = $this->find($etapaId);
        $idRetorno = null;

        // Sobe a árvore até a raiz (enquanto houver pai)
        while($etapa && $etapa->parent_id) {
            
            // Se este passo for "Lado", marcamos o pai dele como ponto de retorno possível.
            // IMPORTANTE: Não paramos aqui! Continuamos subindo.
            // Isso garante que se o usuário marcou 10 fotos seguidas como "Lado",
            // o sistema vai "rebobinar" todas elas até chegar no Tronco Principal.
            if (($etapa->direcao ?? 'frente') === 'lado') {
                $idRetorno = $etapa->parent_id;
            }
            
            // Sobe para o próximo pai
            $etapa = $this->find($etapa->parent_id);
        }
        
        return $idRetorno;
    }
}
