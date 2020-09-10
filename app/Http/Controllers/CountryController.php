<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

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

        $Country = Country::create($request->all());

        return response()->json($Country, 201);
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
        return response('Deleted Successfully', 200);
    }
}