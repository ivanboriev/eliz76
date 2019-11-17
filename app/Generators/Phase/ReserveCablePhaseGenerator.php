<?php


namespace App\Generators\Phase;


class ReserveCablePhaseGenerator
{
    protected static $nominal;
    protected static $magn;

    public static function generate($shield, $group, $cable)
    {
        self::$nominal = $group->automate_nominal;
        switch ($group->automate_category){
            case 'C':
                self::$magn = self::$nominal * 5 .' - '. self::$nominal * 10;
                break;
            case 'B':
                self::$magn = self::$nominal * 3 .' - '. self::$nominal * 5;
                break;
            case 'D':
                self::$magn = self::$nominal * 10 .'-'. self::$nominal * 20;
                break;
            case 'None':
                self::$magn = '-';
                break;
        }
        if($group->pred){
            self::$magn = '-';
        }

        return [
            'name' => $group->name,
            'automate' => $group->automate_name,
            'type' => $group->pred ? 'МД-' . $group->automate_category :'ОВВ, МД-' . $group->automate_category,
            'nominal' => $group->pred ? self::$nominal : self::$magn,
            'magn' => self::$magn,
            'A1' => '-',
            'B1' => '-',
            'C1' => '-',
            'A2' =>'-',
            'B2' => '-',
            'C2' => '-',
            'dop' => '0,4',
            'time' => '0,1',
            'result' => 'Соотв.',
        ];

    }
}
