<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Exception;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index() 
    {
        $data = Site::orderBy('created_at', 'DESC')->get();
        return view('site.index', [
            'title' => 'Site',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('site.create', [
            'title' => 'Site'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:site|max:255',
                'jenis' => 'required|integer',
            ]);

            Site::create($request->all());

            return redirect('/site')->with('success', 'Site has been created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to store the site: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $data = Site::where('id', $id)->first();
        return view('site.edit', [
            'title' => 'Site',
            'data' => $data,
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:site,name,' . $id . '|max:255', 
                'jenis' => 'required|integer',
            ]);

            $site = Site::findOrFail($id);
            $site->update([
                'name' => $request->name,
                'jenis' => $request->jenis,
            ]);

            return redirect('/site')->with('success', 'Site has been updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to update the site: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $site = Site::findOrFail($id);
            $site->delete();

            return redirect('/site')->with('success', 'Site has been deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to update the site: ' . $e->getMessage());
        }
    }


}
