<?php

namespace Tests\Models;

use App\Models\EnsaioModel;
use App\Models\EtapaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class EnsaioModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null; // Executa todas as migrations

    public function testInsertEnsaio()
    {
        $model = new EnsaioModel();

        $data = [
            'titulo' => 'Ensaio Teste',
            'slug' => 'ensaio-teste',
            'resumo_card' => 'Resumo do ensaio de teste',
            'status' => 'publicado'
        ];

        $id = $model->insert($data);

        $this->assertIsNumeric($id);
        $this->seeInDatabase('ensaios', ['slug' => 'ensaio-teste']);
    }

    public function testGetEnsaioCompleto()
    {
        $model = new EnsaioModel();

        $id = $model->insert([
            'titulo' => 'Completo',
            'slug' => 'ensaio-completo',
            'status' => 'publicado'
        ]);

        $etapaModel = new EtapaModel();
        $etapaModel->insert([
            'ensaio_id' => $id,
            'titulo' => 'Etapa 1',
            'tipo' => 'galeria',
            'ordem' => 1,
            'direcao' => 'frente'
        ]);

        $ensaio = $model->getEnsaioCompleto('ensaio-completo');

        $this->assertNotNull($ensaio);
        $this->assertEquals('Completo', $ensaio->titulo);
        $this->assertCount(1, $ensaio->etapas);
        $this->assertEquals('Etapa 1', $ensaio->etapas[0]->titulo);
    }
}
