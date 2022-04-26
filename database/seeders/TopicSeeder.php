<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    private $tableName = 'topics';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic = DB::table($this->tableName)->find(1);
        if (!$topic) {
            DB::table('topics')->insert([
                'id'         => 1,
                'topic_name' => '结伴学习',
                'remarks'    => '结伴学习',
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
