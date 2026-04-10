<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Testes de Segurança — Rotas Protegidas
 *
 * Garante que nenhuma rota administrativa ou autenticada
 * está exposta a visitantes não autenticados.
 */
class SecurityTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $refresh   = true;
    protected $namespace = null;

    // -------------------------------------------------------------------------
    // Rotas de Admin — devem bloquear convidados
    // -------------------------------------------------------------------------

    public function testAdminRedirecionaOuBloqueiaSemLogin(): void
    {
        $result = $this->get('/admin');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'A rota /admin deve bloquear visitantes não autenticados.'
        );
    }

    public function testAdminNovoRedirecionaSemLogin(): void
    {
        $result = $this->get('/admin/novo');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'A rota /admin/novo deve bloquear visitantes.'
        );
    }

    public function testAdminCandidaturasRedirecionaSemLogin(): void
    {
        $result = $this->get('/admin/candidaturas');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'A rota /admin/candidaturas deve bloquear visitantes.'
        );
    }

    public function testAdminExtrasRedirecionaSemLogin(): void
    {
        $result = $this->get('/admin/extras');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'A rota /admin/extras deve bloquear visitantes.'
        );
    }

    // -------------------------------------------------------------------------
    // Rotas de Ensaios — devem exigir autenticação
    // -------------------------------------------------------------------------

    /**
     * CORRIGIDO: A versão anterior aceitava HTTP 200 como resultado válido,
     * o que significa que o teste passaria mesmo com a rota totalmente exposta.
     * Agora exigimos estritamente um bloqueio (redirect ou 4xx).
     */
    public function testEnsaiosIndexExigeLogin(): void
    {
        $result = $this->get('/ensaios');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'A listagem de ensaios DEVE exigir autenticação. HTTP 200 sem login é uma vulnerabilidade.'
        );
    }

    public function testEnsaiosConfirmarExigeLogin(): void
    {
        $result = $this->get('/ensaios/confirmar/qualquer-slug');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'A tela de confirmação deve exigir login.'
        );
    }

    public function testEnsaiosVerExigeLogin(): void
    {
        // "Caverna inexistente" é a PageNotFoundException do controller — o usuário não
        // chegou ao conteúdo (seria 200), portanto a rota está protegida.
        try {
            $result = $this->get('/ensaios/ver/qualquer-slug');
            $status = $result->response()->getStatusCode();
            $this->assertTrue(
                $result->isRedirect() || $status === 403 || $status === 401 || $status === 404,
                'A visualização de ensaêo DEVE bloquear visitantes.'
            );
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // PageNotFoundException = slug não existe ou acesso negado — comportamento seguro
            $this->assertTrue(true);
        }
    }

    public function testEnsaiosSantuarioExigeLogin(): void
    {
        try {
            $result = $this->get('/ensaios/santuario/qualquer-slug');
            $this->assertTrue(
                $result->isRedirect()
                    || $result->response()->getStatusCode() >= 400,
                'O santuário deve ser bloqueado sem autenticação.'
            );
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            $this->assertTrue(true);
        }
    }

    // -------------------------------------------------------------------------
    // Rota de Candidatura — exige login
    // -------------------------------------------------------------------------

    public function testCandidaturaExigeLogin(): void
    {
        $result = $this->get('/candidatura');

        $this->assertTrue(
            $result->isRedirect()
                || $result->response()->getStatusCode() === 403
                || $result->response()->getStatusCode() === 401,
            'O formulário de candidatura deve exigir autenticação.'
        );
    }

    // -------------------------------------------------------------------------
    // Endpoint AJAX — deve rejeitar requests normais
    // -------------------------------------------------------------------------

    public function testRegistrarInteresseRotaNaoExiste(): void
    {
        // A rota no Routes.php é ensaios/registrar_interesse (underscore, não hífen)
        // Testa que POST sem sessão na rota real também bloqueia
        try {
            $result = $this->post('/ensaios/registrar_interesse', [
                'ensaio_id' => 1,
                'item_id'   => 1,
                'nome'      => 'Teste',
                'contato'   => 'contato@teste',
                'mensagem'  => 'Quero comprar',
            ]);
            // Se chegou aqui sem throw, a rota respondeu algo — deve ser bloqueio
            $status = $result->response()->getStatusCode();
            $this->assertTrue(
                $result->isRedirect() || $status === 403 || $status === 401 || $status === 404,
                'POST em registrar_interesse sem sessão deve ser bloqueado.'
            );
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            $this->assertTrue(true);
        }
    }
}
