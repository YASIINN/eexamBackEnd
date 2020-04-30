<?php

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::where("id", ">", 0)->delete();
        $datas = [
            ["name"=>"A", "code"=>"A"],
            ["name"=>"B", "code"=>"B"],
            ["name"=>"C", "code"=>"C"],
            ["name"=>"D", "code"=>"D"],
          ];
       foreach ($datas as $key=>$data) {
           $school = new Branch();
           $school->name =$data["name"];
           $school->code = $data["code"];
           $school->save();
       }
    }
}
