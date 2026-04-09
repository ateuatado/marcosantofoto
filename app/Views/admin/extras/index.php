<?= $this->extend('admin/layout') ?>

<?= $this->section('conteudo') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Santuário <small class="text-muted fs-6">(Documentação & Vendas)</small></h1>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            
            <div class="row align-items-center">
                <div class="col-md-8">
                    <label for="selectEnsaio" class="form-label text-uppercase text-xs font-weight-bold text-primary mb-2">
                        Selecione a Caverna (Ensaio)
                    </label>
                    <select id="selectEnsaio" class="form-control form-control-lg" onchange="carregarExtras(this.value)">
                        <option value="">-- Escolha um Ensaio --</option>
                        <?php foreach ($ensaios as $e): ?>
                            <option value="<?= $e->id ?>"><?= esc($e->titulo) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 text-muted small mt-3 mt-md-0">
                    Aqui gerenciamos Biografias, Fichas Técnicas e Venda de Obras.
                </div>
            </div>

            <hr class="my-4">

            <div id="areaListaExtras" class="min-vh-50">
                <div class="text-center text-muted py-5 opacity-50">
                    <i class="fas fa-folder-open fa-3x mb-3"></i><br>
                    Aguardando seleção...
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function carregarExtras(ensaioId) {
        const area = document.getElementById('areaListaExtras');
        
        if (!ensaioId) {
            area.innerHTML = '<div class="text-center text-muted py-5">Selecione um ensaio acima.</div>';
            return;
        }

        area.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Buscando documentos...</p></div>';

        fetch(`<?= base_url('admin/extras/listar') ?>/${ensaioId}`)
            .then(response => response.text())
            .then(html => {
                area.innerHTML = html;
            })
            .catch(err => {
                area.innerHTML = '<div class="alert alert-danger">Erro de conexão.</div>';
                console.error(err);
            });
    }

    // Reabre o ensaio se voltar de um salvamento
    document.addEventListener("DOMContentLoaded", () => {
        const urlParams = new URLSearchParams(window.location.search);
        const ensaioAberto = urlParams.get('ensaio_aberto');
        if (ensaioAberto) {
            const select = document.getElementById('selectEnsaio');
            if(select.querySelector(`option[value="${ensaioAberto}"]`)) {
                select.value = ensaioAberto;
                carregarExtras(ensaioAberto);
            }
        }
    });
</script>

<?= $this->endSection() ?>
