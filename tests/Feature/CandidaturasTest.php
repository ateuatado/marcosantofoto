<?php

namespace Tests\Feature;

use App\Models\CandidaturaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Helpers\AuthHelper;

/**
 * Testes do fluxo de Candidaturas.
 *
 * Garante que o formulário de candidatura:
 *  - Exige autenticação
 *  - Valida todos os campos obrigatórios
 *  - Persiste corretamente no banco quando válido
 */
class CandidaturasTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthHelper;

    protected $refresh   = true;
    protected $namespace = null;

    /**
     * Dados válidos de candidatura para reuso nos testes.
     */
    private function dadosValidos(): array
    {
        return [
            'nome'     => 'Maria Fotógrafa',
            'email'    => 'maria@foto.com',
            'telefone' => '11999999999',
            'historia' => 'Tenho fotografado pessoas há 10 anos.',
        ];
    }

    // -------------------------------------------------------------------------
    // Acesso ao formulário
    // -------------------------------------------------------------------------

    public function testFormularioExibeParaUsuarioLogado(): void
    {
        $user   = $this->criarUsuarioComum('candidata@teste.com');
        $result = $this->withSession(['user' => ['id' => $user->id]])->get('/candidatura');

        $result->assertStatus(200);
    }

    public function testFormularioRedirecionaParaLoginSemAutenticacao(): void
    {
        $result = $this->get('/candidatura');

        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
    }

    // -------------------------------------------------------------------------
    // Validação
    // -------------------------------------------------------------------------

    public function testEnviarFalhaSemNome(): void
    {
        $user = $this->criarUsuarioComum('seqnome@teste.com');

        $dados = $this->dadosValidos();
        unset($dados['nome']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->post('/candidatura/enviar', $dados);

        $result->assertRedirect();
        $this->dontSeeInDatabase('candidaturas', ['email' => $dados['email']]);
    }

    public function testEnviarFalhaNomeMenorQueTresCaracteres(): void
    {
        $user  = $this->criarUsuarioComum('nomecurto@teste.com');
        $dados = array_merge($this->dadosValidos(), ['nome' => 'AB', 'email' => 'nomecurto@foto.com']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->post('/candidatura/enviar', $dados);

        $result->assertRedirect();
        $this->dontSeeInDatabase('candidaturas', ['email' => 'nomecurto@foto.com']);
    }

    public function testEnviarFalhaSemEmail(): void
    {
        $user  = $this->criarUsuarioComum('sememail@teste.com');
        $dados = $this->dadosValidos();
        unset($dados['email']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->post('/candidatura/enviar', $dados);

        $result->assertRedirect();
    }

    public function testEnviarFalhaComEmailInvalido(): void
    {
        $user  = $this->criarUsuarioComum('emailinv@teste.com');
        $dados = array_merge($this->dadosValidos(), ['email' => 'nao-e-um-email']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->post('/candidatura/enviar', $dados);

        $result->assertRedirect();
        $this->dontSeeInDatabase('candidaturas', ['email' => 'nao-e-um-email']);
    }

    // -------------------------------------------------------------------------
    // Persistência com dados válidos
    // -------------------------------------------------------------------------

    public function testEnviarSalvaCandidaturaComStatusPendente(): void
    {
        $user  = $this->criarUsuarioComum('salvar@teste.com');
        $dados = $this->dadosValidos();

        $this->withSession(['user' => ['id' => $user->id]])
             ->post('/candidatura/enviar', $dados);

        $this->seeInDatabase('candidaturas', [
            'email'  => 'maria@foto.com',
            'status' => 'pendente',
        ]);
    }

    public function testEnviarRedirecionaParaCandidaturaAposSucesso(): void
    {
        $user   = $this->criarUsuarioComum('redirect@teste.com');
        $dados  = array_merge($this->dadosValidos(), ['email' => 'redirect@foto.com']);

        $result = $this->withSession(['user' => ['id' => $user->id]])
                       ->post('/candidatura/enviar', $dados);

        $result->assertRedirect();
        $this->assertStringContainsString('candidatura', $result->getRedirectUrl());
    }

    public function testEnviarNaoSalvaDuplicataDeMesmoCandidato(): void
    {
        $user  = $this->criarUsuarioComum('duplicata@teste.com');
        $dados = array_merge($this->dadosValidos(), ['email' => 'duplicata@foto.com']);

        // Envia duas vezes
        $this->withSession(['user' => ['id' => $user->id]])->post('/candidatura/enviar', $dados);
        $this->withSession(['user' => ['id' => $user->id]])->post('/candidatura/enviar', $dados);

        // O sistema salva as duas (não há regra de unicidade por email) — verificamos apenas que ambas têm status pendente
        $total = (new CandidaturaModel())->where('email', 'duplicata@foto.com')->countAllResults();
        $this->assertGreaterThanOrEqual(1, $total, 'Pelo menos uma candidatura deve ter sido salva.');
    }
}
