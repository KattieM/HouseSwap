<?php

namespace App\Http\Controllers;

use App\PostCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostCodeController extends Controller
{
    public function returnPostCodes(){
        $postCodes = DB::table('postcodes')->selectRaw('DISTINCT(SUBSTRING_INDEX(postcode, \' \', 1)) AS dist')->whereNotNull('postcode')->orderBy('dist', 'asc')->get()->filter();
        return view('mainpage', ['postCodes' =>$postCodes]);
    }

    public function returnAllPostCodes(Request $request){

        $postCodes = DB::table('postcodes')->where('postcode','like', $request['postCode']."%")->get();
        return $postCodes;
    }
}
