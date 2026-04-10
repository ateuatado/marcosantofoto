<?php

namespace Tests\Models;

use App\Models\CandidaturaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * Testes do CandidaturaModel.
 *
 * Verifica os métodos customizados pendentes() e todas(),
 * incluindo ordenação e isolamento por status.
 */
class CandidaturaModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate    = true;
    protected $migrateOnce = false;
    protected $refresh    = true;
    protected $namespace  = null;

    private CandidaturaModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CandidaturaModel();
    }

    // -------------------------------------------------------------------------
    // pendentes()
    // -------------------------------------------------------------------------

    public function testPendentesRetornaApenasCandidaturasPendentes(): void
    {
        $this->inserirCandidatura('Ana', 'ana@teste.com', 'pendente');
        $this->inserirCandidatura('Bob', 'bob@teste.com', 'pendente');
        $this->inserirCandidatura('Cia', 'cia@teste.com', 'aceito');

        $resultado = $this->model->pendentes();

        $this->assertCount(2, $resultado, 'Deve retornar apenas as 2 candidaturas pendentes.');
        foreach ($resultado as $candidatura) {
            $this->assertEquals('pendente', $candidatura->status);
        }
    }

    public function testPendentesRetornaArrayVazioSemPendentes(): void
    {
        $this->inserirCandidatura('Ana', 'ana@teste.com', 'aceito');
        $this->inserirCandidatura('Bob', 'bob@teste.com', 'recusado');

        $resultado = $this->model->pendentes();

        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado);
    }

    public function testPendentesRetornaOrdenacaoDecrescente(): void
    {
        // Insere na ordem: antiga, recente
        $dataAntiga  = date('Y-m-d H:i:s', strtotime('-2 days'));
        $dataRecente = date('Y-m-d H:i:s', strtotime('-1 hour'));

        $this->model->insert(['nome' => 'Antiga', 'email' => 'antiga@teste.com', 'status' => 'pendente', 'created_at' => $dataAntiga]);
        $this->model->insert(['nome' => 'Recente', 'email' => 'recente@teste.com', 'status' => 'pendente', 'created_at' => $dataRecente]);

        $resultado = $this->model->pendentes();

        $this->assertEquals('Recente', $resultado[0]->nome, 'A candidatura mais recente deve vir primeiro.');
    }

    // -------------------------------------------------------------------------
    // todas()
    // -------------------------------------------------------------------------

    public function testTodasRetornaTodasIndependenteDoStatus(): void
    {
        $this->inserirCandidatura('Ana', 'ana@teste.com', 'pendente');
        $this->inserirCandidatura('Bob', 'bob@teste.com', 'aceito');
        $this->inserirCandidatura('Cia', 'cia@teste.com', 'recusado');

        $resultado = $this->model->todas();

        $this->assertCount(3, $resultado, 'todas() deve retornar as 3 candidaturas, independente do status.');
    }

    public function testTodasRetornaOrdenadaDecrescente(): void
    {
        $dataAntiga  = date('Y-m-d H:i:s', strtotime('-3 days'));
        $dataRecente = date('Y-m-d H:i:s', strtotime('-1 hour'));

        $this->model->insert(['nome' => 'Antiga', 'email' => 'a@teste.com', 'status' => 'aceito', 'created_at' => $dataAntiga]);
        $this->model->insert(['nome' => 'Recente', 'email' => 'b@teste.com', 'status' => 'pendente', 'created_at' => $dataRecente]);

        $resultado = $this->model->todas();

        $this->assertEquals('Recente', $resultado[0]->nome, 'A candidatura mais recente deve aparecer primeiro.');
    }

    public function testTodasRetornaArrayVazioSemCandidaturas(): void
    {
        $resultado = $this->model->todas();

        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado);
    }

    // -------------------------------------------------------------------------
    // Helpers privados
    // -------------------------------------------------------------------------

    private function inserirCandidatura(string $nome, string $email, string $status): void
    {
        $this->model->insert([
            'nome'       => $nome,
            'email'      => $email,
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
