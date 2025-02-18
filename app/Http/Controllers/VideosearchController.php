<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\Videosearch;
use App\Models\VideosearchDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideosearchController extends Controller
{
    public function index() 
    {
        $data = Videosearch::with(['site', 'keywordrelation'])->orderBy('created_at', 'DESC')->get();
       
        return view('videosearch.index', [
            'title' => 'Video Search',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('videosearch.create', [
            'title' => 'Video Search',
            'title2' => 'Video Search Detail',
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
                'site_id' => 'required|integer|unique:videosearch',
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'link' => 'required|array', 
                'link.*' => 'string', 
                'snippet' => 'required|array', 
                'snippet.*' => 'string', 
                'imageUrl' => 'required|array', 
                'imageUrl.*' => 'string',
                'duration' => 'required|array', 
                'duration.*' => 'string',
                'source' => 'required|array', 
                'source.*' => 'string',
                'channel' => 'required|array', 
                'channel.*' => 'string',
                'date' => 'required|array', 
                'date.*' => 'date',
                'position' => 'required|array', 
                'position.*' => 'numeric', 
            ], [
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
            ]);

            $site_id = $request->input('site_id');
            $keyword_id = $request->input('keyword_id');
            $title = $request->input('title');
            $link = $request->input('link');
            $snippet = $request->input('snippet');
            $imageUrl = $request->input('imageUrl');
            $duration = $request->input('duration');
            $source = $request->input('source');
            $channel = $request->input('channel');
            $date = $request->input('date');
            $position = $request->input('position');

            $createVideosearch = Videosearch::create([
                'site_id' => $site_id,
            ]);

            if ($createVideosearch) {
                foreach ($keyword_id as $ki) {
                    RelationKeyword::create([
                        'related_id' => $createVideosearch->id,
                        'keyword_id' => $ki,
                        'jenis' => 4
                    ]);
                }

                foreach ($title as $index => $value) {
                    VideosearchDetail::create([
                        "videosearch_id" => $createVideosearch->id,
                        "title" => $value,
                        "link" => $link[$index],
                        "snippet" => $snippet[$index],
                        "imageUrl" => $imageUrl[$index],
                        "duration" => $duration[$index],
                        "source" => $source[$index],
                        "channel" => $channel[$index],
                        "date" => $date[$index],
                        "position" => $position[$index]  
                    ]);
                }
                
                DB::commit();
                return redirect('/videosearch')->with('success', 'Videosearch has been created successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to store the videosearch: ' . $e->getMessage())->withInput();
        }
    }




    public function edit($id)
    {
        $site = Site::all();
        $keyword = Keyword::all();
        $data = Videosearch::where('id', $id)->first();
        $dataKeywordSelected = RelationKeyword::where('related_id', $id)->where('jenis', 4)->pluck('keyword_id')->toArray();
        $dataImageDetail = VideosearchDetail::where('videosearch_id', $data->id)->get();
        
        return view('videosearch.edit', [
            'title' => 'Video Search',
            'title2' => 'Video Search Detail',
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
                'site_id' => 'required|integer|unique:videosearch,id,' . $id,
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'link' => 'required|array', 
                'link.*' => 'string', 
                'snippet' => 'required|array', 
                'snippet.*' => 'string', 
                'imageUrl' => 'required|array', 
                'imageUrl.*' => 'string',
                'duration' => 'required|array', 
                'duration.*' => 'string',
                'source' => 'required|array', 
                'source.*' => 'string',
                'channel' => 'required|array', 
                'channel.*' => 'string',
                'date' => 'required|array', 
                'date.*' => 'date',
                'position' => 'required|array', 
                'position.*' => 'numeric', 
            ], [
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
            ]);

            $site_id = $request->input('site_id');
            $keyword_id = $request->input('keyword_id');
            $title = $request->input('title');
            $link = $request->input('link');
            $snippet = $request->input('snippet');
            $imageUrl = $request->input('imageUrl');
            $duration = $request->input('duration');
            $source = $request->input('source');
            $channel = $request->input('channel');
            $date = $request->input('date');
            $position = $request->input('position');

            $videosearch = Videosearch::findOrFail($id); 
            $videosearch->update([
                'site_id' => $site_id
            ]);

            RelationKeyword::where('related_id', $id)->where('jenis', 4)->delete();
            foreach ($keyword_id as $kid) {
                RelationKeyword::create([
                    'related_id' => $id,
                    'keyword_id' => $kid,
                    'jenis' => 4
                ]);
            }

            VideosearchDetail::where('videosearch_id', $id)->delete();
            foreach ($title as $index => $value) {
                VideosearchDetail::create([
                    "videosearch_id" => $videosearch->id,  
                    "title" => $value,
                    "link" => $link[$index],
                    "snippet" => $snippet[$index],
                    "imageUrl" => $imageUrl[$index],
                    "duration" => $duration[$index],
                    "source" => $source[$index],
                    "channel" => $channel[$index],
                    "date" => $date[$index],
                    "position" => $position[$index]
                ]);
            }

            DB::commit();
            return redirect('/videosearch')->with('success', 'Videosearch has been updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to update the videosearch: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {   
        DB::beginTransaction();
        try {
            RelationKeyword::where('related_id', $id)->where('jenis', 4)->delete();

            $videosearch = Videosearch::where('id', $id)->first();
            if ($videosearch) {
                VideosearchDetail::where('videosearch_id', $videosearch->id)->delete();
                $videosearch->delete();
            }

            DB::commit();
            return redirect('/videosearch')->with('success', 'Videosearch has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the videosearch: ' . $e->getMessage());
        }
    }
}
