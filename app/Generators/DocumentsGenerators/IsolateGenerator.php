<?php


namespace App\Generators\DocumentsGenerators;


use App\Subject;
use App\Template;
use App\Equip;

class IsolateGenerator
{
    public $word;

    public function __construct()
    {
        $this->template = Template::where('type', 'isolate')->first();
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
                'cable' => '',
                'voltage' => '',
                'AB' => '',
                'AC' => '',
                'BC' => '',
                'AN' => '',
                'BN' => '',
                'CN' => '',
                'APE' => '',
                'BPE' => '',
                'CPE' => '',
                'NPE' => '',
                'result' => '',
            ]);
            $number = 1;
            if (count($cluster->shields) > 0) {
                foreach ($cluster->shields as $shield) {
                    array_push($data, [
                        'number' => '',
                        'group_name' => $shield->name,
                        'cable' => '',
                        'voltage' => '',
                        'AB' => '',
                        'AC' => '',
                        'BC' => '',
                        'AN' => '',
                        'BN' => '',
                        'CN' => '',
                        'APE' => '',
                        'BPE' => '',
                        'CPE' => '',
                        'NPE' => '',
                        'result' => '',
                    ]);

                    foreach ($shield->isolate_data as $isolate_data) {
                        array_push($data, [
                            'number' => $number,
                            'group_name' => $isolate_data['name'],
                            'cable' => $isolate_data['cable'],
                            'voltage' => $isolate_data['voltage'],
                            'AB' => $isolate_data['AB'],
                            'AC' => $isolate_data['AC'],
                            'BC' => $isolate_data['BC'],
                            'AN' => $isolate_data['AN'],
                            'BN' => $isolate_data['BN'],
                            'CN' => $isolate_data['CN'],
                            'APE' => $isolate_data['APE'],
                            'BPE' => $isolate_data['BPE'],
                            'CPE' => $isolate_data['CPE'],
                            'NPE' => $isolate_data['NPE'],
                            'result' => $isolate_data['result'],
                        ]);
                        $number++;
                    }
                }
            }
        }


        $protocol_equips = Equip::find($subject->isolate_equip);
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
