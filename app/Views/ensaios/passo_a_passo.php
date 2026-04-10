<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?><?= esc($ensaio->titulo ?? 'Ensaio') ?> — Marcosanto Foto<?= $this->endSection() ?>

<?= $this->section('header_back') ?>
<a href="<?= site_url('ensaios') ?>" class="text-secondary text-decoration-none small text-uppercase" style="letter-spacing:2px; font-size: 0.65rem;">
    &larr; Obras
</a>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<div class="d-flex flex-column min-vh-100 bg-black animate-fade-in palco-transicao" style="overflow-x: hidden;">
    
    <?php if (isset($etapa) && is_object($etapa) && isset($etapa->audio_url) && $etapa->audio_url): ?>
        <audio id="audioSala" loop>
            <source src="<?= $etapa->audio_url ?>" type="audio/mpeg">
        </audio>

        <div class="position-fixed bottom-0 start-0 p-4" style="z-index: 1050;">
            <button id="toggleSom" type="button" class="btn btn-link text-secondary p-0 text-decoration-none d-flex align-items-center gap-2 opacity-50 hover-opacity-100 transition">
                <span id="iconSom"><i class="bi bi-volume-mute fs-4"></i></span>
                <small class="text-uppercase ls-1" style="font-size: 0.6rem;">Som da Câmara</small>
            </button>
        </div>
    <?php endif; ?>

    <div class="progress" style="height: 2px;">
        <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%; opacity: 0.1;"></div>
    </div>

    <div class="flex-grow-1 d-flex flex-column justify-content-center py-5">
        <div class="container">
            
            <div class="text-center mb-5 fade-in-up">
                <small class="text-uppercase ls-2 text-muted mb-2 d-block">
                    <?= esc($ensaio->titulo) ?>
                </small>
                
                <?php if(isset($etapa->titulo) && $etapa->titulo): ?>
                    <h1 class="display-6 text-white" style="font-family: 'EB Garamond', serif;">
                        <?= esc($etapa->titulo) ?>
                    </h1>
                <?php endif; ?>
                
                <?php if(isset($etapa->descricao) && $etapa->descricao): ?>
                    <p class="text-secondary fst-italic mt-2"><?= esc($etapa->descricao) ?></p>
                <?php endif; ?>
            </div>

            <div class="row g-5 justify-content-center align-items-center">
                <?php if(!empty($etapa->itens)): ?>
                    <?php foreach($etapa->itens as $item): ?>
                        
                        <div class="<?= esc($item->classe_css) ?> fade-in-item position-relative grupo-obra">
                            
                            <?php if($item->tipo == 'foto'): ?>
                                <img src="<?= esc($item->conteudo) ?>" class="img-fluid shadow-lg rounded-1" alt="<?= esc(!empty($item->titulo) ? $item->titulo : 'Obra fine art do ensaio ' . $ensaio->titulo) ?>" loading="lazy">
                                <?php 
                                    $idFormatado = '#' . str_pad($item->id, 4, '0', STR_PAD_LEFT);
                                    $tituloComercial = !empty($item->titulo) ? $item->titulo : 'Obra Sem Título';
                                    
                                    // BLINDAGEM: Prepara o JSON de forma segura
                                    $dadosJson = json_encode([
                                        "src" => $item->conteudo,
                                        "id" => $idFormatado,
                                        "titulo" => $tituloComercial,
                                        "db_id" => $item->id
                                    ]);
                                ?>
                                
                                <button type="button" class="btn-info-obra" 
                                        data-info='<?= esc($dadosJson, 'attr') ?>'
                                        onclick="abrirFichaObra(JSON.parse(this.getAttribute('data-info')), this)">
                                    <span class="font-serif fst-italic">i</span>
                                </button>

                                <?php if($item->legenda): ?>
                                    <p class="text-center small text-muted mt-2 fst-italic"><?= esc($item->legenda) ?></p>
                                <?php endif; ?>

                            <?php elseif($item->tipo == 'texto'): ?>
                                <div class="text-justify px-md-5 fs-5 leading-loose" style="color: #ccc; font-family: 'EB Garamond', serif;">
                                    <?= nl2br(esc($item->conteudo)) ?>
                                </div>
                            <?php elseif($item->tipo == 'citacao'): ?>
                                <blockquote class="blockquote text-center border-start border-end border-secondary border-opacity-25 py-4 px-5">
                                    <p class="mb-0 fst-italic fs-3 text-white">"<?= esc($item->conteudo) ?>"</p>
                                </blockquote>
                            <?php elseif($item->tipo == 'video'): ?>
                                <div class="ratio ratio-16x9 border border-secondary border-opacity-25">
                                    <iframe src="<?= esc($item->conteudo) ?>" allowfullscreen></iframe>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Este nível está vazio.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container py-5 mt-5">
        <?php if (!empty($proximasEtapas)): ?>
            <div class="text-center animate-on-scroll">
                <p class="text-muted text-uppercase ls-2 small mb-4">Aprofunde-se</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <?php foreach ($proximasEtapas as $prox): ?>
                        <?php $direcao = $prox->direcao ?? 'frente'; ?>
                        
                        <a href="<?= base_url("ensaios/ver/{$ensaio->slug}/{$prox->id}") ?>" 
                           class="btn btn-outline-light border-opacity-25 px-5 py-3 rounded-0 text-uppercase ls-2 btn-direcao transition"
                           data-direcao="<?= esc($direcao) ?>">
                            
                           <?php if($direcao == 'lado'): ?>
                               <?= esc($prox->decisao_texto ?: $prox->titulo) ?> &rarr;
                           <?php else: ?>
                               <?= esc($prox->decisao_texto ?: $prox->titulo) ?> &darr;
                           <?php endif; ?>

                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            
            <div class="text-center animate-on-scroll py-5 border-top border-secondary border-opacity-10">
                
                <?php if (isset($idRetornoBifurcacao) && $idRetornoBifurcacao): ?>
                    <h3 class="font-serif fst-italic text-white mb-4">Esta variante se encerra aqui.</h3>
                    <a href="<?= site_url("ensaios/ver/{$ensaio->slug}/{$idRetornoBifurcacao}") ?>" 
                       class="btn btn-outline-light px-5 py-3 rounded-0 text-uppercase ls-3 btn-direcao"
                       data-direcao="voltar"> 
                       Voltar ao Ensaio
                    </a>
                <?php else: ?>
                    <h3 class="font-serif fst-italic text-white mb-4">A jornada termina aqui.</h3>
                    <a href="<?= base_url("ensaios/santuario/{$ensaio->slug}") ?>" 
                       class="btn btn-primary px-5 py-3 rounded-0 text-uppercase ls-3 btn-direcao"
                       data-direcao="frente">
                       Emergir para a Contemplação
                    </a>
                <?php endif; ?>
                
            </div>

        <?php endif; ?>

        <?php 
        $ehFimLateral = empty($proximasEtapas) && !empty($idRetornoBifurcacao);
        if (!empty($etapa->parent_id) && !$ehFimLateral): 
        ?>
            <div class="mt-5 pt-3 border-top border-secondary border-opacity-10 text-center">
                <a href="<?= site_url("ensaios/ver/{$ensaio->slug}/{$etapa->parent_id}") ?>" 
                   class="text-secondary small text-decoration-none text-uppercase ls-1 hover-text-white">
                    &uarr; Retornar à câmara anterior
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="overlayObra" class="d-none">
    <div class="overlay-backdrop" onclick="fecharFichaObra()"></div>
    <div class="ficha-tecnica-modal animate-fade-in">
        <button type="button" class="btn-fechar-ficha" onclick="fecharFichaObra()">&times;</button>
        
        <div class="row g-0 h-100">
            <div class="col-md-5 d-none d-md-block bg-black position-relative">
                <img id="imgFicha" src="" class="img-fluid w-100 h-100 object-fit-cover opacity-50">
            </div>
            
            <div class="col-md-7 p-5 d-flex flex-column justify-content-center bg-dark text-white position-relative">
                
                <div id="areaFicha">
                    <small class="text-uppercase ls-2 text-warning mb-4 d-block">Informação do Catálogo</small>
                    <span class="d-block text-muted x-small text-uppercase ls-1 mb-1">Nome da Obra</span>
                    <h3 id="tituloFicha" class="font-serif fst-italic mb-4 display-6"></h3>
                    
                    <div class="border-top border-bottom border-secondary border-opacity-25 py-3 my-3">
                        <div class="row g-3">
                            <div class="col-6">
                                <span class="d-block text-muted x-small text-uppercase ls-1">Catalogação</span>
                                <span id="idFicha" class="font-monospace text-white small"></span>
                            </div>
                            <div class="col-6">
                                <span class="d-block text-muted x-small text-uppercase ls-1">Dimensão Máxima</span>
                                <span id="dimensaoFicha" class="text-white small fw-bold text-info">Calculando...</span>
                            </div>
                            <div class="col-6">
                                <span class="d-block text-muted x-small text-uppercase ls-1">Impressão</span>
                                <span class="text-white small">Pigmento Mineral</span>
                            </div>
                            <div class="col-6">
                                <span class="d-block text-muted x-small text-uppercase ls-1">Papel</span>
                                <span class="text-white small">Hahnemühle 308g</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" onclick="mostrarFormulario()" class="btn btn-outline-light rounded-0 text-uppercase ls-2 w-100 py-3">
                            Consultar Aquisição
                        </button>
                        <small class="d-block text-center text-muted mt-2 x-small">
                            Esta obra faz parte do acervo "<?= esc($ensaio->titulo) ?>"
                        </small>
                    </div>
                </div>

                <div id="areaFormulario" class="d-none fade-in-up">
                    <button type="button" onclick="voltarFicha()" class="btn btn-link text-muted text-decoration-none p-0 mb-3 small">
                        &larr; Voltar aos detalhes
                    </button>
                    
                    <h3 class="font-serif fst-italic text-white mb-3">Interesse na Obra</h3>
                    <p class="text-muted small mb-4">Deixe seus dados. Nossa curadoria entrará em contato.</p>

                    <form id="formAquisicao" onsubmit="enviarInteresse(event)">
                        <?= csrf_field() ?>
                        <input type="hidden" name="ensaio_id" value="<?= $ensaio->id ?>">
                        <input type="hidden" name="item_id" id="inputItemId">
                        
                        <div class="mb-3">
                            <label class="d-block mb-1" style="font-size:0.6rem;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.35);">Seu nome *</label>
                            <input type="text" name="nome" class="form-control rounded-0 bg-dark text-white border-secondary" placeholder="Como deseja ser chamado(a)" required>
                        </div>
                        <div class="mb-3">
                            <label class="d-block mb-1" style="font-size:0.6rem;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.35);">E-mail *</label>
                            <input type="email" name="email_contato" class="form-control rounded-0 bg-dark text-white border-secondary" placeholder="seu@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="d-block mb-1" style="font-size:0.6rem;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.35);">Telefone / WhatsApp *</label>
                            <input type="tel" name="telefone" class="form-control rounded-0 bg-dark text-white border-secondary" placeholder="(11) 91234-5678" required>
                        </div>
                        <div class="mb-4">
                            <label class="d-block mb-1" style="font-size:0.6rem;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.35);">Mensagem <span style="opacity:0.5;">(opcional)</span></label>
                            <textarea name="mensagem" class="form-control rounded-0 bg-dark text-white border-secondary" rows="3" placeholder="Conte mais sobre seu interesse na obra..."></textarea>
                        </div>
                        
                        <button type="submit" id="btnEnviar" class="btn btn-warning rounded-0 text-uppercase ls-2 w-100 py-3 text-dark fw-bold">
                            Enviar Solicitação
                        </button>
                    </form>


                </div>

                <div id="areaSucesso" class="d-none text-center fade-in-up">
                    <i class="bi bi-check-circle text-success display-1 mb-3"></i>
                    <h3 class="font-serif text-white mb-3">Solicitação Recebida</h3>
                    <p class="text-muted">Agradecemos o interesse. Entraremos em contato em breve.</p>
                    <button type="button" onclick="fecharFichaObra()" class="btn btn-outline-light rounded-0 text-uppercase ls-2 mt-4 px-5">
                        Voltar à Galeria
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #000; overflow-x: hidden; }
    .btn-info-obra { position: absolute; top: 20px; right: 20px; width: 35px; height: 35px; border-radius: 50%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.3); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; transform: translateY(-5px); transition: all 0.4s ease; z-index: 10; backdrop-filter: blur(4px); }
    .grupo-obra:hover .btn-info-obra { opacity: 1; transform: translateY(0); }
    .btn-info-obra:hover { background: white; color: black; border-color: white; }
    #overlayObra { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 9999; display: flex; align-items: center; justify-content: center; }
    .overlay-backdrop { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); }
    .ficha-tecnica-modal { position: relative; width: 90%; max-width: 900px; background: #111; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 50px 100px rgba(0,0,0,0.5); z-index: 10000; overflow: hidden; }
    .btn-fechar-ficha { position: absolute; top: 15px; right: 15px; background: none; border: none; color: white; font-size: 2rem; line-height: 1; cursor: pointer; z-index: 20; opacity: 0.5; transition: opacity 0.3s; }
    .btn-fechar-ficha:hover { opacity: 1; }
    .x-small { font-size: 0.7rem; }
    .object-fit-cover { object-fit: cover; }
    .palco-transicao { transition: transform 1s cubic-bezier(0.77, 0, 0.175, 1), opacity 1s ease; transform-origin: center center; opacity: 1; will-change: transform, opacity; }
    .saindo-frente { transform: scale(0.9) translateY(-50px); opacity: 0; filter: blur(5px); }
    .saindo-lado { transform: translateX(-100vw); opacity: 0.5; }
    .saindo-voltar { transform: translateX(100vw); opacity: 0; }
    .entrando { animation: fadeEnter 1.2s forwards; }
    @keyframes fadeEnter { 0% { opacity: 0; transform: scale(1.02); } 100% { opacity: 1; transform: scale(1); } }
    .fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>

<script>
const base_url = "<?= base_url() ?>";

function abrirFichaObra(dados, btn) {
    const overlay = document.getElementById('overlayObra');
    
    // Reseta visualização
    document.getElementById('areaFicha').classList.remove('d-none');
    document.getElementById('areaFormulario').classList.add('d-none');
    document.getElementById('areaSucesso').classList.add('d-none');

    document.getElementById('imgFicha').src = dados.src;
    document.getElementById('tituloFicha').innerText = dados.titulo;
    document.getElementById('idFicha').innerText = dados.id;
    document.getElementById('inputItemId').value = dados.db_id;

    let dimTexto = "Sob Consulta";
    if (btn) {
        const imgReal = btn.parentElement.querySelector('img');
        if (imgReal && imgReal.naturalWidth > 0) {
            const wPx = imgReal.naturalWidth;
            const hPx = imgReal.naturalHeight;
            const ppi = 100;
            const wMetros = (wPx / ppi * 0.0254).toFixed(2);
            const hMetros = (hPx / ppi * 0.0254).toFixed(2);
            dimTexto = `${wMetros} m x ${hMetros} m`;
        }
    }
    document.getElementById('dimensaoFicha').innerText = dimTexto;
    overlay.classList.remove('d-none');
    document.body.style.overflow = 'hidden';
}

function fecharFichaObra() {
    document.getElementById('overlayObra').classList.add('d-none');
    document.body.style.overflow = '';
}

function mostrarFormulario() {
    document.getElementById('areaFicha').classList.add('d-none');
    document.getElementById('areaFormulario').classList.remove('d-none');
}

function voltarFicha() {
    document.getElementById('areaFormulario').classList.add('d-none');
    document.getElementById('areaFicha').classList.remove('d-none');
}

async function enviarInteresse(event) {
    event.preventDefault();
    const btn = document.getElementById('btnEnviar');
    const form = document.getElementById('formAquisicao');
    
    const textoOriginal = btn.innerText;
    btn.innerText = "Enviando...";
    btn.disabled = true;

    try {
        const formData = new FormData(form);
        const response = await fetch(`${base_url}/ensaios/registrar_interesse`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const result = await response.json();
        if (result.status === 'success') {
            document.getElementById('areaFormulario').classList.add('d-none');
            document.getElementById('areaSucesso').classList.remove('d-none');
            form.reset();
        } else {
            alert('Erro: ' + result.message);
        }
    } catch (error) {
        console.error('Erro de envio:', error);
        alert('Ocorreu um erro ao enviar. Tente novamente.');
    } finally {
        btn.innerText = textoOriginal;
        btn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            const palco = document.querySelector('.palco-transicao');
            if(palco) {
                palco.classList.remove('saindo-frente', 'saindo-lado', 'saindo-voltar');
                palco.style.opacity = '1';
                palco.style.transform = 'none';
            }
        }
    });

    const palco = document.querySelector('.palco-transicao');
    if(palco) {
        palco.classList.add('entrando');
        palco.addEventListener('animationend', () => { palco.classList.remove('entrando'); }, { once: true });
    }

    const botoes = document.querySelectorAll('a.btn-direcao');
    botoes.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); 
            const url = this.href;
            const direcao = this.getAttribute('data-direcao');
            if(palco) {
                palco.classList.remove('entrando');
                if (direcao === 'lado') palco.classList.add('saindo-lado');
                else if (direcao === 'voltar') palco.classList.add('saindo-voltar');
                else palco.classList.add('saindo-frente');
            }
            setTimeout(() => { window.location.href = url; }, 900); 
        });
    });

    const audio = document.getElementById('audioSala');
    const btn = document.getElementById('toggleSom');
    const icon = document.getElementById('iconSom');
    if (audio && btn && icon) {
        const somAtivo = localStorage.getItem('caverna_som') === 'true';
        function atualizarInterface(playing) {
            icon.innerHTML = playing ? '<i class="bi bi-volume-up fs-4"></i>' : '<i class="bi bi-volume-mute fs-4"></i>';
        }
        if (somAtivo) {
            audio.play().catch(() => { atualizarInterface(false); });
            atualizarInterface(true);
        }
        btn.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
                localStorage.setItem('caverna_som', 'true');
                atualizarInterface(true);
            } else {
                audio.pause();
                localStorage.setItem('caverna_som', 'false');
                atualizarInterface(false);
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
