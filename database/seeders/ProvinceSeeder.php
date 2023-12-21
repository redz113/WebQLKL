<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Permission;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = [
            1, 2, 4, 6, 8, 10, 11, 12, 14, 15, 17, 19, 20, 22, 24, 25, 26, 27, 30, 31, 33, 34, 35, 36, 37, 38, 40, 42, 44, 45, 46, 48, 49, 51, 52, 54, 56, 58, 60, 62, 64, 66, 67, 68, 70, 72, 74, 75, 77, 79, 80, 82, 83, 84, 86, 87, 89, 91, 92, 93, 94, 95, 96
        ];
        $provinces = [
            'Hà Nội', 'Hà Giang', 'Cao Bằng', 'Bắc Kạn', 'Tuyên Quang', 'Lào Cai', 'Điện Biên', 'Lai Châu', 'Sơn La', 'Yên Bái', 'Hòa Bình', 'Thái Nguyên', 'Lạng Sơn', 'Quảng Ninh', 'Bắc Giang', 'Phú Thọ', 'Vĩnh Phúc', 'Bắc Ninh', 'Hải Dương', 'Hải Phòng', 'Hưng Yên', 'Thái Bình', 'Hà Nam', 'Nam Định', 'Ninh Bình', 'Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Quảng Bình', 'Quảng Trị', 'Thừa Thiên Huế', 'Đà Nẵng', 'Quảng Nam', 'Quảng Ngãi', 'Bình Định', 'Phú Yên', 'Khánh Hòa', 'Ninh Thuận', 'Bình Thuận', 'Kon Tum', 'Gia Lai', 'Đăk Lăk', 'Đăk Nông', 'Lâm Đồng', 'Bình Phước', 'Tây Ninh', 'Bình Dương', 'Đồng Nai', 'Bà Rịa - Vũng Tàu', 'Hồ Chí Minh', 'Long An', 'Tiền Giang', 'Bến Tre', 'Trà Vinh', 'Vĩnh Long', 'Đồng Tháp', 'An Giang', 'Kiên Giang', 'Cần Thơ', 'Hậu Giang', 'Sóc Trăng', 'Bạc Liêu', 'Cà Mau'
        ];

        $role = Role::create(['name' => 'Chuyên viên Sở']);
        $permissions = [17,18,19,20,29, 30, 31, 32, 33, 34, 36];

        $role->syncPermissions($permissions);

        foreach ($ids as $key => $id) {
            Province::create(['id' => $id, 'name' => $provinces[$key]]);
            $user = User::create([
                'name' => 'Sở Giáo dục và Đào tạo ' . $provinces[$key],
                'username' => Str::slug($provinces[$key], '_'),
                'id_ref' => $id,
                'role' => 3,
                'password' => bcrypt('123456')
            ]);
            $user->assignRole([$role->id]);
        }
        $schools = [
            ['name' => 'PT Vùng Cao Việt Bắc', 'username' => 'pt_vung_cao_viet_bac', 'id_ref' => 19, 'role' => 3, 'password' => bcrypt('123456')],
            ['name' => 'Trường Đại học Khoa học tự nhiên - ĐHQG HN', 'username' => 'dh_khoa_hoc_tu_nhien', 'id_ref' => 1, 'role' => 3, 'password' => bcrypt('123456')],
            ['name' => 'Trường Đại học Giáo dục - ĐHQG HN', 'username' => 'dh_giao_duc', 'id_ref' => 1, 'role' => 3, 'password' => bcrypt('123456')],
            ['name' => 'Trường Đại học Ngoại ngữ - ĐHQG HN', 'username' => 'dh_ngoai_ngu', 'id_ref' => 1, 'role' => 3, 'password' => bcrypt('123456')],
            ['name' => 'Trường Đại học sư phạm TP. HCM', 'username' => 'dh_su_pham_hcm', 'id_ref' => 1, 'role' => 3, 'password' => bcrypt('123456')],
            ['name' => 'Đại học Vinh', 'username' => 'dh_vinh', 'id_ref' => 1, 'role' => 3, 'password' => bcrypt('123456')],
            ['name' => 'Trường Đại học sư phạm Hà Nội', 'username' => 'dh_su_pham_hn', 'id_ref' => 1, 'role' => 3, 'password' => bcrypt('123456')]
        ];

        foreach ($schools as $school){
            $user = User::create($school);
            $user->assignRole(3);
        }
        /* 
        INSERT INTO `users` (`name`, `username`, `email`, `role`, `id_ref`, `email_verified_at`, `password_change_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
        ( 'Trường Đại học khoa học tự nhiên - ĐHQG HN', 'dh_khoa_hoc_tu_nhien', NULL, 3, '1', NULL, NULL, '$2y$10$F5oRdMRJDQPC0BaWG96pauyeLpsHVDF211MGDPJ/xRploubnai87C', NULL, '2021-01-13 12:23:48', '2021-01-13 12:23:48'),
        ( 'Trường Đại học Giáo dục - ĐHQG HN', 'dh_giao_duc', NULL, 3, '1', NULL, NULL, '$2y$10$pHD4KlHxl5RwK7uxuW5OlO7ojpiQs0va3oiunwJnxf/1ziO/W3Cki', NULL, '2021-01-13 12:24:49', '2021-01-13 12:24:49'),
        ( 'Trường Đại học Ngoại ngữ - ĐHQG HN', 'dh_ngoai_ngu', NULL, 3, '1', NULL, NULL, '$2y$10$ZQ1Jy0Z5Xmkg37nbm.Kja.GRdHMgv9T3sx7mmSwFGPY7U.SXPecQG', NULL, '2021-01-13 12:25:25', '2021-01-13 12:25:25'),
        ( 'Trường Đại học sư phạm TP. HCM', 'dh_su_pham_hcm', NULL, 3, '79', NULL, NULL, '$2y$10$JzACPu6mEZ/EXRaYk62RSe0qN3sfRNA.Ayq5Dg/YgITNgqqH4o9uO', NULL, '2021-01-13 12:26:16', '2021-01-13 12:26:16'),
        ( 'Đại học Vinh', 'dh_vinh', NULL, 3, '40', NULL, NULL, '$2y$10$ewM8/EjaDfcYQ7N3azoBqerV1DkwLTHv8YhN3HfjznI.pK4QjKzCO', NULL, '2021-01-13 12:26:57', '2021-01-13 12:26:57'),
        ( 'Trường Đại học sư phạm Hà Nội', 'dh_su_pham_hn', NULL, 3, '1', NULL, NULL, '$2y$10$28I2NrR7NtdRYs4FrLXVFOKeZBXRA0Ptbf.wJL6tOl5te3x8SzXf.', NULL, '2021-01-13 12:27:25', '2021-01-13 12:27:25'),
        ( 'PT Vùng Cao Việt Bắc', 'pt_vung_cao_viet_bac', NULL, 3, '19', NULL, NULL, '$2y$10$BUxtmGARF4nSMGzGWZLJY.GfBGPZqOv9a.r62E1KUN2D7z7VCGs1e', NULL, '2021-01-14 02:53:53', '2021-01-14 02:53:53')
        */
    }
}
