<?php

use Illuminate\Database\Seeder;
use App\Modules\UserCategory\Admin\Models\UserCategory;

class UserCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCategories = [
            [
                'id' => '1',
                'title' => 'ادمین',
                'permissions' => '{"admin":{"Base":{"permAll":"no","permissions":["{\"Add\":[\"Base.Add.View\",\"Base.Add\"]}","{\"Edit\":[\"Base.Edit.View\",\"Base.Edit\"]}","{\"List\":[\"Base.List.View\"]}"]},"Grade":{"permAll":"no","permissions":["{\"Add\":[\"Grade.Add.View\",\"Grade.Add\"]}","{\"Edit\":[\"Grade.Edit.View\",\"Grade.Edit\"]}","{\"List\":[\"Grade.List.View\"]}"]},"Lesson":{"permAll":"no","permissions":["{\"Add\":[\"Lesson.Add.View\",\"Lesson.Add\"]}","{\"Edit\":[\"Lesson.Edit.View\",\"Lesson.Edit\"]}","{\"List\":[\"Lesson.List.View\"]}"]},"School":{"permAll":"no","permissions":["{\"Add\":[\"School.Add.View\",\"School.Add\"]}"]},"Setting":{"permAll":"no","permissions":["{\"Edit\":[\"Setting.Edit.View\",\"Setting.Edit\"]}"]},"UserCategory":{"permAll":"no","permissions":["{\"Add\":[\"UserCategory.Add.View\",\"UserCategory.Add\"]}","{\"Edit\":[\"UserCategory.Edit.View\",\"UserCategory.Edit\"]}","{\"List\":[\"UserCategory.List.View\"]}"]},"Users":{"permAll":"no","permissions":["{\"Add\":[\"Users.Add.View\",\"Users.Add\"]}","{\"Edit\":[\"Users.Edit.View\",\"Users.Edit\"]}","{\"List\":[\"Users.List.View\"]}"]}}}',
                'status' => '1'
            ],
            [
                'id' => '2',
                'title' => 'مدیر سیستم',
                'permissions' => '{"admin":{"Setting":{"permAll":"no","permissions":["{\"Edit\":[\"Setting.Edit.View\",\"Setting.Edit\"]}"]}}}',
                'status' => '1'
            ]
        ];
        foreach ($userCategories as $category) {
            UserCategory::create($category);
        }
    }
}