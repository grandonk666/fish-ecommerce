<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('auth_groups')->insert([
            'name' => 'admin',
            'description' => 'Web Administrator'
        ]);
        $this->db->table('auth_groups')->insert([
            'name' => 'user',
            'description' => 'Regular User'
        ]);

        $user = new User([
            'username' => 'trikurniawan',
            'firstname' => 'Tri',
            'lastname' => 'Kurniawan',
            'email' => 'trikurniawan02091998@gmail.com',
            'phone' => '081234567890',
            'password' => 'Trikurniawan1927',
        ]);
        $user->activate();
        $users = model('UserModel');
        $users->withGroup('admin');
        $users->save($user);

        $this->db->table('categories')->insert([
            'name' => 'Fish',
            'slug' => 'fish',
            'image' => 'category-default.jpg'
        ]);
        $this->db->table('categories')->insert([
            'name' => 'Lobster',
            'slug' => 'lobster',
            'image' => 'category-default.jpg'
        ]);

        $this->db->table('products')->insert([
            'name' => 'Tuna',
            'slug' => 'tuna',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'product-default.jpg',
            'domestic_stock' => 100,
            'international_stock' => 20
        ]);
        $this->db->table('products')->insert([
            'name' => 'Salmon',
            'slug' => 'salmon',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 120000,
            'image' => 'product-default.jpg',
            'domestic_stock' => 80,
            'international_stock' => 20
        ]);

        $this->db->table('products')->insert([
            'name' => 'Jumbo Lobster',
            'slug' => 'jumbo-lobster',
            'category_id' => 2,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 110000,
            'image' => 'product-default.jpg',
            'domestic_stock' => 0,
            'international_stock' => 40
        ]);
        $this->db->table('products')->insert([
            'name' => 'Mini Lobster',
            'slug' => 'mini-lobster',
            'category_id' => 2,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 90000,
            'image' => 'product-default.jpg',
            'domestic_stock' => 200,
            'international_stock' => 0
        ]);
    }
}
