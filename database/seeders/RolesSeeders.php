<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class RolesSeeders
{
    private ConsoleOutput $consoleOutput;
    private  ProgressBar $progressBar;


    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->progressBar = new ProgressBar($this->consoleOutput,5);
    }

    public function  run():void
    {
        info("\nINIZIO CREAZIONE ROLES....\n");

        $this->progressBar->start();
        Role::insert([
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Admin",
                "created_at"=>Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at"=>Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "User",
                "created_at"=>Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at"=>Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "User-child",
                "created_at"=>Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at"=>Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Company",
                "created_at"=>Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at"=>Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Altro",
                "created_at"=>Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at"=>Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
        $this->progressBar->finish();

        info("\nFINE CREAZIONE ROLES....\n");
    }

}
