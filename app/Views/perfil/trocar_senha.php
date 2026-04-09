<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>Definir Nova Senha — Marcosanto Foto<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
    
    <div class="col-11 col-md-5 mx-auto">

        <div class="mb-5">
            <small class="text-uppercase ls-2 text-muted d-block mb-2" style="font-size: 0.65rem;">Acesso via Link Seguro</small>
            <h1 class="h5 text-white" style="font-family: 'EB Garamond', serif; font-style: italic;">Defina sua senha</h1>
            <p class="text-muted small mt-2">Você entrou pelo link enviado por e-mail.<br>Aproveite para criar uma senha definitiva para sua conta.</p>
        </div>

        <?php if (session()->has('erro')): ?>
            <div class="alert alert-warning text-center mb-4 small">
                <?= session('erro') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('perfil/salvar_senha') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3 text-start">
                <label class="text-muted text-uppercase small ls-2 d-block mb-1" style="font-size: 0.65rem;">Nova Senha</label>
                <input type="password" 
                       name="nova_senha" 
                       class="form-control rounded-0 bg-dark text-white border-secondary" 
                       placeholder="Mínimo 8 caracteres"
                       required
                       minlength="8"
                       style="background: rgba(255,255,255,0.05) !important; border-color: rgba(255,255,255,0.15) !important;">
            </div>

            <div class="mb-4 text-start">
                <label class="text-muted text-uppercase small ls-2 d-block mb-1" style="font-size: 0.65rem;">Confirmar Senha</label>
                <input type="password" 
                       name="confirmar_senha" 
                       class="form-control rounded-0 bg-dark text-white border-secondary"
                       placeholder="Repita a senha"
                       required
                       minlength="8"
                       style="background: rgba(255,255,255,0.05) !important; border-color: rgba(255,255,255,0.15) !important;">
            </div>

            <button type="submit" 
                    class="btn btn-outline-light rounded-0 text-uppercase ls-2 w-100 py-3"
                    style="font-size: 0.75rem;">
                Salvar e Entrar
            </button>
        </form>

        <div class="mt-4">
            <a href="<?= site_url('ensaios') ?>" 
               class="text-secondary text-decoration-none small text-uppercase"
               style="font-size: 0.65rem; letter-spacing: 2px;">
                Pular por agora →
            </a>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
