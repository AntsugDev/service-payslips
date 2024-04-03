<?php

namespace Database\Seeders;

use App\Http\Api\Core\Random;
use App\Models\Compaineis;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use function Laravel\Prompts\error;

class UserCreateSeeders
{
    use Random;

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
        $this->progressBar = new ProgressBar($this->consoleOutput,($this->len+1));
    }


    public function  run():void
    {
        \Laravel\Prompts\info("\nINIZIO CREAZIONE USER....\n");
        $this->progressBar->start();
        for($i = 0 ; $i < $this->len ; $i ++){
            try {
                $userPadre = User::whereNull('user_id')->get()->toArray();
                if(is_array($userPadre) && count($userPadre) > 0) {
                    $random     = $userPadre[rand(0,count($userPadre)-1)];
                    $email      = fake()->email;
                    $uuid       = $random['uuid'];
                    $companyId  = $random['company_id'];
                    $role = Role::where('name','User')->pluck('uuid')->toArray();
                    User::create(
                            [
                                'email' => $email,
                                'name' => fake()->firstName . ' ' . fake()->lastName,
                                'code_user' => Crypt::encryptString($this->generateFiscalCode()),
                                'password' => Hash::make(trim(strtolower(str_replace('', '_', explode('@', $email)[0]))) . '.007'),
                                'password_at' => Carbon::now()->format('d/m/Y H:i:s'),
                                'user_id' => $uuid,
                                'company_id' => $companyId,
                                'created_at'=> Carbon::now(),
                                'update_at'=> Carbon::now(),
                                'uuid' => Str::uuid()->toString(),
                                'change_password' => false,
                                "role_id"=>count($role) > 0 ? $role[0] : null
                            ]
                    );
                }
            }catch (\Exception $e){
                error("Eccezione creazione utente: ".$e->getFile().':'.$e->getLine().' '.$e->getMessage());
            }
            $this->progressBar->advance();
        }

        $roleAdmin = Role::where('name','Admin')->pluck('uuid')->toArray();
        User::create(
            [
                'email' => "admin@amministratore.it",
                'name' => "Admin",
                'code_user' => Crypt::encryptString("000000000000"),
                'password' => Hash::make("admin.007@"),
                'password_at' => Carbon::now()->format('d/m/Y H:i:s'),
                'user_id' => null,
                'company_id' => null,
                'created_at'=> Carbon::now(),
                'update_at'=> Carbon::now(),
                'uuid' => Str::uuid()->toString(),
                'change_password' => false,
                "role_id"=>count($roleAdmin) > 0 ? $roleAdmin[0] : null
            ]
        );
        $this->progressBar->advance();

        $this->progressBar->finish();


    }
}
