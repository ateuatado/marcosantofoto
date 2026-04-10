<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Cria as tabelas que não tinham migration formal:
 * - acessos_ensaios (Lei do Tempo)
 * - candidaturas
 * - pedidos_aquisicao
 * - ensaio_paginas_extras
 */
class CreateMissingTables extends Migration
{
    public function up(): void
    {
        // -----------------------------------------------------------------------
        // acessos_ensaios — Lei do Tempo
        // -----------------------------------------------------------------------
        if (! $this->db->tableExists('acessos_ensaios')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 10,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                ],
                'ensaio_slug' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'data_acesso' => [
                    'type' => 'DATETIME',
                ],
                'ip_address' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 45,
                ],
                'user_agent' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 512,
                    'null'       => true,
                ],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->addKey(['user_id', 'data_acesso'], false, false, 'user_id_data_acesso');
            $this->forge->createTable('acessos_ensaios');
        }

        // -----------------------------------------------------------------------
        // candidaturas
        // -----------------------------------------------------------------------
        if (! $this->db->tableExists('candidaturas')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 10,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nome' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 254,
                ],
                'telefone' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'null'       => true,
                ],
                'nascimento' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'sexo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 80,
                    'null'       => true,
                ],
                'redes_sociais' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'lattes' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 500,
                    'null'       => true,
                ],
                'historia' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pendente', 'aceito', 'recusado'],
                    'default'    => 'pendente',
                    'null'       => true,
                ],
                'notas_admin' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('candidaturas');
        }

        // -----------------------------------------------------------------------
        // pedidos_aquisicao
        // -----------------------------------------------------------------------
        if (! $this->db->tableExists('pedidos_aquisicao')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'auto_increment' => true,
                ],
                'ensaio_id' => [
                    'type' => 'INT',
                ],
                'item_id' => [
                    'type' => 'INT',
                ],
                'user_id' => [
                    'type' => 'INT',
                ],
                'nome_contato' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'meio_contato' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'mensagem' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pendente', 'em_negociacao', 'vendido', 'arquivado'],
                    'default'    => 'pendente',
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('pedidos_aquisicao');
        }

        // -----------------------------------------------------------------------
        // ensaio_paginas_extras
        // -----------------------------------------------------------------------
        if (! $this->db->tableExists('ensaio_paginas_extras')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 10,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'ensaio_id' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                ],
                'tipo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'titulo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'conteudo' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'configuracoes' => [
                    'type' => 'LONGTEXT',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('ensaio_paginas_extras');
        }
    }

    public function down(): void
    {
        $this->forge->dropTable('ensaio_paginas_extras', true);
        $this->forge->dropTable('pedidos_aquisicao', true);
        $this->forge->dropTable('candidaturas', true);
        $this->forge->dropTable('acessos_ensaios', true);
    }
}
