<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('titulo') ?: 'Marcosanto Foto' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    
    <meta name="description" content="<?= $this->renderSection('meta_desc') ? esc($this->renderSection('meta_desc')) : 'Marcosanto Foto — Experimentações em fotografia de autor.' ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= $this->renderSection('canonical_url') ? esc($this->renderSection('canonical_url')) : current_url() ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?= $this->renderSection('titulo') ? esc($this->renderSection('titulo')) : 'Marcosanto Foto' ?>">
    <meta property="og:description" content="<?= $this->renderSection('meta_desc') ? esc($this->renderSection('meta_desc')) : 'Marcosanto Foto — Experimentações em fotografia de autor.' ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="<?= $this->renderSection('og_type') ? esc($this->renderSection('og_type')) : 'website' ?>">
    <meta property="og:image" content="<?= $this->renderSection('og_image') ? esc($this->renderSection('og_image')) : base_url('assets/img/og_default.jpg') ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $this->renderSection('titulo') ? esc($this->renderSection('titulo')) : 'Marcosanto Foto' ?>">
    <meta name="twitter:description" content="<?= $this->renderSection('meta_desc') ? esc($this->renderSection('meta_desc')) : 'Marcosanto Foto — Experimentações em fotografia de autor.' ?>">
    <meta name="twitter:image" content="<?= $this->renderSection('og_image') ? esc($this->renderSection('og_image')) : base_url('assets/img/og_default.jpg') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/intimidade.css') ?>">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <?= $this->renderSection('css') ?>
</head>
<body class="<?= $this->renderSection('body_class') ?> bg-black">

    <header class="position-fixed w-100 top-0 z-3 py-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <?= $this->renderSection('header_back') ?>
            </div>
            <div>
                <?php if (auth()->loggedIn()): ?>
                    <a href="<?= site_url('metodo') ?>" class="nav-link text-white text-uppercase small ls-2 me-3 d-inline" style="opacity: 0.4; font-size: 0.6rem;">Método</a>
                    <a href="<?= site_url('perfil/trocar_senha') ?>" class="nav-link text-white text-uppercase small ls-2 me-3 d-inline" style="opacity: 0.4; font-size: 0.6rem;">Senha</a>
                    <?php if (auth()->user()->inGroup('superadmin')): ?>
                        <span style="opacity: 0.15; margin-right: 0.75rem; font-size: 0.6rem;">|</span>
                        <a href="<?= site_url('admin') ?>" class="nav-link text-white text-uppercase small ls-2 me-3 d-inline" style="opacity: 0.4; font-size: 0.6rem; color: #c8a96e !important;">Admin</a>
                    <?php endif; ?>
                    <a href="<?= url_to('logout') ?>" class="nav-link text-white text-uppercase small ls-2 d-inline">Sair</a>
                <?php else: ?>
                    <a href="<?= url_to('login') ?>" class="nav-link text-white text-uppercase small ls-2">Acessar</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <?= $this->renderSection('conteudo') ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
