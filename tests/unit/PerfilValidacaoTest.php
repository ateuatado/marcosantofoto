<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * Testes unitários das regras de validação de senha do Perfil.
 *
 * Como a lógica está diretamente no controller (Perfil::salvar_senha),
 * estes testes validam as regras de forma isolada sem HTTP,
 * tornando-os rápidos e determinísticos.
 */
final class PerfilValidacaoTest extends CIUnitTestCase
{
    // -------------------------------------------------------------------------
    // Validação de tamanho mínimo
    // -------------------------------------------------------------------------

    public function testSenhaVaziaEhInvalida(): void
    {
        $this->assertFalse($this->senhaEhValida('', 'qualquer'), 'Senha vazia deve ser inválida.');
    }

    public function testSenhaComSeteCarcteresEhInvalida(): void
    {
        $this->assertFalse($this->senhaEhValida('1234567', '1234567'), 'Senha com 7 caracteres deve ser inválida (mínimo 8).');
    }

    public function testSenhaComOitoCaracteresEhValida(): void
    {
        $this->assertTrue($this->senhaEhValida('12345678', '12345678'), 'Senha com 8 caracteres deve ser válida.');
    }

    public function testSenhaComMaisDeOitoCaracteresEhValida(): void
    {
        $this->assertTrue($this->senhaEhValida('Senha@Forte123!', 'Senha@Forte123!'), 'Senha longa e forte deve ser válida.');
    }

    // -------------------------------------------------------------------------
    // Validação de confirmação (as duas devem ser iguais)
    // -------------------------------------------------------------------------

    public function testSenhasDivergentesRetornamInvalido(): void
    {
        $this->assertFalse($this->senhaEhValida('senha12345', 'senha99999'), 'Senhas diferentes devem ser inválidas.');
    }

    public function testSenhasIguaisRetornamValido(): void
    {
        $this->assertTrue($this->senhaEhValida('MinhaSenha!1', 'MinhaSenha!1'), 'Senhas iguais devem ser válidas.');
    }

    public function testSenhaSensivelaCase(): void
    {
        // 'Senha123' e 'senha123' são diferentes (case-sensitive)
        $this->assertFalse($this->senhaEhValida('Senha123', 'senha123'), 'A validação deve ser case-sensitive.');
    }

    // -------------------------------------------------------------------------
    // Lógica extraída do controller (Perfil::salvar_senha)
    // Espelha exatamente as condições do método real:
    //   if (empty($nova) || strlen($nova) < 8) → inválido
    //   if ($nova !== $conf) → inválido
    // -------------------------------------------------------------------------

    /**
     * Replica a lógica de validação do Perfil::salvar_senha()
     * sem precisar de HTTP ou banco de dados.
     */
    private function senhaEhValida(string $nova, string $confirmacao): bool
    {
        if (empty($nova) || strlen($nova) < 8) {
            return false;
        }

        if ($nova !== $confirmacao) {
            return false;
        }

        return true;
    }
}
