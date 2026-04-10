<?php

namespace Tests\Feature;

use App\Models\EnsaioModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Helpers\AuthHelper;

/**
 * Testes das operações administrativas.
 *
 * Garante que:
 *  - Usuários comuns não acessam rotas de admin
 *  - Operações destrutivas funcionam corretamente
 *  - Validações de formulário são aplicadas
 *  - Alternância de status é precisa
 */
class AdminTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthHelper;

    protected $refresh   = true;
    protected $namespace = null;

    // -------------------------------------------------------------------------
    // Controle de acesso — usuário comum não deve acessar
    // -------------------------------------------------------------------------

    public function testUsuarioComumNaoAcessaPainelAdmin(): void
    {
        $user   = $this->criarUsuarioComum('comum_admin@teste.com');
        $result = $this->withSession(['user' => ['id' => $user->id]])->get('/admin');

        $this->assertTrue(
            $result->isRedirect() || $result->response()->getStatusCode() >= 400,
            'Usuário comum não deve acessar o painel admin.'
        );
    }

    public function testUsuarioComumNaoAcessaAdminExtras(): void
    {
        $user   = $this->criarUsuarioComum('comumextras@teste.com');
        $result = $this->withSession(['user' => ['id' => $user->id]])->get('/admin/extras');

        $this->assertTrue(
            $result->isRedirect() || $result->response()->getStatusCode() >= 400,
            'Usuário comum não deve acessar /admin/extras.'
        );
    }

    // -------------------------------------------------------------------------
    // Validação de formulário — Admin::salvar()
    // -------------------------------------------------------------------------

    public function testSalvarEnsaioFalhaSemTitulo(): void
    {
        $admin  = $this->criarAdmin('adm_semtitulo@teste.com');
        $result = $this->withSession(['user' => ['id' => $admin->id]])
                       ->post('/admin/salvar', [
                           'slug' => 'sem-titulo-slug',
                       ]);

        // Deve redirecionar de volta com erros de validação
        $result->assertRedirect();
        $this->dontSeeInDatabase('ensaios', ['slug' => 'sem-titulo-slug']);
    }

    public function testSalvarEnsaioFalhaComSlugDuplicado(): void
    {
        $admin = $this->criarAdmin('adm_slugdup@teste.com');

        // Insere ensaio com o slug 'slug-existente'
        (new EnsaioModel())->insert([
            'titulo' => 'Ensaio Original',
            'slug'   => 'slug-existente',
            'status' => 'publicado',
        ]);

        $result = $this->withSession(['user' => ['id' => $admin->id]])
                       ->post('/admin/salvar', [
                           'titulo' => 'Ensaio Duplicado',
                           'slug'   => 'slug-existente',
                       ]);

        $result->assertRedirect();

        // Deve existir apenas 1 ensaio com esse slug (o original)
        $total = (new EnsaioModel())->where('slug', 'slug-existente')->countAllResults();
        $this->assertEquals(1, $total, 'Não deve permitir dois ensaios com o mesmo slug.');
    }

    public function testSalvarEnsaioComDadosValidosCriaRegistro(): void
    {
        $admin  = $this->criarAdmin('adm_criar@teste.com');
        $result = $this->withSession(['user' => ['id' => $admin->id]])
                       ->post('/admin/salvar', [
                           'titulo'      => 'Novo Ensaio Teste',
                           'slug'        => 'novo-ensaio-teste',
                           'resumo_card' => 'Um resumo.',
                       ]);

        $this->seeInDatabase('ensaios', [
            'slug'   => 'novo-ensaio-teste',
            'status' => 'rascunho', // Admin::salvar() sempre cria como rascunho
        ]);
    }

    // -------------------------------------------------------------------------
    // Alternância de status — Admin::alternar_status()
    // -------------------------------------------------------------------------

    public function testAlternarStatusMudaRascunhoParaPublicado(): void
    {
        $admin = $this->criarAdmin('adm_altst1@teste.com');

        $id = (new EnsaioModel())->insert([
            'titulo' => 'Ensaio Rascunho',
            'slug'   => 'ensaio-rascunho-alt',
            'status' => 'rascunho',
        ]);

        $this->withSession(['user' => ['id' => $admin->id]])
             ->post("/admin/alternar-status/{$id}");

        $this->seeInDatabase('ensaios', ['id' => $id, 'status' => 'publicado']);
    }

    public function testAlternarStatusMudaPublicadoParaRascunho(): void
    {
        $admin = $this->criarAdmin('adm_altst2@teste.com');

        $id = (new EnsaioModel())->insert([
            'titulo' => 'Ensaio Publicado',
            'slug'   => 'ensaio-pub-alt',
            'status' => 'publicado',
        ]);

        $this->withSession(['user' => ['id' => $admin->id]])
             ->post("/admin/alternar-status/{$id}");

        $this->seeInDatabase('ensaios', ['id' => $id, 'status' => 'rascunho']);
    }

    // -------------------------------------------------------------------------
    // Exclusão — Admin::excluir()
    // -------------------------------------------------------------------------

    public function testExcluirEnsaioRemoveDoBanco(): void
    {
        $admin = $this->criarAdmin('adm_excluir@teste.com');

        $id = (new EnsaioModel())->insert([
            'titulo' => 'Para Excluir',
            'slug'   => 'para-excluir',
            'status' => 'rascunho',
        ]);

        $this->withSession(['user' => ['id' => $admin->id]])
             ->post("/admin/excluir/{$id}");

        // EnsaioModel usa soft delete — o registro existe mas com deleted_at preenchido
        $model   = new EnsaioModel();
        $ensaio  = $model->withDeleted()->find($id);

        $this->assertNotNull($ensaio, 'O registro deve existir com soft delete.');
        $this->assertNotNull($ensaio->deleted_at, 'O campo deleted_at deve estar preenchido após exclusão.');
    }

    // -------------------------------------------------------------------------
    // Listagem de candidaturas
    // -------------------------------------------------------------------------

    public function testAdminListaCandidaturas(): void
    {
        $admin = $this->criarAdmin('adm_lista@teste.com');

        (new \App\Models\CandidaturaModel())->insert([
            'nome'       => 'Candidato Teste',
            'email'      => 'ct@teste.com',
            'status'     => 'pendente',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $result = $this->withSession(['user' => ['id' => $admin->id]])
                       ->get('/admin/candidaturas');

        $result->assertStatus(200);
        $result->assertSee('Candidato Teste');
    }
}
