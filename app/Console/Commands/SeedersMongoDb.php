<?php

namespace App\Console\Commands;

use App\Models\Compaineis;
use App\Models\User;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use function Symfony\Component\String\b;

class SeedersMongoDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeders:mongo-db';

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

        $compain =   Compaineis::create([
            "name" => fake('it-IT')->company,
            "city" => fake('it-IT')->city,
            "address" => fake('it-IT')->address,
            'email' => fake('it-IT')->email,
            'phone' => fake('it-IT')->phoneNumber
        ]);

        User::create([
            'email' => "root@root.it",
            'name' => 'Root',
            'code_user' => Crypt::encryptString("PYNPTB61L22H479S"),
            'password' => Hash::make('root.007'),
            'company_id' =>$compain->_id
        ]);

        User::create([
            'email' => "company@company.it",
            'name' => 'Company',
            'code_user' => Crypt::encryptString("25712160859"),
            'password' => Hash::make('company.007'),
        ]);
    }
}
