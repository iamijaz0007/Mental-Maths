<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    public function index()
    {
        $data['title'] ='SchoolList';
        $schools = School::paginate(5);
        $data['schools'] = $schools;
        return view('school.list', $data);
    }

    public function add(){
        $data['title'] ='School add';
        return view('school.add', $data);

    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|max:50',
            'status' =>'required|in:pending,active,blocked'
        ]);

        $school = new School;
        $school->name = $request->name;
        $school->address = $request->address;
        $school->status = $request->status;
        $school->save();

        return redirect()->route('school.list')->with('success', 'School added successfully.');
    }

    public function edit($id){
        $data['title'] ='School edit';
        $school = School::find($id);
        $data['school'] = $school;
        return view('school.edit', $data);
    }

    public function update(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    // Find the school by ID and update its details
    $school = School::findOrFail($id);

    // Ensure all necessary fields are updated
    $school->update([
        'name' => $request->name,
        'address' => $request->address,
    ]);

    // Redirect with a success message
    return redirect()->route('school.list')->with('success', 'School updated successfully.');
}


        public function delete($id)
    {
        $school = School::findOrFail($id);
        $school->delete();
        return redirect()->route('school.list')->with('success', 'School deleted successfully');
    }

        public function updateStatus(Request $request, $id)
    {
        $school = School::findOrFail($id);
        $school->status = $request->status;
        $school->save();

        return redirect()->route('school.list')->with('success', 'School status updated successfully.');
    }


}
