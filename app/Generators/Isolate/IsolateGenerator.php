<?php


namespace App\Generators\Isolate;


use App\Cable;
use App\Shield;

class IsolateGenerator
{
    protected static $twc = 1;
    protected static $trc = 1;
    protected static $data = [];

    public static function generate(Shield $shield)
    {
        foreach ($shield->groups->sortBy('order') as $group) {
            $cable = Cable::find($group->cable_id);
            if ($cable->count == 0) {
                array_push(self::$data, ReserveCableGenerator::generate($shield, $group, $cable));
            }
            if ($cable->count == 2) {
                array_push(self::$data, TwoCableGenerator::generate($shield, $group, $cable, self::$twc));
                self::$twc++;
                if (self::$twc > 3) {
                    self::$twc = 1;
                }
            }
            if ($cable->count == 3) {
                array_push(self::$data, ThreeCableGenerator::generate($shield, $group, $cable, self::$trc));
                self::$trc++;
                if (self::$trc > 3) {
                    self::$trc = 1;
                }
            }
            if ($cable->count == 4) {
                array_push(self::$data, FourCableGenerator::generate($shield, $group, $cable));
            }
            if ($cable->count == 5) {
                array_push(self::$data, FiveCableGenerator::generate($shield, $group, $cable));
            }
        }

        $shield->isolate_data = self::$data;
        $shield->save();


    }
}
