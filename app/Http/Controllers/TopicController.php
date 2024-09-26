<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TopicController extends Controller
{

    // public function getAllTopics()
    // {
    //     $topics = Topic::all();
    //     return $topics;
    // }
    public function index()
    {
       
        return view('Dashboard.topics.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.topics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:topics,name',
            ]);

            Topic::create([
                'name' => $request['name'],
            ]);

            Alert::success('Success!', 'Added successfully');
        } catch (\Exception $e) {
            Alert::error('Error!', 'Failed to add this topic');

        }
        return redirect()->route('topics.index');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        // Implement this if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return view('Dashboard.topics.update', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:topics,name',
            ]);

            $topic->update(['name' => $request['name']]);
            Alert::success('Success!', 'Updated successfully');
        } catch (\Exception $e) {
            Alert::error('Error!', 'Failed to update');
        }

        return redirect()->route('topics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        
        try {
            $topic->delete();
            Alert::success('Success!', 'Deleted successfully');
        } catch (\Exception $e) {
            Alert::error('Error!', 'Failed to delete this topic');
           
        }

        return redirect()->route('topics.index');
    }
}
