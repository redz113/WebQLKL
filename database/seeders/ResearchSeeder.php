<?php

namespace Database\Seeders;

use App\Models\Research;
use Illuminate\Database\Seeder;

class ResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Research::create([
            'name' => 'Tên đề tài',
            'nameEn' => 'Name Research',
            'status' => 1,
            'province_id' => 1,
            'user_id' => 3,
            'field_id' => 1,
            'student_1' => '1,1,1,1,1,1,1',
            'school_1' => '',
            'teacher' => 'LXH'
        ]);
    }
}
