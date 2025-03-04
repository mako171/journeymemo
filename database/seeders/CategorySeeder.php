<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['観る', '遊ぶ', '食べる', '泊まる', '買う', 'イベント', 'アクセス', 'その他'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
