<?php


namespace App\Generators\Isolate;


class FourCableGenerator
{
    protected static $min;
    protected static $max;

    public static function generate($shield, $group, $cable)
    {
        self::$min = $shield->min;
        self::$max = $shield->max;
        return [
            'name' => $group->name,
            'cable' => $cable->full_name,
            'voltage' => $cable->voltage,
            'AB' => rand(self::$min, self::$max),
            'AC' => rand(self::$min, self::$max),
            'BC' => rand(self::$min, self::$max),
            'AN' => rand(self::$min, self::$max),
            'BN' => rand(self::$min, self::$max),
            'CN' => rand(self::$min, self::$max),
            'APE' => '-',
            'BPE' => '-',
            'CPE' => '-',
            'NPE' => '-',
            'result' => 'Соотв.',
        ];

    }
}
