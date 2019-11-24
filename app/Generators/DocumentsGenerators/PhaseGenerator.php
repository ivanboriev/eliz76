<?php


namespace App\Generators\DocumentsGenerators;


use App\Subject;
use App\Template;
use App\Equip;

class PhaseGenerator
{
    public $word;

    public function __construct()
    {
        $this->template = Template::where('type', 'phase')->first();
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
                'type' => '',
                'nominal' => '',
                'magn' => '',
                'A1' => '',
                'B1' => '',
                'C1' => '',
                'A2' => '',
                'B2' => '',
                'C2' => '',
                'dop' => '',
                'time' => '',
                'result' => '',
            ]);
            $number = 1;
            if (count($cluster->shields) > 0) {
                foreach ($cluster->shields as $shield) {
                    array_push($data, [
                        'number' => '',
                        'group_name' => $shield->name,
                        'automate' => '',
                        'type' => '',
                        'nominal' => '',
                        'magn' => '',
                        'A1' => '',
                        'B1' => '',
                        'C1' => '',
                        'A2' => '',
                        'B2' => '',
                        'C2' => '',
                        'dop' => '',
                        'time' => '',
                        'result' => '',
                    ]);

                    foreach ($shield->phase_data as $phase_data) {
                        array_push($data, [
                            'number' => $number,
                            'group_name' => $phase_data['name'],
                            'automate' => $phase_data['automate'],
                            'type' => $phase_data['type'],
                            'nominal' => $phase_data['nominal'],
                            'magn' => $phase_data['magn'],
                            'A1' => $phase_data['A1'],
                            'B1' => $phase_data['B1'],
                            'C1' => $phase_data['C1'],
                            'A2' => $phase_data['A2'],
                            'B2' => $phase_data['B2'],
                            'C2' => $phase_data['C2'],
                            'dop' => $phase_data['dop'],
                            'time' => $phase_data['time'],
                            'result' => $phase_data['result'],
                        ]);
                        $number++;
                    }
                }
            }
        }

        $protocol_equips = Equip::find($subject->phase_equip);
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
