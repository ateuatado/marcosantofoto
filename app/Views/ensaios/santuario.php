<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>Santuário: <?= esc($ensaio->titulo ?? '') ?> — Marcosanto Foto<?= $this->endSection() ?>

<?= $this->section('header_back') ?>
<a href="<?= site_url('ensaios') ?>" class="text-white text-decoration-none small text-uppercase" style="letter-spacing:2px; font-size: 0.65rem; opacity: 0.6;">
    &larr; Obras
</a>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<style>
    /* Transição cromática: Roxo -> Lilás -> Azul */
    .bg-santuario {
        background: linear-gradient(180deg, #1a0b2e 0%, #4a2c6d 35%, #5a67d8 75%, #3182ce 100%);
        min-height: 100vh;
        color: white;
    }

    /* A Moldura e o Paspatur */
    .moldura-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 6rem;
    }

    .hero-moldura {
        /* Tons sugeridos: 
           #faf9f6 (Off-white neutro)
           #fffaf0 (Floral White - levemente quente)
           #fdf5e6 (Old Lace - tom de papel clássico) 
        */
        background: #fdf5e6; 
        
        padding: 80px;       
        border: 20px solid #0a0a0a; 
        box-shadow: 
            0 50px 100px rgba(0,0,0,0.5),
            inset 0 0 15px rgba(0,0,0,0.05); /* Sombra interna ainda mais suave para o tom amarelado */
        display: inline-block;
        position: relative;
    }

    .hero-moldura img {
        max-height: 45vh; 
        width: auto;
        display: block;
        /* Simula que a foto está um pouco "atrás" do paspatur */
        box-shadow: 0 0 20px rgba(0,0,0,0.2); 
    }

    .card-mural {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        transition: all 0.5s ease;
        cursor: pointer;
    }

    .card-mural:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-10px);
    }

    /* Overlay do Santuário com Transparência Real */
    #santuarioOverlay {
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        /* Reduzido de 0.98 para 0.85 para permitir a visão do fundo */
        background: rgba(26, 11, 46, 0.5); 
        
        /* O segredo da transparência com desfoque */
        -webkit-backdrop-filter: blur(20px); 
        backdrop-filter: blur(20px);
        
        z-index: 2000;
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
        overflow-y: auto;
    }

    /* Ajuste para que o conteúdo do modal se destaque sobre o fundo translúcido */
    .modal-body-custom {
        padding: 60px 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.7);
    }
    #santuarioOverlay.active { display: block; opacity: 1; }
    
    .btn-fechar-overlay {
        position: fixed; top: 30px; right: 30px;
        background: none; border: 1px solid rgba(255,255,255,0.3);
        color: white; padding: 10px 20px; text-transform: uppercase;
        letter-spacing: 2px; font-size: 0.8rem;
    }

    .font-serif { font-family: 'EB Garamond', serif; }
    .ls-3 { letter-spacing: 3px; }

    /* Estilo Rótulo de Museu */
.label-museu-item {
    margin-bottom: 2.5rem;
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    padding-left: 1.5rem;
}

.label-museu-key {
    font-family: 'Inter', sans-serif; /* Ou qualquer sans-serif limpa */
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 0.65rem;
    color: rgba(255, 255, 255, 0.4);
    display: block;
    margin-bottom: 0.5rem;
}

.label-museu-val {
    font-family: 'EB Garamond', serif;
    font-style: italic;
    font-size: 1.4rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.2;
}
</style>

<div class="bg-santuario py-5 animate-fade-in">
    <div class="container py-5 text-center">
        
        <div class="mb-5 pb-5">
            <small class="text-uppercase ls-3 opacity-50 d-block mb-3">Materizalização da Arte</small>
            <h1 class="display-3 font-serif fst-italic"><?= esc($ensaio->titulo) ?></h1>
        </div>

        <div class="moldura-container">
            <div class="hero-moldura">
                <img src="<?= esc($fotoEstrela) ?>" alt="Obra Fineart">
            </div>
        </div>

        <div class="row g-4 justify-content-center text-start">
            <?php if (!empty($extras)): ?>
                <?php foreach($extras as $extra): ?>
                    <div class="col-md-5">
                        <div class="card-mural p-5 h-100" onclick="abrirDetalhe('extra-<?= $extra->id ?>')">
                            <small class="text-info text-uppercase ls-2 d-block mb-3 opacity-75">
                                <?= esc(str_replace('_', ' ', $extra->tipo)) ?>
                            </small>
                            <h4 class="font-serif mb-4"><?= esc($extra->titulo) ?></h4>
                            <div class="mt-auto pt-3 border-top border-white border-opacity-10">
                                <span class="small text-uppercase ls-2 opacity-50">Toque para aprofundar &rarr;</span>
                            </div>
                        </div>

                        <div id="extra-<?= $extra->id ?>" class="d-none">
                            <h2 class="font-serif display-5 mb-4"><?= esc($extra->titulo) ?></h2>
                            <div class="opacity-75">
                                <?php if(!empty($extra->configuracoes)): ?>
                                    <?php if($extra->tipo == 'galeria'): ?>
                                        <?= view('ensaios/extras/layout_galeria', ['config' => $extra->configuracoes]) ?>
                                    <?php else: ?>
                                        <?= view('ensaios/extras/layout_ficha', ['config' => $extra->configuracoes]) ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?= nl2br(esc($extra->conteudo)) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="mt-5 pt-5 opacity-50">
            <a href="<?= base_url('ensaios') ?>" class="text-white text-decoration-none small text-uppercase ls-3">
                &times; Concluir Experiência
            </a>
        </div>
    </div>
</div>

<div id="santuarioOverlay">
    <button class="btn-fechar-overlay" onclick="fecharDetalhe()">&times; Fechar</button>
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div id="conteudoDinamicoOverlay" class="col-md-8 text-white">
                </div>
        </div>
    </div>
</div>

<script>
    function abrirDetalhe(idElemento) {
        const overlay = document.getElementById('santuarioOverlay');
        const destino = document.getElementById('conteudoDinamicoOverlay');
        const origem = document.getElementById(idElemento);

        destino.innerHTML = origem.innerHTML;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; 
    }

    function fecharDetalhe() {
        const overlay = document.getElementById('santuarioOverlay');
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
</script>

<?= $this->endSection() ?>
