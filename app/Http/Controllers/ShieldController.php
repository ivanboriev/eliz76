<?php

namespace App\Http\Controllers;

use App\Cable;
use App\Cluster;
use App\Generators\Generator;
use App\Group;
use App\Http\Resources\GroupResource;
use App\Shield;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        Shield::destroy($request->id);
        return response()->json([
            'message' => 'Щит удален'
        ]);
    }

    public function groups(Request $request)
    {
        $shield = Shield::find($request->shid);
        return response()->json(GroupResource::collection($shield->groups->sortBy('order')));
    }

    public function addGroups(Request $request)
    {
        $shield = Shield::find($request->shid);
        $i = 1;
        while ($i <= $request->groups['g_count']) {
            Group::create([
                'name' => $shield->group_name,
                'consumer' => '',
                'cable_id' => $request->groups['cable']['id'],
                'automate_name' => $request->groups['automate_name'],
                'automate_category' => $request->groups['automate_category'],
                'automate_nominal' => $request->groups['automate_nominal'],
                'shield_id' => $shield->id,
                'order' => $i
            ]);
            $i++;
        }
        return response()->json([
            'message' => 'Группы созданы'
        ]);
    }

    public function saveGroups(Request $request)
    {

        $i = 1;
        foreach ($request->groups as $group) {
            $gr = Group::find($group['id']);

            if ($group['enter']) {
                $i--;
            }
            $gr->update([
                'name' => $group['name'],
                'consumer' => $group['consumer'],
                'cable_id' => $group['cable']['id'],
                'automate_name' => $group['automate_name'],
                'automate_category' => $group['automate_category'],
                'automate_nominal' => $group['automate_nominal'],
                'uzo' => $group['uzo'],
                'pred' => $group['pred'],
                'diff' => $group['diff'],
                'enter' => $group['enter'],
                'order' => $i,
                'numerable' => $group['numerable']
            ]);
            $i++;
        }
        return response()->json([
            'message' => 'Группы обновлены'
        ]);
    }

    public function updateShieldsInCluster(Request $request)
    {
        $shields = $request->shields;
        $i = 1;
        foreach ($shields as $shield) {
            Shield::find($shield['id'])->update([
                'name' => $shield['name'],
                'group_name' => $shield['group_name'],
                'min' => $shield['min'],
                'max' => $shield['max'],
                'order' => $i,
            ]);
            $i++;
        }
    }

    public function deleteGroup(Request $request)
    {
        Group::destroy($request->id);
    }

    public function generate(Request $request)
    {
        $shield = Shield::with('groups')->find($request->sid);
        Generator::generate($shield);
    }

    /**
     * @param $name
     * @param $count
     * @param $consumer
     * @param $enter
     * @param $order
     * @return string
     */


    public function getIsolateData(Request $request)
    {
        $shield = Shield::find($request->shid);
        return response()->json($shield);
    }

    public function saveIsolateData(Request $request)
    {
        $shield = Shield::find($request->shid);
        $data = $request->isolate_data;
        $shield->isolate_data = $data;
        $shield->save();
        return response()->json([
            'message' => 'Протокол обновлен'
        ]);
    }

    public function isolateBlock(Request $request)
    {
        $shield = Shield::find($request->shid);
        $shield->isolate_block = $request->block;
        $shield->save();
    }

    public function getPhaseData(Request $request)
    {
        $shield = Shield::find($request->shid);
        return response()->json($shield);
    }

    public function savePhaseData(Request $request)
    {
        $shield = Shield::find($request->shid);
        $data = $request->phase_data;
        $shield->phase_data = $data;
        $shield->save();
        return response()->json([
            'message' => 'Протокол обновлен'
        ]);
    }

    public function phaseBlock(Request $request)
    {
        $shield = Shield::find($request->shid);
        $shield->phase_block = $request->block;
        $shield->save();
    }

    public function getUzoData(Request $request)
    {
        $shield = Shield::find($request->shid);
        return response()->json($shield);
    }

    public function saveUzoData(Request $request)
    {
        $shield = Shield::find($request->shid);
        $data = $request->uzo_data;
        $shield->uzo_data = $data;
        $shield->save();
        return response()->json([
            'message' => 'Протокол обновлен'
        ]);
    }


    public function uzoBlock(Request $request)
    {
        $shield = Shield::find($request->shid);
        $shield->uzo_block = $request->block;
        $shield->save();
    }

    public function automateBlock(Request $request)
    {
        $shield = Shield::find($request->shid);
        $shield->automate_block = $request->block;
        $shield->save();
    }

    public function getAutomateData(Request $request)
    {
        $shield = Shield::find($request->shid);
        return response()->json($shield);
    }

    public function saveAutomateData(Request $request)
    {
        $shield = Shield::find($request->shid);
        $data = $request->automate_data;
        $shield->automate_data = $data;
        $shield->save();
        return response()->json([
            'message' => 'Протокол обновлен'
        ]);
    }


    public function getEditorData(Request $request)
    {
        $subject = Subject::find($request->subject_id);
        $shield = Shield::find($request->shield_id);
        return response()->json([
            'subject' => $subject->name,
            'shield' => $shield->name,
        ]);
    }

    public function addShield(Request $request)
    {
        $cluster = Cluster::find($request->cluster_id);
        $shield = $request->shield;
        $i = 1;
        if (count($cluster->shields) > 0) {
            $i = count($cluster->shields);
        }
        $shield['cluster_id'] = $cluster->id;
        $shield['order'] = $i++;
        Shield::create($shield);
    }

    public function getShields(Request $request)
    {

        $shields = Shield::where('cluster_id', $request->cluster_id)->orderBy('order')->get();
        return $shields->toArray();
    }

    public function copyShield(Request $request)
    {
        $shield = Shield::find($request->id);
        $new_shield = $shield->replicate();
        $new_shield->name = $new_shield->name . ' - Копия';
        $new_shield->push();
        foreach ($shield->groups as $group) {
            $new_group = $group->replicate();
            $new_group->shield_id = $new_shield->id;
            $new_group->push();
        }
    }

    public function moveShield(Request $request)
    {
        $shield = Shield::find($request->shield_id);
        $shield->update([
            "cluster_id" => $request->cluster_id
        ]);
        return response()->json([
            'message' => "Щит перенесён",

        ]);
    }

    public function automateNames()
    {
        $groups = Group::orderBy('automate_name')->get();
        $names = $groups->unique('automate_name');
        $names = $names->pluck('automate_name')->toArray();

        return response()->json($names );
    }
}
