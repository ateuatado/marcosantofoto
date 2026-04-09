<?php // app/Views/ensaios/extras/layout_galeria.php ?>
<div class="row g-4 mt-2">
    <?php if (!empty($config) && is_array($config)): ?>
        <?php foreach ($config as $index => $item): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 bg-dark text-white border-secondary shadow-sm hover-shadow transition-all">
                    <?php if(!empty($item->img)): ?>
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img src="<?= esc($item->img) ?>" class="card-img-top w-100 h-100 object-fit-cover" alt="<?= esc($item->titulo ?? 'Obra') ?>">
                            
                            <?php if(isset($item->status)): ?>
                                <div class="position-absolute top-0 end-0 p-2">
                                    <?php 
                                        $badgeClass = 'bg-success';
                                        if($item->status == 'vendido') $badgeClass = 'bg-danger';
                                        if($item->status == 'reservado') $badgeClass = 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?= $badgeClass ?> text-uppercase shadow-sm border border-light border-opacity-25">
                                        <?= esc($item->status) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title text-uppercase ls-1 mb-3" style="font-family: 'EB Garamond', serif;"><?= esc($item->titulo ?? 'Sem Título') ?></h5>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-end">
                            <?php if(!empty($item->preco)): ?>
                                <div class="text-success fw-bold fs-5"><?= esc($item->preco) ?></div>
                            <?php endif; ?>
                            
                            <?php if(isset($item->status) && $item->status == 'disponivel'): ?>
                                <button class="btn btn-sm btn-outline-light text-uppercase ls-1 px-3" onclick="registrarInteresse(<?= htmlspecialchars(json_encode($item)) ?>)">Tenho Interesse</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center text-muted">
            <p>Nenhuma estampa ou obra documentada nesta galeria.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function registrarInteresse(item) {
    if(confirm('Deseja iniciar negociação sobre a obra "' + item.titulo + '"?')) {
        alert('Este é um ambiente simulado. Num ambiente real abriria um form de contato ou chamaria AJAX AdminExtras::registrar_interesse() passando item.id (ou título).');
    }
}
</script
