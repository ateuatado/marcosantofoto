<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AcessosEnsaiosModel;
use App\Models\EnsaioModel; // Importante: Carregar o Model do Ensaio
use CodeIgniter\Exceptions\PageNotFoundException;

class Ensaios extends BaseController
{
    /**
     * O HALL DE ENTRADA (Aviso)
     * Lista todos os ensaios disponíveis dinamicamente.
     */
    public function index()
    {
        if (! auth()->loggedIn()) return redirect()->to('login');
        $model = new EnsaioModel();

        // Admin vê TUDO. Visitantes veem apenas publicados.
        $ehAdmin = auth()->user() && auth()->user()->inGroup('superadmin');
        if ($ehAdmin) {
            $ensaios = $model->orderBy('created_at', 'DESC')->findAll();
        } else {
            $ensaios = $model->where('status', 'publicado')->orderBy('created_at', 'DESC')->findAll();
        }


        // Dados de acesso para indicadores visuais
        $userId = auth()->id();
        $acessoModel = new AcessosEnsaiosModel();
        $bloqueio = $acessoModel->bloqueioRecente($userId);
        
        // Monta um array de slugs já desbloqueados por este usuário
        $slugsDesbloqueados = [];
        foreach ($ensaios as $ensaio) {
            if ($acessoModel->jaDesbloqueou($userId, $ensaio->slug)) {
                $slugsDesbloqueados[] = $ensaio->slug;
            }
        }

        return view('pages/ensaios', [
            'ensaios'           => $ensaios,
            'bloqueio'          => $bloqueio,
            'slugsDesbloqueados' => $slugsDesbloqueados,
        ]);
    }

    /**
     * Página do Método — Os 5 Atos e o Pacto de Coautoria
     *
     * @return string
     */
    public function metodo(): string
    {
        return view('pages/metodo');
    }

    /**
     * Tela de Confirmação (O Atrito)
     */
    public function confirmar(string $slug)
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        helper('form');
        $userId = auth()->id();
        $model  = new AcessosEnsaiosModel();

        // 1. Já tem acesso? Libera.
        if ($model->jaDesbloqueou($userId, $slug)) {
            return redirect()->to("ensaios/ver/$slug");
        }

        // 2. É Super Admin? (A CHAVE MESTRA)
        // Se for admin, IGNORA a verificação de bloqueio recente.
        $ehAdmin = auth()->user()->inGroup('superadmin');

        if (! $ehAdmin && $model->bloqueioRecente($userId)) {
            return redirect()->to('ensaios')->with('erro', 'A Lei do Tempo é absoluta. Volte amanhã.');
        }

        return view('pages/confirma', ['slug' => $slug]);
    }

    /**
     * Processa a Confirmação e Grava no Banco
     */
    public function processar(string $slug)
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        $userId = auth()->id();
        $model  = new AcessosEnsaiosModel();
        
        $ehAdmin = auth()->user()->inGroup('superadmin');

        // Verificação final (Race Condition) - Admin também fura aqui
        if (! $ehAdmin && $model->bloqueioRecente($userId) && ! $model->jaDesbloqueou($userId, $slug)) {
            return redirect()->to('ensaios')->with('erro', 'Ação negada pelo tempo.');
        }

        if (! $model->jaDesbloqueou($userId, $slug)) {
            $model->insert([
                'user_id'     => $userId,
                'ensaio_slug' => $slug,
                'data_acesso' => date('Y-m-d H:i:s'),
                'ip_address'  => $this->request->getIPAddress(),
                'user_agent'  => (string) $this->request->getUserAgent(),
            ]);
        }

        return redirect()->to("ensaios/ver/$slug");
    }

    /**
     * Exibe o Ensaio (A Caverna)
     * Agora suporta bifurcações via ID da etapa.
     * URL: ensaios/ver/{slug}/{etapa_id?}
     */
    public function ver(string $slug, int $etapaId = null)
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        $acessoModel = new AcessosEnsaiosModel();
        $ensaioModel = new EnsaioModel();
        $etapaModel  = new \App\Models\EtapaModel();
        $itemModel   = new \App\Models\ItemModel();

        // 1. Valida Ensaio
        $ensaio = $ensaioModel->where('slug', $slug)->first();
        if (! $ensaio) {
            throw PageNotFoundException::forPageNotFound("Caverna inexistente.");
        }

        // 2. Valida Permissão (Tempo/Admin)
        $user = auth()->user();
        $ehAdmin = $user ? $user->inGroup('superadmin') : false;
        
        if (! $ehAdmin && ! $acessoModel->jaDesbloqueou(auth()->id(), $slug)) {
            return redirect()->to("ensaios/confirmar/$slug");
        }

        // 3. Determina a Etapa Atual
        if ($etapaId === null) {
            // Se não tem ID na URL, busca a entrada (raiz)
            $etapaAtual = $etapaModel->getPrimeiraEtapa($ensaio->id);
        } else {
            // Busca a etapa específica
            $etapaAtual = $etapaModel->find($etapaId);
            
            // SEGURANÇA: Impede acessar etapa de outro ensaio trocando o ID na URL
            if ($etapaAtual && $etapaAtual->ensaio_id != $ensaio->id) {
                return redirect()->to('ensaios')->with('erro', 'Você tentou atravessar paredes para outra caverna. Proibido.');
            }
        }

        // Se a caverna estiver vazia ou ID inválido
        if (!$etapaAtual) {
             return redirect()->to('ensaios')->with('sucesso', 'Esta caverna ainda não foi escavada.');
        }

        // 4. Carrega Conteúdo (Itens)
        $etapaAtual->itens = $itemModel->where('etapa_id', $etapaAtual->id)
                                       ->orderBy('ordem', 'ASC')
                                       ->findAll();

        // 5. Descobre as Bifurcações (Para onde posso ir?)
        $proximasEtapas = $etapaModel->getProximasEtapas($etapaAtual->id);

        $paginasExtras = [];
        
        // Se não há para onde ir (fim da linha), buscamos a saída (Extras)
        if (empty($proximasEtapas)) {
            $extraModel = new \App\Models\EnsaioPaginaExtraModel();
            $paginasExtras = $extraModel->where('ensaio_id', $ensaio->id)
                                        ->orderBy('id', 'ASC') // Ou ordem, se criarmos campo ordem depois
                                        ->findAll();
        }

        // 6. Lógica de Retorno Ancestral (MVC) - INSERÇÃO CIRÚRGICA
        $idRetornoBifurcacao = null;
        if ($etapaAtual) {
            // O Model agora usa a nova lógica recursiva inteligente
            $idRetornoBifurcacao = $etapaModel->getBifurcacao($etapaAtual->id);
        }
        // -------------------------------------------

        return view('ensaios/passo_a_passo', [
            'ensaio'              => $ensaio,
            'etapa'               => $etapaAtual,
            'proximasEtapas'      => $proximasEtapas,
            'paginasExtras'       => $paginasExtras,
            'idRetornoBifurcacao' => $idRetornoBifurcacao // <--- Passamos a variável calculada
        ]);
    }

    /**
     * Exibe uma página do Santuário (Documentação/Venda)
     */
    public function extra($id)
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        $extraModel = new \App\Models\EnsaioPaginaExtraModel();
        $ensaioModel = new \App\Models\EnsaioModel();

        // Busca a página extra
        $pagina = $extraModel->find($id);

        if (!$pagina) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Documento não encontrado.");
        }

        // Busca o ensaio pai para manter o contexto (botão voltar, título, etc)
        $ensaio = $ensaioModel->find($pagina->ensaio_id);

        // REGRA DE ACESSO:
        $acessoModel = new \App\Models\AcessosEnsaiosModel();
        $ehAdmin = auth()->user()->inGroup('superadmin');
        
        if (! $ehAdmin && ! $acessoModel->jaDesbloqueou(auth()->id(), $ensaio->slug)) {
            return redirect()->to("ensaios/confirmar/$ensaio->slug");
        }

        return view('ensaios/extra', [
            'ensaio' => $ensaio,
            'pagina' => $pagina
        ]);
    }

    public function santuario(string $slug)
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        $ensaioModel = new \App\Models\EnsaioModel();
        $etapaModel  = new \App\Models\EtapaModel();
        $itemModel   = new \App\Models\ItemModel();
        $extraModel  = new \App\Models\EnsaioPaginaExtraModel();

        $ensaio = $ensaioModel->where('slug', $slug)->first();
        if (!$ensaio) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        // --- LÓGICA PARA A FOTO ESTRELA ---
        // 1. Buscamos a última etapa (a que tem o maior ID ou maior ordem no tronco principal)
        $ultimaEtapa = $etapaModel->where('ensaio_id', $ensaio->id)
                                ->orderBy('id', 'DESC') 
                                ->first();

        $fotoEstrela = $ensaio->capa_url; // Fallback: se nada for encontrado, usa a capa

        if ($ultimaEtapa) {
            // 2. Buscamos a primeira foto desta última etapa
            $itemFoto = $itemModel->where('etapa_id', $ultimaEtapa->id)
                                ->where('tipo', 'foto')
                                ->orderBy('ordem', 'ASC')
                                ->first();
            
            if ($itemFoto) {
                $fotoEstrela = $itemFoto->conteudo;
            }
        }

        $extras = $extraModel->where('ensaio_id', $ensaio->id)->findAll();

        return view('ensaios/santuario', [
            'ensaio'      => $ensaio,
            'extras'      => $extras,
            'fotoEstrela' => $fotoEstrela 
        ]);
    }

    public function registrar_interesse()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setBody('Acesso negado.');
        }

        $pedidoModel = new \App\Models\PedidoAquisicaoModel();
        $emailService = \Config\Services::email();

        // Coleta dados
        $dados = [
            'ensaio_id'    => $this->request->getPost('ensaio_id'),
            'item_id'      => $this->request->getPost('item_id'),
            'user_id'      => auth()->id(),
            'nome_contato' => $this->request->getPost('nome'),
            'meio_contato' => $this->request->getPost('contato'),
            'mensagem'     => $this->request->getPost('mensagem'),
            'status'       => 'pendente'
        ];

        // 1. Salva no Banco (Prioridade Máxima)
        if (!$pedidoModel->save($dados)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao salvar pedido.']);
        }

        // 2. Dispara E-mail para o Curador (Você)
        $emailService->setFrom('seu-email-zoho@seudominio.com', 'Sistema Fineart'); // AJUSTE SEU REMETENTE AQUI SE PRECISAR
        $emailService->setTo('seu-email-pessoal@gmail.com'); // AJUSTE PARA ONDE VOCÊ QUER RECEBER O ALERTA
        
        $emailService->setSubject("Novo Interesse: Obra #{$dados['item_id']}");
        $msg = "Um colecionador demonstrou interesse.<br><br>" .
               "<strong>Nome:</strong> {$dados['nome_contato']}<br>" .
               "<strong>Contato:</strong> {$dados['meio_contato']}<br>" .
               "<strong>Mensagem:</strong> {$dados['mensagem']}<br>" .
               "<strong>ID da Obra:</strong> #{$dados['item_id']}<br>" .
               "<br>Verifique o painel administrativo.";
        
        $emailService->setMessage($msg);
        
        // Tenta enviar (sem travar o processo se falhar)
        if ($emailService->send()) {
            // Opcional: Enviar confirmação para o cliente também
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Solicitação recebida. Entraremos em contato.']);
    }
}
