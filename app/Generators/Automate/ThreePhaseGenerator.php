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

    public static function generate($shield, $group, $cable)
    {
        self::$nominal = $group->automate_nominal;
        switch ($group->automate_category) {
            case 'C':
                self::$magn = self::$nominal * 5 . ' - ' . self::$nominal * 10;
                break;
            case 'B':
                self::$magn = self::$nominal * 3 . ' - ' . self::$nominal * 5;
                break;
            case 'D':
                self::$magn = self::$nominal * 10 . '-' . self::$nominal * 20;
                break;
            case 'None':
                self::$magn = self::$nominal * 10 . '-' . self::$nominal * 20;
                break;
        }
        switch ($cable->count) {
            case 2:
                return self::oneGenerator($group, $cable);
                break;
            case 3:
                return self::twoGenerator($group, $cable);
                break;
            case 4:
                return self::threeGenerator($group, $cable);
                break;
            case 5:
                return self::threeGenerator($group, $cable);
                break;
        }
    }


    private static function oneGenerator($group, $cable)
    {
        $A = 0;

        switch ($group->automate_category) {
            case 'C':
                $A = rand(self::$c_min * self::$nominal, self::$c_max * self::$nominal);
                break;
            case 'B':
                $A = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
            case 'D':
                $A = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
        }
        if ($group->pred) {
            self::$magn = '-';
            $A = rand(self::$pred_min * self::$nominal, self::$pred_max * self::$nominal);
        }
        return [
            'name' => $group->name,
            'automate' => $group->automate_name,
            'nominal' => !$group->pred ? self::$nominal : self::$magn,
            'magn' => self::$magn,
            'pred' => $group->pred ? self::$nominal : '-',
            'A1' => '-',
            'B1' => '-',
            'C1' => '-',
            'A2' => $A,
            'B2' => '-',
            'C2' => '-',
            'dop' => 3,
            'fact' => round(($A * 0.9) / self::$nominal, 1),
            'result' => 'Соотв.',
        ];
    }

    private static function twoGenerator($group, $cable)
    {
        $B = 0;

        switch ($group->automate_category) {
            case 'C':
                $B = rand(self::$c_min * self::$nominal, self::$c_max * self::$nominal);
                break;
            case 'B':
                $B = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
            case 'D':
                $B = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
        }
        if ($group->pred) {
            self::$magn = '-';
            $B = rand(self::$pred_min * self::$nominal, self::$pred_max * self::$nominal);
        }
        return [
            'name' => $group->name,
            'automate' => $group->automate_name,
            'nominal' => !$group->pred ? self::$nominal : self::$magn,
            'magn' => self::$magn,
            'pred' => $group->pred ? self::$nominal : '-',
            'A1' => '-',
            'B1' => '-',
            'C1' => '-',
            'A2' => '-',
            'B2' => $B,
            'C2' => '-',
            'dop' => 3,
            'fact' => round(($B * 0.9) / self::$nominal, 1),
            'result' => 'Соотв.',
        ];
    }

    private static function threeGenerator($group, $cable)
    {
        $C = 0;

        switch ($group->automate_category) {
            case 'C':
                $C = rand(self::$c_min * self::$nominal, self::$c_max * self::$nominal);
                break;
            case 'B':
                $C = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
            case 'D':
                $C = rand(self::$b_min * self::$nominal, self::$b_max * self::$nominal);
                break;
        }
        if ($group->pred) {
            self::$magn = '-';
            $C = rand(self::$pred_min * self::$nominal, self::$pred_max * self::$nominal);
        }
        return [
            'name' => $group->name,
            'automate' => $group->automate_name,
            'nominal' => !$group->pred ? self::$nominal : self::$magn,
            'magn' => self::$magn,
            'pred' => $group->pred ? self::$nominal : '-',
            'A1' => '-',
            'B1' => '-',
            'C1' => '-',
            'A2' => '-',
            'B2' => '-',
            'C2' => $C,
            'dop' => 3,
            'fact' => round(($C * 0.9) / self::$nominal, 1),
            'result' => 'Соотв.',
        ];
    }
}
