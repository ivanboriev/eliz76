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
    public function template(Request $request)
    {
        $template = Template::find($request->id);
        return response()->json($template);
    }

    public function destroy(Request $request)
    {
        $template = Template::find($request->id);
        unlink($template->path);
        $template->destroy($request->id);
        return response()->json(["message" => "Документ удален"]);
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
            "url" => env('APP_URL') . '/templates/' . $file_name,
            "path" => public_path('templates') . '/' . $file_name,
        ];

        $file->move(public_path('templates'), $file_name);
        Template::create($data);
        return response()->json([
            "message" => "FileUploaded",
            "path" => $data["path"]
        ]);
    }

    public function update(Request $request)
    {
        $template = Template::find($request->id);
        $file = $request->file('doc_file');
        if ($file) {
            $name = $request->get('name');
            $type = $request->get('type');
            $id = $request->get('id');
            $file_name = $type . '.' . $file->getClientOriginalExtension();

            $data = [
                "name" => $name,
                "type" => $type,
                "url" => env('APP_URL') . '/templates/' . $file_name,
                "path" => public_path('templates') . '/' . $file_name,
            ];

            $file->move(public_path('templates'), $file_name);

            $template->update($data);
        } else {

            $template->update($request->all());
        }
        return response()->json([
            "message" => "Updated",

        ]);
    }
}
