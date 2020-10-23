<?php

namespace App\Http\Controllers;

use App\Brewery;
use App\Country;
use Illuminate\Http\Request;

class BreweryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function getList()
    {
        $breweries = Brewery::with('country')->get();
        return response()->json($breweries);
    }

    public function get($id)
    {
        return response()->json(Brewery::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if($countryId = $request->input('country_id')) {
            $country = Country::find($countryId);
        }

        $Brewery = new Brewery(['name' => $request->input('name')]);
        $Brewery->country()->associate($country);
        $Brewery->save();

        return response()->json($Brewery, 201);
    }

    public function update($id, Request $request)
    {
        $Brewery = Brewery::findOrFail($id);
        $Brewery->update($request->all());

        return response()->json($Brewery, 200);
    }

    public function delete($id)
    {
        Brewery::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }
}