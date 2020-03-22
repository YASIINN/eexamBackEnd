<?php

use Illuminate\Database\Seeder;
use App\Models\ExamType;

class ExamTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamType::where("id", ">", 0)->delete();
        $datas = [
            ["name"=>"Lise Deneme"],
            ["name"=>"İlkokul Deneme"],
            ["name"=>"Ortaokul Deneme"],
            ["name"=>"LGS Deneme"],
            ["name"=>"Lise Ünite Testi"],
            ["name"=>"İlkokul Ünite Testi"],
            ["name"=>"Ortaokul Ünite Testi"],
            ["name"=>"YKS Lise"]
          ];
       foreach ($datas as $key=>$data) {
           $school = new ExamType();
           $school->name =$data["name"];
           $school->save();
       }
    }
}
