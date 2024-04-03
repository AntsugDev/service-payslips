<?php

namespace App\Models\PassSave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class PassGroups extends Model
{
    use HasFactory;

    protected $connection = "mongodb";

    protected $collection = "pass_groups";

    protected $fillable = [
        "uuid" ,
        "name",
        "user_id"
    ];


}
