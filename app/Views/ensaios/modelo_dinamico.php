<?= $this->extend('layout/main') ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid p-0 bg-black min-vh-100">
    
    <div class="container py-5 text-center animate-fade-in" style="margin-top: 60px;">
        <h1 class="text-uppercase ls-2 mb-2" style="color: var(--luz-guia);">
            <?= esc($ensaio->titulo) ?>
        </h1>
        
        <?php if(!empty($ensaio->resumo_card)): ?>
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <p class="lead" style="color: var(--branco-incerteza); font-family: 'EB Garamond', serif;">
                        <?= esc($ensaio->resumo_card) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if(!empty($ensaio->etapas)): ?>
        <?php foreach($ensaio->etapas as $etapa): ?>
            
            <div class="etapa-container mb-5 pb-5">
                
                <?php if($etapa->titulo && $etapa->tipo != 'texto_livre'): ?>
                    <div class="container mb-4">
                        <div class="d-flex align-items-center">
                            <span class="line flex-grow-1 border-top border-secondary opacity-25"></span>
                            <span class="mx-3 text-uppercase small ls-2 text-muted"><?= esc($etapa->titulo) ?></span>
                            <span class="line flex-grow-1 border-top border-secondary opacity-25"></span>
                        </div>
                        <?php if($etapa->descricao): ?>
                            <p class="text-center mt-3 text-muted fst-italic"><?= esc($etapa->descricao) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="container">
                    <div class="row g-4 justify-content-center align-items-center">
                        
                        <?php if(!empty($etapa->itens)): ?>
                            <?php foreach($etapa->itens as $item): ?>
                                
                                <div class="<?= esc($item->classe_css) ?>">
                                    
                                    <?php if($item->tipo == 'foto'): ?>
                                        <div class="position-relative">
                                            <img src="<?= esc($item->conteudo) ?>" 
                                                 class="img-fluid w-100 grayscale hover-color transition shadow-sm" 
                                                 alt="<?= esc($item->legenda) ?>">
                                            <?php if($item->legenda): ?>
                                                <p class="small text-muted mt-2 text-end fst-italic"><?= esc($item->legenda) ?></p>
                                            <?php endif; ?>
                                        </div>

                                    <?php elseif($item->tipo == 'texto'): ?>
                                        <div class="text-justify px-md-4" style="color: var(--branco-incerteza); font-family: 'EB Garamond', serif; font-size: 1.1rem; line-height: 1.8;">
                                            <?= nl2br(esc($item->conteudo)) ?>
                                        </div>

                                    <?php elseif($item->tipo == 'citacao'): ?>
                                        <div class="text-center px-5 py-4 border-start border-end border-secondary border-opacity-25">
                                            <p class="h4 fst-italic" style="color: var(--luz-guia);">
                                                "<?= esc($item->conteudo) ?>"
                                            </p>
                                            <?php if($item->legenda): ?>
                                                <small class="d-block mt-3 text-uppercase ls-2 text-muted"><?= esc($item->legenda) ?></small>
                                            <?php endif; ?>
                                        </div>

                                    <?php elseif($item->tipo == 'video'): ?>
                                        <div class="ratio ratio-16x9 shadow-sm border border-secondary border-opacity-25">
                                            <?php if(strpos($item->conteudo, '<iframe') !== false): ?>
                                                <?= $item->conteudo ?>
                                            <?php else: ?>
                                                <iframe src="<?= esc($item->conteudo) ?>" allowfullscreen></iframe>
                                            <?php endif; ?>
                                        </div>

                                    <?php endif; ?>

                                </div>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    <?php endif; ?>

    <div class="container text-center py-5 pb-5">
        <hr class="border-secondary opacity-25 mb-5">
        <a href="<?= site_url('ensaios') ?>" class="text-decoration-none text-uppercase small ls-2 text-secondary hover-white transition">
            &larr; Voltar para o Hall
        </a>
    </div>

</div>

<style>
    .grayscale { filter: grayscale(100%); transition: filter 0.8s ease; }
    .hover-color:hover { filter: grayscale(0%); cursor: crosshair; }
    .transition { transition: all 0.5s ease; }
    .text-justify { text-align: justify; }
</style>
<?= $this->endSection() ?>
