<?php


namespace App\Generators\Phase;


use App\Cable;
use App\Shield;

class PhaseGenerator
{
    protected static $twc = 1;
    protected static $trc = 1;
    protected static $data = [];

    public static function generate(Shield $shield)
    {
        foreach ($shield->groups->sortBy('order') as $group) {
            $cable = Cable::find($group->cable_id);
            if ($cable->count == 0) {
                array_push(self::$data, ReserveCablePhaseGenerator::generate($shield, $group, $cable));
            }
            if ($cable->count == 2) {
                array_push(self::$data, TwoCablePhaseGenerator::generate($shield, $group, $cable, self::$twc));
                self::$twc++;
                if (self::$twc > 3) {
                    self::$twc = 1;
                }
            }
            if ($cable->count == 3) {
                array_push(self::$data, ThreeCablePhaseGenerator::generate($shield, $group, $cable, self::$trc));
                self::$trc++;
                if (self::$trc > 3) {
                    self::$trc = 1;
                }
            }
            if ($cable->count == 4) {
                array_push(self::$data, FourCablePhaseGenerator::generate($shield, $group, $cable));
            }
            if ($cable->count == 5) {
                array_push(self::$data, FiveCablePhaseGenerator::generate($shield, $group, $cable));
            }
        }

        $shield->phase_data = self::$data;
        $shield->save();


    }
}
