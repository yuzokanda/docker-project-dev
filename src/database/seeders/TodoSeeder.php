<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('todos')->insert([
            [
                'task' => 'プログラミング学習',
                'description' => 'Laravel collectionについて',
                'due_date' => '2024-05-30',
                'due_time' => '18:00',
                'completed' => 1
            ],
            [
                'task' => '買い物',
                'description' => '今晩の夕食と明日の昼食の食材',
                'due_date' => '2024-05-31',
                'due_time' => '17:00',
                'completed' => 1
            ],
            [
                'task' => 'アプリ作成',
                'description' => 'vue.js側の仕上げ',
                'due_date' => '2024-06-03',
                'due_time' => '19:00',
                'completed' => 0
            ]
        ]);
    }
}
