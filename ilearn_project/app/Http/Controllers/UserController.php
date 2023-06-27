<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    //  public function subscribe(Request $request){
    //     // $validator = Validator::make($request->all(),[
    //     //     'email' => 'required|email|unique:subscribers                                                                                                                                                                                                                                                   '
    //     // ]);
    //     // // if($validator->fails()){
    //     //     return new JsonResponse(
    //     //         [
    //     //             'success' => false, 
    //     //             'message' => $validator->errors()
    //     //         ], 422
    //     //     );
    //     // }

    //     // $data_array = [
    //     //     'full_name'    => 'Melvin Kakilala',
    //     //     'firstname'    => trim('Melvin'),
    //     //     'middlename'    => trim('Briones'),
    //     //     'lastname'    => trim('Kakilala'),
    //     //     'email'    => trim('mbkakilala@rfc.com.ph'),
    //     // ];

    //     // $data = array("name" => "Cloudways (sender_name)", "body" => "A test mail");
    //     // $resultMail = Mail::send('sendmessage', ['data' => $data_array], function ($message) use ($data_array) {
    //     //     $message->to($data_array['email'], $data_array['full_name'])
    //     //         ->subject("Email Verification");
    //     //     $message->from("no-reply.ilearn@rfc.com.ph", "Policy Portal");
    //     // });
    //     // dd($resultMail);
    //     // // return response()->json(['status' => true, 'msg' => '', 'dedup' => $resultMail]);

    //     // $email = $request->all()['email'];
    //     // $email = 'melvinbrioneskakilala07@gmail.com';
    //     // $subscriber = Subscriber::create([
    //     //     'email' => $email
    //     // ]);
    //     // if($subscriber){
    //         // Mail::to($email)->send(new Subscribe($email));
    //         // Mail::to($email)->send($email);
    //         // return new JsonResponse(
    //         //     [
    //         //         'success' => true,
    //         //         'message' => "Thank you for subscribing to our email, please check your inbox"
    //         //     ], 200
    //         // );
    //     // }
    // }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {
            // return view('categories');
            $data = DB::select('exec SP_FETCH_STATUS');
            $array = Array();
            $array['status_name'] = $data;
            $user = $request->session()->get('user');
            return view('user_management')->with('entities', $array)->with('user',$user);
                // return redirect()->route('home');
            }else{
                // return view('login');
                return redirect()->route('Login');
            }
        
    } 
    public function department_func(Request $request){
        $result_department =  DB::select('EXEC SP_FETCH_DEPARTMENT');
        if ($result_department) {
            return response()->json(['status' => true, 'msg' => 'true','user_department' => $result_department]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_department' => '']);
        }
    }
    public function division_func(Request $request){
        $result_division_func =  DB::select('EXEC [SP_FETCH_DIVISION]');
        if ($result_division_func) {
            return response()->json(['status' => true, 'msg' => 'true','user_division' => $result_division_func]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_division' => '']);
        }
    }
    
    public function section_func(Request $request){
        $department_id = $request->department;
        $result_section =  DB::select('EXEC SP_FETCH_SECTION ?,?',array($department_id,'-1'));
        if ($result_section) {
            return response()->json(['status' => true, 'msg' => 'true','user_section' => $result_section]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_section' => '']);
        }
    }

    public function section_func_id(Request $request){
        $department_id = $request->edit_department;

        $result_section =  DB::select('EXEC [SP_FETCH_SECTION_ID] ?',array($department_id));

        if ($result_section) {
            return response()->json(['status' => true, 'msg' => 'true','user_section' => $result_section]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_section' => '']);
        }
    }

    public function status_func(Request $request){
        $department_id = $request->department;
        $result_status =  DB::select('EXEC [SP_FETCH_STATUS]');
        if ($result_status) {
            return response()->json(['status' => true, 'msg' => 'true','user_status' => $result_status]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_status' => '']);
        }
    }

    public function role_func(Request $request){
        $department_id = $request->department;
        $result_role =  DB::select('EXEC [SP_FETCH_ROLE]');
        if ($result_role) {
            return response()->json(['status' => true, 'msg' => 'true','user_role' => $result_role]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_role' => '']);
        }
    }
    

    public function get_user_management_table(Request $request){
        if ($request->ajax()) {

            $search_bar = $request->search_bar;
            $department_id = $request->department_id;
        
            $data =  DB::select('EXEC [SP_FETCH_USERS] ?,?', array($search_bar,$department_id));
            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                    $btn = '
                        <a href="#" id="edit" class="btn btn-primary btn-sm" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">
                            Edit
                        </a>
                        <a href="#" id="delete" class="btn btn-danger btn-sm" data-id="'.$row->id.'">
                            Deactivate
                        </a>';   
                    }
                    else{
                        $btn = '
                        <a href="#" id="active" class="btn btn-info btn-sm" data-id="'.$row->id.'">
                            Activate
                        </a>'; 
                    }
                        
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('datatable');        
    }
    
    public function insert_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
        ]);

        $user_input_forms = array(
            'password' => 'password',
            'firstname' => 'firstname',
            'middlename' => 'middlename',
            'lastname' => 'lastname',
            'emp' => 'emp',
            'email' => 'email',
            'role_id' => 'role_name',
            'position' => 'position',
            'section_name' => 'section_name',
            'division_name' => 'division_name',
            'department_name' => 'department_name',
            'level' => 'level',
            'status' => 'status_name',
        );

        $this->MainController->setAttributeNames($user_input_forms);
        $validator->setAttributeNames($user_input_forms);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->all()]);
            die();
        }
            
            $firstname = $request->firstname;
            $middlename = $request->middlename;
            $lastname = $request->lastname;
            $username = $request->username;
            $email = $request->email;
            $password = $request->password;
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role_id = $request->role_name;
            $position = $request->position;
            $department = $request->department_name;
            $section = $request->section_name;
            $division = $request->division_name;
            $level = $request->level;
            $status = $request->status_name;
            // $attachment = $imagename;


            $row =  DB::connection('sqlsrv')->select('exec [SP_INSERT_USER] @username=?
                                ,@password=?
                                ,@email=?
                                ,@firstname=?
                                ,@middlename=?
                                ,@lastname=?
                                ,@position=?
                                ,@section=?
                                ,@division=?
                                ,@department=?
                                ,@role_id=?
                                ,@status=?'
                        ,array($username, $hashed_password, $email, $firstname, $middlename, $lastname, $position, $section, $division, $department, $role_id, $status));
            if ($row) {

        $data_array = [
            'full_name'    => $firstname. ' ' .$lastname,
            'firstname'    => trim($firstname),
            'middlename'    => trim($middlename),
            'lastname'    => trim($lastname),
            'email'    => trim($email),
            'username'    => trim($username),
            'password'    => trim($password),
        ];

        $data = array("name" => "Cloudways (sender_name)", "body" => "A test mail");
        $resultMail = Mail::send('sendmessage', ['data' => $data_array], function ($message) use ($data_array) {
            $message->to($data_array['email'], $data_array['full_name'])
                ->subject("Email Verification");
            $message->from("no-reply.ilearn@rfc.com.ph", "Policy Portal");
        });
                    return response()->json(['status' => true, 'msg' => ['Success']]);
            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }
    }

    public function edit_users(Request $request){
        $data = DB::select('exec [SP_FETCH_EDIT_USERS] @id=?', array($request->id));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }
    
    public function update_users(Request $request){

        if($request->edit_password == ''){
            $data = DB::select('exec [SP_FETCH_EDIT_USERS] @id=?', array($request->id));
                
            $edit_hashed_password = $data[0]->password;
        }else{
            $edit_hashed_password = password_hash($request->edit_password, PASSWORD_DEFAULT);
        }
       
        $data = DB::select('exec SP_EDIT_UPDATE_USERS @id=?
                        ,@username=?
                        ,@password=? 
                        ,@firstname=?
                        ,@middlename=?
                        ,@lastname=?
                        ,@email=?
                        ,@position=?
                        ,@section=?
                        ,@division=?
                        ,@department=?
                        ,@status=?
                        ,@role_id=?', 
        array($request->id
            ,$request->edit_username
            ,$edit_hashed_password
            ,$request->edit_firstname
            ,$request->edit_middlename
            ,$request->edit_lastname
            ,$request->edit_email
            ,$request->edit_position
            ,$request->edit_section_name
            ,$request->division_id
            ,$request->department_name_edit
            ,$request->status_name_edit
            ,$request->edit_role_name
            ));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function deactivate_users(Request $request){
        $data = DB::select('exec [SP_UPDATE_USERS] @id=?,@status=?', array($request->id,2));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function activate_users(Request $request){
        $data = DB::select('exec SP_UPDATE_USERS @id=?,@status=?', array($request->id,1));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function dropdown_department(Request $request){
        $result_status =  DB::select('EXEC [SP_FETCH_DEPARTMENT]');
        if ($result_status) {
            return response()->json(['status' => true, 'msg' => 'true','user_status' => $result_status]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_status' => '']);
        }
    }

// -------------------------------------------------------------------- Section Functions -------------------------------------------------------------------
// create, update, delete, fetch, display table, deactivate, activate

    // section blade connection 
    public function indexsection(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
                return view('section')->with('user',$user);
        }else{
                return redirect()->route('Login');
        }
        
    }

    // insert to database 
    public function insert_section(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'required',
        ]);

        $section_input_forms = array(
            'section_name' => 'section_name',
            'status' => 'status_name',
        );

        $this->MainController->setAttributeNames($section_input_forms);
        $validator->setAttributeNames($section_input_forms);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->all()]);
            die();
        }
            
            $section = $request->section_name;
            $department_id = $request->department_name;
           
            if  ($request->search_bar){
                $search_bar = $request->search_bar; 
            }
            else{
                $search_bar = '';
            }

            if  ($request->section_id){
                $section_id = $request->section_id; 
            }
            else{
                $section_id = '';
            }

            $row =  DB::connection('sqlsrv')->insert('exec [SP_SECTION] @section_id=?,@search_bar=?,@section_filter_id=?,@section_name=?
                                ,@department=? ,@status=? ,@StatementType=?'
                        ,array('',$search_bar,$section_id,$section, $department_id, '','Insert'));
            if ($row) {
                    return response()->json(['status' => true, 'msg' => ['Success']]);
            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }
    }

    // table display 
    public function display_section (Request $request){
       
            if  ($request->search_bar){
                $search_bar = $request->search_bar; 
            }
            else{
                $search_bar = '';
            }
            
            if  ($request->department_id){
                $department_id = $request->department_id;
            }
            else{
                $department_id = '';
            }

            if ($request->id){
                $id = $request->id;
            }
            else{
                $id = '';
            }

            if  ($request->section_id){
                $section_id = $request->section_id; 
            }
            else{
                $section_id = '';
            }

            $data =  DB::select('EXEC [SP_SECTION] ?,?,?,?,?,?,?', array($id,$search_bar,$section_id,$department_id,'','','Select'));
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                    $btn = '
                        <a href="#" id="edit" class="btn btn-primary btn-sm" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">
                            Edit
                        </a>
                        <a href="#" id="deactivate" class="btn btn-danger btn-sm" data-id="'.$row->id.'">
                            Deactivate
                        </a>';   
                    }
                    else{
                        $btn = '
                        <a href="#" id="activate" class="btn btn-info btn-sm" data-id="'.$row->id.'">
                            Activate
                        </a>
                        <a href="#" id="delete" class="btn btn-danger btn-sm" data-id="'.$row->id.'">
                            Delete
                        </a>'; 
                    }
                        
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        
        return view('datatable');      
    }

    // fetching data in editfunction 
    public function fetch_section(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->section_id){
            $section_id = $request->section_id; 
        }
        else{
            $section_id = '';
        }

        $data = DB::select('exec [SP_SECTION] @section_id=?, @search_bar=?,@section_filter_id=?,  @section_name=?, @department=?, @status=?, @StatementType=?', array($id,$search_bar,$section_id,'','','','Fetch'));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // update function
    public function update_section(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_section){
            $edit_section = $request->edit_section;
        }
        else{
            $edit_section = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }
       
        if  ($request->section_id){
            $section_id = $request->section_id; 
        }
        else{
            $section_id = '';
        }

        $data = DB::connection('sqlsrv')->select('exec [SP_SECTION] @section_id=?
                        ,@search_bar=?
                        ,@section_filter_id=?
                        ,@section_name=?
                        ,@department=?
                        ,@status=?
                        ,@StatementType=?'
                            ,array($id
                                ,$search_bar
                                ,$section_id
                                ,$edit_section
                                ,$edit_department
                                ,''
                                ,'Update'));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // delete function
    public function delete_section(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_section){
            $edit_section = $request->edit_section;
        }
        else{
            $edit_section = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->section_id){
            $section_id = $request->section_id; 
        }
        else{
            $section_id = '';
        }

        $data = DB::update('exec [SP_SECTION] @section_id=?,@search_bar=?,@section_filter_id=? ,@section_name=?, @department=?, @status=?, @StatementType=?', array($id, $search_bar,$section_id,'' ,'',2,'Delete'));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // deactivate function
    public function deactivate_section(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_section){
            $edit_section = $request->edit_section;
        }
        else{
            $edit_section = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->section_id){
            $section_id = $request->section_id; 
        }
        else{
            $section_id = '';
        }

        $data = DB::update('exec [SP_SECTION] @section_id=? ,@search_bar=? ,@section_filter_id=? ,@section_name=?, @department=?, @status=?, @StatementType=?', array($id, $search_bar ,$section_id ,'' ,'' ,2 ,'Deactivate'));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // activate function
    public function activate_section(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_section){
            $edit_section = $request->edit_section;
        }
        else{
            $edit_section = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->section_id){
            $section_id = $request->section_id; 
        }
        else{
            $section_id = '';
        }

        $data = DB::update('exec [SP_SECTION] @section_id=? ,@search_bar=? ,@section_filter_id=? ,@section_name=? ,@department=? ,@status=? ,@StatementType=?' ,array($id, $search_bar,$section_id,'','',1,'Activate'));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // filter section function
    public function section_dropdown(Request $request){
        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_section){
            $edit_section = $request->edit_section;
        }
        else{
            $edit_section = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->section_id){
            $section_id = $request->section_id; 
        }
        else{
            $section_id = '';
        }

        $result_status =  DB::select('EXEC [SP_SECTION] @section_id=?,@search_bar=?,@section_filter_id=? ,@section_name=?, @department=?, @status=?, @StatementType=?', array($id, $search_bar,$section_id,'','',1,'Filter'));
        if ($result_status) {
            return response()->json(['status' => true, 'msg' => 'true','section_dropdown' => $result_status]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','section_dropdown' => '']);
        }
    }
    // end for Section




// --------------------------------------------------------- department function --------------------------------------------------------------------------------
// create, update, delete, fetch, display table, deactivate, activate 

    // Department blade connection 
    public function indexdepartment(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
                return view('department')->with('user',$user);
        }else{
                return redirect()->route('Login');
        }
        
    }

    // insert function
    public function insert_department(Request $request){
        $validator = Validator::make($request->all(), [
            'department_name' => 'required',
        ]);

        $section_input_forms = array(
            'department_name' => 'department_name',
        );

        $this->MainController->setAttributeNames($section_input_forms);
        $validator->setAttributeNames($section_input_forms);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->all()]);
            die();
        }
                       
            if  ($request->search_bar){
                $search_bar = $request->search_bar; 
            }
            else{
                $search_bar = '';
            }

            if  ($request->filter_department){
                $filter_department = $request->filter_department; 
            }
            else{
                $filter_department = '';
            }

            if  ($request->department_name){
                $department_name = $request->department_name; 
            }
            else{
                $department_name = '';
            }

            $row =  DB::connection('sqlsrv')->insert('exec [SP_DEPARTMENT] @department_id=? ,@search_bar=? ,@department_filter_id=? ,@department_name=? ,@status=? ,@StatementType=?'
                        ,array('',$search_bar,$filter_department,$department_name, '','Insert'));
            if ($row) {
                    return response()->json(['status' => true, 'msg' => ['Success']]);
            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }
    }

    // table display 
    public function display_department (Request $request){
       
        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }
        
        if  ($request->department_id){
            $department_id = $request->department_id;
        }
        else{
            $department_id = '';
        }

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }

        $data =  DB::select('EXEC [SP_DEPARTMENT] ?,?,?,?,?,?', array('',$search_bar,$filter_department,'','','Select'));
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){     
                if($row->status == '1'){
                $btn = '
                    <a href="#" id="edit" class="btn btn-primary btn-sm" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">
                        Edit
                    </a>
                    <a href="#" id="deactivate" class="btn btn-danger btn-sm" data-id="'.$row->id.'">
                        Deactivate
                    </a>';   
                }
                else{
                    $btn = '
                    <a href="#" id="activate" class="btn btn-info btn-sm" data-id="'.$row->id.'">
                        Activate
                    </a>
                    <a href="#" id="delete" class="btn btn-danger btn-sm" data-id="'.$row->id.'">
                        Delete
                    </a>'; 
                }
                    
                    return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    
        return view('datatable');      
    }

    // fetching data in editfunction 
    public function fetch_department(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->department_name){
            $department_name = $request->department_name; 
        }
        else{
            $department_name = '';
        }

        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }

        $data = DB::select('exec [SP_DEPARTMENT] @department_id=?,@search_bar=?,@department_filter_id=? ,@department_name=? ,@status=? ,@StatementType=?', array($id,$search_bar,$filter_department,$department_name,'','Fetch'));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // update function
    public function update_department(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }
    
        $data = DB::connection('sqlsrv')->select('exec [SP_DEPARTMENT] @department_id=?
                        ,@search_bar=?
                        ,@department_filter_id=?
                        ,@department_name=?
                        ,@status=?
                        ,@StatementType=?'
                            ,array($id
                                ,$search_bar
                                ,$filter_department
                                ,$edit_department
                                ,''
                                ,'Update'));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // deactivate function
    public function deactivate_department(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        
        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }

        $data = DB::update('exec [SP_DEPARTMENT] @department_id=? ,@search_bar=?, @department_filter_id=? ,@department_name=?, @status=?, @StatementType=?', array($id ,$search_bar, $filter_department ,'' ,2 ,'Deactivate'));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // activate function
    public function activate_department(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }

        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }

        $data = DB::update('exec [SP_DEPARTMENT] @department_id=? ,@search_bar=?, @department_filter_id=? ,@department_name=? ,@status=? ,@StatementType=?' ,array($id,$search_bar, $filter_department ,$edit_department,1,'Activate'));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // delete function
    public function delete_department(Request $request){

        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }


        $data = DB::update('exec [SP_DEPARTMENT] @department_id=? ,@search_bar=?, @department_filter_id=? ,@department_name=? ,@status=? ,@StatementType=?', array($id ,$search_bar, $filter_department ,$edit_department ,2,'Delete'));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    // filter section function
    public function department_dropdown(Request $request){
        if ($request->id){
            $id = $request->id;
        }
        else{
            $id = '';
        }
        
        if ($request->edit_department){
            $edit_department = $request->edit_department;
        }
        else{
            $edit_department = '';
        }

        if  ($request->search_bar){
            $search_bar = $request->search_bar; 
        }
        else{
            $search_bar = '';
        }

        if  ($request->filter_department){
            $filter_department = $request->filter_department; 
        }
        else{
            $filter_department = '';
        }

    

        $result_status =  DB::select('EXEC [SP_DEPARTMENT] @department_id=?,@search_bar=?, @department_filter_id=?,@status=?, @StatementType=?', array($id, $search_bar, $filter_department ,$edit_department ,'' ,'Filter'));
        if ($result_status) {
            return response()->json(['status' => true, 'msg' => 'true','section_dropdown' => $result_status]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','section_dropdown' => '']);
        }
    }

}
