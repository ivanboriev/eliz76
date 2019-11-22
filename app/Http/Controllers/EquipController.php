<?php

namespace App\Http\Controllers;

use App\Equip;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class EquipController extends Controller
{
    public function index()
    {
        $equips = Equip::orderBy('name')->get();
        return response()->json($equips);
    }
    public function getEquip(Request $request)
    {
        $equp = Equip::find($request->id);
        return response()->json($equp);
    }

    public function store(Request $request)
    {
        Equip::create($request->get('equip'));
        return response()->json([
            'message' => 'Оборудование добавлено'
        ]);
    }
    public function update(Request $request)
    {
        $equp = Equip::find($request->id);
        $equp->update($request->all());
        return response()->json([
            'message' => 'Оборудование обновлено'
        ]);
    }
    public function destroy(Request $request)
    {
        Equip::destroy($request->id);

        return response()->json([
            'message' => 'Оборудование удалено'
        ]);
    }
}
