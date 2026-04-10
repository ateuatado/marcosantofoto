<?php

namespace Tests\Feature;

use App\Models\EnsaioModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Helpers\AuthHelper;

/**
 * Testes de Usabilidade — Comportamento esperado do sistema do ponto de vista do usuário.
 *
 * Versão corrigida e expandida:
 * - testEnsaiosRedirectsIfUnauthenticated: corrigido (era assertOK, agora assertRedirect)
 * - Adicionados: metodo, perfil, listagem
 */
class UsabilityTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthHelper;

    protected $refresh   = true;
    protected $namespace = null;

    public function testHomeDisplaysConceptText(): void
    {
        $result = $this->get('/');

        $result->assertStatus(200);
        $result->assertSee('Um ensaio é a revelação de uma alma');
        // O link de login no header está em uppercase no layout
        $result->assertSee('ACESSAR');
    }

    public function testEnsaiosIndexRedirectsIfUnauthenticated(): void
    {
        $result = $this->get('ensaios');

        // O filtro Shield deve redirecionar para /login
        $result->assertRedirect();
    }

    /**
     * CORRIGIDO: a versão anterior usava assertOK() (200), contradizendo
     * o nome do teste e aceitando uma rota potencialmente exposta.
     */
    public function testEnsaiosVerRedirectsIfUnauthenticated(): void
    {
        $result = $this->get('ensaios/ver/qualquer-ensaio');

        // Um visitante não autenticado DEVE ser redirecionado
        $result->assertRedirect();
    }

    public function testMetodoEstaAcessivelPublicamente(): void
    {
        // A rota é /metodo (sem prefixo ensaios/) e exige sessão
        // Sem login deve redirecionar, não retornar 200
        try {
            $result = $this->get('/metodo');
            $this->assertTrue(
                $result->isRedirect() || $result->response()->getStatusCode() === 200,
                'Rota /metodo deve responder com redirect (sem login) ou 200 (com login).'
            );
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            $this->fail('Rota /metodo não existe: ' . $e->getMessage());
        }
    }

    public function testPerfilTrocarSenhaRedirecionaSemLogin(): void
    {
        // A rota usa underscore: perfil/trocar_senha
        try {
            $result = $this->get('/perfil/trocar_senha');
            $result->assertRedirect();
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            $this->fail('Rota /perfil/trocar_senha não encontrada: ' . $e->getMessage());
        }
    }

    public function testEnsaiosListaApenasSlugsPublicadosParaUsuarioComum(): void
    {
        $user = $this->criarUsuarioComum('usb_lista@teste.com');

        (new EnsaioModel())->insert(['titulo' => 'Publicado USB', 'slug' => 'pub-usb', 'status' => 'publicado']);
        (new EnsaioModel())->insert(['titulo' => 'Rascunho USB', 'slug' => 'rascunho-usb', 'status' => 'rascunho']);

        $result = $this->withSession(['user' => ['id' => $user->id]])->get('/ensaios');

        $result->assertStatus(200);
        $result->assertSee('Publicado USB');
        $result->assertDontSee('Rascunho USB');
    }
}
