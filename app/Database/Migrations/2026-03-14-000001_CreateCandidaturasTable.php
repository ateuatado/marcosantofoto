<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCandidaturasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nome'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 254],
            'telefone'      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'nascimento'    => ['type' => 'DATE', 'null' => true],
            'sexo'          => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'redes_sociais' => ['type' => 'TEXT', 'null' => true],
            'lattes'        => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'historia'      => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pendente', 'aceito', 'recusado'], 'default' => 'pendente'],
            'notas_admin'   => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->createTable('candidaturas');
    }

    public function down(): void
    {
        $this->forge->dropTable('candidaturas', true);
    }
}
