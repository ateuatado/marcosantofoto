<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/shield.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="auth-container">
    <div class="auth-box">
        <h2 class="auth-title">APRESENTE-SE</h2>
        <form action="<?= url_to('register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="auth-group">
                <label class="auth-label">E-MAIL</label>
                <input type="email" name="email" class="auth-input" value="<?= old('email') ?>" required>
            </div>
            <div class="auth-group">
                <label class="auth-label">COMO QUER SER CHAMADO?</label>
                <input type="text" name="username" class="auth-input" value="<?= old('username') ?>" required>
            </div>
            <div class="auth-group">
                <label class="auth-label">SENHA</label>
                <input type="password" name="password" class="auth-input" required>
            </div>
            <div class="auth-group">
                <label class="auth-label">CONFIRME A SENHA</label>
                <input type="password" name="password_confirm" class="auth-input" required>
            </div>
            <button type="submit" class="auth-btn">CRIAR RASTRO</button>
        </form>
        <a href="<?= url_to('login') ?>" class="auth-link">Eu já estive aqui antes</a>
    </div>
</div>
<?= $this->endSection() ?>
