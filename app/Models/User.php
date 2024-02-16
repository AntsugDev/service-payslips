<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static create(array $array)
 */
class User extends Model implements Authenticatable,JWTSubject
{
    use  HasFactory,HasApiTokens;



    public function getAuthIdentifierName(): string
    {
        return 'code_user';
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
        'email',
        'name',
        'code_user',
        'password',
        'vp'
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
        return [
            "type" => "Bearer",
            "expired" => Carbon::now()->addHours()->format('d/m/Y H:i:s'),
            "access_token" => null,
            "users" => null
        ];
    }
}
