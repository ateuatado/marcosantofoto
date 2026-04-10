<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnsaioModel;
use App\Models\EnsaioPaginaExtraModel;

class AdminExtras extends BaseController
{
    // 1. O Painel com Dropdown
    public function index()
    {
        if (!auth()->user()->inGroup('superadmin'))
            return redirect()->to('/');

        $ensaioModel = new EnsaioModel();
        // Apenas ID e Título para o select, ordenado pelos mais recentes
        $ensaios = $ensaioModel->select('id, titulo')->orderBy('created_at', 'DESC')->findAll();

        return view('admin/extras/index', ['ensaios' => $ensaios]);
    }

    // 2. O Fragmento da Lista (AJAX)
    public function listar($ensaioId)
    {
        if (!auth()->user()->inGroup('superadmin'))
            return '';

        $extraModel = new EnsaioPaginaExtraModel();
        $paginas = $extraModel->where('ensaio_id', $ensaioId)->findAll();

        return view('admin/extras/lista_fragment', [
            'paginas' => $paginas,
            'ensaio_id' => $ensaioId
        ]);
    }

    public function nova($ensaioId)
    {
        if (!auth()->user()->inGroup('superadmin'))
            return redirect()->to('/');

        // ADICIONE ESTA LINHA:
        helper('form');

        $ensaioModel = new EnsaioModel();
        $ensaio = $ensaioModel->find($ensaioId);

        if (!$ensaio)
            return redirect()->to('admin/extras')->with('erro', 'Caverna não encontrada.');

        return view('admin/extras/form', [
            'ensaio' => $ensaio,
            'pagina' => null,
            'titulo' => 'Nova Página de Documentação'
        ]);
    }

    // 4. Formulário de Edição
    public function editar($id)
    {
        if (!auth()->user()->inGroup('superadmin'))
            return redirect()->to('/');

        // ADICIONE ESTA LINHA TAMBÉM:
        helper('form');

        $extraModel = new EnsaioPaginaExtraModel();
        $pagina = $extraModel->find($id);

        if (!$pagina)
            return redirect()->to('admin/extras');

        $ensaioModel = new EnsaioModel();
        $ensaio = $ensaioModel->find($pagina->ensaio_id);

        return view('admin/extras/form', [
            'ensaio' => $ensaio,
            'pagina' => $pagina,
            'titulo' => 'Editar: ' . $pagina->titulo
        ]);
    }

    // 5. Salvar (O Cérebro da Operação)
    public function salvar()
    {
        if (!auth()->user()->inGroup('superadmin'))
            return redirect()->to('/');


        $model = new EnsaioPaginaExtraModel();

        $id = $this->request->getPost('id');
        $ensaioId = $this->request->getPost('ensaio_id');

        $dados = [
            'ensaio_id' => $ensaioId,
            'titulo'    => $this->request->getPost('titulo'),
            'tipo'      => $this->request->getPost('tipo'),
            'conteudo'  => $this->request->getPost('conteudo'),
        ];

        // Processamento do JSON vindo do Javascript
        $jsonRaw = $this->request->getPost('configuracoes_json');
        if ($jsonRaw) {
            // Decodifica para array PHP, o Model fará o cast para JSON no banco
            $dados['configuracoes'] = json_decode($jsonRaw, true);
        }
        else {
            $dados['configuracoes'] = null;
        }

        if ($id) {
            $model->update($id, $dados);
            $msg = 'Documentação atualizada.';
        }
        else {
            $model->insert($dados);
            $msg = 'Documentação criada.';
        }

        // Retorna para o index com o parâmetro para reabrir a lista certa
        return redirect()->to('admin/extras?ensaio_aberto=' . $ensaioId)->with('sucesso', $msg);
    }

    public function excluir($id)
    {
        if (!auth()->user()->inGroup('superadmin'))
            return redirect()->to('/');

        $model = new EnsaioPaginaExtraModel();
        $pagina = $model->find($id);

        if ($pagina) {
            $model->delete($id);
            return redirect()->to('admin/extras?ensaio_aberto=' . $pagina->ensaio_id)->with('sucesso', 'Página removida.');
        }

        return redirect()->back();
    }
}
