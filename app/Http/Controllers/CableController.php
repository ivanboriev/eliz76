<?php

namespace App\Http\Controllers;

use App\Cable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Cable::orderBy('name')->get());
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        Cable::create($request->cable);
        return response()->json([
            'message' => 'Кабель добавлен'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        return response()->json(Cable::find($request->id));
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
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $cable = Cable::find($request->cable['id']);
        $cable->update($request->cable);
        return response()->json([
            'message' => 'Кабель обновлен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        Cable::destroy($request->id);
        return response()->json([
            'message' => 'Кабель удален'
        ]);
    }
}
