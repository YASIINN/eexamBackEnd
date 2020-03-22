<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;

class TestController extends Controller
{
    public function index()
    {
        $no = ["0216", "0215", "0214"];
        $tc = "11111111111";
        $sinif = "042";
        $group = "A";
        $bosluk = "   ";

        $info = "0424B000216A           ";
        $infos = [
            "0424B000216A           ",
            "0424B000214A           ",
            "0424B000217B           "
        ];
        $fullnames = ["adem özgen          ", "yasin dalkilic      ", "ali akcan           "];
        $chapter1 = "CBAAAABBCCADBDA               ";
        $chapter2 = "DCCADDCACDDCAAD               ";
        $chapter3 = "DCCADDCCCDDCAAD               ";
        $chapter4 = "CBAAABBDCCADBDA               ";

        foreach ($fullnames as $key => $name) {
            $line = $name . $bosluk . $no[$key] . $bosluk . $tc . $bosluk . $sinif . $bosluk . $group . $bosluk . $chapter1 . $chapter2 . $chapter3 . $chapter4;
            //  $line = $key.$line;
            if ($key === 0) {
                Storage::put('public/file.dat', $line);
            } else {
                Storage::append('public/file.dat', $line);
            }

        }

    }

    public function test(Request $request)
    {
        date_default_timezone_set('Europe/Istanbul');

/*        for ($i = 0; $i < 50; $i++) {
            $test = new Question();
            $test->qNo = $i + 1;
            $test->exam_group_id = 4;
            $test->qAnswer = "";
            $test->save();
        }*/

        //    $today = new Carbon(new \DateTime(), new \DateTimeZone('Europe/Istanbul'));
     /*   $today = Carbon::now();
        $aa = $today->format("H:i");*/
        return $aa;
        //false ise küçük şuan verilen saatten
        //true ise now 16:54 den küçük değil büyük o saat geçti ise
        //->format("Y-m-d H:i");
        if ($today == 1) {
            echo "saat tamam";
        } else {
            echo "vakit var";
        }
        /*   $aa = $today->format("H:i");*/


        $saat1 = "10:00";
        $saat2 = "17:00";
        /*        return $aa;*/

    }
}
