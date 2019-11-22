<?php


namespace App\Generators\DocumentsGenerators;


use App\Subject;
use App\Template;
use App\Equip;

class AutomateGenerator
{
    public $word;
    public $template;

    public function __construct()
    {
        $this->template = Template::where('type', 'automate')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor($this->template->path);
    }

    public function generate(Subject $subject, $path)
    {
        $this->word->setValue('company_name', config('app.company_name'));
        $this->word->setValue('company_address', config('app.company_address'));
        $this->word->setValue('company_phone1', config('app.company_phone1'));
        $this->word->setValue('company_phone2', config('app.company_phone2'));
        $this->word->setValue('company_email', config('app.company_email'));
        $this->word->setValue('company_snum', config('app.company_snum'));
        $this->word->setValue('company_s_day', config('app.company_s_day'));
        $this->word->setValue('company_s_month', config('app.company_s_month'));
        $this->word->setValue('company_s_year', config('app.company_s_year'));
        $this->word->setValue('company_s_end_day', config('app.company_s_end_day'));
        $this->word->setValue('company_s_end_day', config('app.company_s_end_day'));
        $this->word->setValue('company_s_end_year', config('app.company_s_end_year'));

        $this->word->setValue('name', $subject->name);
        $this->word->setValue('customerName', $subject->customer->name);
        $this->word->setValue('address', $subject->address);
        $this->word->setValue('engineer1', $subject->engineer1);
        $this->word->setValue('engineer2', $subject->engineer2);
        $this->word->setValue('temp', $subject->temp);
        $this->word->setValue('atm', $subject->atm);
        $this->word->setValue('humidity', $subject->humidity);
        $this->word->setValue('start_day', $subject->customer->start_date->day);
        $this->word->setValue('start_month', $subject->customer->start_date->locale('ru')->monthName);
        $this->word->setValue('start_year', $subject->customer->start_date->year);

        $data = [];
        foreach ($subject->clusters as $cluster) {
            array_push($data, [
                'number' => '',
                'group_name' => $cluster->name,
                'automate' => '',
                'nominal' => '',
                'tepl_rasc' => '',
                'magn' => '',
                'phase' => '',
                'crat' => '',
                'tokA' => '',
                'time' => '',
                'sopr' => '',
                'result' => '',
            ]);
            $number = 1;
            if (count($cluster->shields) > 0) {
                foreach ($cluster->shields as $shield) {
                    array_push($data, [
                        'number' => '',
                        'group_name' => $shield->name,
                        'automate' => '',
                        'nominal' => '',
                        'tepl_rasc' => '',
                        'magn' => '',
                        'phase' => '',
                        'crat' => '',
                        'tokA' => '',
                        'time' => '',
                        'sopr' => '',
                        'result' => '',
                    ]);

                    foreach ($shield->automate_data as $automate_data) {

                        array_push($data, [
                            'number' => $automate_data['name'] ? $number : '',
                            'group_name' => $automate_data['name'],
                            'automate' => $automate_data['automate'],
                            'nominal' => $automate_data['nominal'],
                            'tepl_rasc' => $automate_data['tepl_rasc'],
                            'magn' => $automate_data['magn'],
                            'phase' => $automate_data['phase'],
                            'crat' => $automate_data['crat'],
                            'tokA' => $automate_data['tokA'],
                            'time' => $automate_data['time'],
                            'sopr' => $automate_data['sopr'],
                            'result' => $automate_data['result'],
                        ]);
                        if ($automate_data['name']) {
                            $number++;
                        }
                    }
                }
            }
        }

        $equips = [];
        $protocol_equips = Equip::find($subject->automate_equip);
        $num = 1;
        foreach ($protocol_equips as $equip) {

            array_push($equips, [
                "num" => $num,
                "eq_name" => $equip->name,
                "eq_number" => $equip->factory_number,
                "eq_check_date" => $equip->check_date,

            ]);
            $num++;
        }


        $this->word->cloneRowAndSetValues('group_name', $data);
        $this->word->cloneRowAndSetValues('eq_name', $equips);
        $this->word->saveAs($path . "/" . $this->template->name . ".docx");
    }
}
