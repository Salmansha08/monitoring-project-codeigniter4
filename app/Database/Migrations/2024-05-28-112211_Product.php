<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'productId' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'productSlug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'categorySlug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'productName' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'productImage' => [
                'type' => 'VARCHAR',
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
        $this->forge->addKey('productId', true);
        $this->forge->createTable('product');
    }

    public function down()
    {
        $this->forge->dropTable('product');
    }
}
