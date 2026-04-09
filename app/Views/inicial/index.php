<?= $this->extend('layout/main') ?>

<?= $this->section('body_class') ?>fundo-assinatura<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    :root {
        --luz-guia: #c8a96e;
        --branco-incerteza: rgba(255, 255, 255, 0.75);
    }
    .fundo-assinatura {
        background-color: #050505;
        position: relative;
    }
    .fundo-assinatura::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('<?= base_url('assets/img/pegaavisao.jpg') ?>') no-repeat center center fixed;
        background-size: 80%;
        opacity: 0.2; /* 80% de transparência */
        z-index: 0;
    }
    .fundo-assinatura::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.6); /* Escurecimento sobre a imagem */
        z-index: 0;
    }
    .fundo-assinatura .container {
        position: relative;
        z-index: 1;
    }
    
    .btn-terroso {
        background-color: var(--luz-guia);
        color: #050505;
        padding: 12px 30px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        border: 1px solid var(--luz-guia);
        font-family: 'Inter', sans-serif;
    }
    .btn-terroso:hover {
        background-color: transparent;
        color: var(--luz-guia);
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('conteudo') ?>
<div class="container vh-100 d-flex flex-column justify-content-center align-items-center text-center">
    
    <h1 class="display-5 mb-2 fw-light" style="color: var(--luz-guia); letter-spacing: 1px;">
        Um ensaio é a revelação de uma alma.
    </h1>
    
    <p class="mb-5 opacity-75" style="color: var(--branco-incerteza); font-style: italic; font-size: 1.1rem;">
        Veja com responsabilidade.
    </p>

    <a href="<?= url_to('ensaios') ?>" class="btn-terroso text-uppercase ls-2">
        Eu quero ver
    </a>

</div>
<?= $this->endSection() ?>
