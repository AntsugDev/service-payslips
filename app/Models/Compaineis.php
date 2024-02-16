<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Compaineis extends Model
{
    use HasFactory;
    protected $connection = "mongodb";

    protected $collection = "companies";


    protected $fillable = [
        'uuid',
        "name",
        "city",
        "address",
        'email',
        'phone'
    ];

    public function list_user()
    {
        return $this->hasMany(User::class,'uuid','company_id');
    }
}
