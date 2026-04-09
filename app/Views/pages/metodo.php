<?= $this->extend('layout/main') ?>

<?= $this->section('titulo') ?>O Método — Marcosanto Foto<?= $this->endSection() ?>
<?= $this->section('meta_desc') ?>Cinco atos, dois autores, uma investigação. Conheça o processo por trás dos ensaios fotográficos de Marco Santo.<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<style>
    .metodo-secao { border-left: 1px solid rgba(255,255,255,0.07); padding-left: 2.5rem; margin-bottom: 4rem; position: relative; }
    .metodo-num   { position: absolute; left: -1.2rem; top: -0.2rem; font-family: 'EB Garamond', serif; font-style: italic; font-size: 2.5rem; color: rgba(200,169,110,0.25); line-height: 1; user-select: none; }
    .metodo-ato   { font-size: 0.6rem; letter-spacing: 4px; text-transform: uppercase; color: #c8a96e; opacity: 0.8; display: block; margin-bottom: 0.5rem; }
    .metodo-titulo { font-family: 'EB Garamond', serif; font-style: italic; font-size: 2rem; color: #fff; margin-bottom: 1rem; line-height: 1.2; }
    .metodo-texto { color: rgba(255,255,255,0.55); line-height: 1.9; font-size: 1rem; }

    .pacto-item { border-top: 1px solid rgba(255,255,255,0.07); padding: 2rem 0; }
    .pacto-item:last-child { border-bottom: 1px solid rgba(255,255,255,0.07); }
    .pacto-titulo { font-family: 'EB Garamond', serif; font-size: 1.2rem; color: #fff; margin-bottom: 0.5rem; }
    .pacto-texto { color: rgba(255,255,255,0.5); font-size: 0.9rem; line-height: 1.8; }

    .hero-linha { width: 40px; height: 1px; background: #c8a96e; opacity: 0.4; margin: 1.5rem 0; }
</style>

<div class="min-vh-100 bg-black text-white">

    {{-- HERO --}}
    <div class="container py-5" style="padding-top: 120px !important;">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <small class="text-uppercase ls-2 text-muted d-block mb-4" style="font-size: 0.6rem; letter-spacing: 5px;">Investigação em Fine Art</small>
                <h1 class="display-4 mb-0" style="font-family: 'EB Garamond', serif; font-style: italic; line-height: 1.1;">
                    O Método
                </h1>
                <div class="hero-linha mx-auto"></div>
                <p class="text-muted" style="font-size: 1.05rem; line-height: 1.9; color: rgba(255,255,255,0.45) !important;">
                    Um ensaio fotográfico fine art não é uma sessão de fotos.<br>
                    É uma investigação sobre identidade, conduzida em conjunto.<br>
                    Este é o protocolo que governa esse encontro.
                </p>
            </div>
        </div>
    </div>

    {{-- OS 5 ATOS --}}
    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-md-7">

                <div class="mb-5 pb-3">
                    <small class="text-uppercase ls-2 text-muted" style="font-size: 0.6rem; letter-spacing: 5px;">Estrutura do Encontro</small>
                    <h2 class="mt-2" style="font-family: 'EB Garamond', serif; font-size: 1.4rem; font-weight: 400; color: rgba(255,255,255,0.7);">Cinco Atos. Aproximadamente seis horas.</h2>
                </div>

                <div class="metodo-secao">
                    <span class="metodo-num">I</span>
                    <span class="metodo-ato">Ato I</span>
                    <h3 class="metodo-titulo">Observação</h3>
                    <p class="metodo-texto">
                        O encontro começa antes das câmeras. A primeira hora é de conversa, 
                        de presença, de aprender o ritmo do outro. As imagens produzidas aqui 
                        não são mostradas imediatamente — esse veto à visualização imediata 
                        preserva a espontaneidade e protege o estado de naturalidade que é 
                        impossível de fabricar depois.
                    </p>
                </div>

                <div class="metodo-secao">
                    <span class="metodo-num">II</span>
                    <span class="metodo-ato">Ato II</span>
                    <h3 class="metodo-titulo">Espelho</h3>
                    <p class="metodo-texto">
                        A câmera passa a exibir em tempo real. O retratado se vê sendo visto. 
                        Isso muda tudo — surgem reações, surpresas, resistências, descobertas. 
                        Essas percepções não são descartadas; elas entram no material, 
                        tornam-se parte da narrativa. O processo de ser fotografado passa a ser 
                        também o conteúdo fotográfico.
                    </p>
                </div>

                <div class="metodo-secao">
                    <span class="metodo-num">III</span>
                    <span class="metodo-ato">Ato III</span>
                    <h3 class="metodo-titulo">Construção</h3>
                    <p class="metodo-texto">
                        Pausa para análise. O material produzido até aqui é revisado em conjunto. 
                        Define-se o norte emocional e visual da obra — não por imposição técnica, 
                        mas por decisão compartilhada. Referências estéticas são escolhidas. 
                        O que será e o que não será a obra começa a tomar forma a partir 
                        de duas perspectivas iguais.
                    </p>
                </div>

                <div class="metodo-secao">
                    <span class="metodo-num">IV</span>
                    <span class="metodo-ato">Ato IV</span>
                    <h3 class="metodo-titulo">Fina Arte</h3>
                    <p class="metodo-texto">
                        Com o norte estabelecido, a execução se aprofunda. Luz, sombra, 
                        composição. A referência é a pintura clássica — não como pastiche, 
                        mas como compromisso com a permanência. O corpo é território de 
                        investigação, não de decoração. Nenhum padrão comercial, nenhum 
                        critério editorial externo orienta o enquadramento.
                    </p>
                </div>

                <div class="metodo-secao">
                    <span class="metodo-num">V</span>
                    <span class="metodo-ato">Ato V</span>
                    <h3 class="metodo-titulo">Curadoria</h3>
                    <p class="metodo-texto">
                        O quinto ato acontece em um segundo encontro, posterior ao primeiro. 
                        O material é revisto com um olhar renovado — o que a imediatez do 
                        estúdio não permite ver. Juntos, selecionamos e organizamos a narrativa 
                        final. Essa distância temporal não é burocracia: é parte essencial 
                        do processo de fazer arte com integridade.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- PACTO DE COAUTORIA --}}
    <div class="container py-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="mb-5 pb-3">
                    <small class="text-uppercase ls-2 text-muted" style="font-size: 0.6rem; letter-spacing: 5px;">Fundamentos</small>
                    <h2 class="mt-2" style="font-family: 'EB Garamond', serif; font-size: 1.4rem; font-weight: 400; color: rgba(255,255,255,0.7);">O Pacto de Coautoria</h2>
                    <p class="text-muted mt-3" style="font-size: 0.9rem; line-height: 1.8; color: rgba(255,255,255,0.4) !important;">
                        Este não é um pacto jurídico. É um compromisso ético que antecede e supera qualquer contrato.<br>
                        Ele existe para proteger o que é mais difícil de recuperar: a confiança e a integridade da obra.
                    </p>
                </div>

                <div class="pacto-item">
                    <h3 class="pacto-titulo">Parceria Conjunta</h3>
                    <p class="pacto-texto">
                        Este trabalho nasce de um encontro entre dois sujeitos ativos — não de 
                        uma relação entre criador e objeto. O retratado contribui com presença, 
                        história, corpo e tempo; o fotógrafo com escuta, técnica e visão. 
                        As condições de uso, publicação e direitos sobre a obra são definidas 
                        em acordo explícito entre as partes, caso a caso, antes da realização 
                        do ensaio.
                    </p>
                </div>

                <div class="pacto-item">
                    <h3 class="pacto-titulo">Soberania da Imagem</h3>
                    <p class="pacto-texto">
                        Nenhuma peça — nem o material de processo — é publicada, exibida ou 
                        compartilhada sem acordo mútuo explícito. Cada parte tem direito de veto 
                        irrestrito sobre qualquer uso de qualquer imagem produzida. 
                        Esse veto não precisa ser justificado.
                    </p>
                </div>

                <div class="pacto-item">
                    <h3 class="pacto-titulo">Natureza da Obra</h3>
                    <p class="pacto-texto">
                        Este projeto não é um ensaio de beleza convencional. Não é editorial de moda, 
                        não é ensaio de vaidade, não é produto. É uma investigação artística honesta 
                        sobre identidade e presença. Sem padrões estéticos externos impostos. 
                        Sem retoque que apague o que é real. O foco é o que existe, não o que 
                        deveria existir.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- CTA FINAL --}}
    <div class="container py-5 mb-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="hero-linha mx-auto"></div>
                <p class="text-muted mb-4" style="font-size: 0.85rem; line-height: 1.9; color: rgba(255,255,255,0.35) !important;">
                    Se este processo ressoa com o que você busca,<br>
                    os ensaios estão à sua espera.
                </p>
                <a href="<?= site_url('ensaios') ?>" 
                   class="btn btn-outline-light rounded-0 text-uppercase ls-2 px-5 py-3"
                   style="font-size: 0.7rem; letter-spacing: 3px;">
                    Ver os Ensaios
                </a>
                <div class="mt-4">
                    <a href="<?= site_url('candidatura') ?>"
                       style="color: rgba(200,169,110,0.5); font-family: 'EB Garamond', serif; font-style: italic; font-size: 1rem; text-decoration: none;"
                       onmouseover="this.style.color='rgba(200,169,110,1)'"
                       onmouseout="this.style.color='rgba(200,169,110,0.5)'">
                        Quero participar de um ensaio →
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
