<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'categoryId' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'categoryName' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'categorySlug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'createdAt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'modifiedAt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('categoryId', true);
        $this->forge->createTable('productCategory');
    }

    public function down()
    {
        $this->forge->dropTable('productCategory');
    }
}
