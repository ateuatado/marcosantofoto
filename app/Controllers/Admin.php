<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnsaioModel;
use App\Models\CandidaturaModel;

class Admin extends BaseController
{
    /**
     * Dashboard Principal: Lista todos os ensaios (cavernas)
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
    {
        
        // Se a rota falhar em barrar (improvável agora), o controller barra.
        if (! auth()->user()->inGroup('superadmin')) {
            // USAR REDIRECT, NÃO VIEW
            return redirect()->to('ensaios')->with('erro', 'Acesso restrito.');
        }

        $model = new EnsaioModel();
        
        // Verifica se é Admin
        $user = auth()->user();
        $ehAdmin = $user ? $user->inGroup('superadmin') : false;

        if ($ehAdmin) {
            // Admin vê TUDO (Rascunhos e Publicados)
            $ensaios = $model->orderBy('created_at', 'DESC')->findAll();
        } else {
            // Visitantes veem APENAS Publicados
            $ensaios = $model->where('status', 'publicado')
                             ->orderBy('created_at', 'DESC')
                             ->findAll();
        }

        // CORREÇÃO: Apontando para a view correta do painel administrativo
        $totalPendentes = (new CandidaturaModel())->where('status', 'pendente')->countAllResults();
        return view('admin/index', [
            'ensaios'            => $ensaios,
            'totalCandidaturas'  => $totalPendentes,
        ]);
    }

    /**
     * Formulário para criar a "Casca" do Ensaio (Título, Slug, Capa)
     * O conteúdo interno (etapas/itens) será editado em outra tela.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function novo()
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login')->with('error', 'Apenas o curador pode entrar aqui.');
        }
        // Carrega o ajudante para permitir o uso de form_open() na view
        helper('form'); 

        if (! auth()->loggedIn()) return redirect()->to('login');

        return view('admin/form_ensaio', ['titulo' => 'Novo Ensaio']);
    }

    /**
     * Processa a criação básica do ensaio
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function salvar()
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        $model = new EnsaioModel();
        
        // Validação básica
        $regras = [
            'titulo' => 'required|min_length[3]',
            'slug'   => 'required|is_unique[ensaios.slug]',
        ];

        if (! $this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- LÓGICA DE UPLOAD DA CAPA ---
        $capaUrl = null;
        $img = $this->request->getFile('capa');

        $novoNome = $this->processarUploadImagem($img, 'uploads/ensaios');
        if ($novoNome) {
            $capaUrl = base_url('uploads/ensaios/' . $novoNome);
        }
        // --------------------------------

        // Salva os dados no banco
        $id = $model->insert([
            'titulo'      => $this->request->getPost('titulo'),
            'slug'        => url_title($this->request->getPost('slug'), '-', true),
            'resumo_card' => $this->request->getPost('resumo_card'),
            'capa_url'    => $capaUrl, // Aqui entra a URL da imagem
            'status'      => 'rascunho',
        ]);

        return redirect()->to("admin/mapa/$id")->with('sucesso', 'A caverna foi aberta e a capa definida.');
    }

    /**
     * Exibe o mapa/árvore de itens de um ensaio específico
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function mapa($id)
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login')->with('error', 'Apenas o curador pode entrar aqui.');
        }
        // Também precisaremos aqui para os Modais de adicionar etapa/item
        helper('form'); 

        if (! auth()->loggedIn()) return redirect()->to('login');

        $ensaioModel = new \App\Models\EnsaioModel();
        $etapaModel  = new \App\Models\EtapaModel();
        $itemModel   = new \App\Models\ItemModel();

        $ensaio = $ensaioModel->find($id);

        if (!$ensaio) {
            return redirect()->to('admin')->with('erro', 'Caverna não encontrada.');
        }

        // Busca as etapas ordenadas
        $etapas = $etapaModel->where('ensaio_id', $id)->orderBy('ordem', 'ASC')->findAll();

        // Popula os itens dentro de cada etapa
        foreach ($etapas as $etapa) {
            $etapa->itens = $itemModel->where('etapa_id', $etapa->id)->orderBy('ordem', 'ASC')->findAll();
        }

        return view('admin/mapa', [
            'ensaio' => $ensaio,
            'etapas' => $etapas
        ]);
    }

    /**
     * Adiciona uma nova CAMADA (Etapa) à caverna
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function adicionar_etapa()
    {
        $etapaModel = new \App\Models\EtapaModel();
        
        // Tratamento: Se vier vazio, salva NULL (Raiz)
        $parentId = $this->request->getPost('parent_id');
        $parentId = empty($parentId) ? null : $parentId;
        $audioUrl = null;
        $audioFile = $this->request->getFile('audio_arquivo');

        if ($audioFile && $audioFile->isValid() && ! $audioFile->hasMoved()) {
            $novoNome = $audioFile->getRandomName();
            // Salva na pasta uploads/audios
            $audioFile->move(FCPATH . 'uploads/audios', $novoNome);
            $audioUrl = base_url('uploads/audios/' . $novoNome);
        }
        $etapaModel->insert([
            'ensaio_id'     => $this->request->getPost('ensaio_id'),
            'titulo'        => $this->request->getPost('titulo'),
            'tipo'          => $this->request->getPost('tipo'),
            'ordem'         => $this->request->getPost('ordem'),
            'descricao'     => $this->request->getPost('descricao'),
            // Novos campos:
            'parent_id'     => $parentId,
            'decisao_texto' => $this->request->getPost('decisao_texto'),
            'direcao'       => $this->request->getPost('direcao'), // <--- ADICIONADO AQUI TAMBÉM
            'audio_url'     => $audioUrl,            
        ]);

        return redirect()->back()->with('sucesso', 'Nova camada escavada.');
    }

    /**
     * Adiciona um novo ARTEFATO (Item) a uma camada
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function adicionar_item()
    {
        helper('form');
        $itemModel = new \App\Models\ItemModel();
        
        $tipo = $this->request->getPost('tipo');
        $conteudo = $this->request->getPost('conteudo'); // Pega o texto (se houver)

        // Lógica de Upload para FOTOS
        if ($tipo === 'foto') {
            $img = $this->request->getFile('arquivo_imagem');
            
            $novoNome = $this->processarUploadImagem($img, 'uploads/ensaios');
            if ($novoNome) {
                $conteudo = base_url('uploads/ensaios/' . $novoNome);
            }
        }

        $itemModel->insert([
            'etapa_id'   => $this->request->getPost('etapa_id'),
            'tipo'       => $tipo,
            'titulo'     => $this->request->getPost('titulo'), // <--- NOVO
            'conteudo'   => $conteudo,
            'legenda'    => $this->request->getPost('legenda'),
            'classe_css' => $this->request->getPost('classe_css'),
            'ordem'      => $this->request->getPost('ordem'),
        ]);

        return redirect()->back()->with('sucesso', 'Artefato adicionado.');
    }

    /**
     * Excluir Etapa
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function excluir_etapa($id)
    {
        $etapaModel = new \App\Models\EtapaModel();
        $etapaModel->delete($id);
        return redirect()->back()->with('sucesso', 'Camada aterrada.');
    }

    /**
     * Excluir Item
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function excluir_item($id)
    {
        $itemModel = new \App\Models\ItemModel();
        $itemModel->delete($id);
        return redirect()->back()->with('sucesso', 'Artefato removido.');
    }
    
    /**
     * Atualiza uma Etapa existente
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function atualizar_etapa()
    {
        $etapaModel = new \App\Models\EtapaModel();
        $id = $this->request->getPost('id');
        
        // Dados básicos e de bifurcação
        $dados = [
            'titulo'        => $this->request->getPost('titulo'),
            'tipo'          => $this->request->getPost('tipo'),
            'ordem'         => $this->request->getPost('ordem'),
            'descricao'     => $this->request->getPost('descricao'),
            'parent_id'     => $this->request->getPost('parent_id') ?: null,
            'decisao_texto' => $this->request->getPost('decisao_texto'),
            'direcao'       => $this->request->getPost('direcao'), // <--- ADICIONADO: A CHAVE FALTANTE
        ];

        // Lógica de Áudio (Atualização)
        $audioFile = $this->request->getFile('audio_arquivo');
        
        if ($audioFile && $audioFile->isValid() && ! $audioFile->hasMoved()) {
            
            // 1. Busca a etapa atual para apagar o áudio antigo se existir
            $etapaAntiga = $etapaModel->find($id);
            if ($etapaAntiga && !empty($etapaAntiga->audio_url)) {
                $caminhoAntigo = FCPATH . 'uploads/audios/' . basename($etapaAntiga->audio_url);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }

            // 2. Faz o upload do novo áudio
            $novoNome = $audioFile->getRandomName();
            $audioFile->move(FCPATH . 'uploads/audios', $novoNome);
            $dados['audio_url'] = base_url('uploads/audios/' . $novoNome);
        }

        $etapaModel->update($id, $dados);

        return redirect()->back()->with('sucesso', 'Camada redefinida com sucesso.');
    }

    /**
     * Atualiza um Item existente
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function atualizar_item()
    {
        helper('form');
        $itemModel = new \App\Models\ItemModel();
        $id = $this->request->getPost('id');
        $tipo = $this->request->getPost('tipo');
        
        // Começa com o conteúdo atual (pode ser o texto editado)
        $conteudo = $this->request->getPost('conteudo');

        // Se enviou uma NOVA imagem, faz o upload e substitui a URL antiga
        if ($tipo === 'foto') {
            $img = $this->request->getFile('arquivo_imagem');
            
            $novoNome = $this->processarUploadImagem($img, 'uploads/ensaios');
            if ($novoNome) {
                $conteudo = base_url('uploads/ensaios/' . $novoNome);
            }
        }

        $itemModel->update($id, [
            'tipo'       => $tipo,
            'titulo'     => $this->request->getPost('titulo'), // <--- NOVO
            'conteudo'   => $conteudo,
            'legenda'    => $this->request->getPost('legenda'),
            'classe_css' => $this->request->getPost('classe_css'),
            'ordem'      => $this->request->getPost('ordem'),
        ]);

        return redirect()->back()->with('sucesso', 'Artefato atualizado.');
    }

    /**
     * Reordena uma Etapa (Sobe ou Desce)
     * Direção: 'sobe' (diminui ordem) ou 'desce' (aumenta ordem)
     * 
     * @param int|string $id
     * @param string $direcao
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function reordenar_etapa($id, $direcao)
    {
        $model = new \App\Models\EtapaModel();
        $etapaAtual = $model->find($id);
        $ensaioId = $etapaAtual->ensaio_id;

        // Define a ordem vizinha que estamos procurando
        $operador = ($direcao == 'sobe') ? '<' : '>';
        $orderDir = ($direcao == 'sobe') ? 'DESC' : 'ASC';

        // Busca o vizinho mais próximo
        $vizinho = $model->where('ensaio_id', $ensaioId)
                         ->where("ordem $operador", $etapaAtual->ordem)
                         ->orderBy('ordem', $orderDir)
                         ->first();

        if ($vizinho) {
            // Troca as posições
            $ordemAtual = $etapaAtual->ordem;
            $ordemVizinho = $vizinho->ordem;

            $model->update($etapaAtual->id, ['ordem' => $ordemVizinho]);
            $model->update($vizinho->id, ['ordem' => $ordemAtual]);
        }

        return redirect()->back(); // Recarrega a página silenciosamente
    }

    /**
     * Reordena um Item dentro da Etapa
     * 
     * @param int|string $id
     * @param string $direcao
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function reordenar_item($id, $direcao)
    {
        $model = new \App\Models\ItemModel();
        $itemAtual = $model->find($id);
        $etapaId = $itemAtual->etapa_id;

        // Se 'sobe', procura alguém menor (<). Se 'desce', procura alguém maior (>)
        $operador = ($direcao == 'sobe') ? '<' : '>';
        // Se 'sobe', quero o mais próximo descendo (DESC). Se 'desce', o mais próximo subindo (ASC).
        $orderDir = ($direcao == 'sobe') ? 'DESC' : 'ASC';

        $vizinho = $model->where('etapa_id', $etapaId)
                         ->where("ordem $operador", $itemAtual->ordem)
                         ->orderBy('ordem', $orderDir)
                         ->first();

        if ($vizinho) {
            // Troca os números
            $ordemAtual = $itemAtual->ordem;
            $ordemVizinho = $vizinho->ordem;

            $model->update($itemAtual->id, ['ordem' => $ordemVizinho]);
            $model->update($vizinho->id, ['ordem' => $ordemAtual]);
        }

        return redirect()->back();
    }

    /**
     * Alterna o status do Ensaio (Publicar <-> Rascunho)
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function alternar_status($id)
    {
        $model = new \App\Models\EnsaioModel();
        $ensaio = $model->find($id);

        if ($ensaio) {
            // Lógica de inversão
            $novoStatus = ($ensaio->status === 'publicado') ? 'rascunho' : 'publicado';
            
            $model->update($id, ['status' => $novoStatus]);

            $msg = ($novoStatus === 'publicado') ? 'A caverna foi aberta ao público.' : 'A caverna foi ocultada (Rascunho).';
            return redirect()->back()->with('sucesso', $msg);
        }

        return redirect()->back()->with('erro', 'Ensaio não encontrado.');
    }

    /**
     * Renderiza a tela de edição
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function editar($id)
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login');
        }
        helper('form');
        
        $model = new EnsaioModel();
        $ensaio = $model->find($id);

        if (!$ensaio) {
            return redirect()->to('admin')->with('erro', 'Ensaio não encontrado.');
        }

        return view('admin/form_ensaio', [
            'titulo' => 'Editar Ensaio', // Título da página
            'ensaio' => $ensaio
        ]);
    }

    /**
     * Processa a atualização do Ensaio
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function atualizar()
    {
        if (! auth()->loggedIn()) return redirect()->to('login');

        $model = new EnsaioModel();
        $id = $this->request->getPost('id');
        
        // Validação: Slug deve ser único, mas ignoramos o ID do próprio ensaio atual
        $regras = [
            'titulo' => 'required|min_length[3]',
            'slug'   => "required|is_unique[ensaios.slug,id,{$id}]",
        ];

        if (! $this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'titulo'      => $this->request->getPost('titulo'),
            'slug'        => url_title($this->request->getPost('slug'), '-', true),
            'resumo_card' => $this->request->getPost('resumo_card'),
        ];

        // Lógica de Upload da Capa (Só atualiza se enviar nova)
        $img = $this->request->getFile('capa');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            
            // 1. Apaga a imagem antiga do servidor para não acumular lixo
            $ensaioAntigo = $model->find($id);
            if (!empty($ensaioAntigo->capa_url)) {
                $caminhoAntigo = FCPATH . 'uploads/ensaios/' . basename($ensaioAntigo->capa_url);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }

            // 2. Sobe a nova otimizada
            $novoNome = $this->processarUploadImagem($img, 'uploads/ensaios');
            if ($novoNome) {
                $dados['capa_url'] = base_url('uploads/ensaios/' . $novoNome);
            }
        }

        $model->update($id, $dados);

        return redirect()->to('admin')->with('sucesso', 'Dados da caverna atualizados.');
    }

    /**
     * Exclui um ensaio e suas dependências
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function excluir($id)
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login');
        }
        
        $model = new EnsaioModel();
        $ensaio = $model->find($id);

        if ($ensaio) {
            // Remove o arquivo físico da capa
            if (!empty($ensaio->capa_url)) {
                $arquivo = FCPATH . 'uploads/ensaios/' . basename($ensaio->capa_url);
                if (file_exists($arquivo)) {
                    unlink($arquivo);
                }
            }
            
            // Remove do banco (Etapas e Itens somem via Cascade)
            $model->delete($id);
            
            return redirect()->to('admin')->with('sucesso', 'Caverna implodida e aterrada.');
        }

        return redirect()->to('admin')->with('erro', 'Ensaio não encontrado.');
    }

    /**
     * Lista todas as candidaturas recebidas
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function candidaturas()
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login');
        }
        $model = new CandidaturaModel();
        return view('admin/candidaturas', ['candidaturas' => $model->todas()]);
    }

    /**
     * Aceita uma candidatura
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function aceitar_candidatura($id)
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login');
        }
        $model = new CandidaturaModel();
        $candidato = $model->find($id);
        if ($candidato) {
            $model->update($id, ['status' => 'aceito']);

            // Envio de Email de Aprovação
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtppro.zoho.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'marcosanto@marcosantofoto.com.br';
                $mail->Password   = 'curEYib00ffd';
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);

                $corpo = view('emails/candidatura_aceita', (array)$candidato);
                $mail->setFrom('marcosanto@marcosantofoto.com.br', 'Marco Santo');
                $mail->addAddress($candidato->email);
                $mail->Subject = 'Sua candidatura foi selecionada — marcosantofoto.com.br';
                $mail->Body    = $corpo;
                $mail->send();
            } catch (\Exception $e) {
                log_message('error', 'Falha email aprovação: ' . $mail->ErrorInfo);
            }
        }
        
        return redirect()->to('admin/candidaturas')->with('sucesso', 'Candidatura aceita e e-mail enviado.');
    }

    /**
     * Recusa uma candidatura
     * 
     * @param int|string $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function recusar_candidatura($id)
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login');
        }
        $model = new CandidaturaModel();
        $candidato = $model->find($id);
        if ($candidato) {
            $model->update($id, ['status' => 'recusado']);

            // Envio de Email de Recusa
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtppro.zoho.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'marcosanto@marcosantofoto.com.br';
                $mail->Password   = 'curEYib00ffd';
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);

                $corpo = view('emails/candidatura_recusada', (array)$candidato);
                $mail->setFrom('marcosanto@marcosantofoto.com.br', 'Marco Santo');
                $mail->addAddress($candidato->email);
                $mail->Subject = 'Retorno da sua candidatura — marcosantofoto.com.br';
                $mail->Body    = $corpo;
                $mail->send();
            } catch (\Exception $e) {
                log_message('error', 'Falha email recusa: ' . $mail->ErrorInfo);
            }
        }

        return redirect()->to('admin/candidaturas')->with('sucesso', 'Candidatura recusada e e-mail enviado.');
    }

    /**
     * Auxiliar para mover, redimensionar e comprimir imagens.
     * Retorna o novo nome do arquivo em caso de sucesso, ou null.
     */
    private function processarUploadImagem($img, $pastaDestino, $larguraMax = 1920, $qualidade = 80)
    {
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            $novoNome = $img->getRandomName();
            $caminhoDestino = rtrim((string)FCPATH, '/') . '/' . trim($pastaDestino, '/');
            
            // 1. O CodeIgniter move o arquivo primeiro
            $img->move($caminhoDestino, $novoNome);
            $caminhoArquivo = $caminhoDestino . '/' . $novoNome;
            // 2. Redimensionamento e compressão em duas etapas para evitar bugs de estado do CodeIgniter 4
            try {
                // ETAPA A: Corrigir a orientação EXIF primeiro e salvar a imagem "em pé"
                $image = \Config\Services::image()->withFile($caminhoArquivo);
                $image->reorient(true);
                $image->save($caminhoArquivo); // Salva com 100% de qualidade apenas para consertar a rotação
                
                // ETAPA B: Abrir a imagem (agora com a rotação e dimensões perfeitas) e redimensionar
                $image = \Config\Services::image()->withFile($caminhoArquivo);
                $width  = $image->getWidth();
                $height = $image->getHeight();
                
                // Redimensiona mantendo a proporção exata apenas se passar do limite
                if ($width > $larguraMax || $height > $larguraMax) {
                    $image->resize($larguraMax, $larguraMax, true, 'auto');
                }
                
                // Salva o resultado final comprimido
                $image->save($caminhoArquivo, $qualidade);
            } catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                log_message('error', 'Erro ao otimizar imagem: ' . $e->getMessage());
            }

            return $novoNome;
        }
        return null;
    }
}
