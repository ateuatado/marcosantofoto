<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>Candidaturas — Admin Marcosanto Foto<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container py-5" style="margin-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h4 text-white text-uppercase ls-2 mb-1">Candidaturas</h1>
            <small class="text-muted">Total: <?= count($candidaturas) ?> | Pendentes: <?= count(array_filter($candidaturas, fn($c) => $c->status === 'pendente')) ?></small>
        </div>
        <a href="<?= site_url('admin') ?>" class="text-secondary text-decoration-none small text-uppercase ls-2" style="font-size: 0.7rem;">← Admin</a>
    </div>

    <?php if (empty($candidaturas)): ?>
        <div class="text-center py-5 opacity-50">
            <p class="text-white">Nenhuma candidatura recebida ainda.</p>
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($candidaturas as $c): ?>
                <div class="col-12">
                    <div class="p-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,<?= $c->status === 'pendente' ? '0.1' : '0.04' ?>); border-left: 3px solid <?= $c->status === 'pendente' ? '#c8a96e' : ($c->status === 'aceito' ? '#28a745' : '#dc3545') ?>;">
                        
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h2 class="h6 text-white mb-1"><?= esc($c->nome) ?></h2>
                                <small class="text-muted"><?= esc($c->email) ?><?= $c->telefone ? ' · ' . esc($c->telefone) : '' ?></small>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge rounded-0 text-uppercase" 
                                      style="font-size: 0.55rem; letter-spacing: 2px; background: <?= $c->status === 'pendente' ? 'rgba(200,169,110,0.2)' : ($c->status === 'aceito' ? 'rgba(40,167,69,0.2)' : 'rgba(220,53,69,0.2)') ?>; color: <?= $c->status === 'pendente' ? '#c8a96e' : ($c->status === 'aceito' ? '#28a745' : '#dc3545') ?>;">
                                    <?= esc($c->status) ?>
                                </span>
                                <small class="text-muted" style="font-size: 0.65rem;"><?= date('d/m/Y', strtotime($c->created_at)) ?></small>
                            </div>
                        </div>

                        <div class="mt-3 row g-3" style="font-size: 0.8rem; color: rgba(255,255,255,0.5);">
                            <?php if ($c->nascimento): ?>
                                <div class="col-auto">
                                    <span class="text-uppercase" style="font-size: 0.6rem; letter-spacing: 2px; color: rgba(255,255,255,0.25);">Nasc.</span><br>
                                    <?= date('d/m/Y', strtotime($c->nascimento)) ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($c->sexo): ?>
                                <div class="col-auto">
                                    <span class="text-uppercase" style="font-size: 0.6rem; letter-spacing: 2px; color: rgba(255,255,255,0.25);">Identidade</span><br>
                                    <?= esc($c->sexo) ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($c->lattes): ?>
                                <div class="col-auto">
                                    <span class="text-uppercase" style="font-size: 0.6rem; letter-spacing: 2px; color: rgba(255,255,255,0.25);">Lattes</span><br>
                                    <a href="<?= esc($c->lattes) ?>" target="_blank" class="text-info" style="font-size: 0.75rem;">Ver currículo ↗</a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($c->redes_sociais): ?>
                            <div class="mt-2" style="font-size: 0.75rem; color: rgba(255,255,255,0.4);">
                                <span class="text-uppercase" style="font-size: 0.6rem; letter-spacing: 2px; color: rgba(255,255,255,0.2);">Redes: </span>
                                <?= nl2br(esc($c->redes_sociais)) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($c->historia): ?>
                            <div class="mt-3 p-3" style="background: rgba(255,255,255,0.02); border-left: 1px solid rgba(255,255,255,0.06); font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.8; font-family: 'EB Garamond', serif; font-style: italic;">
                                <?= nl2br(esc($c->historia)) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($c->status === 'pendente'): ?>
                            <div class="mt-3 d-flex gap-2">
                                <a href="<?= site_url('admin/candidatura/aceitar/' . $c->id) ?>" 
                                   class="btn btn-sm rounded-0 text-uppercase" 
                                   style="font-size: 0.6rem; letter-spacing: 2px; background: rgba(40,167,69,0.1); border: 1px solid rgba(40,167,69,0.3); color: #28a745;">
                                    Aceitar
                                </a>
                                <a href="<?= site_url('admin/candidatura/recusar/' . $c->id) ?>" 
                                   class="btn btn-sm rounded-0 text-uppercase"
                                   style="font-size: 0.6rem; letter-spacing: 2px; background: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.3); color: #dc3545;">
                                    Recusar
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
<?= $this->endSection() ?>
