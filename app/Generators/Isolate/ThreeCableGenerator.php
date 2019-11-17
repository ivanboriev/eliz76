<?php


namespace App\Generators\Isolate;


class ThreeCableGenerator
{
    protected static $min;
    protected static $max;

    public static function generate($shield, $group, $cable, $counter)
    {
        self::$min = $shield->min;
        self::$max = $shield->max;
        switch ($counter) {
            case 1 :
                return self::oneGenerator($group, $cable);
                break;
            case 2:
                return self::twoGenerator($group, $cable);
                break;
            case 3:
                return self::threeGenerator($group, $cable);
                break;
        }

    }


    private static function oneGenerator($group, $cable)
    {
        return [
            'name' => $group->name,
            'cable' => $cable->full_name,
            'voltage' => $cable->voltage,
            'AB' => '-',
            'AC' => '-',
            'BC' => '-',
            'AN' => rand(self::$min, self::$max),
            'BN' => '-',
            'CN' => '-',
            'APE' => rand(self::$min, self::$max),
            'BPE' => '-',
            'CPE' => '-',
            'NPE' => rand(self::$min, self::$max),
            'result' => 'Соотв.',
        ];
    }

    private static function twoGenerator($group, $cable)
    {
        return [
            'name' => $group->name,
            'cable' => $cable->full_name,
            'voltage' => $cable->voltage,
            'AB' => '-',
            'AC' => '-',
            'BC' => '-',
            'AN' => '-',
            'BN' => rand(self::$min, self::$max),
            'CN' => '-',
            'APE' => '-',
            'BPE' => rand(self::$min, self::$max),
            'CPE' => '-',
            'NPE' => rand(self::$min, self::$max),
            'result' => 'Соотв.',
        ];
    }

    private static function threeGenerator($group, $cable)
    {
        return [
            'name' => $group->name,
            'cable' => $cable->full_name,
            'voltage' => $cable->voltage,
            'AB' => '-',
            'AC' => '-',
            'BC' => '-',
            'AN' => '-',
            'BN' => '-',
            'CN' => rand(self::$min, self::$max),
            'APE' => '-',
            'BPE' => '-',
            'CPE' => rand(self::$min, self::$max),
            'NPE' => rand(self::$min, self::$max),
            'result' => 'Соотв.',
        ];
    }
}
