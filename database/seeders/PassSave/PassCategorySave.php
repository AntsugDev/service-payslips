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
                "name" => "Email",
                "fields"=>[
                    [
                        "title" => "dominio",
                        "description" =>"Dominio email",
                        "type" => "string"
                    ],
                    [
                        "title" => "email",
                        "description" =>"Email",
                        "type" => "string"
                    ]
                ]
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Account",
                "fields"=>[
                    [
                        "title" => "username",
                        "description" =>"username",
                        "type" => "string"
                    ],
                    [
                        "title" => "password",
                        "description" =>"password",
                        "type" => "string"
                    ]
                ]
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "SSO",
                "fields"=>[
                    [
                        "title" => "username",
                        "description" =>"username",
                        "type" => "string"
                    ],
                    [
                        "title" => "password",
                        "description" =>"password",
                        "type" => "string"
                    ],
                    [
                        "title" => "private-key",
                        "description" =>"Chiave private accesso",
                        "type" => "string/url/file"
                    ],
                    [
                        "title" => "public-key",
                        "description" =>"Chiave pubblica accesso",
                        "type" => "string/url/file"
                    ],
                    [
                        "title" => "url",
                        "description" =>"Url per accedere",
                        "type" => "url"
                    ]
                ]
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "DataBase",
                "fields"=>[
                    [
                        "title" => "username",
                        "description" =>"username",
                        "type" => "string"
                    ],
                    [
                        "title" => "password",
                        "description" =>"password",
                        "type" => "string"
                    ],
                    [
                        "title" => "host",
                        "description" =>"Host",
                        "type" => "string/url/file"
                    ],
                    [
                        "title" => "typeDb",
                        "description" =>"Tipologia di db",
                        "type" => "string"
                    ],
                    [
                        "title" => "nome",
                        "description" =>"Nome database",
                        "type" => "string"
                    ]
                ]
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Group Account",
                "fields"=>[
                    [
                        "title" => "url",
                        "description" =>"url",
                        "type" => "url"
                    ],
                    [
                        "title" => "nome",
                        "description" =>"Nome gruppo",
                        "type" => "string"
                    ],
                    [
                        "title" => "dati_accesso",
                        "description" =>"Dati di accesso",
                        "type" => "array"
                    ],

                ]
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Altro",
                "fields" => []
            ]

        ]);
        $this->progressBar->finish();
        \Laravel\Prompts\info("\nFINE CREAZIONE PassCategory....\n");
    }
}
