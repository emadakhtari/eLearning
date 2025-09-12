<?php

use App\Modules\Deputy\Admin\Models\Deputy;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DeputySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deputy::insert(
            [
                'id' => '1',
                'name' => 'معاون',
                'family' => 'گلبانگ',
                'phone' => '09301583798',
                'national_code' => '0452320496',
                'password' => bcrypt('123456'),
                'school_id' => 1,
                'email' => 'hasan@seemsys.com',
                'above_id' => '0',
                'level' => '1',
                'status' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => '2',
                'name' => 'حسین',
                'family' => 'جمشیدی',
                'phone' => '09301583798',
                'national_code' => '1234567890',
                'password' => bcrypt('123456'),
                'school_id' => 2,
                'email' => 'hasan@seemsys.com',
                'above_id' => '0',
                'level' => '1',
                'status' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        );
    }
}