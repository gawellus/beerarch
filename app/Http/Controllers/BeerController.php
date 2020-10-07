<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use App\Country;
use App\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function getList()
    {
        return response()->json(Beer::all());
    }

    public function get($id)
    {
        return response()->json(Beer::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if($breweryId = $request->input('brewery_id')) {
            $brewery = Brewery::find($breweryId);
        }

        if($styleId = $request->input('style_id')) {
            $style = Style::find($styleId);
        }

        $Beer = new Beer([
            'name' => $request->input('name'),
            'alc' => $request->input('alc'),
            'ekst' => $request->input('ekst'),
            'ibu' => $request->input('ibu'),
            'description' => $request->input('description'),
            'notes' => $request->input('notes'),
            'rating' => $request->input('rating'),
            'photo' => $request->input('photo'),
        ]);
        
        $Beer->style()->associate($style);
        $Beer->brewery()->associate($brewery);
        $Beer->save();

        return response()->json($Beer, 201);
    }

    public function update($id, Request $request)
    {
        $Beer = Beer::findOrFail($id);
        $Beer->update($request->all());

        return response()->json($Beer, 200);
    }

    public function delete($id)
    {
        Beer::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}