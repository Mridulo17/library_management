<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\IssueBook;
use Auth;
use DataTables;
use Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $members = Member::with('createdBy')->latest()->get();
            return Datatables::of($members)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('createdBy', function (Member $member) {
                        return $member->createdBy->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->product_id)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:members',
            ],
            [
                'email.unique' => 'This email is already taken!'
            ]);
        }
        else
        {
            // return true;
            // return 'shovon';
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:members,email,'.$request->product_id.',id',
                
            ],
            [
                'email.unique' => 'This email is already taken!'
            ]); 
        }
        
     
        if ($validator->passes()) {
            
            Member::updateOrCreate(
                ['id' => $request->product_id],
                ['name' => $request->name,
                 'phone' => $request->phone,
                 'email' => $request->email,
                 'created_by' => Auth::user()->id]);        

                return response()->json(['success'=>'Mamber saved successfully.']);
        }
        else
        {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        



        
   
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        
        $member = Member::find($id)->delete();
        //dd($member);
        if($member){
            IssueBook::where('member_id',$id)->delete();
        }
     
        return response()->json(['success'=>'Member deleted successfully.']);
    }
}
