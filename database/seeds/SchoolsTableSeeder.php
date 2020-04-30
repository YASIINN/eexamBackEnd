<?php

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          School::where("id", ">", 0)->delete();
          $datas = [
              ["name"=>"Özel Zafer Anadolu Lisesi", "code"=>"AL"],
              ["name"=>"Özel Zafer Fen Lisesi", "code"=>"FL"],
              ["name"=>"Özel Zafer Ortaokulu", "code"=>"ORT"],
              ["name"=>"Özel Zafer İlkokulu", "code"=>"ILK"]
            ];
         foreach ($datas as $key=>$data) {
             $school = new School();
             $school->name =$data["name"];
             $school->code = $data["code"];
             $school->save();
         }
    }
}
