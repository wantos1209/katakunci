<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Knowledgegraph;
use App\Models\Organic;
use App\Models\Preview;
use App\Models\RelatedSearch;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\Websearch;
use Exception;
use Illuminate\Http\Request;

class WebsearchController extends Controller
{
    public function index() 
    {
        $data = Websearch::with(['site', 'keywordrelation', 'knowledgegraph.shortcut.shortcutdetail', 'organic.organicdetail', 'preview', 'relatedsearch.keyword'])->orderBy('created_at', 'DESC')->get();
       
        return view('websearch.index', [
            'title' => 'Websearch',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('websearch.create', [
            'title' => 'Websearch',
            'dataSite' => $site,
            'dataKeyword' => $keyword
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'site_id' => 'required|integer|unique:websearch',
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
            ]);

            $createWebsearch = Websearch::create([
                'site_id' => $request->site_id,
            ]);

            if($createWebsearch) {
                foreach ($request->keyword_id as $keyword_id) {
                    RelationKeyword::create([
                        'related_id' => $createWebsearch->id,
                        'keyword_id' => $keyword_id,
                        'jenis' => 1
                    ]);

                    RelatedSearch::create([
                        'websearch_id' => $createWebsearch->id,
                        'keyword_id' => $keyword_id
                    ]);
                }
            }

            Knowledgegraph::create([
                'websearch_id' => $createWebsearch->id
            ]);

            Organic::create([
                'websearch_id' => $createWebsearch->id
            ]);
            
            Preview::create([
                'websearch_id' => $createWebsearch->id
            ]);
            
            return redirect('/websearch')->with('success', 'Websearch has been created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to store the websearch: ' . $e->getMessage())->withInput();
        }
    }



    public function edit($id)
    {
        $site = Site::all();
        $keyword = Keyword::all();
        $data = Websearch::where('id', $id)->first();
        $dataKeywordSelected = RelationKeyword::where('related_id', $id)->where('jenis', 1)->pluck('keyword_id')->toArray();
        
        return view('websearch.edit', [
            'title' => 'Websearch',
            'data' => $data,
            'id' => $id,
            'dataSite' => $site,
            'dataKeyword' => $keyword,
            'dataKeywordSelected' => $dataKeywordSelected
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'site_id' => 'required|integer|unique:websearch,site_id,' . $id,  // Perbaikan pada validasi unique
                'keyword_id' => 'required|array', 
                'keyword_id.*' => 'integer', 
            ]);

            $websearch = Websearch::findOrFail($id);
            $websearch->update([
                'site_id' => $request->site_id
            ]);

            if($websearch) {
                RelationKeyword::where('related_id', $id)->where('jenis', 1)
                  ->delete(); 

                foreach ($request->keyword_id as $keyword_id) {
                    RelationKeyword::create([
                        'related_id' => $id,
                        'keyword_id' => $keyword_id,
                        'jenis' => 1
                    ]);
                }
            }

            return redirect('/websearch')->with('success', 'Websearch has been updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to update the websearch: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $relationKeyword = RelationKeyword::where('related_id', $id);
            
            if ($relationKeyword->exists()) {
                $relationKeyword->delete();
            }

            $websearch = Websearch::findOrFail($id);
            $websearch->delete();

            return redirect('/websearch')->with('success', 'Websearch has been deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to delete the websearch: ' . $e->getMessage());
        }
    }

    public function editKnowledgeGraph($id)
    {
        $data = Knowledgegraph::where('websearch_id', $id)->first();
        return view('websearch.knowledgeGraph', [
            'title' => 'Knowledge Graph',
            'data' => $data,
            'id' => $id
        ]);
    }

}
