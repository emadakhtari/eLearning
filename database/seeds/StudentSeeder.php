<?php

use App\Modules\Students\Admin\Models\Students;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Students::insert(
            [
                'id' => '1',
                'name' => 'امیرمحمد',
                'family' => 'مقدم فر',
                'phone' => '09021583798',
                'image' => 'image1617022127_pp.jpg',
                'national_code' => '0025094548',
                'password' => bcrypt('123456'),
                'school_id' => 1,
                'deputy_id' => 1,
                'grade_id' => 3,
                'base_id' => 4,
                'class_id' => 2,
                'email' => 'hasan@seemsys.com',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => '2',
                'name' => 'علی',
                'family' => 'ابوتراب',
                'phone' => '09125666716',
                'image' => 'image1617022127_pp.jpg',
                'national_code' => '1234567890',
                'password' => bcrypt('123456'),
                'school_id' => 1,
                'deputy_id' => 1,
                'grade_id' => 3,
                'base_id' => 4,
                'class_id' => 2,
                'email' => 'test@gmail.com',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        );
    }
}