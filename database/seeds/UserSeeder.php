<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'id' => '1',
            'name' => 'سید حسن',
            'family' => 'مقدم',
            'phone' => '09121583798',
            'national_code' => '0452320496',
            'publicName' => 'سید حسن مقدم',
            'password' => bcrypt('123456'),
            'email' => 'test@gmail.com',
            'address' => 'Iran,Tehran,Motahari',
            'status' => 1,
            'user_category_id' => 1,
            'level' => 0,
            'permissions' => '{"admin":{"Base":{"permissions":["{\"Add\":[\"Base.Add.View\",\"Base.Add\"]}","{\"Edit\":[\"Base.Edit.View\",\"Base.Edit\"]}","{\"List\":[\"Base.List.View\"]}"]},"Grade":{"permissions":["{\"Add\":[\"Grade.Add.View\",\"Grade.Add\"]}","{\"Edit\":[\"Grade.Edit.View\",\"Grade.Edit\"]}","{\"List\":[\"Grade.List.View\"]}"]},"Lesson":{"permissions":["{\"Add\":[\"Lesson.Add.View\",\"Lesson.Add\"]}","{\"Edit\":[\"Lesson.Edit.View\",\"Lesson.Edit\"]}","{\"List\":[\"Lesson.List.View\"]}"]},"School":{"permissions":["{\"Add\":[\"School.Add.View\",\"School.Add\"]}"]},"UserCategory":{"permissions":["{\"Add\":[\"UserCategory.Add.View\",\"UserCategory.Add\"]}","{\"Edit\":[\"UserCategory.Edit.View\",\"UserCategory.Edit\"]}","{\"List\":[\"UserCategory.List.View\"]}"]},"Users":{"permissions":["{\"Add\":[\"Users.Add.View\",\"Users.Add\"]}","{\"Edit\":[\"Users.Edit.View\",\"Users.Edit\"]}","{\"List\":[\"Users.List.View\"]}"]}}}',
        ]);
    }
}
