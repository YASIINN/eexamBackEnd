<?php

namespace App\Imports;

use App\Models\User;
use App\Models\School;
use App\Models\Clas;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class UsersImport implements OnEachRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        if($rowIndex > 1){
            $user = new User();
            $user->schoolNo = $row[0];
            $user->name = $row[1];
            $user->surname = $row[2];
            $user->fullname=$row[1].''.$row[2];
            $user->tc = $row[3];
            $user->email = $row[7];
            $user->password = Hash::make("123456");
            $user->school_id = School::where("name", $row[4])->first()->id;
          $user->class_id = Clas::where("name", $row[5])->first()->id;
          $user->branch_id=Branch::where("name", $row[6])->first()->id;
          $user->status=0;
          $user->type=0;

          return $user->save();

            //     "schoolNo"=>$row[0],
            //     "name"=>$row[1],
            //     "surname"=>$row[2],
            //     "fullname"=>$row[1].' '.$row[2],
            //     "tc"=>$row[3],
            //     "email"=>$row[7],
            //     'password' => Hash::make("123456"),
            //     'school_id' => 32,
            //     'class_id' => 10,
            //     "branch_id"=>1,
            //     "status"=>1,
            //     "type"=>1
            // ];
        }



        return $row;
    }
}
