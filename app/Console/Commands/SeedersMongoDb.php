<?php

namespace App\Console\Commands;

use App\Models\Compaineis;
use App\Models\User;
use Database\Seeders\CitySeeders;
use Database\Seeders\CompaniesSeeders;
use Database\Seeders\PassSave\PassCategorySave;
use Database\Seeders\RolesSeeders;
use Database\Seeders\UserCreateSeeders;
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
            $dropDb = $this->choice('Vuoi cancellare il db?[s,n]',['s','n']);

            if(strcmp($dropDb,'s') === 0){
                DB::connection('mongodb')->table('loggers')->delete();
                DB::connection('mongodb')->table('cities')->delete();
                DB::connection('mongodb')->table('roles')->delete();
                DB::connection('mongodb')->table('users')->delete();
                DB::connection('mongodb')->table('companies')->delete();

                DB::connection('mongodb')->table('pass_category')->delete();

            }


            $passCategory = new PassCategorySave();
            $passCategory->run();

//            $role       = new RolesSeeders();
//            $role->run();
//
//            $cities     = new CitySeeders();
//            $cities->run();
//
//            $lenCompainies = $this->ask('Inidica il numero di aziende da inserire');
//            $compainesSeeders = new CompaniesSeeders($lenCompainies);
//            $compainesSeeders->run();
//
//            $lenuser = $this->ask('Inidica il numero di utenti da inserire');
//            $userSeeders = new UserCreateSeeders($lenuser);
//            $userSeeders->run();

            \Laravel\Prompts\info("\n...Fine della creazione db mongo");
        }catch (CommandException $e){
            error($e->getMessage());
        }
    }
}
