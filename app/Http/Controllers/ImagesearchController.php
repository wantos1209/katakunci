<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\Imagesearch;
use App\Models\ImagesearchDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImagesearchController extends Controller
{
    public function index() 
    {
        $data = Imagesearch::with(['site', 'keywordrelation'])->orderBy('created_at', 'DESC')->get();
       
        return view('imagesearch.index', [
            'title' => 'Image Search',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('imagesearch.create', [
            'title' => 'Image Search',
            'title2' => 'Image Search Detail',
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
            'site_id' => 'required|integer|unique:imagesearch',
            'keyword_id' => 'required|array', 
            'keyword_id.*' => 'integer', 
            'title' => 'required|array', 
            'title.*' => 'string',  
            'imageUrl' => 'required|array', 
            'imageUrl.*' => 'string', 
            'imageWidth' => 'required|array', 
            'imageWidth.*' => 'numeric', 
            'imageHeight' => 'required|array', 
            'imageHeight.*' => 'numeric',
            'thumbnailUrl' => 'required|array', 
            'thumbnailUrl.*' => 'string', 
            'thumbnailWidth' => 'required|array', 
            'thumbnailWidth.*' => 'numeric',
            'thumbnailHeight' => 'required|array', 
            'thumbnailHeight.*' => 'numeric',
            'source' => 'required|array', 
            'source.*' => 'string',  
            'domain' => 'required|array', 
            'domain.*' => 'string',  
            'link' => 'required|array', 
            'link.*' => 'string',  
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
        $imageUrl = $request->input('imageUrl');
        $imageWidth = $request->input('imageWidth');
        $imageHeight = $request->input('imageHeight');
        $thumbnailUrl = $request->input('thumbnailUrl');
        $thumbnailWidth = $request->input('thumbnailWidth');
        $thumbnailHeight = $request->input('thumbnailHeight');
        $source = $request->input('source');
        $domain = $request->input('domain');
        $link = $request->input('link');
        $position = $request->input('position');

        $createImagesearch = Imagesearch::create([
            'site_id' => $site_id,
        ]);

        if ($createImagesearch) {
            foreach ($keyword_id as $ki) {
                RelationKeyword::create([
                    'related_id' => $createImagesearch->id,
                    'keyword_id' => $ki,
                    'jenis' => 2
                ]);
            }

            foreach ($title as $index => $value) {
                ImagesearchDetail::create([
                    "imagesearch_id" => $createImagesearch->id,
                    "title" => $value,
                    "imageUrl" => $imageUrl[$index],
                    "imageWidth" => $imageWidth[$index],
                    "imageHeight" => $imageHeight[$index],
                    "thumbnailUrl" => $thumbnailUrl[$index],
                    "thumbnailWidth" => $thumbnailWidth[$index],
                    "thumbnailHeight" => $thumbnailHeight[$index],
                    "source" => $source[$index],
                    "domain" => $domain[$index],
                    "link" => $link[$index],
                    "position" => $position[$index]  
                ]);
            }
            
            DB::commit();
            return redirect('/imagesearch')->with('success', 'Imagesearch has been created successfully!');
        }
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'An error occurred while trying to store the imagesearch: ' . $e->getMessage())->withInput();
    }
}




    public function edit($id)
    {
        $site = Site::all();
        $keyword = Keyword::all();
        $data = Imagesearch::where('id', $id)->first();
        $dataKeywordSelected = RelationKeyword::where('related_id', $id)->where('jenis', 2)->pluck('keyword_id')->toArray();
        $dataImageDetail = ImagesearchDetail::where('imagesearch_id', $data->id)->get();
        
        return view('imagesearch.edit', [
            'title' => 'Image Search',
            'title2' => 'Image Search Detail',
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
                'site_id' => 'required|integer|unique:imagesearch,id,' . $id,
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
                'title' => 'required|array', 
                'title.*' => 'string',  
                'imageUrl' => 'required|array', 
                'imageUrl.*' => 'string', 
                'imageWidth' => 'required|array', 
                'imageWidth.*' => 'numeric', 
                'imageHeight' => 'required|array', 
                'imageHeight.*' => 'numeric',
                'thumbnailUrl' => 'required|array', 
                'thumbnailUrl.*' => 'string', 
                'thumbnailWidth' => 'required|array', 
                'thumbnailWidth.*' => 'numeric',
                'thumbnailHeight' => 'required|array', 
                'thumbnailHeight.*' => 'numeric',
                'source' => 'required|array', 
                'source.*' => 'string',  
                'domain' => 'required|array', 
                'domain.*' => 'string',  
                'link' => 'required|array', 
                'link.*' => 'string',  
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
            $imageUrl = $request->input('imageUrl');
            $imageWidth = $request->input('imageWidth');
            $imageHeight = $request->input('imageHeight');
            $thumbnailUrl = $request->input('thumbnailUrl');
            $thumbnailWidth = $request->input('thumbnailWidth');
            $thumbnailHeight = $request->input('thumbnailHeight');
            $source = $request->input('source');
            $domain = $request->input('domain');
            $link = $request->input('link');
            $position = $request->input('position');

            $imagesearch = Imagesearch::findOrFail($id); 
            $imagesearch->update([
                'site_id' => $site_id
            ]);

            RelationKeyword::where('related_id', $id)->where('jenis', 2)->delete();
            foreach ($keyword_id as $kid) {
                RelationKeyword::create([
                    'related_id' => $id,
                    'keyword_id' => $kid,
                    'jenis' => 2
                ]);
            }

            ImagesearchDetail::where('imagesearch_id', $id)->delete();
            foreach ($title as $index => $value) {
                ImagesearchDetail::create([
                    "imagesearch_id" => $imagesearch->id,  
                    "title" => $value,
                    "imageUrl" => $imageUrl[$index],
                    "imageWidth" => $imageWidth[$index],
                    "imageHeight" => $imageHeight[$index],
                    "thumbnailUrl" => $thumbnailUrl[$index],
                    "thumbnailWidth" => $thumbnailWidth[$index],
                    "thumbnailHeight" => $thumbnailHeight[$index],
                    "source" => $source[$index],
                    "domain" => $domain[$index],
                    "link" => $link[$index],
                    "position" => $position[$index]
                ]);
            }

            DB::commit();
            return redirect('/imagesearch')->with('success', 'Imagesearch has been updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to update the imagesearch: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {   
        DB::beginTransaction();
        try {
            RelationKeyword::where('related_id', $id)->where('jenis', 2)->delete();

            $imagesearch = Imagesearch::where('id', $id)->first();
            if ($imagesearch) {
                ImagesearchDetail::where('imagesearch_id', $imagesearch->id)->delete();
                $imagesearch->delete();
            }

            DB::commit();
            return redirect('/imagesearch')->with('success', 'Imagesearch has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the imagesearch: ' . $e->getMessage());
        }
    }
}
