<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?><?= esc($pagina->titulo ?? 'Documento') ?> — Marcosanto Foto<?= $this->endSection() ?>

<?= $this->section('header_back') ?>
<a href="<?= site_url('ensaios/santuario/' . ($ensaio->slug ?? '')) ?>" class="text-secondary text-decoration-none small text-uppercase" style="letter-spacing:2px; font-size: 0.65rem;">
    &larr; Santuário
</a>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="min-vh-100 bg-black text-white py-5 animate-fade-in">
    <div class="container py-5">
        
        <div class="mb-5 d-flex justify-content-between align-items-center">
            <a href="<?= base_url('ensaios/ver/' . $ensaio->slug) ?>" class="text-secondary text-decoration-none small text-uppercase ls-2 hover-text-white">
                &larr; Voltar para a Caverna
            </a>
            <small class="text-muted text-uppercase ls-3"><?= esc($ensaio->titulo) ?></small>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                
                <h1 class="display-5 mb-4 text-center" style="font-family: 'EB Garamond', serif;">
                    <?= esc($pagina->titulo) ?>
                </h1>
                
                <?php if(!empty($pagina->conteudo)): ?>
                    <div class="lead text-center text-muted mb-5">
                        <?= nl2br(esc($pagina->conteudo)) ?>
                    </div>
                <?php endif; ?>

                <div class="extra-content mt-5">
                    <?php 
                        // Agora passamos a $pagina inteira ou as configurações
                        $dadosView = ['config' => $pagina->configuracoes];
                        
                        switch($pagina->tipo):
                            case 'ficha_tecnica': 
                            case 'compradores':
                                // Usamos o mesmo layout para listas chave/valor
                                echo view('ensaios/extras/layout_ficha', $dadosView);
                                break;
                                
                            case 'galeria':
                                echo view('ensaios/extras/layout_galeria', $dadosView);
                                break;
                                
                            case 'biografia':
                                // Biografia geralmente é só texto, mas se tiver foto extra no JSON:
                                echo view('ensaios/extras/layout_biografia', $dadosView);
                                break;
                                
                            default:
                                // Caso genérico
                        endswitch;
                    ?>
                </div>

                <div class="mt-5 pt-5 border-top border-secondary border-opacity-10 text-center">
                    <p class="small text-muted fst-italic">Documentação Autêntica &copy; Fineart System</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
