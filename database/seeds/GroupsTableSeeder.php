<?php

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::where("id", ">", 0)->delete();
        $datas = [
            ["name"=>"A"],
            ["name"=>"B"],
            ["name"=>"C"],
            ["name"=>"D"],
            ["name"=>"E"]
          ];
       foreach ($datas as $key=>$data) {
           $school = new Group();
           $school->name =$data["name"];
           $school->save();
       }
    }
}
