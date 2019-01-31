<?php

namespace App\Http\Controllers;

use App\Address;
use App\House;
use App\PostCode;
use App\School;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

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

    public function returnDataForTable(Request $request)
    {
        $addresses = Address::where('postcode_id', '=', $request['postcode_id'])->get();

        $postCode = PostCode::where('id', '=', $request['postcode_id'])->first();
        $schools = DB::table('postcodes')->join('schools', 'postcodes.id', '=', 'schools.postcode_id')->selectRaw('schools.name, ( 6371 * acos( cos( radians('.$postCode->latitude.') ) * cos( radians( postcodes.latitude ) ) * cos( radians( postcodes.longitude ) - radians('.$postCode->longitude.') ) + sin( radians('.$postCode->latitude.') ) * sin( radians( postcodes.latitude ) ) ) ) AS distance')->havingRaw('distance <= 20')->orderBy('distance', 'asc')->get();
        $busstops = DB::table('busstops')->selectRaw('id, name, 6371 * acos(cos(radians(' . $postCode->latitude . ')) * cos(radians(lat)) * cos(radians(lon) -
            radians(' . $postCode->longitude . ')) + sin(radians(' . $postCode->latitude . '))*sin(radians(lat))) AS distance')->orderBy('distance', 'asc')->take(5)->get();

        return ['busstops'=>$busstops, 'schools'=>$schools, 'addresses'=>$addresses];
    }

//    public function export()
//    {
//        $headers = array(
//            "Content-type" => "text/csv",
//            "Content-Disposition" => "attachment; filename=file.csv",
//            "Pragma" => "no-cache",
//            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
//            "Expires" => "0"
//        );
//
//        $reviews = User::getDataExport();
//
//        $columns = array('id', 'name', 'surname', 'email');
//
//        $callback = function() use ($reviews, $columns)
//        {
//            $file = fopen('php://output', 'w');
//            fputcsv($file, $columns);
//
//            foreach($reviews as $review) {
//
//                fputcsv($file, array($review->id, $review->name." ".$review->surname, "BLAAA", $review->email));
//
//
//            }
//            fclose($file);
//        };
//        return Response::stream($callback, 200, $headers);
//    }


}
