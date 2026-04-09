<?php // app/Views/ensaios/extras/layout_biografia.php ?>
<?php if (!empty($config)): ?>
<div class="row align-items-center mb-5">
    <?php foreach($config as $item): ?>
        <?php if(isset($item->chave) && $item->chave == "Foto"): ?> <!-- Exemplo de uso pro futuro caso a biografia use a key chave -->
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="<?= esc($item->valor) ?>" class="img-fluid rounded-circle shadow border border-secondary border-opacity-25" style="max-height: 250px; width: 250px; object-fit: cover;" alt="Foto Biográfica">
            </div>
        <?php else: ?>
            <div class="col-md-8">
                <p class="lead text-light"><?= isset($item->valor) ? esc($item->valor) : '' ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>
