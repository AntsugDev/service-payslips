<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CitySeeders
{

    private ConsoleOutput $consoleOutput;
    private  ProgressBar $progressBar;

    private array $csv ;


    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
       $this->csv =  DB::connection('mysql')->table('cities')->addSelect(
           [
               'cities.cadastral_code',
               DB::raw('cities.name as name'),
               DB::raw('provinces.name as provincie'),
               DB::raw('provinces.automotive_abbreviation as pr'),
               DB::raw('regions.name as region'),

           ]
       )
            ->join('provinces','provinces.id','=','cities.province_id')
            ->join('regions','regions.id','=','provinces.region_id')->get()->toArray();
        $this->progressBar = new ProgressBar($this->consoleOutput,count($this->csv));
    }




    public function  run():void
    {
        \Laravel\Prompts\info("\nINIZIO CREAZIONE Cities....\n");
        $this->progressBar->start();

        foreach ($this->csv as $key => $item){
            $item->uuid = Str::uuid()->toString();
            City::create(json_decode(json_encode($item), true));
            $this->progressBar->advance();
        }
        $this->progressBar->finish();
        \Laravel\Prompts\info("\nTerminata creazione Cities....\n");
    }




}
