<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>Confirmar Acesso — Marcosanto Foto<?= $this->endSection() ?>
<?= $this->section('meta_desc') ?>Você escolheu. Esta é sua única janela de hoje.<?= $this->endSection() ?>

<?= $this->section('header_back') ?>
<a href="<?= site_url('ensaios') ?>" class="text-secondary text-decoration-none small text-uppercase ls-2" style="letter-spacing:2px; font-size: 0.65rem;">
    &larr; Obras
</a>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
    
    <div class="col-11 col-md-6 mx-auto animate-fade-in">
        <h1 class="h5 text-uppercase ls-2 mb-4" style="color: var(--laranja-chao);">Última chance de recuar</h1>
        
        <p class="mb-5 lh-lg" style="color: var(--branco-incerteza); font-family: 'EB Garamond', serif; font-size: 1.2rem;">
            Você escolheu <strong><?= esc(strtoupper($slug)) ?></strong>.<br><br>
            Ao confirmar, esta será sua única janela para a intimidade hoje. 
            O tempo será selado pelas próximas 24 horas. <br>
            Você está certo de que é isso que sua alma busca agora?
        </p>

        <div class="d-flex justify-content-center gap-4 align-items-center">
            <a href="<?= url_to('ensaios') ?>" 
               class="text-decoration-none text-uppercase small ls-2 text-secondary hover-white transition">
                Prefiro esperar
            </a>

            <?= form_open('ensaios/processar/' . $slug) ?>
                <button type="submit" class="btn btn-outline-light rounded-0 text-uppercase ls-2 px-5 py-2" style="font-size: 0.8rem;">
                    Confirmar Escolha
                </button>
            <?= form_close() ?>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
