<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\Newssearch;
use App\Models\NewssearchDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewssearchController extends Controller
{
    public function index() 
    {
        $data = Newssearch::with(['site', 'keywordrelation'])->orderBy('created_at', 'DESC')->get();
       
        return view('newssearch.index', [
            'title' => 'News Search',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('newssearch.create', [
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
                'site_id' => 'required|integer|unique:newssearch',
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'link' => 'required|array', 
                'link.*' => 'string', 
                'snippet' => 'required|array', 
                'snippet.*' => 'string', 
                'date' => 'required|array', 
                'date.*' => 'date',
                'source' => 'required|array', 
                'source.*' => 'string', 
                'imageUrl' => 'required|array', 
                'imageUrl.*' => 'string',
                'position' => 'required|array', 
                'position.*' => 'numeric', 
            ],[
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
            ]);

            $site_id = $request->input('site_id');
            $keyword_id = $request->input('keyword_id');
            $title = $request->input('title');
            $link = $request->input('link');
            $snippet = $request->input('snippet');
            $date = $request->input('date');
            $source = $request->input('source');
            $imageUrl = $request->input('imageUrl');
            $position = $request->input('position');

            $createNewssearch = Newssearch::create([
                'site_id' => $site_id,
            ]);

            if ($createNewssearch) {
                foreach ($keyword_id as $ki) {
                    RelationKeyword::create([
                        'related_id' => $createNewssearch->id,
                        'keyword_id' => $ki,
                        'jenis' => 3
                    ]);
                }

                foreach ($title as $index => $value) {
                    NewssearchDetail::create([
                        "newssearch_id" => $createNewssearch->id,
                        "title" => $value,
                        "link" => $link[$index],
                        "snippet" => $snippet[$index],
                        "date" => $date[$index],
                        "source" => $source[$index],
                        "imageUrl" => $imageUrl[$index],
                        "position" => $position[$index]  
                    ]);
                }
                
                DB::commit();
                return redirect('/newssearch')->with('success', 'Newssearch has been created successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to store the newssearch: ' . $e->getMessage())->withInput();
        }
    }




    public function edit($id)
    {
        $site = Site::all();
        $keyword = Keyword::all();
        $data = Newssearch::where('id', $id)->first();
        $dataKeywordSelected = RelationKeyword::where('related_id', $id)->where('jenis', 3)->pluck('keyword_id')->toArray();
        $dataImageDetail = NewssearchDetail::where('newssearch_id', $data->id)->get();
        
        return view('newssearch.edit', [
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
                'site_id' => 'required|integer|unique:newssearch,id,' . $id,
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'link' => 'required|array', 
                'link.*' => 'string', 
                'snippet' => 'required|array', 
                'snippet.*' => 'string', 
                'date' => 'required|array', 
                'date.*' => 'date',
                'source' => 'required|array', 
                'source.*' => 'string', 
                'imageUrl' => 'required|array', 
                'imageUrl.*' => 'string',
                'position' => 'required|array', 
                'position.*' => 'numeric', 
            ],[
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
            ]);

            $site_id = $request->input('site_id');
            $keyword_id = $request->input('keyword_id');
            $title = $request->input('title');
            $link = $request->input('link');
            $snippet = $request->input('snippet');
            $date = $request->input('date');
            $source = $request->input('source');
            $imageUrl = $request->input('imageUrl');
            $position = $request->input('position');

            $newssearch = Newssearch::findOrFail($id); 
            $newssearch->update([
                'site_id' => $site_id
            ]);

            RelationKeyword::where('related_id', $id)->where('jenis', 3)->delete();
            foreach ($keyword_id as $kid) {
                RelationKeyword::create([
                    'related_id' => $id,
                    'keyword_id' => $kid,
                    'jenis' => 3
                ]);
            }

            NewssearchDetail::where('newssearch_id', $id)->delete();
            foreach ($title as $index => $value) {
                NewssearchDetail::create([
                    "newssearch_id" => $newssearch->id,  
                    "title" => $value,
                    "link" => $link[$index],
                    "snippet" => $snippet[$index],
                    "date" => $date[$index],
                    "source" => $source[$index],
                    "imageUrl" => $imageUrl[$index],
                    "position" => $position[$index]
                ]);
            }

            DB::commit();
            return redirect('/newssearch')->with('success', 'Newssearch has been updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to update the newssearch: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {   
        DB::beginTransaction();
        try {
            RelationKeyword::where('related_id', $id)->where('jenis', 3)->delete();

            $newssearch = Newssearch::where('id', $id)->first();
            if ($newssearch) {
                NewssearchDetail::where('newssearch_id', $newssearch->id)->delete();
                $newssearch->delete();
            }

            DB::commit();
            return redirect('/newssearch')->with('success', 'Newssearch has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the newssearch: ' . $e->getMessage());
        }
    }
}
