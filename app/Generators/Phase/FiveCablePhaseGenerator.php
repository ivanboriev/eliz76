<?php


namespace App\Generators\Phase;


class FiveCablePhaseGenerator
{
    protected static $c_min = 11;
    protected static $c_max = 15;
    protected static $b_min = 6;
    protected static $b_max = 10;
    protected static $d_min = 21;
    protected static $d_max = 25;
    protected static $pred_min = 4;
    protected static $pred_max = 6;
    protected static $none_min = 4;
    protected static $none_max = 6;
    protected static $magn = '';
    protected static $nominal;

    public static function generate($shield, $group, $cable)
    {
        self::$nominal = $group->automate_nominal;
        $A = 0;
        $B = 0;
        $C = 0;
        switch ($group->automate_category){
            case 'C':
                self::$magn = self::$nominal * 5 .' - '. self::$nominal * 10;
                $A = rand(self::$c_min * self::$nominal, self::$c_max * self::$nominal);
                $B = rand(self::$c_min * self::$nominal, self::$c_max * self::$nominal);
                $C = rand(self::$c_min * self::$nominal, self::$c_max * self::$nominal);
                break;
            case 'B':
                self::$magn = self::$nominal * 3 .' - '. self::$nominal * 5;
                $A = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                $B = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                $C = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
            case 'D':
                self::$magn = self::$nominal * 10 .'-'. self::$nominal * 20;
                $A = rand(self::$d_min * self::$nominal, self::$d_max * self::$nominal);
                $B = rand(self::$d_min * self::$nominal, self::$d_max * self::$nominal);
                $C = rand(self::$d_min * self::$nominal, self::$d_max * self::$nominal);
                break;
            case 'None':
                self::$magn = '-';
                $A = rand(self::$none_min * self::$nominal, self::$none_max * self::$nominal);
                $B = rand(self::$none_min * self::$nominal, self::$none_max * self::$nominal);
                $C = rand(self::$none_min * self::$nominal, self::$none_max * self::$nominal);
                break;
        }
        if($group->pred){
            self::$magn = '-';
            $A = rand(self::$pred_min * self::$nominal, self::$pred_max * self::$nominal);
            $B = rand(self::$pred_min * self::$nominal, self::$pred_max * self::$nominal);
            $C = rand(self::$pred_min * self::$nominal, self::$pred_max * self::$nominal);
        }
        return [
            'name' => $group->name,
            'automate' => $group->automate_name,
            'type' => $group->pred ? 'МД-' . $group->automate_category :'ОВВ, МД-' . $group->automate_category,
            'nominal' => self::$nominal,
            'magn' => self::$magn,
            'A1' => '-',
            'B1' => '-',
            'C1' => '-',
            'A2' => $A,
            'B2' => $B,
            'C2' => $C,
            'dop' => '0,4',
            'time' => '0,1',
            'result' => 'Соотв.',
        ];

    }
}
