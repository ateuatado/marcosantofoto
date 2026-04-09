<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnsaiosStructure extends Migration
{
    public function up()
    {
        // 1. Tabela: ENSAIOS (A Caverna / O Pai)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'unique'     => true,
            ],
            'resumo_card' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'capa_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['rascunho', 'publicado', 'arquivado'],
                'default'    => 'rascunho',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime default null', // Soft delete para segurança
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ensaios');

        // 2. Tabela: ETAPAS (As Camadas: Fotevista, Entrevista, FineArt)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ensaio_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['fotevista', 'entrevista', 'fineart', 'texto_livre'],
                'default'    => 'fotevista',
            ],
            'ordem' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 1,
            ],
            'descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ensaio_id', 'ensaios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('etapas');

        // 3. Tabela: ITENS (O Conteúdo: Fotos, Vídeos, Textos)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'etapa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['foto', 'video', 'texto', 'citacao', 'audio'],
                'default'    => 'foto',
            ],
            'conteudo' => [
                'type' => 'TEXT', // URL ou texto
            ],
            'legenda' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'classe_css' => [
                'type'       => 'VARCHAR',
                'constraint' => 100, 
                'default'    => 'col-md-4', // Controle de layout (grid)
            ],
            'ordem' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 1,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('etapa_id', 'etapas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('itens');
    }

    public function down()
    {
        $this->forge->dropTable('itens');
        $this->forge->dropTable('etapas');
        $this->forge->dropTable('ensaios');
    }
}
