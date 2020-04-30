<?php

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::where("id", ">", 0)->delete();
        $datas = [
            ["name"=>"A"],
            ["name"=>"B"],
            ["name"=>"C"],
            ["name"=>"D"],
            ["name"=>"E"]
          ];
       foreach ($datas as $key=>$data) {
           $school = new Option();
           $school->name =$data["name"];
           $school->save();
       }
    }
}
