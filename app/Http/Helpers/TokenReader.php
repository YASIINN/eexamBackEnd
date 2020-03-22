<?php


namespace App\Http\Helpers;


use Illuminate\Support\Facades\DB;
use ReallySimpleJWT\Token;

class TokenReader
{
    public function read($token, $key, $id)
    {
        $decoded = Token::getPayload($token, env("JWT_SECRET"));
        if ($decoded) {
            $result = DB::table('users')
                ->where("id", $decoded['id'])
                ->get();
            if ($decoded['id'] == $result[0]->id && $decoded['tc'] == $result[0]->tc) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}
/*
return $res['id'];*/
