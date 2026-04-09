<?php

namespace Tests\Models;

use App\Models\EtapaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class EtapaModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null;

    public function testGetPrimeiraEtapa()
    {
        $ensaioModel = new \App\Models\EnsaioModel();
        $ensaioId = $ensaioModel->insert([
            'titulo' => 'Ensaio FK',
            'slug' => 'ensaio-fk',
            'status' => 'publicado'
        ]);

        $model = new EtapaModel();
        
        $idRaiz = $model->insert([
            'ensaio_id' => $ensaioId,
            'titulo' => 'Raiz',
            'parent_id' => null,
            'tipo' => 'galeria',
            'ordem' => 1
        ]);

        $model->insert([
            'ensaio_id' => $ensaioId,
            'titulo' => 'Secundaria',
            'parent_id' => $idRaiz,
            'tipo' => 'texto',
            'ordem' => 2
        ]);

        $primeira = $model->getPrimeiraEtapa($ensaioId);

        $this->assertNotNull($primeira);
        $this->assertEquals('Raiz', $primeira->titulo);
        $this->assertEquals($idRaiz, $primeira->id);
    }

    public function testGetBifurcacao()
    {
        $ensaioModel = new \App\Models\EnsaioModel();
        $ensaioId = $ensaioModel->insert([
            'titulo' => 'Ensaio Bifurcacao FK',
            'slug' => 'ensaio-bifurcacao-fk',
            'status' => 'publicado',
        ]);

        $model = new EtapaModel();
        
        $troncoId = $model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Tronco', 'parent_id' => null, 'direcao' => 'frente']);

        $lado1Id = $model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Lado 1', 'parent_id' => $troncoId, 'direcao' => 'lado']);
        $lado2Id = $model->insert(['ensaio_id' => $ensaioId, 'titulo' => 'Lado 2', 'parent_id' => $lado1Id, 'direcao' => 'lado']);

        $retornoId = $model->getBifurcacao($lado2Id);

        // Ele deve continuar subindo pela árvore e encontrar o tronco
        $this->assertEquals($troncoId, $retornoId);
    }
}
