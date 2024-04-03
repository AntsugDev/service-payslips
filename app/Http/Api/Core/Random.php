<?php

namespace App\Http\Api\Core;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait Random
{
    const CONSONANTI="QWRTYPSDFGHJKLZXCVBNM";

    const INIT_YEAR = 1970;

    const MONTH = ["A","B","C","D","E","H","L","M","P","R","S","T"];

    const DAYS = [
        "A" => 31,
        "B"=> 29,
        "C"=> 31,
        "D"=>30,
        "E"=> 31,
        "H"=> 30,
        "L"=>31,
        "M"=>31,
        "P"=> 30,
        "R"=> 31,
        "S"=> 30,
        "T" => 31
    ];



    public function generatePIVA(): string
    {
        $str = "";
        for($i = 0 ; $i < 12; $i++){
            $str .=rand(0,9);
        }
        return str_shuffle($str);
    }


    private function initial_six(): string
    {
        $str = "";
        $split = str_split(self::CONSONANTI);
        for($i = 0 ; $i < 6 ; $i++){
            $str .= $split[rand(0,count($split)-1)];
        }
        return str_shuffle($str);
    }

    private function createArreyYear():array
    {
        $years = array();
        $end = Carbon::now()->format('Y');
        for ($i = self::INIT_YEAR; $i <= $end; $i++) {
            array_push($years, (self::INIT_YEAR + $i));
        }
        return  $years;
    }

    private function generate_years(): string
    {
        $years = $this->createArreyYear();
        return substr($years[rand(0,count($years)-1)],2,2);
    }

    private function generate_month():string
    {
        return self::MONTH[rand(0,count(self::MONTH)-1)];
    }

    private function generate_days(string $month) :string
    {
        return  str_pad(rand(1,self::DAYS[$month]),2,'0',STR_PAD_LEFT);
    }

    public function generate_cat_code(): string
    {

        $path = Storage::disk('export')->path('CociciCatastali22_01_2024.csv');
        $open = fopen($path,'r');
        $read = fread($open,filesize($path));
        $array = explode("\r\n",$read);
        fclose($open);
        $randomRow = $array[rand(0, count($array)-1)];
        $splitRow = explode(';',$randomRow);
        return $splitRow[19];
    }


    private function ctrl_element(string $string): string
    {
        $split = str_split($string);
        $pari  = 0;
        $dispari  = 0;
        for($i = 0 ; $i < count($split); $i++){
            if($i%2 === 0)
                $pari =$pari+ $i;
            else
                $dispari =$dispari+$i;
        }

        return chr(64+round(($pari+$dispari) % 26));


    }

    public function generateFiscalCode(): string
    {
        $month = $this->generate_month();
        $days  = $this->generate_days($month);
        $parteInit =  $this->initial_six().$this->generate_years().$month.$days.$this->generate_cat_code();
        return $parteInit.$this->ctrl_element($parteInit);
    }


}
