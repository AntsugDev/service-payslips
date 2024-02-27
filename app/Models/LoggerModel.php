<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class LoggerModel extends Model
{
    use HasFactory;


    protected $connection = "mongodb";

    protected $collection = "loggers";

    protected $fillable = [
        "uuid" ,
        "name",
        "date_insert" ,
        "msg",
        "type"
    ];
}
