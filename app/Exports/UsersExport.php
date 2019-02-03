<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('users')->join('houses', 'users.id', '=', 'houses.user_id')->join('postcodes', 'houses.postcode_id', '=', 'postcodes.id')->join('addresses', 'houses.address_id', '=', 'addresses.id')
            ->selectRaw('users.id AS id,
          CONCAT_WS(" ", users.name, users.surname) as fullname,
          houses.id as house,
          (CASE houses.propertytype WHEN 1 THEN \'FLAT\' WHEN 2 THEN \'small house\' WHEN 3 THEN \'big house\' WHEN 4 THEN \'Villa\' ELSE \'-\' END) as property_type,
          CONCAT_WS(" ", postcodes.postcode, addresses.id, addresses.postcode_id, addresses.district, addresses.locality, addresses.street, addresses.site, addresses.site_number, addresses.site_description, addresses.site_subdescription) AS fulladdress,
          (SELECT COUNT(id) FROM likes where a = users.id AND likes.like=1) as num_of_likes_given,
          (SELECT GROUP_CONCAT(b SEPARATOR ", ") FROM likes where a = users.id AND likes.like=1) as likes_given,
          (SELECT COUNT(id) FROM likes where b = users.id AND likes.like=1) as num_of_likes_recieved,
          (SELECT count(id) from likes where a IN (SELECT b from likes where a=users.id AND likes.like = 1) AND b = users.id AND likes.like = 1) as match_count,
          (SELECT GROUP_CONCAT(id SEPARATOR ", ") FROM likes where a IN (SELECT b from likes where a=users.id AND likes.like = 1) AND b = users.id AND likes.like = 1) as match_ids,
          (SELECT COUNT(id) FROM people WHERE user_id = users.id) as count_of_people,
          (SELECT COUNT(id) FROM people WHERE user_id = users.id AND age>45 AND sex = \'M\') as num_of_old')->get();

    }
}
