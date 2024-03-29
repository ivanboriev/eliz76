<?php


namespace App\Generators\Automate;


class ThreePhaseGenerator
{

    protected static $c_min = 11;
    protected static $c_max = 15;
    protected static $b_min = 6;
    protected static $b_max = 10;
    protected static $d_min = 21;
    protected static $d_max = 25;
    protected static $pred_min = 4;
    protected static $pred_max = 6;
    protected static $magn = '';
    protected static $nominal;

    public static function generate($group, $cable)
    {
        self::$nominal = $group->automate_nominal;
        switch ($group->automate_category) {
            case 'C':
                self::$magn = self::$nominal * 5 . ' - ' . self::$nominal * 10;
                return self::phaseGenerate($group);
                break;
            case 'B':
                self::$magn = self::$nominal * 3 . ' - ' . self::$nominal * 5;
                return self::phaseGenerate($group);
                break;
            case 'D':
                self::$magn = self::$nominal * 10 . '-' . self::$nominal * 20;
                return self::phaseGenerate($group);
                break;
            case 'None':
                self::$magn = self::$nominal * 10 . '-' . self::$nominal * 20;
                return self::phaseGenerate($group);
                break;
        }
    }

    private static function phaseGenerate($group)
    {



        $l1 =  [
            'name' => $group->name,
            'automate' => $group->automate_name,
            'nominal' => self::$nominal,
            'tepl_rasc' => self::$magn,
            'magn' => self::$magn,
            'phase' => 'L1',
            'crat' => 2.55,
            'tokA' => round(self::$nominal * 2.55),
            'time' => rand(20, 30),
            'sopr' => 10000,
            'result' => 'Соответсв.',
        ];
        $l2 =   [
            'name' => '',
            'automate' => '',
            'nominal' => '',
            'tepl_rasc' => '',
            'magn' => self::$magn,
            'phase' => 'L2',
            'crat' => 2.55,
            'tokA' => round(self::$nominal * 2.55),
            'time' => rand(20, 30),
            'sopr' => 10000,
            'result' => 'Соответсв.',
        ];
        $l3 =  [
            'name' => '',
            'automate' => '',
            'nominal' => '',
            'tepl_rasc' => '',
            'magn' => self::$magn,
            'phase' => 'L3',
            'crat' => 2.55,
            'tokA' => round(self::$nominal * 2.55),
            'time' => rand(20, 30),
            'sopr' => 10000,
            'result' => 'Соответсв.',
        ];
        $data = [$l1, $l2, $l3];

        return $data;
    }
}
