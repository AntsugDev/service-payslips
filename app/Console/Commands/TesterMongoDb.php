<?php

namespace App\Console\Commands;

use App\Models\User;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TesterMongoDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tester:mongo-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test insert in MongoDB';

    /**
     * Execute the console command.
     */
    public function handle()
    {

//        if(User::all()->count() > 0){
//            $collection = (new \MongoDB\Client)->__get('service-payslips')->__get('users');
//            dd($collection);
//        }


            for ($i = 0; $i < 10; $i++)
                User::create([
                    'email' => fake()->email,
                    'name'=> fake()->name,
                    'code_user'=>fake()->isbn13(),
                    'password'=>(fake()->password)
                ]);

//        dd(User::first()->id);
    }
}
