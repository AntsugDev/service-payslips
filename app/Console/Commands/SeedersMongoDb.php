<?php

namespace App\Console\Commands;

use App\Models\Compaineis;
use App\Models\User;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use MongoDB\Driver\Exception\CommandException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use function Laravel\Prompts\error;
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


        \Laravel\Prompts\info("Inizio creazione collection mongodb...");
        try {
            $console = new ConsoleOutput();
            $bar = new ProgressBar($console, 6);

            $bar->start();
            DB::connection('mongodb')->table('users')->delete();
            DB::connection('mongodb')->table('companies')->delete();

            $compain = Compaineis::create([
                'uuid' => Str::uuid()->toString(),
                "name" => fake('it-IT')->company,
                "city" => fake('it-IT')->city,
                "address" => fake('it-IT')->address,
                'email' => fake('it-IT')->email,
                'phone' => fake('it-IT')->phoneNumber
            ]);
            $bar->advance();

            User::create([
                'uuid' => Str::uuid()->toString(),
                'email' => "root@root.it",
                'name' => 'Root',
                'code_user' => Crypt::encryptString("PYNPTB61L22H479S"),
                'password' => Hash::make('root.007'),
                'company_id' => $compain->uuid
            ]);
            $bar->advance();
            User::create([
                'uuid' => Str::uuid()->toString(),
                'email' => "users@users.it",
                'name' => 'Users',
                'code_user' => Crypt::encryptString("GBUVLN99R01D660D"),
                'password' => Hash::make('users.007'),
                'company_id' => $compain->uuid
            ]);
            $bar->advance();
            User::create([
                'uuid' => Str::uuid()->toString(),
                'email' => "admin@admin.it",
                'name' => 'Admin',
                'code_user' => Crypt::encryptString("SCGZEI45M01M427N "),
                'password' => Hash::make('admin.007'),
                'company_id' => $compain->uuid
            ]);
            $bar->advance();

            User::create([
                'uuid' => Str::uuid()->toString(),
                'email' => "company@company.it",
                'name' => 'Company',
                'code_user' => Crypt::encryptString("25712160859"),
                'password' => Hash::make('company.007'),
            ]);
            $bar->advance();
            User::create([
                'uuid' => Str::uuid()->toString(),
                'email' => "company-bis@company-bis.it",
                'name' => 'CompanyBis',
                'code_user' => Crypt::encryptString("18507080952"),
                'password' => Hash::make('company.bis.007'),
            ]);
            $bar->finish();
            \Laravel\Prompts\info("\n...Fine della creazione db mongo");
        }catch (CommandException $e){
            error($e->getMessage());
        }
    }
}
