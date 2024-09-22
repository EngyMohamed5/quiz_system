<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Traits\Uploadimage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    use Uploadimage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Dashboard.create_admin');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'role' => 'required',

            ]);
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->uploadImage($request, 'image', 'admins_images');
            }
            // dd($request);

            // Create a new admin
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $imageName,
                'role' => $request->role,
            ]);
            alert()->success('Success!', 'Admin added successfully');
        } catch (\Exception $e) {

            alert()->error('Error!', 'Failed to add admin');
            return redirect()->back()->withInput();
        }
        return redirect()->route('allusers.showall');
    }
    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        //

    }
    public function alladmins()
    {
        $title = 'Admins';
        $admins =   User::where('role', 'admin')->latest()->get();
        return view('Dashboard.admins', compact('admins', 'title'));
    }

    public function getusers()
    {
        $title = 'Users';
        $admins =   User::where('role', 'user')->latest()->get();
        return view('Dashboard.admins', compact('admins', 'title'));
    }

    public function allusers()
    {
        $title = 'All Users';
        $admins =   User::latest()->get();
        return view('Dashboard.admins', compact('admins', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        //
        return view('Dashboard.update_admin', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($admin->id),
                ],
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                //        'password' => 'nullable|string|min:8',  // Make password nullable
                'role' => 'required',
            ]);


            // Handle image upload if provided
            $imageName = $admin->image;
            if ($request->hasFile('image')) {
                $path = public_path('upload_images/' . $admin->image);
                if (file_exists($path)) {
                    try {
                        unlink($path);
                    } catch (\Exception $e) {

                        report($e);
                    }
                }
                $imageName = $this->uploadImage($request, 'image', 'admins_images');
            }
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $imageName,
                //    'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // dd($request);
            // $admin->update([$request->all()]);
            alert()->success('Success!', 'Admin updated successfully');
        } catch (\Exception $e) {
            alert()->error('Error!', 'Failed to add admin');
            return redirect()->back();
        }
        return redirect()->route('allusers.showall');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        try {
            if ($admin->image) {
                $path = public_path('upload_images/' . $admin->image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $admin->delete();
            alert()->success('Success!', 'Deleted successfully');
        } catch (\Exception $e) {
            alert()->error('Error!', 'Failed to delete');
        }
        return redirect()->back();
    }

    public function SearchForUser(Request $request)
    {
        try {
            if ($request->searchterm) {
                $title = 'Search';
                $admins = User::where('name', 'like', '%' . $request->searchterm . '%')
                    ->orWhere('email', 'like', '%' . $request->searchterm . '%')
                    ->latest()
                    ->get();
                return view('Dashboard.admins', compact('admins', 'title'));
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
