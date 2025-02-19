<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\RelationKeyword;
use App\Models\Site;
use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
                'divisi' => 'required',           
                'username' => 'required|string|max:255|unique:users,username', 
                'password' => 'required|string|confirmed', 
                'pathImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $pathImage = null;
            if ($request->hasFile('pathImage')) {
                $imageName = time() . '.' . $request->pathImage->extension();
                // Store image in 'images' folder within the public disk (symlink to storage)
                $pathImage = $request->file('pathImage')->storeAs('images', $imageName, 'public');
            }

            $user = new User();
            $user->name = $request->name;
            $user->site_id = $request->site_id;
            $user->divisi = $request->divisi;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->pathImage = $pathImage; 

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
                'site_id' => 'required|exists:site,id',  
                'divisi' => 'required',           
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'password' => 'nullable|string|confirmed',
                'pathImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->site_id = $request->site_id;
            $user->divisi = $request->divisi;
            $user->username = $request->username;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('pathImage')) {
                $file = $request->file('pathImage');
                // Delete old image if exists
                if ($user->pathImage) { 
                    Storage::disk('public')->delete($user->pathImage);
                }

                $imageName = time() . '.' . $request->pathImage->extension();
                // Store new image in 'images' folder
                $path = $request->file('pathImage')->storeAs('images', $imageName, 'public');

                $user->pathImage = $path;
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
            $user = User::findOrFail($id);

            if ($user->pathImage && Storage::exists($user->pathImage)) {
                Storage::delete($user->pathImage);
            }
            $user->delete();

            DB::commit();
            return redirect('/user')->with('success', 'User has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while trying to delete the user: ' . $e->getMessage());
        }
    }

    public function profile()
    {
        $dataUser = Auth::user();
        return view('user.profile', [
            'title' => 'User Management',
            'user' => $dataUser,
        ]);
    }

    public function updateProfile(Request $request)
{
    try {
        $dataUser = Auth::user();
        $user = User::findOrFail($dataUser->id);
        
        $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
            'pathImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('pathImage')) {
            // Delete old image if exists
            if ($user->pathImage && Storage::exists($user->pathImage)) {
                Storage::delete($user->pathImage);
            }

            $imageName = time() . '.' . $request->pathImage->extension();
            // Store the new image in the 'imagesProfile' folder within the public disk
            $pathImage = $request->file('pathImage')->storeAs('imagesProfile', $imageName, 'public');
            $user->pathImage = $pathImage;
        }

        $user->save();

        return redirect('/websearch')->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while trying to update the profile: ' . $e->getMessage());
    }
}

}
