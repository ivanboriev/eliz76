<?php


namespace App\Generators\Isolate;


class ReserveCableGenerator
{
    protected static $min;
    protected static $max;

    public static function generate($shield, $group, $cable)
    {
        self::$min = $shield->min;
        self::$max = $shield->max;
        return [
            'name' => $group->name,
            'cable' => $cable->name,
            'voltage' => '-',
            'AB' => '-',
            'AC' => '-',
            'BC' => '-',
            'AN' => '-',
            'BN' => '-',
            'CN' => '-',
            'APE' => '-',
            'BPE' => '-',
            'CPE' => '-',
            'NPE' => '-',
            'result' => '-',
        ];

    }
}
