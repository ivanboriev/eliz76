<?php


namespace App\Generators\DocumentsGenerators;


use App\Subject;
use App\Template;

class OtherDocumentGenerator
{
    public $word;


    public $company_name;
    public $company_address;
    public $company_phone1;
    public $company_phone2;
    public $company_email;
    public $company_snum;
    public $company_s_day;
    public $company_s_month;
    public $company_s_year;
    public $company_s_end_day;
    public $company_s_end_month;
    public $company_s_end_year;
    public $contract_day;
    public $contract_month;
    public $contract_year;
    public $contract_number;
    public $name;
    public $customerName;
    public $address;
    public $engineer1;
    public $engineer2;
    public $atm;
    public $humidity;
    public $start_day;
    public $start_month;
    public $start_year;
    public $c_id;
    public $s_id;


    public function generate(Subject $subject, $path)
    {
        $this->prepareData($subject);
        $this->titleGenerate($path);
        $this->conturGenerator($path);
        $this->deffectsGenerator($path);
        $this->listCiGenerator($path);
        $this->neprerivGenerator($path);
        $this->programGenerator($path);
        $this->teplovizorGenerator($path);
        $this->visualGenerator($path);
    }

    private function prepareData(Subject $subject)
    {
        $this->company_name = config('app.company_name');
        $this->company_address = config('app.company_address');
        $this->company_phone1 = config('app.company_phone1');
        $this->company_phone2 = config('app.company_phone2');
        $this->company_email = config('app.company_email');
        $this->company_snum = config('app.company_snum');
        $this->company_s_day = config('app.company_s_day');
        $this->company_s_month = config('app.company_s_month');
        $this->company_s_year = config('app.company_s_year');
        $this->company_s_end_day = config('app.company_s_end_day');
        $this->company_s_end_month = config('app.company_s_end_month');
        $this->company_s_end_year = config('app.company_s_end_year');

        $this->name = $subject->name;
        $this->address = $subject->address;
        $this->customerName = $subject->customer->name;
        $this->engineer1 = $subject->engineer1;
        $this->engineer2 = $subject->engineer2;
        $this->temp = $subject->temp;
        $this->atm = $subject->atm;
        $this->humidity = $subject->humidity;
        $this->start_day = $subject->customer->start_date->day;
        $this->start_month = $subject->customer->start_date->locale('ru')->monthName;
        $this->start_year = $subject->customer->start_date->year;
        $this->c_id = $subject->customer->id;
        $this->s_id = $subject->customer->subjects->search(function ($i) use ($subject) {
            return $i->id === $subject->id;
        });
        $this->contract_day = $subject->customer->contract_date->day;
        $this->contract_month = $subject->customer->contract_date->locale('ru')->monthName;
        $this->contract_year = $subject->customer->contract_date->year;
        $this->contract_number = $subject->customer->contract_number;
    }

    private function titleGenerate($path)
    {
        $template = Template::where('type', 'title')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor($template->path);

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('contract_day', $this->contract_day);
        $this->word->setValue('contract_month', $this->contract_month);
        $this->word->setValue('contract_year', $this->contract_year);
        $this->word->setValue('contract_number', $this->contract_number);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id + 1);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    public function conturGenerator($path)
    {
        $template = Template::where('type', 'contur')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/contur.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id + 1);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    private function deffectsGenerator($path)
    {
        $template = Template::where('type', 'deffects')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/deffects.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id + 1);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    private function listCiGenerator($path)
    {
        $template = Template::where('type', 'ci_list')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/ci_list.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id + 1);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    private function neprerivGenerator($path)
    {
        $template = Template::where('type', 'nepreriv')->first();

        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/nepreriv.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id + 1);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    private function programGenerator($path)
    {
        $template = Template::where('type', 'program')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/program.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    private function teplovizorGenerator($path)
    {
        $template = Template::where('type', 'teplovizor')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/teplovizor.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }

    private function visualGenerator($path)
    {
        $template = Template::where('type', 'visual')->first();
        $this->word = new \PhpOffice\PhpWord\TemplateProcessor(public_path('/templates/visual.docx'));

        $this->word->setValue('company_name', $this->company_name);
        $this->word->setValue('company_address', $this->company_address);
        $this->word->setValue('company_phone1', $this->company_phone1);
        $this->word->setValue('company_phone2', $this->company_phone2);
        $this->word->setValue('company_email', $this->company_email);
        $this->word->setValue('company_snum', $this->company_snum);
        $this->word->setValue('company_s_day', $this->company_s_day);
        $this->word->setValue('company_s_month', $this->company_s_month);
        $this->word->setValue('company_s_year', $this->company_s_year);
        $this->word->setValue('company_s_end_day', $this->company_s_end_day);
        $this->word->setValue('company_s_end_month', $this->company_s_end_month);
        $this->word->setValue('company_s_end_year', $this->company_s_end_year);

        $this->word->setValue('name', $this->name);
        $this->word->setValue('address', $this->address);
        $this->word->setValue('customerName', $this->customerName);
        $this->word->setValue('engineer1', $this->engineer1);
        $this->word->setValue('engineer2', $this->engineer2);
        $this->word->setValue('temp', $this->temp);
        $this->word->setValue('atm', $this->atm);
        $this->word->setValue('humidity', $this->humidity);
        $this->word->setValue('start_day', $this->start_day);
        $this->word->setValue('start_month', $this->start_month);
        $this->word->setValue('start_year', $this->start_year);
        $this->word->setValue('c_id', $this->c_id);
        $this->word->setValue('s_id', $this->s_id);

        $this->word->saveAs($path . "/" . $template->name . ".docx");
    }
}
