<?php

namespace App\Models\PassSave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class PassSave extends Model
{
    use HasFactory;

    protected $connection = "mongodb";

    protected $collection = "pass_save";

    protected $fillable = [
        "uuid" ,
        "name",
        "id_category",
        "id_groups",
        "user_id",
        "json_dati"
    ];



    public function category():BelongsTo
    {
        return $this->belongsTo(PassCategory::class,"id_category","uuid");
    }

    public function groups():BelongsTo
    {
        return $this->belongsTo(PassGroups::class,"id_groups","uuid");
    }
}
