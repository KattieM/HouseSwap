<?php

namespace App\Http\Controllers;

use App\Address;
use App\Exports\UsersExport;
use App\House;
use App\PostCode;
use App\School;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class PostCodeController extends Controller
{
    public function returnPostCodes(){
        $postCodes = DB::table('postcodes')->selectRaw('DISTINCT(SUBSTRING_INDEX(postcode, \' \', 1)) AS dist')->whereNotNull('postcode')->orderBy('dist', 'asc')->get()->filter();
        return view('mainpage', ['postCodes' =>$postCodes]);
    }

    public function returnAllPostCodes(Request $request){
        return DB::table('postcodes')->where('postcode','like', $request['postCode']."%")->get();
    }

    public function returnDataForTable(Request $request)
    {
        $addresses = Address::where('postcode_id', '=', $request['postcode_id'])->get();

        $schools = DB::table('postcodes')->join('schools', 'postcodes.id', '=', 'schools.postcode_id')
            ->selectRaw('schools.name, ( 6371 * acos( cos( radians('.$request['latitude'].') ) * cos( radians( postcodes.latitude ) ) * cos( radians( postcodes.longitude ) - radians('.$request['longitude'].') ) + sin( radians('.$request['latitude'].') ) * sin( radians( postcodes.latitude ) ) ) ) AS distance')->havingRaw('distance <= 20')->orderBy('distance', 'asc')->get();

        $busstops = DB::table('busstops')
            ->selectRaw(' name, 6371 * acos(cos(radians(' . $request['latitude'] . ')) * cos(radians(lat)) * cos(radians(lon) - radians(' . $request['longitude'] . ')) + sin(radians(' . $request['latitude'] . '))*sin(radians(lat))) AS distance')
            ->orderBy('distance', 'asc')->take(5)->get();

        return ['busstops'=>$busstops, 'schools'=>$schools, 'addresses'=>$addresses];
    }

    public function export()
    {
        return Excel::download(new UsersExport(), 'users.csv');
    }


}
