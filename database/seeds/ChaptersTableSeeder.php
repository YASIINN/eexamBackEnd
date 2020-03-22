<?php

use Illuminate\Database\Seeder;
use App\Models\Chapter;
class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chapter::where("id", ">", 0)->delete();
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
           $school = new Chapter();
           $school->name =$data["name"];
           $school->save();
       }
        
    }
}
