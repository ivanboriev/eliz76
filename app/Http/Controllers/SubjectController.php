<?php

namespace App\Http\Controllers;

use App\Generators\DocumentGenerator;
use App\Http\Resources\SubjectResource;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function index(Request $request)
    {
        $subjects = Subject::where('customer_id', $request->customerId)->orderBy('created_at', 'desc')->get();
        return response()->json(SubjectResource::collection($subjects));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Subject::create($request->subject);
        return response()->json([
            'message' => 'Объект добавлен'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return new SubjectResource(Subject::find($request->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $subject = Subject::find($request->subject['id']);
        $subject->update($request->subject);
        return response()->json([
            'message' => 'Объект обновлен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Subject::destroy($request->id);
        return response()->json([
            'message' => 'Заказчик удален'
        ]);
    }

    public function generate(Request $request)
    {
       $subject =  Subject::find($request->id);

       $doc = new DocumentGenerator($subject);
       $path = $doc->generate();
       $subject->documents_path = $path;
       $subject->documents_generated = true;
       $subject->save();


       $subject->save();
        return response()->json([
            'message' => 'Документы созданы'
        ]);
    }

    public function copySubject(Request $request){
        $subject =  Subject::find($request->id);
        $new_subject = $subject->replicate();
        $new_subject->name = $new_subject->name . ' - Копия';
        $new_subject->push();
        foreach($subject->clusters as $cluster){
            $new_cluster = $cluster->replicate();
            $new_cluster->subject_id =$new_subject->id;
            $new_cluster->push();

            foreach($cluster->shields as $shield){
                $new_shield = $shield->replicate();
                $new_shield->cluster_id = $new_cluster->id;
                $new_shield->push();

                foreach($shield->groups as $group){
                    $new_group = $group->replicate();
                    $new_group->shield_id = $new_shield->id;
                    $new_group->push();
                }
            }
        }

        return response()->json($new_subject);
    }
}
