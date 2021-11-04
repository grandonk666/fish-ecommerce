<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
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
            'transaction_id'       => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'product_id'       => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'quantity'       => [
                'type'       => 'INT',
                'constraint' => 5,
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
        $this->forge->addKey(['transaction_id', 'product_id']);
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', '', 'CASCADE');
        $this->forge->createTable('orders', true);
    }

    public function down()
    {
        $this->forge->dropTable('orders', true);
    }
}
