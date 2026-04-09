<?php // app/Views/ensaios/extras/layout_ficha.php ?>
<div class="card bg-dark border-secondary bg-opacity-50 shadow-lg">
    <div class="card-body p-5">
        <h4 class="text-white mb-4 text-uppercase ls-2 border-bottom border-secondary pb-3 fs-5">Dados</h4>
        
        <?php if (!empty($config) && is_array($config)): ?>
            <ul class="list-group list-group-flush bg-transparent">
                <?php foreach ($config as $item): ?>
                    <li class="list-group-item bg-transparent text-white border-secondary d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted fw-bold text-uppercase small ls-1"><?= esc($item->chave ?? '') ?></span>
                        <span class="fs-6"><?= esc($item->valor ?? '') ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted fst-italic">Nenhum dado catalogado.</p>
        <?php endif; ?>
    </div>
</div>
