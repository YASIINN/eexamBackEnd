<?php

use Illuminate\Database\Seeder;
use App\Models\SchoolClassBranchPivot as SCB;

class SchoolClassBranchPivotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SCB::where("id", ">", 0)->delete();
        /*ilk okul


        */
        $datas = [
            ["school_id"=>35,"class_id"=>1,"branch_id"=>1],
            ["school_id"=>35,"class_id"=>1,"branch_id"=>2],
            ["school_id"=>35,"class_id"=>1,"branch_id"=>3],
            ["school_id"=>35,"class_id"=>1,"branch_id"=>4],
            ["school_id"=>35,"class_id"=>2,"branch_id"=>1],
            ["school_id"=>35,"class_id"=>2,"branch_id"=>2],
            ["school_id"=>35,"class_id"=>2,"branch_id"=>3],
            ["school_id"=>35,"class_id"=>2,"branch_id"=>4],
            ["school_id"=>35,"class_id"=>3,"branch_id"=>1],
            ["school_id"=>35,"class_id"=>3,"branch_id"=>2],
            ["school_id"=>35,"class_id"=>3,"branch_id"=>3],
            ["school_id"=>35,"class_id"=>3,"branch_id"=>4],
            ["school_id"=>35,"class_id"=>4,"branch_id"=>1],
            ["school_id"=>35,"class_id"=>4,"branch_id"=>2],
            ["school_id"=>35,"class_id"=>4,"branch_id"=>3],
            ["school_id"=>35,"class_id"=>4,"branch_id"=>4],
            
            ["school_id"=>34,"class_id"=>5,"branch_id"=>1],
            ["school_id"=>34,"class_id"=>5,"branch_id"=>2],
            ["school_id"=>34,"class_id"=>5,"branch_id"=>3],
            ["school_id"=>34,"class_id"=>5,"branch_id"=>4],
            
            ["school_id"=>34,"class_id"=>6,"branch_id"=>1],
            ["school_id"=>34,"class_id"=>6,"branch_id"=>2],
            ["school_id"=>34,"class_id"=>6,"branch_id"=>3],
            ["school_id"=>34,"class_id"=>6,"branch_id"=>4],

            ["school_id"=>34,"class_id"=>7,"branch_id"=>1],
            ["school_id"=>34,"class_id"=>7,"branch_id"=>2],
            ["school_id"=>34,"class_id"=>7,"branch_id"=>3],
            ["school_id"=>34,"class_id"=>7,"branch_id"=>4],

            ["school_id"=>34,"class_id"=>8,"branch_id"=>1],
            ["school_id"=>34,"class_id"=>8,"branch_id"=>2],
            ["school_id"=>34,"class_id"=>8,"branch_id"=>3],
            ["school_id"=>34,"class_id"=>8,"branch_id"=>4],

            ["school_id"=>33,"class_id"=>9,"branch_id"=>1],
            ["school_id"=>33,"class_id"=>9,"branch_id"=>2],
            ["school_id"=>33,"class_id"=>9,"branch_id"=>3],
            ["school_id"=>33,"class_id"=>9,"branch_id"=>4],

            ["school_id"=>33,"class_id"=>10,"branch_id"=>1],
            ["school_id"=>33,"class_id"=>10,"branch_id"=>2],
            ["school_id"=>33,"class_id"=>10,"branch_id"=>3],
            ["school_id"=>33,"class_id"=>10,"branch_id"=>4],

            ["school_id"=>33,"class_id"=>11,"branch_id"=>1],
            ["school_id"=>33,"class_id"=>11,"branch_id"=>2],
            ["school_id"=>33,"class_id"=>11,"branch_id"=>3],
            ["school_id"=>33,"class_id"=>11,"branch_id"=>4],

            ["school_id"=>33,"class_id"=>12,"branch_id"=>1],
            ["school_id"=>33,"class_id"=>12,"branch_id"=>2],
            ["school_id"=>33,"class_id"=>12,"branch_id"=>3],
            ["school_id"=>33,"class_id"=>12,"branch_id"=>4],

        
            ["school_id"=>32,"class_id"=>9,"branch_id"=>1],
            ["school_id"=>32,"class_id"=>9,"branch_id"=>2],
            ["school_id"=>32,"class_id"=>9,"branch_id"=>3],
            ["school_id"=>32,"class_id"=>9,"branch_id"=>4],

            ["school_id"=>32,"class_id"=>10,"branch_id"=>1],
            ["school_id"=>32,"class_id"=>10,"branch_id"=>2],
            ["school_id"=>32,"class_id"=>10,"branch_id"=>3],
            ["school_id"=>32,"class_id"=>10,"branch_id"=>4],

            ["school_id"=>32,"class_id"=>11,"branch_id"=>1],
            ["school_id"=>32,"class_id"=>11,"branch_id"=>2],
            ["school_id"=>32,"class_id"=>11,"branch_id"=>3],
            ["school_id"=>32,"class_id"=>11,"branch_id"=>4],

            ["school_id"=>32,"class_id"=>12,"branch_id"=>1],
            ["school_id"=>32,"class_id"=>12,"branch_id"=>2],
            ["school_id"=>32,"class_id"=>12,"branch_id"=>3],
            ["school_id"=>32,"class_id"=>12,"branch_id"=>4],
  
          ];
       foreach ($datas as $key=>$data) {
           $school = new SCB();
           $school->school_id =$data["school_id"];
           $school->class_id = $data["class_id"];
           $school->branch_id = $data["branch_id"];
           $school->save();
       }
    }
}
