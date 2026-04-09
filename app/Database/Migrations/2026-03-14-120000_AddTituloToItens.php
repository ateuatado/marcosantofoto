<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTituloToItens extends Migration
{
    public function up()
    {
        // Verifica se a coluna já existe para evitar erros se foi criada manualmente
        $fields = $this->db->getFieldData('itens');
        $hasTitulo = false;
        foreach ($fields as $field) {
            if ($field->name === 'titulo') {
                $hasTitulo = true;
                break;
            }
        }

        if (!$hasTitulo) {
            $this->forge->addColumn('itens', [
                'titulo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                    'null'       => true,
                    'after'      => 'conteudo'
                ]
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('itens', 'titulo');
    }
}
