<?php

namespace App\Http\Controllers;

use App\Cluster;
use App\Http\Resources\ClusterResource;
use App\Shield;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clusters = Cluster::where('subject_id', $request->sid)->orderBy('order')->get();
        return response()->json(ClusterResource::collection($clusters));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('clusters')) {
            $i = 1;
            foreach ($request->clusters as $cluster) {
                if (array_key_exists('id', $cluster)) {
                    $cl = Cluster::find($cluster['id']);
                    $cl->update([
                        'name' => $cluster['name'],
                        'order' => $i,
                        'subject_id' => $request->subjectId
                    ]);

                } else {
                    $cl = Cluster::create([
                        'name' => $cluster['name'],
                        'order' => $i,
                        'subject_id' => $request->subjectId
                    ]);

                }
                $i++;
                if (count($cluster['shields']) > 0) {
                    $si = 1;
                    foreach ($cluster['shields'] as $shield) {
                        if (array_key_exists('id', $shield)) {
                            $sh = Shield::find($shield['id']);
                            $sh->update([
                                'name' => $shield['name'],
                                'group_name' => $shield['group_name'],
                                'min' => $shield['min'],
                                'max' => $shield['max'],
                                'order' => $si,
                                'cluster_id' => $cl->id
                            ]);

                        } else {
                            Shield::create([
                                'name' => $shield['name'],
                                'group_name' => $shield['group_name'],
                                'min' => $shield['min'],
                                'max' => $shield['max'],
                                'order' => $si,
                                'cluster_id' => $cl->id
                            ]);

                        }
                        $si++;
                    }
                }
            }
        }
        return response()->json([
            'message' => 'Данные сохранены'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Cluster::destroy($request->id);
        return response()->json([
            'message' => 'Кластер удален'
        ]);
    }
    public function update(Request $request)
    {
        $cluster = Cluster::find($request->id);
        $cluster->update([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => 'Кластер обновлён'
        ]);
    }
}
