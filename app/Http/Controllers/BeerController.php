<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use App\Style;
use Illuminate\Http\Request;

use Carbon\Carbon;

class BeerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',  ['except' => ['getList', 'getLatest', 'search']]);        
    }

    public function getList(Request $request)
    {     
        $sort = $request->sort;
        $order = $request->order ?? 'ASC';        
        $limit  = $request->limit;
      
        $beers = Beer::with('brewery', 'style', 'brewery.country')
            ->when($sort && $order, function ($query) use ($sort, $order) {
                return $query->orderBy($sort, $order);
            })
            ->when($limit, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->get();
      
        return response()->json($beers);
    }

    public function get($id)
    {
        return response()->json(Beer::with('brewery', 'style', 'brewery.country')->find($id));
    }

    public function create(Request $request)
    {       
        $this->validate($request, [
            'name' => 'required',
        ]);

        $photo = null;

        $Beer = Beer::where('name', $request->input('name'))->first();        
        
        if($Beer) {
            return response()->json($Beer, 200);
        }

        $Beer = new Beer([
            'name' => $request->input('name'),
            'alc' => $request->input('alc'),
            'ekst' => $request->input('ekst'),
            'ibu' => $request->input('ibu'),
            'description' => $request->input('description'),
            'notes' => $request->input('notes'),
            'rating' => $request->input('rating'),            
            'consumed_on' => Carbon::parse($request->input('consumed_on'))->toDateTimeString()
        ]);       

        if ($request->hasFile('file'))
        {  
            $photo = $this->uploadPhoto($request->file('file'));
            $Beer->photo = $photo;
        }

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

    public function update(Request $request, $id)
    {
        $beer = Beer::findOrFail($id);
        $beer->name = $request->input('name');
        $beer->alc = $request->input('alc');
        $beer->ekst = $request->input('ekst');
        $beer->ibu = $request->input('ibu');
        $beer->description = $request->input('description');
        $beer->notes = $request->input('notes');
        $beer->rating = $request->input('rating');
        $beer->consumed_on = Carbon::parse($request->input('consumed_on'))->toDateTimeString();

        if($breweryId = $request->input('brewery_id')) {
            $brewery = Brewery::find($breweryId);
            $beer->brewery()->associate($brewery);
        }

        if($styleId = $request->input('style_id')) {
            $style = Style::find($styleId);
            $beer->style()->associate($style);
        }

        if ($request->hasFile('file'))
        {  
            $photo = $this->uploadPhoto($request->file('file'));
            $beer->photo = $photo;
        }

        $beer->save();
        
        return response()->json($beer, 200);
    }

    public function delete($id)
    {
        Beer::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }

    public function getLatest()
    {
        return response()->json(Beer::with('brewery', 'style', 'brewery.country')->latest('consumed_on')->first());
    }

    public function search(Request $request)
    {
        $search = $request->search;        
      
        $beers = Beer::with('brewery', 'style', 'brewery.country')
            ->where('name', 'LIKE', "%{$search}%") 
            ->get();
      
        return response()->json($beers);
    }
}