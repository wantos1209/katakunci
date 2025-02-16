<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Exception;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index() 
    {
        $data = Keyword::orderBy('created_at', 'DESC')->get();
        return view('keyword.index', [
            'title' => 'Keyword',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('keyword.create', [
            'title' => 'Keyword'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'key' => 'required|string|unique:keywords|max:255',
            ]);

            Keyword::create($request->all());

            return redirect('/keyword')->with('success', 'Keyword has been created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to store the keyword: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $data = Keyword::where('id', $id)->first();
        return view('keyword.edit', [
            'title' => 'Keyword',
            'data' => $data,
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'key' => 'required|string|unique:keywords,key,' . $id . '|max:255', 
            ]);

            $keyword = Keyword::findOrFail($id);
            $keyword->update([
                'key' => $request->key,
            ]);

            return redirect('/keyword')->with('success', 'Keyword has been updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to update the keyword: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $keyword = Keyword::findOrFail($id);
            $keyword->delete();

            return redirect('/keyword')->with('success', 'Keyword has been deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while trying to update the keyword: ' . $e->getMessage());
        }
    }


}
