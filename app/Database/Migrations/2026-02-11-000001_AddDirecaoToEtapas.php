<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDirecaoToEtapas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('etapas', [
            'direcao' => [
                'type'       => 'ENUM',
                'constraint' => ['frente', 'lado'],
                'default'    => 'frente',
                'after'      => 'decisao_texto', // Fica logo após o texto do botão
                'comment'    => 'Define a animação de transição: frente (vertical) ou lado (horizontal)'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('etapas', 'direcao');
    }
}
