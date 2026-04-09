<?= $this->extend('admin/layout') ?>

<?= $this->section('conteudo') ?>

<?php
    // Verifica se estamos editando ou criando
    $isEdit = isset($ensaio);
    $urlAction = $isEdit ? 'admin/atualizar' : 'admin/salvar';
    $tituloCard = $isEdit ? 'Editar Dados da Caverna' : 'Iniciar Nova Jornada';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="h5 mb-4"><?= esc($titulo ?? 'Gerenciar Ensaio') ?></h2>
        
        <div class="card border-0 shadow-sm p-4">
            <?= form_open_multipart($urlAction) ?>
                
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $ensaio->id ?>">
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label text-uppercase small text-secondary">Título do Ensaio</label>
                    <input type="text" name="titulo" class="form-control form-control-lg" 
                           placeholder="Ex: Solitude - Ana L." 
                           value="<?= $isEdit ? esc($ensaio->titulo) : old('titulo') ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-uppercase small text-secondary">Slug (URL)</label>
                    <input type="text" name="slug" class="form-control" 
                           placeholder="Ex: ana-l" 
                           value="<?= $isEdit ? esc($ensaio->slug) : old('slug') ?>" required>
                    <div class="form-text">Será o endereço: meusite.com/ensaios/<b>slug-aqui</b></div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-uppercase small text-secondary">Imagem de Capa (Card)</label>
                    
                    <?php if($isEdit && !empty($ensaio->capa_url)): ?>
                        <div class="mb-2">
                            <img src="<?= $ensaio->capa_url ?>" alt="Capa Atual" class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                            <span class="text-muted small ms-2">Capa atual (envie outra para trocar)</span>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="capa" class="form-control" accept="image/*" <?= !$isEdit ? 'required' : '' ?>>
                    <div class="form-text">Esta é a imagem redonda que aparece no aviso inicial.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-uppercase small text-secondary">Texto do Card (Aviso)</label>
                    <textarea name="resumo_card" class="form-control" rows="3" 
                              placeholder="Uma breve descrição que aparece no Hall de entrada..."><?= $isEdit ? esc($ensaio->resumo_card) : old('resumo_card') ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= site_url('admin') ?>" class="btn btn-link text-muted text-decoration-none">Cancelar</a>
                    <button type="submit" class="btn btn-dark px-5"><?= $isEdit ? 'Salvar Alterações' : 'Criar Estrutura' ?></button>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
