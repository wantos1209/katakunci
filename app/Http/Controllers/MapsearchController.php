<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\Mapsearch;
use App\Models\MapsearchDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapsearchController extends Controller
{
    public function index() 
    {
        $data = Mapsearch::with(['site', 'keywordrelation'])->orderBy('created_at', 'DESC')->get();
       
        return view('mapsearch.index', [
            'title' => 'News Search',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('mapsearch.create', [
            'title' => 'News Search',
            'title2' => 'News Search Detail',
            'dataSite' => $site,
            'dataKeyword' => $keyword,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi Input
            $request->validate([
                'site_id' => 'required|integer|unique:mapsearch',
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'position' => 'required|array', 
                'position.*' => 'numeric', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'address' => 'required|array', 
                'address.*' => 'string', 
                'latitude' => 'required|array', 
                'latitude.*' => 'string', 
                'longitude' => 'required|array', 
                'longitude.*' => 'string',
                'rating' => 'required|array', 
                'rating.*' => 'numeric',
                'ratingCount' => 'required|array', 
                'ratingCount.*' => 'numeric',
                'phoneNumber' => 'required|array', 
                'phoneNumber.*' => 'string',
                'category' => 'required|array', 
                'category.*' => 'string', 
                'website' => 'required|array', 
                'website.*' => 'string', 
            ],[
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
            ]);

            $site_id = $request->input('site_id');
            $keyword_id = $request->input('keyword_id');
            $position = $request->input('position');
            $title = $request->input('title');
            $address = $request->input('address');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $rating = $request->input('rating');
            $ratingCount = $request->input('ratingCount');
            $phoneNumber = $request->input('phoneNumber');
            $category = $request->input('category');
            $website = $request->input('website');

            $createMapsearch = Mapsearch::create([
                'site_id' => $site_id,
            ]);

            if ($createMapsearch) {
                foreach ($keyword_id as $ki) {
                    RelationKeyword::create([
                        'related_id' => $createMapsearch->id,
                        'keyword_id' => $ki,
                        'jenis' => 5
                    ]);
                }

                foreach ($title as $index => $value) {
                    MapsearchDetail::create([
                        "mapsearch_id" => $createMapsearch->id,
                        "position" => $position[$index],
                        "title" => $value,
                        "address" => $address[$index],
                        "latitude" => $latitude[$index],
                        "longitude" => $longitude[$index],
                        "rating" => $rating[$index],
                        "ratingCount" => $ratingCount[$index],
                        "phoneNumber" => $phoneNumber[$index],
                        "category" => $category[$index],
                        "website" => $website[$index],
                    ]);
                }
                
                DB::commit();
                return redirect('/mapsearch')->with('success', 'Mapsearch has been created successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to store the mapsearch: ' . $e->getMessage())->withInput();
        }
    }




    public function edit($id)
    {
        $site = Site::all();
        $keyword = Keyword::all();
        $data = Mapsearch::where('id', $id)->first();
        $dataKeywordSelected = RelationKeyword::where('related_id', $id)->where('jenis', 5)->pluck('keyword_id')->toArray();
        $dataImageDetail = MapsearchDetail::where('mapsearch_id', $data->id)->get();
        
        return view('mapsearch.edit', [
            'title' => 'News Search',
            'title2' => 'News Search Detail',
            'data' => $data,
            'id' => $id,
            'dataSite' => $site,
            'dataKeyword' => $keyword,
            'dataKeywordSelected' => $dataKeywordSelected,
            'dataImageDetail' => $dataImageDetail
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'site_id' => 'required|integer|unique:mapsearch,id,' . $id,
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'position' => 'required|array', 
                'position.*' => 'numeric', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'address' => 'required|array', 
                'address.*' => 'string', 
                'latitude' => 'required|array', 
                'latitude.*' => 'string', 
                'longitude' => 'required|array', 
                'longitude.*' => 'string',
                'rating' => 'required|array', 
                'rating.*' => 'numeric',
                'ratingCount' => 'required|array', 
                'ratingCount.*' => 'numeric',
                'phoneNumber' => 'required|array', 
                'phoneNumber.*' => 'string',
                'category' => 'required|array', 
                'category.*' => 'string', 
                'website' => 'required|array', 
                'website.*' => 'string', 
            ],[
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
            ]);

            $site_id = $request->input('site_id');
            $keyword_id = $request->input('keyword_id');
            $position = $request->input('position');
            $title = $request->input('title');
            $address = $request->input('address');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $rating = $request->input('rating');
            $ratingCount = $request->input('ratingCount');
            $phoneNumber = $request->input('phoneNumber');
            $category = $request->input('category');
            $website = $request->input('website');
            $mapsearch = Mapsearch::findOrFail($id); 
            $mapsearch->update([
                'site_id' => $site_id
            ]);

            RelationKeyword::where('related_id', $id)->where('jenis', 5)->delete();
            foreach ($keyword_id as $kid) {
                RelationKeyword::create([
                    'related_id' => $id,
                    'keyword_id' => $kid,
                    'jenis' => 5
                ]);
            }

            MapsearchDetail::where('mapsearch_id', $id)->delete();
            foreach ($title as $index => $value) {
                MapsearchDetail::create([
                    "mapsearch_id" => $mapsearch->id,  
                    "position" => $position[$index],
                    "title" => $value,
                    "address" => $address[$index],
                    "latitude" => $latitude[$index],
                    "longitude" => $longitude[$index],
                    "rating" => $rating[$index],
                    "ratingCount" => $ratingCount[$index],
                    "phoneNumber" => $phoneNumber[$index],
                    "category" => $category[$index],
                    "website" => $website[$index],
                ]);
            }

            DB::commit();
            return redirect('/mapsearch')->with('success', 'Mapsearch has been updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to update the mapsearch: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {   
        DB::beginTransaction();
        try {
            RelationKeyword::where('related_id', $id)->where('jenis', 5)->delete();

            $mapsearch = Mapsearch::where('id', $id)->first();
            if ($mapsearch) {
                MapsearchDetail::where('mapsearch_id', $mapsearch->id)->delete();
                $mapsearch->delete();
            }

            DB::commit();
            return redirect('/mapsearch')->with('success', 'Mapsearch has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the mapsearch: ' . $e->getMessage());
        }
    }
}
