<?php
// admin/extras/lista_fragment.php
// Esta view é carregada via AJAX no painel quando o usuário seleciona uma caverna
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="m-0 font-weight-bold text-primary">Documentos da Caverna</h5>
    <a href="<?= base_url('admin/extras/nova/' . $ensaio_id) ?>" class="btn btn-sm btn-success shadow-sm">
        <i class="fas fa-plus"></i> Novo Documento
    </a>
</div>

<?php if (empty($paginas)): ?>
    <div class="alert alert-warning text-center">
        Pela lei do tempo e espaço, nenhum registro extra foi documentado aqui ainda.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white mb-0">
            <thead class="table-light text-uppercase text-xs font-weight-bold text-secondary">
                <tr>
                    <th width="50%">Título</th>
                    <th width="25%">Tipo</th>
                    <th width="25%" class="text-right text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paginas as $p): ?>
                    <tr>
                        <td class="align-middle fw-bold"><?= esc($p->titulo) ?></td>
                        <td class="align-middle">
                            <?php
                            $tipos = [
                                'texto_livre'   => '<span class="badge bg-secondary">Texto Livre</span>',
                                'ficha_tecnica' => '<span class="badge bg-info text-dark">Ficha Técnica</span>',
                                'biografia'     => '<span class="badge bg-primary">Biografia</span>',
                                'galeria'       => '<span class="badge bg-warning text-dark">Galeria (Vendas)</span>',
                                'compradores'   => '<span class="badge bg-dark">Compradores</span>',
                            ];
                            echo $tipos[$p->tipo] ?? '<span class="badge bg-light text-dark">Desconhecido</span>';
                            ?>
                        </td>
                        <td class="align-middle text-right text-end">
                            <a href="<?= base_url('admin/extras/editar/' . $p->id) ?>" class="btn btn-sm btn-primary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/extras/excluir/' . $p->id) ?>" class="btn btn-sm btn-danger" title="Excluir" 
                               onclick="return confirm('Tem certeza que deseja destruir estes registros definitivamente?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
