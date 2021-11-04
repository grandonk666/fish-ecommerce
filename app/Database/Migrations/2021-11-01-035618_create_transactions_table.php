<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
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
            'user_id'       => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'serial_number' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'transaction_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'status_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'payment_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'payment_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'pdf_url' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'delivery_service' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'delivery_cost'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'reciept_number' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
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
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('transactions', true);
    }

    public function down()
    {
        $this->forge->dropTable('transactions', true);
    }
}
