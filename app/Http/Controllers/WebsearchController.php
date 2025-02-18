<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Knowledgegraph;
use App\Models\Organic;
use App\Models\OrganicDetail;
use App\Models\Preview;
use App\Models\RelatedSearch;
use App\Models\RelationKeyword;
use App\Models\Shortcut;
use App\Models\ShortcutDetail;
use App\Models\Site;
use App\Models\Websearch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsearchController extends Controller
{
    public function index() 
    {
        $data = Websearch::with(['site', 'keywordrelation', 'knowledgegraph.shortcut.shortcutdetail', 'organic.organicdetail', 'preview', 'relatedsearch.keyword'])->orderBy('created_at', 'DESC')->get();
       
        return view('websearch.index', [
            'title' => 'Web Search',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('websearch.create', [
            'title' => 'Web Search',
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
            ], [
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
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
            'title' => 'Web Search',
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
            ], [
                'site_id.required' => 'The Site field is required.',
                'site_id.integer' => 'The Site must be a valid number.',
                'site_id.unique' => 'The Site you entered is already taken. Please use a different one.',
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
        DB::beginTransaction();
        try {
            RelationKeyword::where('related_id', $id)->where('jenis', 1)->delete();

            $knowledgeGraph = Knowledgegraph::where('websearch_id', $id)->first();
            if ($knowledgeGraph) {
                $shortCut = Shortcut::where('knowledgegraph_id', $knowledgeGraph->id)->get();
                $shortCutId = $shortCut->pluck('id');
                
                ShortcutDetail::whereIn('shortcut_id', $shortCutId)->delete();
                
                $shortCut->each->delete();
                $knowledgeGraph->delete();
            }

            $organic = Organic::where('websearch_id', $id)->first();
            if ($organic) {
                OrganicDetail::where('organic_id', $organic->id)->delete();
                $organic->delete();
            }

            Preview::where('websearch_id', $id)->delete();

            RelatedSearch::where('websearch_id', $id)->delete();

            $websearch = Websearch::findOrFail($id);
            $websearch->delete();

            DB::commit();
            return redirect('/websearch')->with('success', 'Websearch has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the websearch: ' . $e->getMessage());
        }
    }

    public function editKnowledgeGraph($id)
    {
        $data = Knowledgegraph::where('websearch_id', $id)->first();
        $dataShortcut = Shortcut::where('knowledgegraph_id', $data->id)->get();
        
        $dataShortcutDetails = [];
        foreach ($dataShortcut as $shortcut) {
            $dataShortcutDetails[$shortcut->id] = ShortcutDetail::where('shortcut_id', $shortcut->id)->get();
        }

        return view('websearch.knowledgegraph', [
            'title' => 'Knowledge Graph',
            'title2' => 'Shortcut',
            'data' => $data,
            'dataShortcut' => $dataShortcut,
            'dataShortcutDetails' => $dataShortcutDetails, 
            'id' => $data->id
        ]);
    }

    public function updateKnowledgeGraph(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'website' => 'nullable|string',
                'iconUrl' => 'nullable|string',
                'logoUrl' => 'nullable|string',
                'desktopImageUrl' => 'nullable|string',
                'mobileImageUrl' => 'nullable|string',
                'livechat' => 'nullable|string',
                'whatsapp' => 'nullable|string',
                'telegram' => 'nullable|string',
                'line' => 'nullable|string',
                'facebook' => 'nullable|string',
                'instagram' => 'nullable|string',
                'twitter' => 'nullable|string',
                'youtube' => 'nullable|string',
                'aplikasiIos' => 'nullable|string',
                'aplikasiAndroid' => 'nullable|string',
                'name_shortcut' => 'nullable|array',
                'name_shortcut.*.*' => 'nullable|string',
                'name_shortcut_detail' => 'nullable|array',
                'name_shortcut_detail.*.*' => 'nullable|string',
                'url' => 'nullable|array',
                'url.*.*' => 'nullable|string',
            ]);

            $knowledgeGraph = KnowledgeGraph::findOrFail($id);
            $knowledgeGraph->title = $request->input('title');
            $knowledgeGraph->description = $request->input('description');
            $knowledgeGraph->website = $request->input('website');
            $knowledgeGraph->iconUrl = $request->input('iconUrl');
            $knowledgeGraph->logoUrl = $request->input('logoUrl');
            $knowledgeGraph->desktopImageUrl = $request->input('desktopImageUrl');
            $knowledgeGraph->mobileImageUrl = $request->input('mobileImageUrl');
            $knowledgeGraph->livechat = $request->input('livechat');
            $knowledgeGraph->whatsapp = $request->input('whatsapp');
            $knowledgeGraph->telegram = $request->input('telegram');
            $knowledgeGraph->line = $request->input('line');
            $knowledgeGraph->facebook = $request->input('facebook');
            $knowledgeGraph->instagram = $request->input('instagram');
            $knowledgeGraph->twitter = $request->input('twitter');
            $knowledgeGraph->youtube = $request->input('youtube');
            $knowledgeGraph->aplikasiIos = $request->input('aplikasiIos');
            $knowledgeGraph->aplikasiAndroid = $request->input('aplikasiAndroid');

            $knowledgeGraph->save();
           
            if ($knowledgeGraph) {
                $dataShortcut = Shortcut::where('knowledgegraph_id', $knowledgeGraph->id)->get();
                
                if ($dataShortcut) {
                    foreach ($dataShortcut as $data) {
                        ShortcutDetail::where('shortcut_id', $data->id)->delete();
                        $data->delete();
                    }
                }
            }
            
            
            if ($request->has('name_shortcut')) {
                $shortcuts = $request->input('name_shortcut');
                $details = $request->input('name_shortcut_detail') ?? null;
                $urls = $request->input('url') ?? null;
                
                foreach ($shortcuts as $index => $shortcutNames) {
                    foreach ($shortcutNames as $key => $shortcutName) {
                        $saveShortcut = Shortcut::create([
                            'knowledgegraph_id' => $id,
                            'name' => $shortcutName,
                        ]);
                        if($details) {
                            foreach ($details[$index] as $indexdetail => $detail) {
                                ShortcutDetail::create([
                                    'shortcut_id' => $saveShortcut->id, 
                                    'name' => isset($detail) ? $detail : null,
                                    'url' => isset($urls[$index][$indexdetail]) ? $urls[$index][$indexdetail] : null,
                                ]);
                            }   
                        }
                    }
                }
            }
            DB::commit();
            return redirect('/websearch')->with('success', 'Data updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'There was an issue updating the data. Error: ' . $e->getMessage());
        }
    
    }

    public function editOrganic($id)
    {
        $data = Organic::where('websearch_id', $id)->first();
        $dataOrganicDetail = OrganicDetail::where('organic_id', $data->id)->get();
        return view('websearch.organic', [
            'title' => 'Organic',
            'title2' => 'Site Links',
            'data' => $data,
            'dataOrganicDetail' => $dataOrganicDetail,
            'id' => $data->id
        ]);
    }

    public function updateOrganic(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'link' => 'nullable|string',
                'snippet' => 'nullable|string',
                'iconUrl' => 'nullable|string',
                'title_detail' => 'nullable|array',
                'title_detail.*' => 'nullable|string',
                'link_detail' => 'nullable|array',
                'link_detail.*' => 'nullable|string',
            ]);

            $Organic = Organic::findOrFail($id);
            $Organic->title = $request->input('title');
            $Organic->link = $request->input('link');
            $Organic->snippet = $request->input('snippet');
            $Organic->iconUrl = $request->input('iconUrl');
        
            $Organic->save();
           
            if ($Organic) {
                OrganicDetail::where('organic_id', $Organic->id)->delete();
            }
            if ($request->has('title_detail')) {
                $title_detail = $request->input('title_detail') ?? null;
                $link_detail = $request->input('link_detail') ?? null;

                if($title_detail) {
                    foreach($title_detail as $index => $title) {
                        OrganicDetail::create([
                            'organic_id' => $id,
                            'title' => $title,
                            'link' => $link_detail[$index]
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect('/websearch')->with('success', 'Data updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'There was an issue updating the data. Error: ' . $e->getMessage());
        }
    
    }

    public function editPreview($id)
    {
        $data = Preview::where('websearch_id', $id)->get();
        
        if($data->count() < 2) {
            Preview::create([
                'websearch_id' => $id
            ]);
        } 

        return view('websearch.preview', [
            'title' => 'Preview',
            'data' => $data,
            'id' => $id
        ]);
    }

    public function updatePreview(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'nullable|array',
                'id.*' => 'nullable|string',
                'title' => 'nullable|array',
                'title.*' => 'nullable|string',
                'link' => 'nullable|array',
                'link.*' => 'nullable|string',
            ]);
            
            if ($request->has('id')) {
                $ids = $request->input('id');
                $title = $request->input('title') ?? null;
                $link = $request->input('link') ?? null;

                if($id) {
                    foreach($ids as $index => $id) {
                        $dataPreview = Preview::where('id', $id)->first();
                        if($dataPreview) {
                            $dataPreview->update([
                                'title' => $title[$index],
                                'link' => $link[$index]
                            ]);
                        } else {
                            Preview::create([
                                'id' => $id,
                                'websearch_id'=> $id,
                                'title' => $title[$index],
                                'link' => $link[$index]
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            return redirect('/websearch')->with('success', 'Data updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'There was an issue updating the data. Error: ' . $e->getMessage());
        }
    
    }

    public function ediRelatedSearch($id)
    {
        $data = RelatedSearch::where('websearch_id', $id)->pluck('keyword_id')->toArray();
        $keyword = Keyword::all();
        return view('websearch.relatedsearch', [
            'title' => 'Related Search',
            'data' => $data,
            'id' => $id,
            'dataKeywordSelected' => $data,
            'dataKeyword' => $keyword
        ]);
    }


    public function updateRelatedSearch(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'keyword_id' => 'nullable|array',
                'keyword_id.*' => 'nullable|string',
            ]);

            if ($request->has('keyword_id') && !empty($request->input('keyword_id'))) {
                $keyword_id = $request->input('keyword_id');

                
                RelatedSearch::where('websearch_id', $id)->delete();

                foreach($keyword_id as $key) {
                    RelatedSearch::create([
                        'websearch_id' => $id,
                        'keyword_id' => $key,
                    ]);
                }
            }
            
            DB::commit();
            return redirect('/websearch')->with('success', 'Data updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There was an issue updating the data. Error: ' . $e->getMessage());
        }
    }
}
