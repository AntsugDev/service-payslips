<?php

namespace Database\Seeders;

use App\Models\Compaineis;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\error;

class CompaniesSeeders
{

    private ConsoleOutput $consoleOutput;
    private  ProgressBar $progressBar;

    private int $len;

    /**
     * @param int $len
     */
    public function __construct(int $len)
    {
        $this->len = $len;
        $this->consoleOutput = new ConsoleOutput();
        $this->progressBar = new ProgressBar($this->consoleOutput,$this->len);
    }


    public  function  run() :void
    {
        info("\nINIZIO CREAZIONE COMPAINES....\n");

        $this->progressBar->start();
        for($i = 0 ; $i < $this->len ; $i ++){

            $company = fake()->company;
            $email   = fake()->email;
            $compain = Compaineis::create([
                    'uuid' => Str::uuid()->toString(),
                    "name" => $company,
                    "city" => fake('it-IT')->city,
                    "address" => fake('it-IT')->address,
                    'email' => $email,
                    'phone' => fake('it-IT')->phoneNumber
            ]);
            if($compain instanceof Compaineis){
                 User::create(
                        [
                            'email' => $email,
                            'name' => $company,
                            'code_user' => (fake()->isbn10()),
                            'password' => Hash::make(trim(strtolower(str_replace('','_',explode('@',$email)[0]))).'.007'),
                            'company_id' => $compain->uuid,
                            'uuid' => Str::uuid()->toString()
                        ]
                );
            }else
                error("\nCompany non creata...");

            $this->progressBar->advance();
        }
        $this->progressBar->finish();




    }

}
