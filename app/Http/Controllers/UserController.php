<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() 
    {
        $data = User::with('site')->orderBy('created_at', 'DESC')->get();
        return view('user.index', [
            'title' => 'User Management',
            'data' => $data
        ]);
    }

    public function create()
    {
        $site = Site::all();
        $keyword = Keyword::all();

        return view('user.create', [
            'title' => 'User Management',
            'dataSite' => $site,
            'dataKeyword' => $keyword,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'site_id' => 'required|exists:sites,id',  
                'divisi' => 'required|in:9,8,1',           
                'username' => 'required|string|max:255|unique:users,username', 
                'password' => 'required|string|min:8|confirmed', 
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->site_id = $request->site_id;
            $user->divisi = $request->divisi;
            $user->username = $request->username;
            $user->password = Hash::make($request->password); 
            $user->save();
            
            DB::commit();
            return redirect('/user')->with('success', 'User has been created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to store the user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $site = Site::all();
        $user = User::where('id', $id)->first();
        
        return view('user.edit', [
            'title' => 'User Management',
            'user' => $user,
            'dataSite' => $site,
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'site_id' => 'required|exists:sites,id',  
                'divisi' => 'required|in:9,8,1',           
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);
        
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->site_id = $request->site_id;
            $user->divisi = $request->divisi;
            $user->username = $request->username;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            
            DB::commit();
            return redirect('/user')->with('success', 'User has been updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to update the user: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {   
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->first();
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect('/user')->with('success', 'User has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the user: ' . $e->getMessage());
        }
    }
}
