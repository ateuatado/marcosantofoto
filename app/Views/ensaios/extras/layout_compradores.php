<div class="row g-4">
    <div class="compradores-grid">
        <?= $conteudo ?>
    </div>
</div>

<style>
    .comprador-card {
        border: 1px solid rgba(255,255,255,0.1);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        background: linear-gradient(45deg, #111, #000);
    }
    .comprador-card img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; filter: grayscale(100%); }
    .comprador-info h6 { margin: 0; text-transform: uppercase; letter-spacing: 1px; color: #fff; }
    .comprador-info span { font-size: 0.8rem; color: #666; }
</style>
