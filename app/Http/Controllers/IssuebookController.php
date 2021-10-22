<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueBook;
use App\Models\Member;
use App\Models\Book;
use Auth;
use DataTables;
use Validator;

class IssuebookController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) { 
            $issuebooks = IssueBook::with(['member', 'book', 'createdBy'])->latest()->get();
            
            return Datatables::of($issuebooks)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('member', function (IssueBook $issueBook) {
                        return $issueBook->member->name;
                    })
                    ->addColumn('book', function (IssueBook $issueBook) {
                        return $issueBook->book->book_name;
                    })
                    ->addColumn('createdBy', function (IssueBook $issueBook) {
                        return $issueBook->createdBy->name;
                    })
                    ->addColumn('isReturn', function (IssueBook $issueBook) {
                        if($issueBook->is_return == 1)
                        {
                            return $issueData = "Returned";
                        }
                        else{
                            return $issueData = "Not Returned";
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // $members =Member::all();
        //     $books =Book::where('is_available', 1)
        //                 ->get();
        // , compact('members', 'books')
        return view('issueBook.index');
    }

    public function allMembers()
    {
        $members =Member::pluck('name', 'id');
        return response()->json($members);
    }

    public function allBooks()
    {
        $books =Book::where('is_available', 1)
                    ->pluck('book_name', 'id');
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id'      => 'required',
            'book_id'        => 'required',
            'issue_date'       => 'required',
            'return_date'       => 'required',
            'is_return'       => 'required',
        ],
        [
            'member_id.required' => 'Member is Required!',
            'book_id.required' => 'Book is Required!'
        ]);
        if ($validator->passes()) {
            IssueBook::updateOrCreate(['id' => $request->product_id],
                    ['member_id' => $request->member_id, 'book_id' => $request->book_id, 'issue_date' => $request->issue_date, 'return_date' => $request->return_date, 'is_return' => $request->is_return, 'created_by' => Auth::user()->id]);        
            
            $update_book = Book::find($request->book_id);
            $update_book->is_available = 0;
            $update_book->save();
            return response()->json(['success'=>'IssueBook saved successfully.']);
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
        $issueBook = IssueBook::find($id);
        return response()->json($issueBook);
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
        IssueBook::find($id)->delete();
     
        return response()->json(['success'=>'Issuebook deleted successfully.']);
    }
}
