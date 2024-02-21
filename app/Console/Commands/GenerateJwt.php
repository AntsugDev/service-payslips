<?php

namespace App\Console\Commands;

use App\Http\Api\Core\Random;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class GenerateJwt extends Command
{

    use Random;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tester';

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
        dd($this->generatePIVA());
    }
}
