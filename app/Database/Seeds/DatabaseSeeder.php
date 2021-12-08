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
            'image' => 'fish.jpg'
        ]);
        $this->db->table('categories')->insert([
            'name' => 'Lobster',
            'slug' => 'lobster',
            'image' => 'lobster.jpg'
        ]);
        $this->db->table('categories')->insert([
            'name' => 'Other',
            'slug' => 'other',
            'image' => 'category-default.jpg'
        ]);

        $this->db->table('products')->insert([
            'name' => 'Baby Octopus',
            'slug' => 'baby-octopus',
            'category_id' => 3,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'baby-octopus.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Bamboo Lobster',
            'slug' => 'bamboo-lobster',
            'category_id' => 2,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'bamboo-lobster.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Cube Tuna',
            'slug' => 'cube-tuna',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'cube-tuna.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Cuttlefish',
            'slug' => 'cuttlefish',
            'category_id' => 3,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'cuttlefish.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Leather Jacket',
            'slug' => 'leather-jacket',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'leather-jacket.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Lizard Fish',
            'slug' => 'lizard-fish',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'lizard-fish.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Loligo Squid',
            'slug' => 'loligo-squid',
            'category_id' => 3,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'loligo-squid.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Red Big Eye',
            'slug' => 'red-big-eye',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'red-big-eye.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Red Snapper',
            'slug' => 'red-snapper',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'red-snapper.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Ribbon Fish',
            'slug' => 'ribbon-fish',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'ribbon-fish.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Sashima Tuna',
            'slug' => 'sashima-tuna',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'sashima-tuna.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Skipjack Tuna',
            'slug' => 'skipjack-tuna',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'skipjack-tuna.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Slipper Lobster',
            'slug' => 'slipper-lobster',
            'category_id' => 2,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'slipper-lobster.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'White Pomfret',
            'slug' => 'white-pomfret',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'white-pomfret.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
        $this->db->table('products')->insert([
            'name' => 'Yellow Fin Tuna',
            'slug' => 'yellow-fin-tuna',
            'category_id' => 1,
            'detail' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae perferendis, facere quisquam totam soluta ad harum inventore alias iste consectetur quas voluptate',
            'price' => 100000,
            'image' => 'yellow-fin-tuna.jpeg',
            'domestic_stock' => 100,
            'international_stock' => 10
        ]);
    }
}
