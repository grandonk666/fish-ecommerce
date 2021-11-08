<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id'       => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'detail' => [
                'type' => 'TEXT',
            ],
            'price'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'domestic_stock'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'international_stock'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'created_at'       => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at'       => [
                'type' => 'datetime',
                'null' => true
            ],
            'deleted_at'       => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('category_id', 'categories', 'id', '', 'CASCADE');
        $this->forge->createTable('products', true);
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
