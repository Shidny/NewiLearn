<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;


class CategoriesController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {
        $data = DB::select('exec SP_FETCH_STATUS');
        $array = Array();
        $array['status_name'] = $data;
        $user = $request->session()->get('user');
        return view('categories')->with('entities', $array)->with('user',$user);
            // return redirect()->route('home');
        }else{
            // return view('login');
            return redirect()->route('Login');
        }
        
    }   
    public function insert_category(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'status' => 'required'
        ]);

        $user_acess = array(
            'category_name' => 'Category',
            'status' => 'status',
            'icon' => 'icon',
            'description' => 'Description',
        );

        $this->MainController->setAttributeNames($user_acess);
        $validator->setAttributeNames($user_acess);

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'credentials' => [
                'key'    => 'AKIA3PS4F2Z42PFGRGO7',
                'secret' => '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'
            ],
            'http'    => [
                'verify' => false
            ]
        ]);
        $bucket = 'bucket-policy-portal';

            if ($validator->fails()) {
                return response()->json(['status' => false, 'msg' => $validator->errors()->all()]);
                die();
            } 
            if($request->hasFile('icon')){
                $image = $request->file('icon');
                $imagename = time().$image->getClientOriginalName();

                $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => 'categories/' . $imagename,
                    'Body'   => fopen($image, 'r'),
                    'StorageClass' => 'REDUCED_REDUNDANCY'
                ]);
            }else{
                $imagename = '';
            }
                        
            $category_name = $request->category_name;
            $status = $request->status;
            $description = $request->description;
            $imagename = $imagename;
            $cat_access_levl = explode(',', $request->cat_access_level);
            // dd($cat_access_levl);
            if ($request->session()->has('user')) {
                $user = $request->session()->get('user');
                $user_id = $user->id;
            }

            $row =  DB::connection('sqlsrv')->select('exec SP_INSERT_CATEGORY ?,?,?,?,?', array($category_name, $status, $imagename, $description, $user_id));
            if ($row) {
                
                if  ($request->cat_access_level != null){
                    foreach ($cat_access_levl as $key => $value) {
                        DB::connection('sqlsrv')->select('exec SP_INSERT_ACCESS_LEVEL ?,?', array($value,''));
                        // return response()->json(['status' => true, 'msg' => $value]);
                    }
                }
                    return response()->json(['status' => true, 'msg' => ['Success']]);

            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }

            
    }  

    public function fetch_table(Request $request){
        $search_bar = $request->search_bar;

        if ($request->ajax()) {
            $data = DB::select('exec SP_FETCH_CATEGORY');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                    $btn = '
                            <a class="btn btn-primary btn-sm" id="edit" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</a>
                            <a class="btn btn-danger btn-sm" id="delete" href="#" data-id="'.$row->id.'">Deactivate</a>';   
                    }
                    else if($row->status == '2'){
                        $btn = '
                        <a class="btn btn-info btn-sm" id="active" href="#" data-id="'.$row->id.'">Activate</a>';
                    }
                    else{
                        $btn = '
                        <a href="#" class="retrive btn btn-info btn-sm" data-id="'.$row->id.'">
                            Retrive
                        </a>';
                    }
                        
                        return $btn;
                })
                ->addColumn('category_link', function($row){     
                    $link = '<a href="#" data-id="'.$row->id.'" id="link_btn"  data-bs-toggle="modal" data-bs-target="#category_link">'.$row->category_name.'</a>';
                        
                        return $link;
                })
                ->rawColumns(['action','category_link'])
                ->make(true);
                
        }
        return view('datatable');        
    }

    public function fetch_table_filter(Request $request){
        $search_bar = $request->search_bar;

        if ($request->ajax()) {
            $data = DB::select('exec [SP_FETCH_CATEGORY_FILTER] ?',array($search_bar));
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                        $btn = '
                        <a class="btn btn-primary btn-sm" id="edit" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</a>
                        <a class="btn btn-danger btn-sm" id="delete" href="#" data-id="'.$row->id.'">Deactivate</a>';
                    }
                    else if($row->status == '2'){
                        $btn = '
                        <a class="btn btn-info btn-sm" id="active" href="#" data-id="'.$row->id.'">Activate</a>';
                    }
                    else{
                        $btn = '
                        <a href="#" class="retrive btn btn-info btn-sm" data-id="'.$row->id.'">
                            Retrive
                        </a>';
                    }
                        
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('datatable');        
    }

    public function delete_category(Request $request){
        $data = DB::select('exec SP_UPDATE_CATEGORY @id=?,@status=?', array($request->id,2));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function session_category(Request $request)
    {
        if ($request->session()->has('user')) {
            return view('home');
        }else{
            return view('login');
        }
    }

    public function active_category(Request $request){
        $data = DB::select('exec SP_UPDATE_CATEGORY @id=?,@status=?', array($request->id,1));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function retrive_category(Request $request){
        $data = DB::select('exec SP_UPDATE_CATEGORY @id=?,@status=?', array($request->id,1));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }
    
    public function edit_category(Request $request){
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'credentials' => [
                'key'    => 'AKIA3PS4F2Z42PFGRGO7',
                'secret' => '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'
            ],
            'http'    => [
            'verify' => false
            ]
        ]);
        $bucket = 'bucket-policy-portal';

        $data = DB::select('exec SP_FETCH_EDIT_CATEGORY @id=?', array($request->id)); 
        $array = Array();

        foreach ($data as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'categories/'.$value->icon,
            ]);
            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $presignedUrl = (string)$request->getUri();
            $value->S3_url = $presignedUrl;
            $array[] = $value;
        }

        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0], 'image' => $value->S3_url]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }       
    }

    public function update_category(Request $request){
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'credentials' => [
                'key'    => 'AKIA3PS4F2Z42PFGRGO7',
                'secret' => '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'
            ],
            'http'    => [
                'verify' => false
            ]
        ]);
        $bucket = 'bucket-policy-portal';

        $data = DB::select('exec SP_FETCH_EDIT_CATEGORY @id=?', array($request->id));
        
        $array = Array();
        // for image fetch 
        if($request->hasFile('edit_icon')){
            $image = $request->file('edit_icon');
            $imagename = time().$image->getClientOriginalName();

            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'categories/' . $imagename,
                'Body'   => fopen($image, 'r'),
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);
        }else{
            $imagename = '';
        }
        DB::select('exec SP_UNCHECK_STATUS_ACCESS_RIGHT ?', 
            array($request->id));

        $edit_cat_access_level = explode(',', $request->edit_cat_access_level);

        foreach ($edit_cat_access_level as $key => $update_value) {
            DB::select('exec SP_INSERT_ACCESS_LEVEL ?,?', 
            array($update_value, $request->id));
            
        }

        $data = DB::select('exec SP_EDIT_UPDATE_CATEGORY @id=?, @category_name=?, @attachment=?, @edit_description=?, @status=?', 
        array($request->id,$request->edit_category_name,$imagename,$request->edit_description,$request->edit_status));

        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }  
        
    }

    // public function category_session(Request $request){
    //     $request->session()->forget(['category_level']);
    //     $request->session()->put('category_level', $request->cat_id);
    //     $cat_id = $request->cat_id;
    //     $results_access_list =  DB::connection('sqlsrv')->select('exec SP_FETCH_access_rights ?', array($cat_id));

    //     return Datatables::of($results_access_list)->addIndexColumn()
    //     ->addColumn('action', function ($row) {
    //         if($row->STATUS == 0 || $row->STATUS == null){
    //             $btn= '<input style="cursor:pointer;" type="checkbox" id="chk_access" data-accessid = "'.$row->id.'">';
    //         }else{
    //             $btn= '<input style="cursor:pointer;" type="checkbox" id="chk_access" data-accessid = "'.$row->id.'" checked>';
    //         }

    //         return $btn;
    //     })
    //     ->rawColumns(['action'])
    //     ->make(true);
    // }

    // public function update_access_level(Request $request){        
    //     $access_id = $request->access_id;
    //     $cat_id = $request->session()->get('category_level');
    //     DB::connection('sqlsrv')->select('exec SP_INSERT_ACCESS_LEVEL ?,?', array($access_id,$cat_id));              
    // }

    public function cat_create_fetch(Request $request){        
        $data = DB::connection('sqlsrv')->select('exec [SP_FETCH_users_role_class]');

        return Datatables::of($data)->addIndexColumn()
        ->addColumn('action', function ($data) {
                $btn= '<input style="cursor:pointer;" type="checkbox" class="chk_cat_access" id="chk_cat_access" value="'.$data->id.'">';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function edit_cat_create_fetch(Request $request){        
        // $request->session()->forget(['category_level']);
        // $request->session()->put('category_level', $request->cat_id);
        $cat_id = $request->cat_id;
        $results_access_list =  DB::connection('sqlsrv')->select('exec SP_FETCH_access_rights ?', array($cat_id));

        return Datatables::of($results_access_list)->addIndexColumn()
        ->addColumn('action', function ($row) {
            if($row->STATUS == 0 || $row->STATUS == null){
                $btn= '<input style="cursor:pointer;" class="edit_checkbox" type="checkbox" id="chk_access" value="'.$row->id.'">';
            }else{
                $btn= '<input style="cursor:pointer;" class="edit_checkbox" type="checkbox" id="chk_access" value="'.$row->id.'" checked>';
            }

            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function link_category(Request $request){
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'credentials' => [
                'key'    => 'AKIA3PS4F2Z42PFGRGO7',
                'secret' => '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'
            ],
            'http'    => [
            'verify' => false
            ]
        ]);
        $bucket = 'bucket-policy-portal';

        $data = DB::select('exec SP_FETCH_EDIT_CATEGORY @id=?', array($request->id));
        $array = Array();
        
        foreach ($data as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'categories/'.$value->icon,
                'content-type' => 'inline',
                'content-disposition' => 'application/pdf'
            ]);
            
            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $presignedUrl = (string)$request->getUri();
            $value->S3_url = $presignedUrl;
            // header("Content-Type: {$cmd['ContentType']}");
            $array[] = $value;            

        }
        // if ($array) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $array[0], 'link_image' => $array[0]->S3_url]);
        // } else {
        // return response()->json(['status' => false, 'msg' => ['No Data']]);
        // }      
    }

    // public function update_cat_access_level(Request $request){        
    //     $cat_access_id = $request->cat_access_id;
    //     $cat_ids = $request->session()->get('category_level');
    //     DB::connection('sqlsrv')->select('exec SP_INSERT_ACCESS_LEVEL ?,?', array($cat_access_id,$cat_ids));              
    // }


    
    
}
