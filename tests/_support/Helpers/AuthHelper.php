<?php

namespace Tests\Support\Helpers;

use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

/**
 * Trait AuthHelper
 *
 * Fornece métodos utilitários para criar usuários e simular autenticação
 * nos testes de Feature sem depender de HTTP real ou SMTP.
 */
trait AuthHelper
{
    /**
     * Cria um usuário no banco de dados de teste e opcionalmente o coloca em grupos.
     *
     * @param string   $email
     * @param string   $password
     * @param string[] $grupos   Ex: ['superadmin']
     */
    protected function criarUsuarioNoBanco(
        string $email = 'usuario@teste.com',
        string $password = 'Senh@Teste123',
        array $grupos = []
    ): User {
        /** @var UserModel $users */
        $users = auth()->getProvider();

        $user = new User([
            'username' => str_replace('@', '_', explode('@', $email)[0]) . rand(100, 999),
            'email'    => $email,
            'password' => $password,
        ]);

        $users->save($user);

        // Recarrega do banco para obter o ID gerado
        $user = $users->findByCredentials(['email' => $email]);

        // Adiciona grupos se solicitado
        foreach ($grupos as $grupo) {
            $user->addGroup($grupo);
        }

        return $user;
    }

    /**
     * Cria um usuário comum (sem grupos de admin).
     */
    protected function criarUsuarioComum(string $email = 'comum@teste.com'): User
    {
        return $this->criarUsuarioNoBanco($email);
    }

    /**
     * Cria um superadmin.
     */
    protected function criarAdmin(string $email = 'admin@teste.com'): User
    {
        return $this->criarUsuarioNoBanco($email, 'Senh@Admin123', ['superadmin']);
    }

    /**
     * Retorna um array de sessão simulando um usuário logado via Shield (Session).
     * Usar com ->withSession($this->sessionDeUsuario($user)) no FeatureTestTrait.
     */
    protected function sessionDeUsuario(User $user): array
    {
        return [
            'user' => ['id' => $user->id],
        ];
    }

    /**
     * Faz o login programático do usuário no sistema Shield.
     * Retorna o usuário para encadeamento.
     */
    protected function loginComo(User $user): User
    {
        auth()->login($user);
        return $user;
    }
}
