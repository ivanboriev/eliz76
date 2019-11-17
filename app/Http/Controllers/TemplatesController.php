<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{

    public function index()
    {
        $templates = Template::orderBy('name')->get();
        return response()->json($templates);
    }

    public function destroy(Request $request)
    {
        Template::destroy($request->id);
        return response()->json(["message" => "Документ удален" ]);
    }

    public function store(Request $request)
    {

        $file = $request->file('doc_file');
        $name = $request->get('name');
        $type = $request->get('type');
        $file_name = $type . '.' . $file->getClientOriginalExtension();

        $data = [
            "name" => $name,
            "type" => $type,
            "url" => env('APP_URL').'/templates/' . $file_name,
            "path" => public_path('/templates/') . $file_name,
        ];

        $file->move(public_path('templates'), $file_name);
        Template::create($data);
        return response()->json(["message" => "FileUploaded"]);
    }
}
