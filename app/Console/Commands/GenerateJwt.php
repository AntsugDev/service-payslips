<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class GenerateJwt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-jwt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws JWTException
     */
    public function handle()
    {
        $user = User::where('email','tkreiger@yahoo.com')
            ->where('vp','C?^U@*X<`L1yK5wU%')->first();
        if($user instanceof User){
            try {
                $claims = $user->getJWTCustomClaims();
                $token  = JWTAuth::fromUser($user);
                $claims['access_token'] = $token;
                \Laravel\Prompts\info(json_encode($claims,true));
                Command::SUCCESS;
            }catch (JWTException $exception) {
                $this->error($exception->getFile().':'.$exception->getLine().' - '.$exception->getMessage());
                Command::FAILURE;
            }
        }else {
            $this->error("User non presente");
            Command::FAILURE;
        }
//        }
    }
}
