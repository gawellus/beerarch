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
        $beers = Beer::with('brewery', 'style', 'brewery.country')->get();
        return response()->json($beers);
    }

    public function get($id)
    {
        return response()->json(Beer::with('brewery', 'style', 'brewery.country')->find($id));
    }

    public function create(Request $request)
    {        
        $photo = null;

        $Beer = new Beer([
            'name' => $request->input('name'),
            'alc' => $request->input('alc'),
            'ekst' => $request->input('ekst'),
            'ibu' => $request->input('ibu'),
            'description' => $request->input('description'),
            'notes' => $request->input('notes'),
            'rating' => $request->input('rating')            
        ]);

        if ($request->hasFile('file'))
        {  
            $photo = $this->uploadPhoto($request->file('file'));
        }

        $Beer->photo = $photo;

        $this->validate($request, [
            'name' => 'required',
        ]);

        if($breweryId = $request->input('brewery_id')) {
            $brewery = Brewery::find($breweryId);
        }

        if($styleId = $request->input('style_id')) {
            $style = Style::find($styleId);
        }

        $Beer->style()->associate($style);
        $Beer->brewery()->associate($brewery);
        $Beer->save();
        
        return response()->json($Beer, 201);
    }

    private function uploadPhoto($file)
    {
        $filename  = $file->getClientOriginalName();            
        $picture   = date('His').'-'.$filename;
        $file->move(base_path('public/uploads/images'), $picture);
        return $picture;
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