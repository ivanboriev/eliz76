<?php


namespace App\Generators;


use App\Generators\DocumentsGenerators\IsolateGenerator;
use App\Generators\DocumentsGenerators\OtherDocumentGenerator;
use App\Generators\DocumentsGenerators\PhaseGenerator;
use App\Generators\DocumentsGenerators\UzoGenerator;
use App\Generators\DocumentsGenerators\AutomateGenerator;

use App\Subject;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DocumentGenerator
{
    public $subject;
    public $isolateGenerator;
    public $phaseGenerator;
    public $uzoGenerator;
    public $automateGenerator;
    public $path;


    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
        $this->preparePath();
        $this->isolateGenerator = new IsolateGenerator();
        $this->phaseGenerator = new PhaseGenerator();
        $this->uzoGenerator = new UzoGenerator();
        $this->automateGenerator = new AutomateGenerator();
        $this->otherDocumentGenerator = new OtherDocumentGenerator();
    }


    public function generate()
    {
        if ($this->subject->isolate) {
            $this->isolateGenerator->generate($this->subject, $this->path);
        }
        if ($this->subject->phase) {
            $this->phaseGenerator->generate($this->subject, $this->path);
        }
        if ($this->subject->uzo) {
            $this->uzoGenerator->generate($this->subject, $this->path);
        }
        if ($this->subject->automate) {
            $this->automateGenerator->generate($this->subject, $this->path);
        }
        $this->otherDocumentGenerator->generate($this->subject, $this->path);

        return $this->generateZipArchive();
    }

    public function generateZipArchive()
    {
        $prepareFiles = File::files($this->path);
        $files_paths = [];
        $files = [];
        foreach ($prepareFiles as $file) {
            if (Str::endsWith($file, ['.docx'])) {
                array_push($files, $file);
                array_push($files_paths, $file->getPathname());
            }
        }
        $time = time();
        $zipper = Zipper::make($this->path . '/' . $this->subject->name . $time . '.zip');
        foreach ($files as $file) {
            $zipper->add($file, iconv('UTF-8', 'CP866', $file->getFilename()));
        }
        $zipper->close();
        File::delete($files_paths);
        return '/results/' . $this->subject->customer->id . '/' . $this->subject->id . '/' . $this->subject->name . $time . '.zip';
    }

    public function preparePath()
    {
        if (!File::exists(public_path('/results'))) {
            File::makeDirectory(public_path('/results'));
        }
        if (!File::exists(public_path('/results/' . $this->subject->customer->id))) {
            File::makeDirectory(public_path('/results/' . $this->subject->customer->id));
        }
        if (!File::exists(public_path('/results/' . $this->subject->customer->id . '/' . $this->subject->id))) {
            File::makeDirectory(public_path('/results/' . $this->subject->customer->id . '/' . $this->subject->id));
        }
        $this->path = public_path('/results/' . $this->subject->customer->id . '/' . $this->subject->id);
    }
}
