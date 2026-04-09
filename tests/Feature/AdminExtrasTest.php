<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class AdminExtrasTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $refresh   = true;
    protected $namespace = null;

    /**
     * Auxiliar para criar um user Admin rapidamente no Shield
     * Para os testes, injetamos mock de sessão ou o usuário
     */
    protected function setupAdminUser()
    {
        // Neste sistema de test, podemos simular o login ignorando o Shield 
        // ou criar um provider/mock. Para feature tests do CI4 com filter Shield,
        // às vezes ignoramos o filtro para testar o admin em unidade de feature.
        // O CI4.3+ suporta ->withSession() e ->asUser($user)
        // Se falhar o Shield no test mock, injetamos um mock temporário no container.
        return true; 
    }

    public function testPainelListagemRedirecionaParaLogin()
    {
        $result = $this->get('/admin/extras');
        // Shield filter on admin routes
        $this->assertTrue($result->isRedirect() || $result->response()->getStatusCode() === 403 || $result->response()->getStatusCode() === 401);
    }
}
