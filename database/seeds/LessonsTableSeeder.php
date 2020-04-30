<?php

use Illuminate\Database\Seeder;
use App\Models\Lesson;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lesson::where("id", ">", 0)->delete();
        $datas = [
            ["name"=>"Türkçe"],
            ["name"=>"Matematik"],
            ["name"=>"Fen Bilimleri"],
            ["name"=>"Sosyal Bilimler"],
            ["name"=>"Tarih"],
            ["name"=>"Yabancı Dil"],
            ["name"=>"Din K. Ve Ahlak B."],
            ["name"=>"Türk Dili ve Edebiyatı"],
          ];
       foreach ($datas as $key=>$data) {
           $school = new Lesson();
           $school->name =$data["name"];
           $school->save();
       }
    }
}
