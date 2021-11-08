<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInternationalTransactionsTable extends Migration
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
			'product_id'       => [
				'type'       => 'INT',
				'constraint' => 5,
				'unsigned' => true
			],
			'company_name' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'address' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'status' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'invoice' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			],
			'payment' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			],
			'shipping_reciept' => [
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
		$this->forge->addForeignKey('product_id', 'products', 'id', '', 'CASCADE');
		$this->forge->createTable('international_transactions', true);
	}

	public function down()
	{
		$this->forge->dropTable('international_transactions', true);
	}
}
