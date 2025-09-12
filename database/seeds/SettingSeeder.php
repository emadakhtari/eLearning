<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')
            ->insert([
                'title' =>  'مدیر سامانه',
                'login_image' =>  'login_image1613262960_shoa.png',
                'top_menu_image' =>  'top_menu_image1613257666_pajoohesh.jpg',
                'signature_image' =>  'signature_image1613258350_shoa (1).png',
                'software_text' =>  '<p style="text-align:center"><span style="color:#f87008"><span style="font-size:18px">سامانه آموزش الکترونیک شُعا</span></span></p>',
                'owner_text' =>  '<p style="text-align:center"><span style="font-size:18px">شرکت سامانه&zwnj;های هوشمند سیمرغ</span></p>',
                'powered_text' =>  '<p style="text-align:center"><span style="color:#f87008">قدرت یافته از سکوی نرم افزاری <em><strong>سیم&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;&zwnj;سا ای&zwnj;ال</strong></em></span></p>',
                'license_text' =>  '<p style="text-align:center"><span style="font-size:12px">وابسته به گروه فناوری اطلاعات و ارتباطات سیمرغ سامانه</span></p>',
            ]);
    }
}