<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;

class FieldSeeder extends Seeder
{

    public function run()
    {
        $ids = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22
        ];
        $name = [
            'Khoa học động vật', 'Khoa học xã hội và hành vi', 'Hóa Sinh', 'Y Sinh và khoa học Sức khỏe', 'Kĩ thuật Y Sinh', 'Sinh học tế bào và phân tử', 'Hóa học', 'Sinh học trên máy tính và Sinh -Tin', 'Khoa học Trái đất và Môi trường', 'Hệ thống nhúng', 'Năng lượng: Hóa học', 'Năng lượng: Vật lí', 'Kĩ thuật cơ khí', 'Kĩ thuật môi trường', 'Khoa học vật liệu', 'Toán học', 'Vi Sinh', 'Vật lí và Thiên văn', 'Khoa học Thực vật', 'Rô bốt và máy thông minh', 'Phần mềm hệ thống', 'Y học chuyển dịch'
        ];
        $nameEn = [
            'ANIMAL SCIENCES ', 'BEHAVIORAL AND SOCIAL SCIENCES ', 'BIOCHEMISTRY ', 'BIOMEDICAL AND HEALTH SCIENCES ', 'BIOMEDICAL ENGINEERING ', 'CELLULAR AND MOLECULAR BIOLOGY ', 'CHEMISTRY ', 'COMPUTATIONAL BIOLOGY AND BIOINFORMATICS ', 'EARTH AND ENVIRONMENTAL SCIENCES ', 'EMBEDDED SYSTEMS ', 'ENERGY: CHEMICAL ', 'ENERGY: PHYSICAL ', 'ENGINEERING MECHANICS ', 'ENVIRONMENTAL ENGINEERING ', 'MATERIALS SCIENCE ', 'MATHEMATICS ', 'MICROBIOLOGY ', 'PHYSICS AND ASTRONOMY ', 'PLANT SCIENCES ', 'ROBOTICS AND INTELLIGENT MACHINES ', 'SYSTEMS SOFTWARE ', 'TRANSLATIONAL MEDICAL SCIENCES '
        ];
        foreach ($ids as $key => $id) {
            Field::create([
                'id' => $id,
                'name' => $name[$key],
                'nameEn' => $nameEn[$key]
            ]);
        }
    }
}