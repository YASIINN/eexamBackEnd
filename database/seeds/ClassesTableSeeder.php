<?php

use Illuminate\Database\Seeder;
use App\Models\Clas;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clas::where("id", ">", 0)->delete();
        $datas = [
            ["name"=>"1. Sınıf", "code"=>"01"],
            ["name"=>"2. Sınıf", "code"=>"02"],
            ["name"=>"3. Sınıf", "code"=>"03"],
            ["name"=>"4. Sınıf", "code"=>"04"],
            ["name"=>"5. Sınıf", "code"=>"05"],
            ["name"=>"6. Sınıf", "code"=>"06"],
            ["name"=>"7. Sınıf", "code"=>"07"],
            ["name"=>"8. Sınıf", "code"=>"08"],
            ["name"=>"9. Sınıf", "code"=>"09"],
            ["name"=>"10. Sınıf", "code"=>"10"],
            ["name"=>"11. Sınıf", "code"=>"11"],
            ["name"=>"12. Sınıf", "code"=>"12"]
          ];
       foreach ($datas as $key=>$data) {
           $school = new Clas();
           $school->name =$data["name"];
           $school->code = $data["code"];
           $school->save();
       }
    }
}
