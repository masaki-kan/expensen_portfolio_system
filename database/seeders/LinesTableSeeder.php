<?php

namespace Database\Seeders;

use App\Models\Line;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $line_lists = [
            [
                'id' => 1,
                'line' => 'JR',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 2,
                'line' => '地下鉄',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 3,
                'line' => '阪神',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 4,
                'line' => '阪急',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 5,
                'line' => '近鉄',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 6,
                'line' => '南海',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 7,
                'line' => '京阪',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 8,
                'line' => '神戸電鉄',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 9,
                'line' => 'その他',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ]
        ];
        foreach ($line_lists as $lists) {
            DB::table('lines')->insert($lists);
        }
    }
}
