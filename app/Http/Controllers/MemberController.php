<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\AccuraMember;
use App\Models\Division;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    public function index(Request $request)
    {
        // Retrieve filter values from the request
        $searchTerm = $request->input('search');

        // Start building the query
        $members = AccuraMember::query() ?? [];

        // Apply search by member last name
        if ($searchTerm) {
            $members->where('last_name', 'like', '%' . $searchTerm . '%');
        }

        // Get the filtered members with pagination
        $members = $members->paginate(10);
 
        return view('accura.member_list', compact('members', 'searchTerm'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // This method will show create member page
    public function create() {
        $division = Division::orderBy('name','ASC')->get();
        $division = !empty($division) ? $division : [];
        return view('accura.member_create', compact('division'));
    }

    // This method will store a member in db
    public function store(Request $request) {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date|before:today', // Validate that the date is in the past
            'summary' => 'nullable|string',
            'division_id' => 'required|exists:division,id',        
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return redirect()->route('member.create')->withInput()->withErrors($validator);
        }

        // here we insert member in db
        $member = new AccuraMember();
        $member->division_id = $request->division_id;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->summary = $request->summary;
        $member->dob = $request->dob;

        $member->save();

        return redirect()->route('member.list')->with('success','Member added successfully.');
    }

    // This method will show edit member page
    public function edit($id) {
        $member = AccuraMember::findOrFail($id);
        $division = Division::orderBy('name','ASC')->get();
        return view('accura.member_edit', compact('member','division'));
    }

    // This method will update a member
    public function update($id, Request $request) {

        $member = AccuraMember::findOrFail($id);
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date|before:today', // Validate that the date is in the past
            'summary' => 'nullable|string',
            'division_id' => 'required|exists:division,id',            
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return redirect()->route('member.edit',$member->id)->withInput()->withErrors($validator);
        }

        // here we will update member

        $member->division_id = $request->division_id;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->summary = $request->summary;
        $member->dob = $request->dob;
        $member->save();

        return redirect()->route('member.list')->with('success','Member updated successfully.');
    }

    // This method will delete a member
    public function destroy(Request $request) {
        $id = !empty($request) ? $request->id :'';
        $member = AccuraMember::findOrFail($id);
        $response = [];
       // delete member from database
       $member_delete = $member->delete();
        if($member_delete){
            $response['success'] = 1;
        }else{
            $response['success'] = 0;
        }

        return $response;
    }
}