<?php


namespace App\Generators\Uzo;


use App\Cable;
use App\Shield;

class UzoGenerator
{

    protected static $data = [];

    public static function generate(Shield $shield)
    {
        foreach ($shield->groups->sortBy('order') as $group) {
            $cable = Cable::find($group->cable_id);
            if($group->uzo && $cable->count > 0 || $group->diff && $cable->count > 0){
                array_push(self::$data,[
                    'name' => $group->name,
                    'automate' => $group->automate_name,
                    'nominal' => $group->automate_nominal,
                    'srtr1' => '-',
                    'srdz1' => 30,
                    'srtr2' => '-',
                    'srdz2' => rand(20, 30),
                    'tepl_rasc' => '-',
                    'diff' => rand(10, 30),
                    'result' => 'Соотв.',
                ]);
            }
        }

        $shield->uzo_data = self::$data;
        $shield->save();


    }
}
