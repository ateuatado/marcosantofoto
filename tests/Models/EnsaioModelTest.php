<?php

use App\Models\EnsaioModel;
use App\Models\EtapaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * Testes expandidos do EnsaioModel.
 *
 * Adiciona cobertura de: slug inexistente, múltiplas etapas/itens,
 * soft delete e unicidade de slug.
 */
final class EnsaioModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = null;

    // -------------------------------------------------------------------------
    // insert básico (já existia)
    // -------------------------------------------------------------------------

    public function testInsertEnsaio(): void
    {
        $model = new EnsaioModel();

        $data = [
            'titulo'      => 'Ensaio Teste',
            'slug'        => 'ensaio-teste',
            'resumo_card' => 'Resumo do ensaio de teste',
            'status'      => 'publicado',
        ];

        $id = $model->insert($data);

        $this->assertIsNumeric($id);
        $this->seeInDatabase('ensaios', ['slug' => 'ensaio-teste']);
    }

    // -------------------------------------------------------------------------
    // getEnsaioCompleto() — casos básicos e de borda
    // -------------------------------------------------------------------------

    public function testGetEnsaioCompleto(): void
    {
        $model     = new EnsaioModel();
        $etapaModel = new EtapaModel();

        $id = $model->insert([
            'titulo' => 'Completo',
            'slug'   => 'ensaio-completo',
            'status' => 'publicado',
        ]);

        $etapaModel->insert([
            'ensaio_id' => $id,
            'titulo'    => 'Etapa 1',
            'tipo'      => 'galeria',
            'ordem'     => 1,
            'direcao'   => 'frente',
        ]);

        $ensaio = $model->getEnsaioCompleto('ensaio-completo');

        $this->assertNotNull($ensaio);
        $this->assertEquals('Completo', $ensaio->titulo);
        $this->assertCount(1, $ensaio->etapas);
        $this->assertEquals('Etapa 1', $ensaio->etapas[0]->titulo);
    }

    public function testGetEnsaioCompletoSlugInexistenteRetornaNull(): void
    {
        $model    = new EnsaioModel();
        $ensaio   = $model->getEnsaioCompleto('slug-que-nao-existe');

        $this->assertNull($ensaio, 'Deve retornar null para slug inexistente.');
    }

    public function testGetEnsaioCompletoCarregaItensDeMultiplasEtapas(): void
    {
        $model      = new EnsaioModel();
        $etapaModel = new EtapaModel();
        $itemModel  = new \App\Models\ItemModel();

        $ensaioId = $model->insert([
            'titulo' => 'Multi Etapas',
            'slug'   => 'multi-etapas',
            'status' => 'publicado',
        ]);

        // 3 etapas, cada uma com 2 itens
        for ($e = 1; $e <= 3; $e++) {
            $etapaId = $etapaModel->insert([
                'ensaio_id' => $ensaioId,
                'titulo'    => "Etapa {$e}",
                'tipo'      => 'galeria',
                'ordem'     => $e,
            ]);

            for ($i = 1; $i <= 2; $i++) {
                $itemModel->insert([
                    'etapa_id' => $etapaId,
                    'tipo'     => 'texto',
                    'conteudo' => "Item {$i} da Etapa {$e}",
                    'ordem'    => $i,
                ]);
            }
        }

        $ensaio = $model->getEnsaioCompleto('multi-etapas');

        $this->assertCount(3, $ensaio->etapas, 'Deve carregar as 3 etapas.');
        foreach ($ensaio->etapas as $etapa) {
            $this->assertCount(2, $etapa->itens, 'Cada etapa deve ter 2 itens.');
        }
    }

    public function testGetEnsaioCompletoRetornaEtapasOrdenadas(): void
    {
        $model      = new EnsaioModel();
        $etapaModel = new EtapaModel();

        $ensaioId = $model->insert(['titulo' => 'Ordem', 'slug' => 'ensaio-ordem', 'status' => 'publicado']);

        // Insere em ordem invertida
        $etapaModel->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Terceira', 'tipo' => 'galeria', 'ordem' => 3]);
        $etapaModel->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Primeira', 'tipo' => 'galeria', 'ordem' => 1]);
        $etapaModel->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Segunda', 'tipo' => 'galeria', 'ordem' => 2]);

        $ensaio = $model->getEnsaioCompleto('ensaio-ordem');

        $this->assertEquals('Primeira', $ensaio->etapas[0]->titulo);
        $this->assertEquals('Segunda', $ensaio->etapas[1]->titulo);
        $this->assertEquals('Terceira', $ensaio->etapas[2]->titulo);
    }

    // -------------------------------------------------------------------------
    // Soft Delete
    // -------------------------------------------------------------------------

    public function testSoftDeleteNaoRetornaEnsaioExcluido(): void
    {
        $model = new EnsaioModel();

        $id = $model->insert(['titulo' => 'Para Deletar', 'slug' => 'para-deletar', 'status' => 'publicado']);

        // Soft delete
        $model->delete($id);

        // findAll() padrão não deve retornar o ensaio excluído
        $todos = $model->findAll();
        $slugs = array_column($todos, 'slug');

        $this->assertNotContains('para-deletar', $slugs, 'Ensaio com soft delete não deve aparecer no findAll().');
    }

    public function testWithDeletedRetornaEnsaioExcluido(): void
    {
        $model = new EnsaioModel();

        $id = $model->insert(['titulo' => 'Fantasma', 'slug' => 'ensaio-fantasma', 'status' => 'publicado']);
        $model->delete($id);

        $fantasma = $model->withDeleted()->find($id);

        $this->assertNotNull($fantasma, 'withDeleted() deve retornar o ensaio excluído logicamente.');
        $this->assertNotNull($fantasma->deleted_at);
    }

    // -------------------------------------------------------------------------
    // Unicidade de slug
    // -------------------------------------------------------------------------

    public function testInsertComSlugDuplicadoFalha(): void
    {
        $model = new EnsaioModel();

        $model->insert(['titulo' => 'Original', 'slug' => 'slug-unico', 'status' => 'publicado']);

        // O segundo insert deve falhar (retornar false ou lançar exceção dependendo da config)
        // EnsaioModel não define validação de slug único internamente,
        // mas a constraint do banco deve barrar.
        try {
            $resultado = $model->insert(['titulo' => 'Duplicado', 'slug' => 'slug-unico', 'status' => 'publicado']);
            // Se chegou aqui sem exceção, o resultado deve ser false
            $this->assertFalse((bool) $resultado, 'Insert com slug duplicado deve falhar.');
        } catch (\Exception $e) {
            // Exceção de constraint de banco também é comportamento correto
            $this->assertStringContainsStringIgnoringCase('duplicate', $e->getMessage());
        }
    }
}
