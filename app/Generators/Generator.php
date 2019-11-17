<?php


namespace App\Generators;



use App\Cable;
use App\Generators\Automate\AutomateGenerator;
use App\Generators\Uzo\UzoGenerator;
use App\Shield;
use App\Generators\Isolate\IsolateGenerator;
use App\Generators\Phase\PhaseGenerator;

class Generator
{
    public static $group_number = 0;

    public static function generate(Shield $shield)
    {
        foreach ($shield->groups->sortBy('order') as $group) {
            $cable = Cable::find($group->cable_id);
            $group->update([
                'name' => self::generateGroupName($shield->group_name, $cable->count, $group->consumer, $group->enter, $group->numerable)
            ]);
        }
        if ($shield->cluster->subject->isolate && !$shield->isolate_block) {
            self::isolate($shield);
        }
        if($shield->cluster->subject->phase && !$shield->phase_block){
            self::phase($shield);
        }
        if($shield->cluster->subject->uzo && !$shield->uzo_block){
            self::uzo($shield);
        }
        if($shield->cluster->subject->automate && !$shield->automate_block){
            self::automate($shield);
        }

    }

    public static function isolate(Shield $shield)
    {
        IsolateGenerator::generate($shield);
    }

    public static function phase(Shield $shield)
    {
        PhaseGenerator::generate($shield);
    }

    public static function uzo(Shield $shield)
    {
        UzoGenerator::generate($shield);
    }
    public static function automate(Shield $shield)
    {
        AutomateGenerator::generate($shield);
    }

    public static function generateGroupName($name, $count, $consumer, $enter, $numerable)
    {
        if(!$numerable){
            return $consumer;
        }

        if ($enter) {
            return 'Ввод';
        }
        if ($count == 0) {
            self::$group_number++;
            return $name . ' ' . self::$group_number . ' - Резерв';
        }
        if ($consumer) {
            self::$group_number++;
            return $name . ' ' . self::$group_number . ' - ' . $consumer;
        } else {
            self::$group_number++;
            return $name . ' ' . self::$group_number;
        }

    }
}
