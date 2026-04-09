<?= $this->extend('admin/layout') ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3 text-gray-800"><?= esc($titulo) ?></h1>
        <a href="<?= base_url('admin/extras?ensaio_aberto='.$ensaio->id) ?>" class="btn btn-secondary">
            &larr; Voltar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            
            <?= form_open('admin/extras/salvar', ['id' => 'formExtra']) ?>
                <input type="hidden" name="id" value="<?= $pagina ? $pagina->id : '' ?>">
                <input type="hidden" name="ensaio_id" value="<?= $ensaio->id ?>">
                
                <input type="hidden" name="configuracoes_json" id="inputJson">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Título da Página</label>
                        <input type="text" name="titulo" class="form-control" required 
                               value="<?= $pagina ? esc($pagina->titulo) : '' ?>" placeholder="Ex: Ficha Técnica, Mockups à Venda...">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tipo de Conteúdo</label>
                        <select name="tipo" id="selectTipo" class="form-select" onchange="mudarTipo()">
                            <option value="texto_livre" <?= ($pagina && $pagina->tipo == 'texto_livre') ? 'selected' : '' ?>>Texto Simples</option>
                            <option value="ficha_tecnica" <?= ($pagina && $pagina->tipo == 'ficha_tecnica') ? 'selected' : '' ?>>Ficha Técnica (Chave: Valor)</option>
                            <option value="biografia" <?= ($pagina && $pagina->tipo == 'biografia') ? 'selected' : '' ?>>Biografia</option>
                            <option value="galeria" <?= ($pagina && $pagina->tipo == 'galeria') ? 'selected' : '' ?>>Galeria de Vendas (Mockups)</option>
                            <option value="compradores" <?= ($pagina && $pagina->tipo == 'compradores') ? 'selected' : '' ?>>Lista de Compradores</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Conteúdo Descritivo (Texto / Intro)</label>
                    <textarea name="conteudo" class="form-control" rows="4"><?= $pagina ? esc($pagina->conteudo) : '' ?></textarea>
                    <small class="text-muted">Este texto aparece no topo da página, antes dos dados dinâmicos.</small>
                </div>

                <hr>

                <h5 class="text-primary mb-3"><i class="fas fa-cogs"></i> Dados Específicos (JSON)</h5>
                
                <div id="areaDinamica" class="bg-light p-3 border rounded">
                    </div>

                <div class="mt-4 text-end">
                    <button type="button" onclick="prepararEnvio()" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-save"></i> Salvar Página
                    </button>
                </div>

            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    let dadosAtuais = <?= ($pagina && $pagina->configuracoes) ? json_encode($pagina->configuracoes) : '[]' ?>;
</script>

<script>
    const area = document.getElementById('areaDinamica');
    const select = document.getElementById('selectTipo');

    // Inicializa
    document.addEventListener("DOMContentLoaded", () => {
        mudarTipo(true); // true = carregamento inicial (preserva dados)
    });

    function mudarTipo(isInit = false) {
        const tipo = select.value;
        let html = '';

        if (!isInit) dadosAtuais = []; // Limpa se mudou o tipo manualmente

        if (tipo === 'texto_livre' || tipo === 'biografia') {
            html = '<p class="text-muted">Este tipo não requer campos extras estruturados. Use apenas o campo de texto acima.</p>';
        } 
        else if (tipo === 'ficha_tecnica' || tipo === 'compradores') {
            html = `
                <div class="mb-2">
                    <button type="button" class="btn btn-sm btn-info text-white" onclick="addChaveValor()">+ Adicionar Item</button>
                </div>
                <div id="containerChaveValor"></div>
            `;
        } 
        else if (tipo === 'galeria') {
            html = `
                <div class="mb-2">
                    <button type="button" class="btn btn-sm btn-warning text-dark" onclick="addMockup()">+ Adicionar Quadro (Mockup)</button>
                </div>
                <div id="containerMockup" class="row"></div>
            `;
        }

        area.innerHTML = html;

        // Repopula se tiver dados
        if (isInit && dadosAtuais) {
            if (tipo === 'ficha_tecnica' || tipo === 'compradores') {
                // Supondo que seja objeto {chave: valor} ou array [{chave, valor}]
                // Vamos padronizar como Array de objetos para facilitar a edição
                // Se for objeto antigo {k:v}, converte
                let lista = Array.isArray(dadosAtuais) ? dadosAtuais : Object.entries(dadosAtuais).map(([k,v]) => ({chave: k, valor: v}));
                lista.forEach(item => addChaveValor(item.chave, item.valor));
            }
            if (tipo === 'galeria') {
                dadosAtuais.forEach(item => addMockup(item));
            }
        }
    }

    // --- LOGICA DE CHAVE/VALOR ---
    function addChaveValor(chave = '', valor = '') {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 item-dinamico';
        div.innerHTML = `
            <input type="text" class="form-control campo-chave" placeholder="Rótulo (ex: Papel)" value="${chave}">
            <input type="text" class="form-control campo-valor" placeholder="Valor (ex: Algodão 300g)" value="${valor}">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">X</button>
        `;
        document.getElementById('containerChaveValor').appendChild(div);
    }

    // --- LOGICA DE MOCKUP (GALERIA) ---
    function addMockup(dados = {}) {
        const div = document.createElement('div');
        div.className = 'col-md-6 mb-3 item-dinamico-mockup';
        div.innerHTML = `
            <div class="card p-2">
                <div class="mb-2">
                    <label>URL da Imagem</label>
                    <input type="text" class="form-control campo-img" placeholder="http://..." value="${dados.img || ''}">
                </div>
                <div class="row">
                    <div class="col-6 mb-2">
                        <label>Título</label>
                        <input type="text" class="form-control campo-titulo" placeholder="Obra #1" value="${dados.titulo || ''}">
                    </div>
                    <div class="col-6 mb-2">
                        <label>Preço</label>
                        <input type="text" class="form-control campo-preco" placeholder="R$ 0,00" value="${dados.preco || ''}">
                    </div>
                </div>
                <div class="mb-2">
                    <label>Status</label>
                    <select class="form-select campo-status">
                        <option value="disponivel" ${dados.status === 'disponivel' ? 'selected' : ''}>Disponível</option>
                        <option value="vendido" ${dados.status === 'vendido' ? 'selected' : ''}>Vendido</option>
                        <option value="reservado" ${dados.status === 'reservado' ? 'selected' : ''}>Reservado</option>
                    </select>
                </div>
                <button class="btn btn-sm btn-danger w-100" type="button" onclick="this.closest('.col-md-6').remove()">Remover Quadro</button>
            </div>
        `;
        document.getElementById('containerMockup').appendChild(div);
    }

    // --- PREPARAR JSON PARA ENVIO ---
    function prepararEnvio() {
        const tipo = select.value;
        let resultado = null;

        if (tipo === 'ficha_tecnica' || tipo === 'compradores') {
            // Monta array de objetos: [{chave: 'Papel', valor: 'X'}]
            resultado = [];
            document.querySelectorAll('#containerChaveValor .input-group').forEach(el => {
                const k = el.querySelector('.campo-chave').value;
                const v = el.querySelector('.campo-valor').value;
                if(k) resultado.push({chave: k, valor: v});
            });
        } 
        else if (tipo === 'galeria') {
            resultado = [];
            document.querySelectorAll('#containerMockup .item-dinamico-mockup').forEach(el => {
                resultado.push({
                    img: el.querySelector('.campo-img').value,
                    titulo: el.querySelector('.campo-titulo').value,
                    preco: el.querySelector('.campo-preco').value,
                    status: el.querySelector('.campo-status').value
                });
            });
        }

        // Serializa e coloca no input hidden
        if (resultado) {
            document.getElementById('inputJson').value = JSON.stringify(resultado);
        } else {
             document.getElementById('inputJson').value = '';
        }

        document.getElementById('formExtra').submit();
    }
</script>
<?= $this->endSection() ?>
