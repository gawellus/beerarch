<?php

namespace App\Http\Controllers;

use App\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StyleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function getList()
    {
        return response()->json(Style::all());
    }

    public function get($id)
    {
        return response()->json(Style::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        
        $Style = Style::firstOrNew($request->all());
        if($Style->id) {
            return response()->json($Style, 200);
        } else {
            $Style->save();
            return response()->json($Style, 201);
        }
        return response()->json($Style, 400);        

    }

    public function update($id, Request $request)
    {
        $Style = Style::findOrFail($id);
        $Style->update($request->all());

        return response()->json($Style, 200);
    }

    public function delete($id)
    {
        Style::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }
}