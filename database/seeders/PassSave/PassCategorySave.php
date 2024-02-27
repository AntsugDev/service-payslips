<?php

namespace Database\Seeders\PassSave;

use App\Models\PassSave\PassCategory;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PassCategorySave
{
    private ConsoleOutput $consoleOutput;
    private  ProgressBar $progressBar;


    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->progressBar = new ProgressBar($this->consoleOutput,10);
    }


    public function run():void
    {
        \Laravel\Prompts\info("\nINIZIO CREAZIONE PassCategory....\n");
        $this->progressBar->start();

        PassCategory::insert([

            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Email"
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Account"
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "SSO"
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "DataBase"
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Group Account"
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Varie"
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Altro"
            ]

        ]);
        $this->progressBar->finish();
        \Laravel\Prompts\info("\nFINE CREAZIONE PassCategory....\n");
    }
}
