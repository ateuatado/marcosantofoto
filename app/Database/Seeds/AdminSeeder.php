<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        // 1. Definindo os dados do seu usuário
        $user = new User([
            'username' => 'marcosantofoto',
            'email'    => 'marcosantofoto@gmail.com',
            'password' => 'Lula#Eleito26', // O Shield vai criptografar isso automaticamente
        ]);

        // 2. Salvando o usuário
        if (! $users->save($user)) {
            die(implode("\n", $users->errors()));
        }

        // 3. Pegando o usuário recém-criado para dar os poderes
        $user = $users->findById($users->getInsertID());

        // 4. Adicionando ao grupo 'admin' (ou 'superadmin')
        $user->addGroup('admin', 'superadmin');

        echo "Admin criado com sucesso!\n";
    }
}
