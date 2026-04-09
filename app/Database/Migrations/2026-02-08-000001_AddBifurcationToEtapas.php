<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBifurcationToEtapas extends Migration
{
    public function up()
    {
        $fields = [
            'parent_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
                'comment'    => 'ID da etapa anterior (Pai). Se NULL, é o inicio da caverna.'
            ],
            'decisao_texto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'descricao',
                'comment'    => 'Texto do botão que leva a esta etapa (Ex: Entrar na fenda escura)'
            ],
        ];

        $this->forge->addColumn('etapas', $fields);

        // Adiciona a chave estrangeira para garantir integridade (se apagar o pai, pode dar cascade ou set null)
        // Aqui usaremos SET NULL para não perder etapas filhas acidentalmente se o pai for deletado
        $this->forge->addForeignKey('parent_id', 'etapas', 'id', 'CASCADE', 'SET NULL');
        $this->forge->processIndexes('etapas');
    }

    public function down()
    {
        $this->forge->dropForeignKey('etapas', 'etapas_parent_id_foreign');
        $this->forge->dropColumn('etapas', ['parent_id', 'decisao_texto']);
    }
}
