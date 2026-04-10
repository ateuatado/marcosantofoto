<?php

namespace Tests\Feature;

use App\Models\AcessosEnsaiosModel;
use App\Models\EnsaioModel;
use App\Models\EtapaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Helpers\AuthHelper;

/**
 * Testes do fluxo completo de Ensaios.
 *
 * Cobre tanto usabilidade (jornada do usuário) quanto
 * segurança (bloqueios de acesso e Lei do Tempo).
 */
class EnsaiosFluxoTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthHelper;

    protected $refresh   = true;
    protected $namespace = null;

    // ========================================================================
    // USABILIDADE — Jornada do usuário
    // ========================================================================

    public function testHomeExibeTextoConceitual(): void
    {
        $result = $this->get('/');

        $result->assertStatus(200);
        $result->assertSee('Um ensaio é a revelação de uma alma');
        $result->assertSee('Acessar');
    }

    public function testUsuarioLogadoVeListaDeEnsaiosPublicados(): void
    {
        $user = $this->criarUsuarioComum('lista@teste.com');
        $this->loginComo($user);

        // Garante que há um ensaio publicado
        (new EnsaioModel())->insert([
            'titulo' => 'Ensaio Visível',
            'slug'   => 'ensaio-visivel',
            'status' => 'publicado',
        ]);

        $result = $this->withSession(['user' => ['id' => $user->id]])->get('/ensaios');

        $result->assertStatus(200);
        $result->assertSee('Ensaio Visível');
    }

    public function testUsuarioComumNaoVeRascunhos(): void
    {
        $user = $this->criarUsuarioComum('semrascunho@teste.com');

        (new EnsaioModel())->insert([
            'titulo' => 'Rascunho Secreto',
            'slug'   => 'rascunho-secreto',
            'status' => 'rascunho',
        ]);

        $result = $this->withSession(['user' => ['id' => $user->id]])->get('/ensaios');

        $result->assertStatus(200);
        $result->assertDontSee('Rascunho Secreto');
    }

    public function testMetodoExibeConteudoSemLogin(): void
    {
        $result = $this->get('/ensaios/metodo');

        // A página do método é pública
        $result->assertStatus(200);
    }

    // ========================================================================
    // SEGURANÇA — Lei do Tempo e permissões de acesso
    // ========================================================================

    public function testConfirmarRedirecionaParaVerSeJaDesbloqueou(): void
    {
        $user = $this->criarUsuarioComum('jadeslok@teste.com');

        // Insere acesso existente
        (new EnsaioModel())->insert(['titulo' => 'Ensaio JD', 'slug' => 'ensaio-jd', 'status' => 'publicado']);
        (new AcessosEnsaiosModel())->insert([
            'user_id'     => $user->id,
            'ensaio_slug' => 'ensaio-jd',
            'data_acesso' => date('Y-m-d H:i:s'),
            'ip_address'  => '127.0.0.1',
            'user_agent'  => 'PHPUnit',
        ]);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->get('/ensaios/confirmar/ensaio-jd');

        $result->assertRedirectTo(base_url('ensaios/ver/ensaio-jd'));
    }

    public function testConfirmarBloqueaUsuarioComAcessoRecenteEmOutroEnsaio(): void
    {
        $user = $this->criarUsuarioComum('bloqueado@teste.com');

        // Acesso recente (1 hora atrás) a um slug diferente
        (new AcessosEnsaiosModel())->insert([
            'user_id'     => $user->id,
            'ensaio_slug' => 'outro-ensaio',
            'data_acesso' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            'ip_address'  => '127.0.0.1',
            'user_agent'  => 'PHPUnit',
        ]);

        (new EnsaioModel())->insert(['titulo' => 'Novo Ensaio', 'slug' => 'novo-ensaio', 'status' => 'publicado']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->get('/ensaios/confirmar/novo-ensaio');

        // Deve ser barrado pela Lei do Tempo → redirect para /ensaios
        $result->assertRedirect();
        $this->assertStringContainsString('ensaios', $result->getRedirectUrl());
    }

    public function testVerBloqueiaAcessoSemDesbloqueioPrevio(): void
    {
        $user = $this->criarUsuarioComum('semacesso@teste.com');

        (new EnsaioModel())->insert(['titulo' => 'Ensaio Fechado', 'slug' => 'ensaio-fechado', 'status' => 'publicado']);

        // Usuário NÃO tem entrada em acessos_ensaios
        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->get('/ensaios/ver/ensaio-fechado');

        // Deve redirecionar para /confirmar
        $result->assertRedirect();
        $this->assertStringContainsString('confirmar', $result->getRedirectUrl());
    }

    public function testVerImpedeTrocaDeEnsaioViaEtapaId(): void
    {
        $user = $this->criarUsuarioComum('seguranca@teste.com');

        $ensaioModelA = new EnsaioModel();
        $ensaioModelB = new EnsaioModel();

        $idA = $ensaioModelA->insert(['titulo' => 'Ensaio A', 'slug' => 'ensaio-a', 'status' => 'publicado']);
        $idB = $ensaioModelB->insert(['titulo' => 'Ensaio B', 'slug' => 'ensaio-b', 'status' => 'publicado']);

        // Usuário tem acesso ao Ensaio A
        (new AcessosEnsaiosModel())->insert([
            'user_id'     => $user->id,
            'ensaio_slug' => 'ensaio-a',
            'data_acesso' => date('Y-m-d H:i:s'),
            'ip_address'  => '127.0.0.1',
            'user_agent'  => 'PHPUnit',
        ]);

        // Cria etapa pertencente ao Ensaio B
        $etapaModel = new EtapaModel();
        $etapaIdB   = $etapaModel->insert([
            'ensaio_id' => $idB,
            'titulo'    => 'Etapa do Ensaio B',
            'tipo'      => 'galeria',
            'ordem'     => 1,
            'direcao'   => 'frente',
        ]);

        // Tenta acessar Ensaio A com etapa do Ensaio B na URL
        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->get("/ensaios/ver/ensaio-a/{$etapaIdB}");

        // Deve bloquear — redireciona para /ensaios com mensagem de erro
        $result->assertRedirect();
        $this->assertStringContainsString('ensaios', $result->getRedirectUrl());
    }

    public function testProcessarRegistraAcessoERedirecionaParaVer(): void
    {
        $user = $this->criarUsuarioComum('processa@teste.com');

        (new EnsaioModel())->insert(['titulo' => 'Ensaio Proc', 'slug' => 'ensaio-proc', 'status' => 'publicado']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->post('/ensaios/processar/ensaio-proc');

        // Deve registrar no banco
        $this->seeInDatabase('acessos_ensaios', [
            'user_id'     => $user->id,
            'ensaio_slug' => 'ensaio-proc',
        ]);

        $result->assertRedirect();
        $this->assertStringContainsString('ensaios/ver/ensaio-proc', $result->getRedirectUrl());
    }

    public function testExtraExigeAcessoDesbloqueadoAoEnsaioPai(): void
    {
        $user = $this->criarUsuarioComum('extra@teste.com');

        $ensaioId = (new EnsaioModel())->insert(['titulo' => 'Ensaio Extra', 'slug' => 'ensaio-extra', 'status' => 'publicado']);

        // Insere uma página extra vinculada ao ensaio
        $extraModel = new \App\Models\EnsaioPaginaExtraModel();
        $extraId = $extraModel->insert([
            'ensaio_id' => $ensaioId,
            'titulo'    => 'Página Bônus',
            'tipo'      => 'texto',
            'conteudo'  => 'Conteúdo da página.',
        ]);

        // Usuário SEM acesso ao ensaio pai
        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->get("/ensaios/extra/{$extraId}");

        // Deve redirecionar para /confirmar
        $result->assertRedirect();
        $this->assertStringContainsString('confirmar', $result->getRedirectUrl());
    }
}
