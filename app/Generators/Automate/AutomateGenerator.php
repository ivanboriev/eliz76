<?php


namespace App\Generators\Automate;


use App\Cable;
use App\Shield;

class AutomateGenerator
{

    protected static $data = [];

    public static function generate(Shield $shield)
    {
        foreach ($shield->groups->sortBy('order') as $group) {
            $cable = Cable::find($group->cable_id);
           /* if ($cable->count >= 3) {
                array_push(self::$data, OnePhaseGenerator::generate($shield, $group, $cable));
            }
            if ($cable->count > 3) {
                array_push(self::$data, ThreePhaseGenerator::generate($shield, $group, $cable));
            }*/
            if(!$group->pred){
                array_push(self::$data, OnePhaseGenerator::generate($shield, $group, $cable));
            }

        }

        $shield->automate_data = self::$data;
        $shield->save();
    }
}
