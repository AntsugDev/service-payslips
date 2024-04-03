<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static create(array $array)
 */
class User extends Model implements Authenticatable,JWTSubject
{
    use  HasFactory,HasApiTokens;


    protected $primaryKey = 'uuid';

    public function getAuthIdentifierName(): string
    {
        return 'uuid';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }


    protected $connection="mongodb";

    protected  $collection = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'email',
        'name',
        'code_user',
        'password',
        'password_at',
        'change_password',
        'user_id', //user padre uguale a uuid
        'company_id' ,//la relazione con la tabella companies
        'role_id'
    ];

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }


    public function company (string $uuid){

        return User::where('user_id',$uuid)->get();
    }

    public function details_company(){
        return $this->belongsTo(Compaineis::class,'company_id','uuid');
    }

    public function checkId (string $id){
        return User::where('id',$id)->count() > 0;
    }

    public function get_role(){
        return $this->belongsTo(Role::class,'role_id','uuid')->pluck('name');
    }




}
