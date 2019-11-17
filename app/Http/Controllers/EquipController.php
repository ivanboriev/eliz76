<?php

namespace App\Http\Controllers;

use App\Equip;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class EquipController extends Controller
{
    public function index()
    {
        $equips = Equip::orderBy('created_at', 'desc')->get();
        return response()->json($equips);
    }

    public function store(Request $request){
        Equip::create($request->get('equip'));
        return response()->json([
            'message' => 'Оборудование добавлено'
        ]);
    }
}
