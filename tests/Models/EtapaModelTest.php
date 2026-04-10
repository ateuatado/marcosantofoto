<?php

namespace Tests\Models;

use App\Models\EnsaioModel;
use App\Models\EtapaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * Testes expandidos do EtapaModel.
 *
 * Adiciona cobertura de: getProximasEtapas, getEtapaAnterior,
 * bifurcação com caminhos mistos e profundidade maior que 2.
 */
class EtapaModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = null;

    private EnsaioModel $ensaioModel;
    private EtapaModel  $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ensaioModel = new EnsaioModel();
        $this->model       = new EtapaModel();
    }

    // -------------------------------------------------------------------------
    // getPrimeiraEtapa() — já existia, mantido
    // -------------------------------------------------------------------------

    public function testGetPrimeiraEtapa(): void
    {
        $ensaioId = $this->ensaioModel->insert([
            'titulo' => 'Ensaio FK',
            'slug'   => 'ensaio-fk',
            'status' => 'publicado',
        ]);

        $idRaiz = $this->model->insert([
            'ensaio_id' => $ensaioId,
            'titulo'    => 'Raiz',
            'parent_id' => null,
            'tipo'      => 'galeria',
            'ordem'     => 1,
        ]);

        $this->model->insert([
            'ensaio_id' => $ensaioId,
            'titulo'    => 'Secundaria',
            'parent_id' => $idRaiz,
            'tipo'      => 'texto',
            'ordem'     => 2,
        ]);

        $primeira = $this->model->getPrimeiraEtapa($ensaioId);

        $this->assertNotNull($primeira);
        $this->assertEquals('Raiz', $primeira->titulo);
        $this->assertEquals($idRaiz, $primeira->id);
    }

    // -------------------------------------------------------------------------
    // getProximasEtapas()
    // -------------------------------------------------------------------------

    public function testGetProximasEtapasRetornaFilhosOrdenados(): void
    {
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Pais Filhos', 'slug' => 'pais-filhos', 'status' => 'publicado']);

        $troncoId = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Tronco', 'parent_id' => null, 'ordem' => 1]);

        // Insere filhos em ordem embaralhada
        $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Filho C', 'parent_id' => $troncoId, 'ordem' => 3]);
        $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Filho A', 'parent_id' => $troncoId, 'ordem' => 1]);
        $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Filho B', 'parent_id' => $troncoId, 'ordem' => 2]);

        $proximas = $this->model->getProximasEtapas($troncoId);

        $this->assertCount(3, $proximas);
        $this->assertEquals('Filho A', $proximas[0]->titulo);
        $this->assertEquals('Filho B', $proximas[1]->titulo);
        $this->assertEquals('Filho C', $proximas[2]->titulo);
    }

    public function testGetProximasEtapasRetornaArrayVazioSemFilhos(): void
    {
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Sem Filhos', 'slug' => 'sem-filhos', 'status' => 'publicado']);
        $troncoId = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Folha', 'parent_id' => null, 'ordem' => 1]);

        $proximas = $this->model->getProximasEtapas($troncoId);

        $this->assertIsArray($proximas);
        $this->assertEmpty($proximas, 'Uma etapa folha não deve ter próximas etapas.');
    }

    // -------------------------------------------------------------------------
    // getEtapaAnterior()
    // -------------------------------------------------------------------------

    public function testGetEtapaAnteriorRetornaPai(): void
    {
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Pai Filho', 'slug' => 'pai-filho', 'status' => 'publicado']);

        $paiId   = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Pai', 'parent_id' => null, 'ordem' => 1]);
        $filhoId = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Filho', 'parent_id' => $paiId, 'ordem' => 2]);

        $filho    = $this->model->find($filhoId);
        $anterior = $this->model->getEtapaAnterior($filho->parent_id);

        $this->assertNotNull($anterior);
        $this->assertEquals($paiId, $anterior->id);
        $this->assertEquals('Pai', $anterior->titulo);
    }

    public function testGetEtapaAnteriorRetornaNullParaEtapaSemPai(): void
    {
        $anterior = $this->model->getEtapaAnterior(null);

        $this->assertNull($anterior, 'Etapa raiz (parent_id = null) não deve ter anterior.');
    }

    // -------------------------------------------------------------------------
    // getBifurcacao() — já existia + novos casos
    // -------------------------------------------------------------------------

    public function testGetBifurcacao(): void
    {
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Ensaio Bifurcacao FK', 'slug' => 'ensaio-bifurcacao-fk', 'status' => 'publicado']);

        $troncoId = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Tronco', 'parent_id' => null, 'direcao' => 'frente']);
        $lado1Id  = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Lado 1', 'parent_id' => $troncoId, 'direcao' => 'lado']);
        $lado2Id  = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Lado 2', 'parent_id' => $lado1Id, 'direcao' => 'lado']);

        $retornoId = $this->model->getBifurcacao($lado2Id);

        $this->assertEquals($troncoId, $retornoId, 'Deve subir até encontrar o tronco principal.');
    }

    public function testGetBifurcacaoComCaminhoFrenteRetornaNull(): void
    {
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Só Frente', 'slug' => 'so-frente', 'status' => 'publicado']);

        $troncoId = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Tronco', 'parent_id' => null, 'direcao' => 'frente']);
        $filho1Id = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Frente 1', 'parent_id' => $troncoId, 'direcao' => 'frente']);
        $filho2Id = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Frente 2', 'parent_id' => $filho1Id, 'direcao' => 'frente']);

        $retornoId = $this->model->getBifurcacao($filho2Id);

        $this->assertNull($retornoId, 'Um caminho toda "frente" não deve ter ponto de retorno de bifurcação.');
    }

    public function testGetBifurcacaoComCaminhoMistoFrenteDepoisLado(): void
    {
        // Tronco (frente) → Filho1 (frente) → Filho2 (lado) → Filho3 (lado)
        // O retorno deve ser o pai do PRIMEIRO "lado" encontrado subindo, ou seja, Filho1
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Caminho Misto', 'slug' => 'caminho-misto', 'status' => 'publicado']);

        $troncoId = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Tronco', 'parent_id' => null, 'direcao' => 'frente']);
        $filho1Id = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Frente', 'parent_id' => $troncoId, 'direcao' => 'frente']);
        $filho2Id = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Lado A', 'parent_id' => $filho1Id, 'direcao' => 'lado']);
        $filho3Id = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Lado B', 'parent_id' => $filho2Id, 'direcao' => 'lado']);

        $retornoId = $this->model->getBifurcacao($filho3Id);

        // Deve retornar filho1Id (pai do primeiro "lado" na subida)
        $this->assertEquals($filho1Id, $retornoId);
    }

    public function testGetBifurcacaoRetornaNullParaEtapaRaiz(): void
    {
        $ensaioId = $this->ensaioModel->insert(['titulo' => 'Raiz Bifurcacao', 'slug' => 'raiz-bifurcacao', 'status' => 'publicado']);
        $raizId   = $this->model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Raiz', 'parent_id' => null, 'direcao' => 'frente']);

        $retornoId = $this->model->getBifurcacao($raizId);

        $this->assertNull($retornoId, 'A etapa raiz não tem bifurcação.');
    }
}
