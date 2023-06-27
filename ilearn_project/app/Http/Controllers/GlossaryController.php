<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;


class GlossaryController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
            return view('glossary')->with('user',$user);
        }else{
            return redirect()->route('Login');
        }      
    } 

    public function create_page(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
            return view('new_glossary')->with('user',$user);
        }else{
            return redirect()->route('Login');
        }        
    } 

    public function fetch_table_glossary(Request $request){
        $search_bar = $request->search_bar;

        if ($request->ajax()) {
            $data = DB::select('exec SP_FETCH_GLOSSARY ?',array($search_bar));
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                        $btn = '
                                <a class="btn btn-primary btn-sm" id="edit" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</a>
                                <a class="btn btn-danger btn-sm" id="deactivate" href="#" data-id="'.$row->id.'">Deactivate</a>';   
                        }
                        else{
                            $btn = '<a class="btn btn-info btn-sm" id="active" href="#" data-id="'.$row->id.'">Activate</a>
                            <a class="btn btn-danger btn-sm" id="delete" href="#" data-id="'.$row->id.'">Delete</a>'; 
                        }
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('datatable');        
    }

    public function fetch_table_glossary_master(Request $request){
        $search_bar = $request->search_bar;

        if ($request->ajax()) {
            $data = DB::select('exec [SP_FETCH_MASTER_GLOSSARY] ?',array($search_bar));
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('datatable');        
    }

    public function insert_glossary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'word_name1' => 'required',
            'description1' => 'required',
        ]);

        $glossary_form = array(
            'word_name1' => 'Category',
            'description1' => 'Description',
            'word_name2' => 'Category',
            'description2' => 'Description',
            'word_name3' => 'Category',
            'description3' => 'Description',
            'word_name4' => 'Category',
            'description4' => 'Description',
            'word_name5' => 'Category',
            'description5' => 'Description',
        );

        $this->MainController->setAttributeNames($glossary_form);
        $validator->setAttributeNames($glossary_form);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->all()]);
            die();
        } 
            
            if($request->word_name1){                
                $row =  DB::connection('sqlsrv')->select('exec SP_INSERT_GLOSSARY ?,?', array($request->word_name1, $request->description1));
            }
            if($request->word_name2){                
                $row =  DB::connection('sqlsrv')->select('exec SP_INSERT_GLOSSARY ?,?', array($request->word_name2, $request->description2));
            }
            if($request->word_name3){                
                $row =  DB::connection('sqlsrv')->select('exec SP_INSERT_GLOSSARY ?,?', array($request->word_name3, $request->description3));
            }
            if($request->word_name4){                
                $row =  DB::connection('sqlsrv')->select('exec SP_INSERT_GLOSSARY ?,?', array($request->word_name4, $request->description4));
            }
            if($request->word_name5){                
                $row =  DB::connection('sqlsrv')->select('exec SP_INSERT_GLOSSARY ?,?', array($request->word_name5, $request->description5));
            }
                if ($row) {
                        return response()->json(['status' => true, 'msg' => ['Success']]);
                } else {
                    return response()->json(['status' => false, 'msg' => ['No Data']]);
                }   
            
            
    }

    public function edit_glossary(Request $request){
        $data = DB::select('exec SP_FETCH_EDIT_GLOSSARY @id=?', array($request->id));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function deactivate_glossary(Request $request){
        $data = DB::select('exec SP_UPDATE_GLOSSARY @id=?,@status=?', array($request->id,2));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }
    public function active_glossary(Request $request){
        $data = DB::select('exec SP_UPDATE_GLOSSARY @id=?,@status=?', array($request->id,1));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }
    public function update_glossary(Request $request){
        $data = DB::select('exec SP_EDIT_UPDATE_GLOSSARY @id=?, @title=?, @edit_description=?', 
        array($request->id,$request->edit_word_name, $request->edit_description));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function delete_glossary(Request $request){
        $data = DB::select('exec SP_UPDATE_GLOSSARY @id=?,@status=?', array($request->id,3));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }
}
