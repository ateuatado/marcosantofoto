<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Caverna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; }
        .sidebar { min-height: 100vh; background: #1a1a1a; color: #fff; }
        .nav-link { color: rgba(255,255,255,0.7); }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4">
            <h4 class="mb-4 text-uppercase ls-2 fs-6">Painel de Controle</h4>
            <nav class="nav flex-column gap-2">
                <a class="nav-link active" href="<?= site_url('admin') ?>">Ensaios</a>
                <a class="nav-link" href="<?= base_url('admin/extras') ?>">
                    <i class="fas fa-fw fa-book-open"></i> <span>Santuário (Extras)</span>
                </a>
                <a class="nav-link" href="<?= site_url('logout') ?>">Sair</a>
            </nav>
        </div>

        <div class="col-md-10 p-5">
            <?php if (session()->has('sucesso')): ?>
                <div class="alert alert-success"><?= session('sucesso') ?></div>
            <?php endif; ?>
            
            <?= $this->renderSection('conteudo') ?>
        </div>
    </div>
</div>

</body>
</html>
