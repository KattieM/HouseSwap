<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PostCode extends Model
{
    protected $table = 'postcodes';
    protected $fillable = [
        'postcode', 'latitude', 'longitude',
    ];


}
