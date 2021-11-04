<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $subject_lists = [
            [
                'id' => 1,
                'subject' => '交通費',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 2,
                'subject' => '車両費',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 3,
                'subject' => '交際費',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 4,
                'subject' => '会議費',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 5,
                'subject' => '通信費',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ],
            [
                'id' => 6,
                'subject' => 'その他',
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30'
            ]
        ];

        foreach ($subject_lists as $lists) {
            DB::table('subjects')->insert($lists);
        }
    }
}
