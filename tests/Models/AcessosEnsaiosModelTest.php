<?php

namespace Tests\Models;

use App\Models\AcessosEnsaiosModel;
use App\Models\EnsaioModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * Testes da "Lei do Tempo" — regra central do produto.
 *
 * Garante que:
 *  - jaDesbloqueou() identifica corretamente acessos existentes
 *  - bloqueioRecente() aplica a janela de 24h com precisão
 *  - Nenhuma das verificações vaza dados entre usuários diferentes
 */
class AcessosEnsaiosModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $migrateOnce = false;
    protected $refresh   = true;
    protected $namespace = null;

    private AcessosEnsaiosModel $model;
    private int $userId = 99; // ID fictício; Shield não é necessário para testar o model

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new AcessosEnsaiosModel();

        // Garante que o ensaio referenciado existe (FK)
        $ensaioModel = new EnsaioModel();
        $ensaioModel->insert([
            'titulo' => 'Ensaio Acesso Teste',
            'slug'   => 'ensaio-acesso-teste',
            'status' => 'publicado',
        ]);
    }

    // -------------------------------------------------------------------------
    // jaDesbloqueou()
    // -------------------------------------------------------------------------

    public function testJaDesbloqueouRetornaTrueParaSlugExistente(): void
    {
        $this->inserirAcesso($this->userId, 'ensaio-acesso-teste');

        $resultado = $this->model->jaDesbloqueou($this->userId, 'ensaio-acesso-teste');

        $this->assertNotNull($resultado, 'Deveria retornar o registro de acesso existente.');
    }

    public function testJaDesbloqueouRetornaFalseParaSlugDiferente(): void
    {
        $this->inserirAcesso($this->userId, 'ensaio-acesso-teste');

        $resultado = $this->model->jaDesbloqueou($this->userId, 'outro-slug');

        $this->assertNull($resultado, 'Não deveria encontrar acesso para um slug diferente.');
    }

    public function testJaDesbloqueouNaoConfundeEntreUsuarios(): void
    {
        // User 1 tem acesso
        $this->inserirAcesso(1, 'ensaio-acesso-teste');

        // User 2 NÃO tem acesso
        $resultado = $this->model->jaDesbloqueou(2, 'ensaio-acesso-teste');

        $this->assertNull($resultado, 'Acesso do user 1 não deve vazar para o user 2.');
    }

    public function testJaDesbloqueouRetornaFalseParaUsuarioSemNenhumAcesso(): void
    {
        // Nenhum acesso inserido
        $resultado = $this->model->jaDesbloqueou(999, 'ensaio-acesso-teste');

        $this->assertNull($resultado);
    }

    // -------------------------------------------------------------------------
    // bloqueioRecente()
    // -------------------------------------------------------------------------

    public function testBloqueioRecenteRetornaAcessoSeDentroDeVinteQuatroHoras(): void
    {
        // Acesso há 1 hora atrás (dentro da janela de 24h)
        $this->inserirAcesso($this->userId, 'ensaio-acesso-teste', '-1 hour');

        $resultado = $this->model->bloqueioRecente($this->userId);

        $this->assertNotNull($resultado, 'Deve bloquear: acesso recente dentro de 24h.');
    }

    public function testBloqueioRecenteRetornaAcessoHaVinteETresHoras(): void
    {
        // Acesso há 23h59m — ainda dentro da janela
        $this->inserirAcesso($this->userId, 'ensaio-acesso-teste', '-23 hours -59 minutes');

        $resultado = $this->model->bloqueioRecente($this->userId);

        $this->assertNotNull($resultado, 'Deve bloquear: 23h59m ainda é dentro de 24h.');
    }

    public function testBloqueioRecenteIgnoraAcessosDeVinteECincoHorasAtras(): void
    {
        // Acesso há 25h — fora da janela de bloqueio
        $this->inserirAcesso($this->userId, 'ensaio-acesso-teste', '-25 hours');

        $resultado = $this->model->bloqueioRecente($this->userId);

        $this->assertNull($resultado, 'Não deve bloquear: acesso de 25h atrás está fora da janela.');
    }

    public function testBloqueioRecenteRetornaOAcessoMaisRecente(): void
    {
        // Dois acessos do mesmo usuário
        $this->inserirAcesso($this->userId, 'ensaio-acesso-teste', '-20 hours');
        $this->inserirAcesso($this->userId, 'outro-slug-qualquer', '-1 hour');

        $resultado = $this->model->bloqueioRecente($this->userId);

        $this->assertNotNull($resultado);
        // O mais recente é o de -1 hora (outro-slug-qualquer)
        $this->assertEquals('outro-slug-qualquer', $resultado->ensaio_slug);
    }

    public function testBloqueioRecenteNaoConfundeEntreUsuarios(): void
    {
        // User 10 tem acesso recente, user 20 não tem
        $this->inserirAcesso(10, 'ensaio-acesso-teste', '-1 hour');

        $resultado = $this->model->bloqueioRecente(20);

        $this->assertNull($resultado, 'Bloqueio do user 10 não deve vazar para o user 20.');
    }

    public function testBloqueioRecenteRetornaNullParaUsuarioSemNenhumAcesso(): void
    {
        $resultado = $this->model->bloqueioRecente(999);

        $this->assertNull($resultado);
    }

    // -------------------------------------------------------------------------
    // Helpers privados
    // -------------------------------------------------------------------------

    /**
     * Insere um registro em acessos_ensaios com uma data relativa ao momento atual.
     *
     * @param int    $userId
     * @param string $slug
     * @param string $offset  Formato aceito por strtotime(), ex: '-1 hour', '-25 hours'
     */
    private function inserirAcesso(int $userId, string $slug, string $offset = 'now'): void
    {
        $dataAcesso = date('Y-m-d H:i:s', strtotime($offset));

        $this->model->insert([
            'user_id'      => $userId,
            'ensaio_slug'  => $slug,
            'data_acesso'  => $dataAcesso,
            'ip_address'   => '127.0.0.1',
            'user_agent'   => 'PHPUnit/TestAgent',
        ]);
    }
}
