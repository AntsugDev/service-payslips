<?php

namespace Database\Seeders;

use App\Models\Compaineis;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use function Laravel\Prompts\error;

class UserCreateSeeders
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


    public function  run():void
    {
        \Laravel\Prompts\info("\nINIZIO CREAZIONE USER....\n");
        $this->progressBar->start();
        for($i = 0 ; $i < $this->len ; $i ++){
            $this->progressBar->advance();
            try {
                $userPadre = User::where('company_id', '!=', null)->take(1)->skip(rand(0, User::all()->count()))->first();
                if($userPadre instanceof  User) {
                    $email = fake()->email;
                    User::create(
                        [
                            'email' => $email,
                            'name' => fake()->firstName . ' ' . fake()->lastName,
                            'code_user' => fake()->isbn13(),
                            'password' => Hash::make(trim(strtolower(str_replace('', '_', explode('@', $email)[0]))) . '.007'),
                            'user_id' => $i % 2 === 0 ? $userPadre->code_user : null,
                            'uuid' => Str::uuid()->toString()
                        ]
                    );
                }
            }catch (\Exception $e){
                error("Eccezione creazione utente: ".$e->getFile().':'.$e->getLine().' '.$e->getMessage());
            }

        }

        $this->progressBar->finish();


    }
}
