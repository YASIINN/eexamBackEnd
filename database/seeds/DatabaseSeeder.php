<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(SchoolsTableSeeder::class);
         $this->call(ClassesTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(ChaptersTableSeeder::class);
         $this->call(OptionsTableSeeder::class);
         $this->call(ExamTypesTableSeeder::class);
        $this->call(LessonsTableSeeder::class);
        $this->call(ExamTypesTableSeeder::class);
       $this->call(GroupsTableSeeder::class);
        // $this->call(SchoolClassBranchPivotsTableSeeder::class);
    }
}
