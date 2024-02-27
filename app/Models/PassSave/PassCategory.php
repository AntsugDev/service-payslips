<?php

namespace App\Models\PassSave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class PassCategory extends Model
{
    use HasFactory;

    protected $connection = "mongodb";

    protected $collection = "pass_category";

    protected $fillable = [
        "uuid" ,
        "name",
    ];
}
