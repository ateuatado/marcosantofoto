<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>Candidatura ao Ensaio — Marcosanto Foto<?= $this->endSection() ?>
<?= $this->section('meta_desc') ?>Apresente-se. O artista precisa concordar em fazer o ensaio. Conheça as condições e envie sua candidatura.<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<style>
    .cand-secao { border-left: 1px solid rgba(255,255,255,0.07); padding-left: 2rem; margin-bottom: 3rem; }
    .cand-label { font-size: 0.6rem; letter-spacing: 4px; text-transform: uppercase; color: rgba(255,255,255,0.3); display: block; margin-bottom: 0.4rem; }
    .form-dark { background: rgba(255,255,255,0.04) !important; border: 1px solid rgba(255,255,255,0.1) !important; color: #fff !important; border-radius: 0 !important; }
    .form-dark:focus { background: rgba(255,255,255,0.07) !important; border-color: rgba(200,169,110,0.4) !important; box-shadow: none !important; outline: none; }
    .form-dark option { background: #111; }
    .hero-linha { width: 40px; height: 1px; background: #c8a96e; opacity: 0.4; margin: 1.5rem 0; }
</style>

<div class="min-vh-100 bg-black text-white">

    <!-- HERO -->
    <div class="container" style="padding-top: 130px;">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <small class="text-uppercase ls-2 text-muted d-block mb-4" style="font-size: 0.6rem; letter-spacing: 5px;">Uma proposta, não um serviço</small>
                <h1 class="display-5 mb-0" style="font-family: 'EB Garamond', serif; font-style: italic; line-height: 1.1;">
                    Apresente-se
                </h1>
                <div class="hero-linha mx-auto"></div>
                <p style="color: rgba(255,255,255,0.45); font-size: 1rem; line-height: 1.9;">
                    Este ensaio não é um serviço. Não há pacote, não há catálogo de poses.<br>
                    Há uma investigação — e ela só acontece quando o artista concorda em fazê-la.<br>
                    Para isso, você precisa se apresentar primeiro.
                </p>
            </div>
        </div>
    </div>

    <!-- CONDIÇÕES -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="mb-5">
                    <small class="text-uppercase ls-2 text-muted" style="font-size: 0.6rem; letter-spacing: 4px;">As condições</small>
                </div>

                <div class="cand-secao">
                    <h3 style="font-family: 'EB Garamond', serif; font-size: 1.2rem; color: #fff; margin-bottom: 0.5rem;">Custo de produção</h3>
                    <p style="color: rgba(255,255,255,0.45); font-size: 0.9rem; line-height: 1.9;">
                        O ensaio não é comercial — não é uma sessão de fotos vendida como serviço. 
                        Porém, há um custo real de produção: estúdio, tempo e material. 
                        Esse custo é discutido de forma transparente antes do encontro, 
                        e pode ser negociado caso a caso conforme o contexto.
                    </p>
                </div>

                <div class="cand-secao">
                    <h3 style="font-family: 'EB Garamond', serif; font-size: 1.2rem; color: #fff; margin-bottom: 0.5rem;">O artista precisa concordar</h3>
                    <p style="color: rgba(255,255,255,0.45); font-size: 0.9rem; line-height: 1.9;">
                        Não basta querer ser fotografado. O trabalho exige que o artista reconheça 
                        algo na história de quem se apresenta — algo que valha ser investigado com 
                        seriedade e permanência. Por isso, a candidatura é necessária: ela é 
                        a primeira conversa.
                    </p>
                </div>

                <div class="cand-secao">
                    <h3 style="font-family: 'EB Garamond', serif; font-size: 1.2rem; color: #fff; margin-bottom: 0.5rem;">Uma história de luta</h3>
                    <p style="color: rgba(255,255,255,0.45); font-size: 0.9rem; line-height: 1.9;">
                        O critério central não é estético. O trabalho interessa-se por pessoas 
                        que tenham vivido — ou que ativamente vivam — alguma forma de resistência: 
                        contra opressões, a favor de minorias, em defesa de grupos vulneráveis. 
                        Sua trajetória, sua causa, sua presença no mundo são o material 
                        de partida da investigação.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- FORMULÁRIO -->
    <div class="container pb-5" id="formulario">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="mb-5" style="border-top: 1px solid rgba(255,255,255,0.06); padding-top: 3rem;">
                    <small class="text-uppercase ls-2 text-muted" style="font-size: 0.6rem; letter-spacing: 4px;">Candidatura</small>
                    <h2 class="mt-2" style="font-family: 'EB Garamond', serif; font-size: 1.5rem; font-weight: 400; color: rgba(255,255,255,0.8);">
                        Quem é você?
                    </h2>
                </div>

                <?php if (session()->has('sucesso')): ?>
                    <div class="py-5 text-center" style="border: 1px solid rgba(200,169,110,0.2);">
                        <p style="font-family: 'EB Garamond', serif; font-style: italic; font-size: 1.3rem; color: rgba(200,169,110,0.8);">
                            <?= session('sucesso') ?>
                        </p>
                        <p style="color: rgba(255,255,255,0.3); font-size: 0.8rem;">
                            Entraremos em contato pelo e-mail informado caso haja interesse em avançar.
                        </p>
                    </div>
                <?php else: ?>

                    <?php if (session()->has('erros')): ?>
                        <div class="mb-4 p-3" style="border-left: 2px solid rgba(200,100,100,0.5); background: rgba(200,100,100,0.05);">
                            <?php foreach (session('erros') as $erro): ?>
                                <p class="mb-1 small" style="color: rgba(255,150,150,0.7);"><?= esc($erro) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('candidatura/enviar') ?>" method="POST" novalidate>
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label class="cand-label">Nome completo *</label>
                            <input type="text" name="nome" class="form-control form-dark"
                                   value="<?= old('nome') ?>" required placeholder="Como prefere ser chamado(a)">
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="cand-label">E-mail *</label>
                                <input type="email" name="email" class="form-control form-dark"
                                       value="<?= old('email') ?>" required placeholder="seu@email.com">
                            </div>
                            <div class="col-md-6">
                                <label class="cand-label">Telefone / WhatsApp</label>
                                <input type="text" name="telefone" class="form-control form-dark"
                                       value="<?= old('telefone') ?>" placeholder="(11) 91234-5678">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="cand-label">Data de nascimento</label>
                                <input type="date" name="nascimento" class="form-control form-dark"
                                       value="<?= old('nascimento') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="cand-label">Como se identifica</label>
                                <input type="text" name="sexo" class="form-control form-dark"
                                       value="<?= old('sexo') ?>" placeholder="Livre: mulher, homem, não-binário...">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="cand-label">Redes sociais</label>
                            <textarea name="redes_sociais" class="form-control form-dark" rows="2"
                                      placeholder="Instagram, LinkedIn, site pessoal... (um por linha)"><?= old('redes_sociais') ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="cand-label">Currículo Lattes <span style="opacity: 0.5;">(se tiver)</span></label>
                            <input type="url" name="lattes" class="form-control form-dark"
                                   value="<?= old('lattes') ?>" placeholder="http://lattes.cnpq.br/...">
                        </div>

                        <div class="mb-5">
                            <label class="cand-label">Sua história <span style="opacity: 0.5;">(opcional, mas bem-vinda)</span></label>
                            <textarea name="historia" class="form-control form-dark" rows="6"
                                      placeholder="Conte brevemente sobre sua trajetória, sua causa, o que te move. Não precisa ser formal — pode ser em primeira pessoa, como preferir."><?= old('historia') ?></textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-outline-light rounded-0 text-uppercase ls-2 w-100 py-3"
                                style="font-size: 0.7rem; letter-spacing: 3px;">
                            Enviar Candidatura
                        </button>

                        <p class="text-center mt-3" style="color: rgba(255,255,255,0.2); font-size: 0.65rem;">
                            Não respondemos a todas as candidaturas. Se houver interesse, entraremos em contato.
                        </p>

                    </form>

                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
