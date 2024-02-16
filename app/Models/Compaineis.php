<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Compaineis extends Model
{
    use HasFactory;
    protected $connection = "mongodb";

    protected $collection = "compains";


    protected $fillable = [
        "name",
        "city",
        "address",
        'email',
        'phone'
    ];
}
