<?php


namespace App\Generators\DocumentsGenerators;


use App\Subject;
use App\Template;
use App\Equip;

class UzoGenerator
{
    public $word;

    public function __construct()
    {
        $this->template = Template::where('type', 'uzo')->first();
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
        $this->word->setValue('company_s_end_month', config('app.company_s_end_month'));
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
                'srtr1' => '',
                'srdz1' => '',
                'srtr2' => '',
                'srdz2' => '',
                'tepl_rasc' => '',
                'diff' => '',
                'result' => '',
            ]);
            if (count($cluster->shields) > 0) {
                foreach ($cluster->shields as $shield) {
                    array_push($data, [
                        'number' => '',
                        'group_name' => $shield->name,
                        'automate' => '',
                        'nominal' => '',
                        'srtr1' => '',
                        'srdz1' => '',
                        'srtr2' => '',
                        'srdz2' => '',
                        'tepl_rasc' => '',
                        'diff' => '',
                        'result' => '',
                    ]);
                    $number = 1;
                    foreach ($shield->uzo_data as $uzo_data) {
                        array_push($data, [
                            'number' => $number,
                            'group_name' => $uzo_data['name'],
                            'automate' => $uzo_data['automate'],
                            'nominal' => $uzo_data['nominal'],
                            'srtr1' => $uzo_data['srtr1'],
                            'srdz1' => $uzo_data['srdz1'],
                            'srtr2' => $uzo_data['srtr2'],
                            'srdz2' => $uzo_data['srdz2'],
                            'tepl_rasc' => $uzo_data['tepl_rasc'],
                            'diff' => $uzo_data['diff'],
                            'result' => $uzo_data['result'],
                        ]);
                        $number++;
                    }
                }
            }
        }

        $protocol_equips = Equip::find($subject->uzo_equip);
        if (count($protocol_equips) > 0) {
            $equips = [];
            $num = 1;
            foreach ($protocol_equips as $equip) {

                array_push($equips, [
                    "num" => $num,
                    "eq_name" => $equip->name,
                    "eq_type" => $equip->type,
                    "eq_num" => $equip->factory_number,
                    "eq_ch_d" => $equip->check_date->format('d.m.Y'),
                    "eq_nch_d" => $equip->next_check_date->format('d.m.Y'),
                ]);
                $num++;
            }
            $this->word->cloneRowAndSetValues('eq_name', $equips);
        }

        $this->word->cloneRowAndSetValues('group_name', $data);
        $this->word->saveAs($path . "/" . $this->template->name . ".docx");
    }
}
