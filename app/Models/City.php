<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class City extends Model
{
    use HasFactory;

    protected $connection = "mongodb";

    protected $collection = "cities";


    protected $fillable = [
        "uuid",
        "name",
        "provincie",
        "pr",
        "region",
        "cadastral_code"
    ];
}
