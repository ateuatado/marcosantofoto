<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Shield\Models\UserModel;

class TornarAdmin extends BaseCommand
{
    protected $group       = 'Auth';
    protected $name        = 'auth:admin';
    protected $description = 'Promove um usuário para o grupo superadmin via ID ou Email.';

    public function run(array $params)
    {
        $users = new UserModel();

        // Pergunta qual usuário promover
        $email = CLI::prompt('Digite o e-mail do usuário que será o Mestre da Caverna');

        $user = $users->findByCredentials(['email' => $email]);

        if (! $user) {
            CLI::error("Usuário não encontrado.");
            return;
        }

        // Adiciona ao grupo superadmin
        $user->addGroup('superadmin');

        CLI::write("Sucesso! O usuário {$user->username} ({$email}) agora tem acesso total.", 'green');
    }
}
