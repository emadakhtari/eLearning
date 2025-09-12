<?php

use App\Modules\Teacher\Admin\Models\Teacher;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::insert(
            [
                'id' => '1',
                'name' => 'عماد',
                'family' => 'اختری',
                'phone' => '09125666716',
                'national_code' => '0323738893',
                'password' => bcrypt('123456'),
                'school_id' => '1',
                'email' => 'akhtari.em@zoho.com',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => '2',
                'name' => 'سادینا',
                'family' => 'آبائی',
                'phone' => '09121831613',
                'national_code' => '3961769311',
                'password' => bcrypt('123456'),
                'school_id' => '2',
                'email' => 'sadina@seemsys.com',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        );
    }
}