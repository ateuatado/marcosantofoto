<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/shield.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="auth-container">
    <div class="auth-box">
        <h2 class="auth-title">QUEM É VOCÊ?</h2>

        <?php if (session()->has('error')): ?>
            <div class="auth-erro"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <?php if (session()->has('errors')): ?>
            <div class="auth-erro">
                <?php foreach ((array) session('errors') as $erro): ?>
                    <div><?= esc($erro) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="auth-group">
                <label class="auth-label">E-MAIL</label>
                <input type="email" name="email" class="auth-input" value="<?= old('email') ?>" required>
            </div>
            <div class="auth-group">
                <label class="auth-label">SENHA</label>
                <input type="password" name="password" class="auth-input" required>
            </div>
            <button type="submit" class="auth-btn">MERGULHAR</button>
        </form>
        <a href="<?= url_to('register') ?>" class="auth-link">Quero me apresentar</a>
        <a href="<?= url_to('magic-link') ?>" class="auth-link" style="opacity: 0.5; font-size: 0.75em; margin-top: 0.5rem;">Não lembro minha senha</a>
    </div>
</div>
<?= $this->endSection() ?>
