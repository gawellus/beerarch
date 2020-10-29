<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function getList()
    {
        return response()->json(Country::all());
    }

    public function get($id)
    {
        return response()->json(Country::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $Country = Country::firstOrNew($request->all());
        if($Country->id) {
            return response()->json($Country, 200);
        } else {
            $Country->save();
            return response()->json($Country, 201);
        }
        return response()->json($Country, 400);        
    }

    public function update($id, Request $request)
    {
        $Country = Country::findOrFail($id);
        $Country->update($request->all());

        return response()->json($Country, 200);
    }

    public function delete($id)
    {
        Country::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }
}