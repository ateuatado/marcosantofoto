<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>Acervo — Marcosanto Foto<?= $this->endSection() ?>
<?= $this->section('meta_desc') ?>Escolha seu ensaio. Lembre-se: apenas uma janela por dia.<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container py-5" style="margin-top: 80px;">
    
    <?php if (session()->has('erro')): ?>
        <div class="alert alert-warning text-center mb-5">
            <?= session('erro') ?>
        </div>
    <?php endif; ?>

    <div class="mb-5 py-5 px-4 px-md-5" style="border: 1px solid rgba(200,169,110,0.15); background: linear-gradient(180deg, rgba(20,20,20,0.4) 0%, rgba(0,0,0,0) 100%); position: relative;">
        <!-- Elementos decorativos nos cantos -->
        <div style="position: absolute; top: 0; left: 0; width: 10px; height: 10px; border-top: 1px solid #c8a96e; border-left: 1px solid #c8a96e;"></div>
        <div style="position: absolute; top: 0; right: 0; width: 10px; height: 10px; border-top: 1px solid #c8a96e; border-right: 1px solid #c8a96e;"></div>
        
        <div class="row g-5 align-items-stretch">
            <div class="col-md-6 position-relative">
                <div class="pe-md-4 h-100 d-flex flex-column justify-content-center">
                    <h2 class="h6 text-uppercase mb-4 text-center text-md-start" style="color: #c8a96e; letter-spacing: 4px; font-weight: 300;">O Pacto do Olhar</h2>
                    <p class="lh-lg mb-0 text-center text-md-start" style="color: rgba(255,255,255,0.6); font-family: 'EB Garamond', serif; font-style: italic; font-size: 1.15rem;">
                        As obras aqui expostas transcendem o mero registro visual; são fragmentos de intimidade partilhada. Exige-se de quem observa a mesma coragem, respeito e responsabilidade de quem se dispôs a ser retratado.
                    </p>
                </div>
                <!-- Linha divisória vertical que some no mobile -->
                <div class="d-none d-md-block" style="position: absolute; right: 0; top: 10%; bottom: 10%; width: 1px; background: rgba(255,255,255,0.08);"></div>
            </div>
            
            <div class="col-md-6">
                <div class="ps-md-4 h-100 d-flex flex-column justify-content-center">
                    <h2 class="h6 text-uppercase mb-4 text-center text-md-start" style="color: #c8a96e; letter-spacing: 4px; font-weight: 300;">A Rigidez do Tempo</h2>
                    <p class="lh-lg mb-0 text-center text-md-start" style="color: rgba(255,255,255,0.6); font-family: 'EB Garamond', serif; font-style: italic; font-size: 1.15rem;">
                        Neste espaço, a urgência contemporânea perde a força. Você terá permissão para adentrar livremente em <strong style="color: #fff; font-weight: normal; font-style: normal; letter-spacing: 1px;">um único ensaio a cada 24 horas</strong>. Escolha com profunda intenção, consuma na velocidade do silêncio e dedique à obra a atenção que ela exige.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 border-secondary opacity-25">

    <?php if (!empty($bloqueio)): ?>
        <div class="text-center mb-5 py-3" style="border: 1px solid rgba(200,169,110,0.2); border-radius: 4px;">
            <p class="small text-muted text-uppercase ls-2 mb-1">Próxima janela abre em</p>
            <p class="mb-0" style="color: #c8a96e; font-family: 'EB Garamond', serif; font-size: 1.8rem; font-style: italic;">
                <span id="countdown" data-acesso="<?= esc($bloqueio->data_acesso) ?>">calculando...</span>
            </p>
        </div>
    <?php endif; ?>

    <style>
        .capa-wrapper { position: relative; overflow: hidden; aspect-ratio: 3/4; }
        .capa-ensaio  { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease, filter 0.6s ease; filter: grayscale(40%); }
        .capa-wrapper:hover .capa-ensaio { transform: scale(1.04); filter: grayscale(0%); }
        .capa-ouro    { border-bottom: 2px solid #c8a96e; }
        .capa-hover-label { position: absolute; bottom: 0; left: 0; right: 0; padding: 10px; text-align: center; background: rgba(0,0,0,0.6); color: #fff; font-size: 0.65rem; letter-spacing: 3px; text-transform: uppercase; opacity: 0; transition: opacity 0.4s; }
        .capa-wrapper:hover .capa-hover-label { opacity: 1; }
        .bloqueado-label { color: #888 !important; }
        .badge-ensaio { text-align: center; padding: 6px 0 12px 0; }
        .opacity-40 { opacity: 0.4; pointer-events: none; }
    </style>

    <div class="row g-5 align-items-start justify-content-center">
        
        <?php if (empty($ensaios)): ?>
            <div class="col-12 text-center py-5 opacity-50">
                <p class="text-white">O silêncio impera. Nenhum ensaio revelado ainda.</p>
            </div>
        <?php else: ?>
            
            <?php foreach ($ensaios as $ensaio):
                $desbloqueado = in_array($ensaio->slug, $slugsDesbloqueados ?? []);
                $bloqueado    = !$desbloqueado && !empty($bloqueio);
            ?>
                <div class="col-md-4 mb-5">
                    <div class="card-ensaio <?= $bloqueado ? 'opacity-40' : '' ?>" style="position: relative;">

                        <?php if ($desbloqueado): ?>
                            <div class="badge-ensaio">
                                <span style="color: #c8a96e; font-size: 0.6rem; text-transform: uppercase; letter-spacing: 3px;">Câmara Aberta</span>
                            </div>
                        <?php endif; ?>

                        <a href="<?= $bloqueado ? '#' : site_url('ensaios/confirmar/' . $ensaio->slug) ?>" 
                           class="text-decoration-none d-block <?= $bloqueado ? 'cursor-blocked' : '' ?>">
                            
                            <div class="capa-wrapper">
                                <img src="<?= !empty($ensaio->capa_url) ? esc($ensaio->capa_url) : 'https://placehold.co/600x800/111/444?text=' . urlencode($ensaio->titulo) ?>" 
                                     class="img-fluid capa-ensaio <?= $desbloqueado ? 'capa-ouro' : '' ?>" 
                                     alt="<?= esc($ensaio->titulo) ?>" loading="lazy">
                                
                                <?php if (!$desbloqueado && !$bloqueado): ?>
                                    <div class="capa-hover-label">Entrar &darr;</div>
                                <?php elseif ($bloqueado): ?>
                                    <div class="capa-hover-label bloqueado-label">Indisponível</div>
                                <?php endif; ?>
                            </div>

                            <div class="mt-4 px-1">
                                <h3 class="h6 text-uppercase ls-2 mb-2" style="color: <?= $desbloqueado ? '#c8a96e' : 'var(--branco-incerteza, #ccc)' ?>;">
                                    <?= esc($ensaio->titulo) ?>
                                </h3>
                                <?php if (!empty($ensaio->resumo_card)): ?>
                                    <p class="small opacity-50 mb-0" style="color: var(--branco-incerteza, #aaa)"><?= esc($ensaio->resumo_card) ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
    </div>

    <div class="text-center mt-5 pt-4" style="border-top: 1px solid rgba(255,255,255,0.05);">
        <small class="text-muted d-block mb-3" style="font-size: 0.6rem; letter-spacing: 4px; text-transform: uppercase;">Sobre o trabalho</small>
        <a href="<?= site_url('metodo') ?>" 
           class="text-decoration-none"
           style="color: rgba(200,169,110,0.5); font-family: 'EB Garamond', serif; font-style: italic; font-size: 1.1rem; letter-spacing: 1px; transition: color 0.3s;"
           onmouseover="this.style.color='rgba(200,169,110,1)'"
           onmouseout="this.style.color='rgba(200,169,110,0.5)'">
            Entender o Método →
        </a>
        <p class="text-muted mt-2 mb-0" style="font-size: 0.65rem; color: rgba(255,255,255,0.2) !important; letter-spacing: 1px;">
            Os 5 Atos e o Pacto de Coautoria
        </p>
    </div>

</div>
<?= $this->section('scripts') ?>
<script>
    // Countdown para a próxima janela de acesso
    (function () {
        const el = document.getElementById('countdown');
        if (!el) return;
        const dataAcesso = new Date(el.dataset.acesso + ' UTC');
        // Add 24h to the access time
        const abertura = new Date(dataAcesso.getTime() + 24 * 60 * 60 * 1000);

        function tick() {
            const agora = new Date();
            const diff = abertura - agora;
            if (diff <= 0) {
                el.textContent = 'Recarregue a página';
                return;
            }
            const h = String(Math.floor(diff / 3600000)).padStart(2, '0');
            const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
            const s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            el.textContent = h + ':' + m + ':' + s;
        }
        tick();
        setInterval(tick, 1000);
    })();
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
