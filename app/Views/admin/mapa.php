<?= $this->extend('admin/layout') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
    <div>
        <small class="text-uppercase text-muted ls-2">Editando Mapa da Caverna</small>
        <div class="d-flex align-items-center gap-3">
            <h1 class="h3 fw-bold text-dark mt-1 mb-0"><?= esc($ensaio->titulo) ?></h1>
            
            <?php if($ensaio->status === 'publicado'): ?>
                <span class="badge bg-success text-uppercase ls-1" style="font-size: 0.6rem;">No Ar</span>
            <?php else: ?>
                <span class="badge bg-secondary text-uppercase ls-1" style="font-size: 0.6rem;">Rascunho</span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="d-flex gap-2">
        <?php if($ensaio->status === 'rascunho'): ?>
            <a href="<?= site_url('admin/alternar_status/' . $ensaio->id) ?>" class="btn btn-outline-success btn-sm text-uppercase ls-2 fw-bold">
                Publicar Agora
            </a>
        <?php else: ?>
            <a href="<?= site_url('admin/alternar_status/' . $ensaio->id) ?>" class="btn btn-outline-secondary btn-sm text-uppercase ls-2">
                Tornar Rascunho
            </a>
        <?php endif; ?>

        <div class="vr mx-2"></div>

        <a href="<?= site_url('ensaios/ver/' . $ensaio->slug) ?>" target="_blank" class="btn btn-outline-dark btn-sm">
            Ver Caverna Real
        </a>
        <button class="btn btn-dark btn-sm text-uppercase ls-2" data-bs-toggle="modal" data-bs-target="#modalNovaEtapa">
            + Nova Camada
        </button>
    </div>
</div>

<div class="accordion" id="accordionMapa">
    
    <?php if(empty($etapas)): ?>
        <div class="alert alert-light text-center border py-5">
            <p class="mb-0 text-muted">A caverna está vazia. Adicione a primeira camada.</p>
        </div>
    <?php endif; ?>

    <?php foreach($etapas as $etapa): ?>
        <div class="accordion-item mb-3 border shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $etapa->id ?>">
                    <div class="d-flex w-100 justify-content-between align-items-center pe-3">
                        <div class="d-flex align-items-center">
                            <?php if(($etapa->direcao ?? 'frente') == 'lado'): ?>
                                <span class="badge bg-info text-dark me-2" title="Transição Lateral">→ LADO</span>
                            <?php else: ?>
                                <span class="badge bg-dark me-2" title="Transição Frontal">↓ FRENTE</span>
                            <?php endif; ?>
                            
                            <?php if(empty($etapa->parent_id)): ?>
                                <span class="badge bg-primary me-2" title="Início da Caverna">⌂ Raiz</span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-50 text-dark me-2" title="Vem da Etapa ID <?= $etapa->parent_id ?>">
                                    ↳ Vem de <?= $etapa->parent_id ?>
                                </span>
                            <?php endif; ?>

                            <strong class="me-2"><?= esc($etapa->titulo) ?></strong>
                            <small class="text-muted">(ID: <?= $etapa->id ?>)</small>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="me-3 border-end pe-3">
                                <small class="text-muted d-block text-end" style="font-size: 0.7rem;">ORDEM VISUAL</small>
                                <a href="<?= site_url('admin/reordenar_etapa/' . $etapa->id . '/sobe') ?>" class="text-decoration-none text-secondary me-1 fw-bold">↑</a>
                                <span class="badge bg-light text-dark border"><?= $etapa->ordem ?></span>
                                <a href="<?= site_url('admin/reordenar_etapa/' . $etapa->id . '/desce') ?>" class="text-decoration-none text-secondary ms-1 fw-bold">↓</a>
                            </div>

                            <div>
                                <a href="#" class="btn btn-link text-secondary p-0 me-3 small text-decoration-none"
                                   data-bs-toggle="modal" data-bs-target="#modalEditarEtapa"
                                   onclick='preencherEditarEtapa(<?= json_encode($etapa) ?>)'>
                                    Editar
                                </a>
                                <a href="<?= site_url('admin/excluir_etapa/' . $etapa->id) ?>" class="btn btn-link text-danger p-0 small text-decoration-none" onclick="return confirm('Tem certeza? Todos os itens desta camada serão apagados.')">
                                    Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </button>
            </h2>
            <div id="collapse<?= $etapa->id ?>" class="accordion-collapse collapse show" data-bs-parent="#accordionMapa">
                <div class="accordion-body bg-white">
                    
                    <?php if($etapa->decisao_texto): ?>
                        <div class="mb-3 ps-3 border-start border-3 border-warning bg-warning bg-opacity-10 py-2 rounded-end">
                            <small class="text-uppercase text-warning-emphasis fw-bold" style="font-size: 0.7rem;">Texto do Botão de Entrada:</small><br>
                            <span class="fst-italic">"<?= esc($etapa->decisao_texto) ?>"</span>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3 mb-3">
                        <?php foreach($etapa->itens as $item): ?>
                            <div class="col-md-12">
                                <div class="p-2 border rounded d-flex align-items-center gap-3 bg-light hover-bg-gray">
                                    <div class="d-flex flex-column align-items-center justify-content-center me-2" style="width: 30px;">
                                        <a href="<?= site_url('admin/reordenar_item/' . $item->id . '/sobe') ?>" class="text-decoration-none text-secondary small" style="line-height: 1;">▲</a>
                                        <span class="small fw-bold text-muted"><?= $item->ordem ?></span>
                                        <a href="<?= site_url('admin/reordenar_item/' . $item->id . '/desce') ?>" class="text-decoration-none text-secondary small" style="line-height: 1;">▼</a>
                                    </div>
                                    
                                    <div style="width: 60px;">
                                        <?php if($item->tipo == 'foto'): ?>
                                            <img src="<?= esc($item->conteudo) ?>" class="img-fluid rounded" style="height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= $item->tipo ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="flex-grow-1 text-truncate">
                                        <strong class="d-block text-dark small mb-1"><?= esc($item->titulo ?: 'Sem Título') ?></strong>
                                        <small class="d-block text-muted">Classe: <?= esc($item->classe_css) ?></small>
                                        <small class="text-muted fst-italic">"<?= esc($item->legenda ?? '') ?>"</small>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-light border" 
                                                data-bs-toggle="modal" data-bs-target="#modalEditarItem"
                                                onclick='preencherEditarItem(<?= json_encode($item) ?>)'>
                                                ✎
                                        </button>
                                        <a href="<?= site_url('admin/excluir_item/' . $item->id) ?>" class="btn btn-sm btn-light border text-danger" onclick="return confirm('Apagar item?')">&times;</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-outline-primary btn-sm text-uppercase ls-1" 
                                onclick="prepararModalItem(<?= $etapa->id ?>)"
                                data-bs-toggle="modal" data-bs-target="#modalNovoItem">
                            + Adicionar Artefato Aqui
                        </button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<div class="modal fade" id="modalNovaEtapa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escavar Nova Camada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/adicionar_etapa') ?>
            <input type="hidden" name="ensaio_id" value="<?= $ensaio->id ?>">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Título da Sala</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Atmosfera Sonora (Áudio)</label>
                    <input type="file" name="audio_arquivo" class="form-control" accept="audio/*">
                    <small class="text-muted">Frases, suspiros ou sons ambientes (MP3/WAV).</small>
                </div>

                <div class="row bg-light border rounded p-2 mb-3 mx-0">
                    <div class="col-12 mb-2">
                        <small class="text-uppercase fw-bold text-muted">Conexões da Caverna</small>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label small">Origem (Pai)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Início (Raiz) --</option>
                            <?php foreach($etapas as $e): ?>
                                <option value="<?= $e->id ?>">
                                    ID <?= $e->id ?>: <?= esc($e->titulo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text small">De onde o visitante vem para chegar aqui?</div>
                    </div>
                    <div class="col-md-12">
                         <label class="form-label small">Texto do Botão (Decisão)</label>
                         <input type="text" name="decisao_texto" class="form-control" placeholder="Ex: Entrar na fenda escura...">
                         <div class="form-text small">O que aparece no botão para o usuário clicar.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 mb-3">
                        <label class="form-label small">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="fotevista">Fotevista</option>
                            <option value="entrevista">Entrevista</option>
                            <option value="fineart">FineArt</option>
                            <option value="texto_livre">Texto Livre</option>
                        </select>
                    </div>
                    
                    <div class="col-4 mb-3">
                        <label class="form-label small">Direção</label>
                        <select name="direcao" class="form-select">
                            <option value="frente">Em Frente (&darr;)</option>
                            <option value="lado">Para o Lado (&rarr;)</option>
                        </select>
                    </div>

                    <div class="col-4 mb-3">
                        <label class="form-label small">Ordem</label>
                        <input type="number" name="ordem" class="form-control" value="1">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição (Interna)</label>
                    <textarea name="descricao" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-dark">Criar</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovoItem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Artefato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/adicionar_item') ?>
            <input type="hidden" name="etapa_id" id="inputEtapaId">
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" id="novoItemTipo" class="form-select" onchange="alternarCamposNovo()">
                            <option value="foto">Foto</option>
                            <option value="texto">Texto (Parágrafo)</option>
                            <option value="citacao">Citação (Destaque)</option>
                            <option value="video">Vídeo</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" name="ordem" class="form-control" value="1">
                    </div>
                </div>

                <div class="mb-3" id="campoArquivoNovo">
                    <label class="form-label">Selecionar Imagem</label>
                    <input type="file" name="arquivo_imagem" class="form-control" accept="image/*">
                </div>

                <div class="mb-3 d-none" id="campoTextoNovo">
                    <label class="form-label">Conteúdo (Texto ou Embed)</label>
                    <textarea name="conteudo" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Layout (Grid)</label>
                    <select name="classe_css" class="form-select">
                        <option value="col-md-4">Vertical Padrão (1/3)</option>
                        <option value="col-md-6">Metade (1/2)</option>
                        <option value="col-md-8">Largo (2/3)</option>
                        <option value="col-12">Largura Total (Full)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Título da Obra (Ficha Técnica)</label>
                    <input type="text" name="titulo" class="form-control" placeholder="Ex: Estudo de Luz #01">
                    <div class="form-text small">Nome oficial para venda. Se vazio, será tratado como "Sem Título".</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Legenda (Opcional)</label>
                    <input type="text" name="legenda" class="form-control">
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark">Adicionar Item</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarEtapa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title text-warning-emphasis">Editar Camada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/atualizar_etapa') ?>
            <input type="hidden" name="id" id="editEtapaId">
            <div class="modal-body">
                <div class="mb-3 mt-4 pt-3 border-top">
                    <label class="form-label fw-bold">Atmosfera Sonora (Opcional)</label>
                    <input type="file" name="audio_arquivo" class="form-control" accept="audio/*">
                    <div id="audioAtualInfo" class="form-text small text-info d-none">
                        <i class="bi bi-info-circle"></i> Esta sala já possui um áudio configurado.
                    </div>
                    <small class="text-muted">Suba um novo arquivo apenas se quiser substituir o atual.</small>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" id="editEtapaTitulo" class="form-control" required>
                </div>

                 <div class="row bg-light border rounded p-2 mb-3 mx-0">
                    <div class="col-md-12 mb-3">
                        <label class="form-label small">Origem (Pai)</label>
                        <select name="parent_id" id="editEtapaParent" class="form-select">
                            <option value="">-- Início (Raiz) --</option>
                            <?php foreach($etapas as $e): ?>
                                <option value="<?= $e->id ?>">
                                    ID <?= $e->id ?>: <?= esc($e->titulo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                         <label class="form-label small">Texto do Botão</label>
                         <input type="text" name="decisao_texto" id="editEtapaDecisao" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 mb-3">
                        <label class="form-label small">Tipo</label>
                        <select name="tipo" id="editEtapaTipo" class="form-select">
                            <option value="fotevista">Fotevista</option>
                            <option value="entrevista">Entrevista</option>
                            <option value="fineart">FineArt</option>
                            <option value="texto_livre">Texto Livre</option>
                        </select>
                    </div>
                    
                    <div class="col-4 mb-3">
                        <label class="form-label small">Direção</label>
                        <select name="direcao" id="editEtapaDirecao" class="form-select">
                            <option value="frente">Em Frente (&darr;)</option>
                            <option value="lado">Para o Lado (&rarr;)</option>
                        </select>
                    </div>

                    <div class="col-4 mb-3">
                        <label class="form-label small">Ordem</label>
                        <input type="number" name="ordem" id="editEtapaOrdem" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" id="editEtapaDescricao" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-warning">Salvar Alterações</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarItem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-info">
            <div class="modal-header bg-info bg-opacity-10">
                <h5 class="modal-title text-info-emphasis">Editar Artefato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/atualizar_item') ?>
            <input type="hidden" name="id" id="editItemId">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" id="editItemTipo" class="form-select" onchange="alternarCamposEdit()">
                            <option value="foto">Foto</option>
                            <option value="texto">Texto</option>
                            <option value="citacao">Citação</option>
                            <option value="video">Vídeo</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" name="ordem" id="editItemOrdem" class="form-control">
                    </div>
                </div>

                 <div class="mb-3" id="campoArquivoEdit">
                    <label class="form-label">Trocar Imagem (Opcional)</label>
                    <input type="file" name="arquivo_imagem" class="form-control" accept="image/*">
                    <div class="form-text small text-muted">Deixe vazio para manter a imagem atual.</div>
                </div>

                <div class="mb-3" id="campoTextoEdit">
                    <label class="form-label">Conteúdo Atual</label>
                    <textarea name="conteudo" id="editItemConteudo" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Layout</label>
                    <select name="classe_css" id="editItemClasse" class="form-select">
                        <option value="col-md-4">Vertical Padrão (1/3)</option>
                        <option value="col-md-6">Metade (1/2)</option>
                        <option value="col-md-8">Largo (2/3)</option>
                        <option value="col-12">Total (Full)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Título da Obra</label>
                    <input type="text" name="titulo" id="editItemTitulo" class="form-control" placeholder="Ex: Estudo de Luz #01">
                </div>

                <div class="mb-3">
                    <label class="form-label">Legenda</label>
                    <input type="text" name="legenda" id="editItemLegenda" class="form-control">
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-info text-white">Salvar Alterações</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // --- LÓGICA DE ITENS (FOTOS/TEXTOS) ---

    function prepararModalItem(etapaId) {
        document.getElementById('inputEtapaId').value = etapaId;
        alternarCamposNovo();
    }

    function alternarCamposNovo() {
        const tipo = document.getElementById('novoItemTipo').value;
        const divArquivo = document.getElementById('campoArquivoNovo');
        const divTexto = document.getElementById('campoTextoNovo');

        if (tipo === 'foto') {
            divArquivo.classList.remove('d-none');
            divTexto.classList.add('d-none');
        } else {
            divArquivo.classList.add('d-none');
            divTexto.classList.remove('d-none');
        }
    }

    function alternarCamposEdit() {
        const tipo = document.getElementById('editItemTipo').value;
        const divArquivo = document.getElementById('campoArquivoEdit');
        
        if (tipo === 'foto') {
            divArquivo.classList.remove('d-none');
        } else {
            divArquivo.classList.add('d-none');
        }
    }

    function preencherEditarItem(item) {
        document.getElementById('editItemId').value = item.id;
        document.getElementById('editItemTipo').value = item.tipo;
        document.getElementById('editItemOrdem').value = item.ordem;
        document.getElementById('editItemConteudo').value = item.conteudo;
        document.getElementById('editItemClasse').value = item.classe_css;
        
        // NOVO: Preenche o título
        document.getElementById('editItemTitulo').value = item.titulo || ''; 

        document.getElementById('editItemLegenda').value = item.legenda;
        
        alternarCamposEdit();
    }
    
    // --- LÓGICA DE ETAPAS (CAMADAS) ---

    function preencherEditarEtapa(etapa) {
        document.getElementById('editEtapaId').value = etapa.id;
        document.getElementById('editEtapaTitulo').value = etapa.titulo;
        document.getElementById('editEtapaTipo').value = etapa.tipo;
        document.getElementById('editEtapaOrdem').value = etapa.ordem;
        document.getElementById('editEtapaDescricao').value = etapa.descricao;
        document.getElementById('editEtapaParent').value = etapa.parent_id;
        document.getElementById('editEtapaDecisao').value = etapa.decisao_texto;
        
        // Preenche a direção
        document.getElementById('editEtapaDirecao').value = etapa.direcao || 'frente';

        // Mostra info se já houver áudio
        const infoAudio = document.getElementById('audioAtualInfo');
        if (etapa.audio_url) {
            infoAudio.classList.remove('d-none');
        } else {
            infoAudio.classList.add('d-none');
        }
    }
</script>

<?= $this->endSection() ?>
