<?= $this->extend('admin/layout') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 fw-bold text-dark">Ensaios Fotográficos</h1>
    <div class="d-flex gap-2">
        <a href="<?= site_url('admin/candidaturas') ?>" class="btn btn-outline-secondary btn-sm text-uppercase ls-2 px-4 position-relative">
            Candidaturas
            <?php if (!empty($totalCandidaturas)): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size:0.6rem;">
                    <?= $totalCandidaturas ?>
                </span>
            <?php endif; ?>
        </a>
        <a href="<?= site_url('admin/novo') ?>" class="btn btn-dark btn-sm text-uppercase ls-2 px-4">
            + Novo Ensaio
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase small text-secondary">Título</th>
                    <th class="py-3 text-uppercase small text-secondary">Slug</th>
                    <th class="py-3 text-uppercase small text-secondary">Status</th>
                    <th class="pe-4 py-3 text-end text-uppercase small text-secondary">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ensaios)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            Nenhuma caverna explorada ainda. Crie a primeira.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($ensaios as $ensaio): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= esc($ensaio->titulo) ?></td>
                            <td class="text-muted small"><?= esc($ensaio->slug) ?></td>
                            <td>
                                <?php if($ensaio->status === 'publicado'): ?>
                                    <span class="badge bg-success rounded-pill px-3">No Ar</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-3">Rascunho</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="<?= site_url('admin/mapa/' . $ensaio->id) ?>" class="btn btn-outline-dark btn-sm me-1" title="Editar Conteúdo (Etapas)">
                                    <i class="bi bi-map"></i> Mapa
                                </a>
                                
                                <a href="<?= site_url('admin/editar/' . $ensaio->id) ?>" class="btn btn-outline-secondary btn-sm me-1" title="Editar Título/Capa">
                                    Editar
                                </a>

                                <a href="<?= site_url('ensaios/ver/' . $ensaio->slug) ?>" target="_blank" class="btn btn-link text-decoration-none text-muted btn-sm me-1" title="Ver Site">
                                    Ver
                                </a>

                                <a href="<?= site_url('admin/excluir/' . $ensaio->id) ?>" 
                                   class="btn btn-link text-danger btn-sm p-0 ms-2" 
                                   title="Excluir Definitivamente"
                                   onclick="return confirm('ATENÇÃO: Isso implodirá a caverna e todo seu conteúdo (etapas e fotos). Não há como desfazer. Tem certeza?');">
                                   &times;
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
