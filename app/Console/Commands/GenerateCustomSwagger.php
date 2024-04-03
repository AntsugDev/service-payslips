<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCustomSwagger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = array();
        exec("php artisan route:list ",$result);
        $result = array_filter($result,function ($value){
            return stristr($value,'api') !== false;
        });
        $csv = "METHOD;API;CONTROLLER\n";
        array_map(function ($item) use(&$csv) {
            $explode = explode(" ",trim($item));
            $csv .= $explode[0].';'.$explode[2].';'.(array_key_exists(4,$explode) ? $explode[4]: "")."\n";
        },$result);
        $nomeFile = "router.".Carbon::now()->format('Ymd').".csv";
        Storage::drive('router')->put($nomeFile,$csv);
    }
}
