<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;

class PolicyController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function category_func(Request $request){
        $department_id = $request->department;
        $result_status =  DB::select('EXEC [SP_FETCH_CATEGORY_POLICY]');
        if ($result_status) {
            return response()->json(['status' => true, 'msg' => 'true','user_status' => $result_status]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_status' => '']);
        }
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {

        $data = DB::select('exec SP_FETCH_CATEGORY');
        $array = Array();
        $array['category_data'] = $data;
        $user = $request->session()->get('user');
        return view('policy')
            ->with('entities', $array)
            ->with('user',$user);
        }else{
            return redirect()->route('Login');
        }
    }

    public function title_link(Request $request,$id)
    {
        $user = $request->session()->get('user');
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
        
        // dd($id);
        $data = DB::select('exec SP_FETCH_EDIT_POLICY @id=?', array($id));
        if($data){
            

        $array = Array();

        $data_attachemnt = DB::select('exec SP_FETCH_EDIT_POLICY_ATTACHMENT ?', array($id));
        
        foreach ($data_attachemnt as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'policy/'.$value->attachment,
                'Content-type' => 'application/pdf',
                'Content-disposition' => 'inline',
                // 'ACL'    => 'public-read'
            ]);

            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $presignedUrl = (string)$request->getUri();
            $value->S3_url = $presignedUrl;
            $array[] = $value;

            // if($array[0]->attachment){
            //     $s3_url = $value->S3_url;
            // }else{
            //     $s3_url = 'assets/img/no_image.png';
            // }
            
        }
        // dd($id);
        // if ($request->session()->has('user')) {

        // $data = DB::select('exec SP_FETCH_CATEGORY');
        $array_1 = Array();
        $array_1['category_data'] = $data;
        
        return view('title_link')
            // ->with('data_sp', $array['0'])
            ->with('entities', $array_1)
            ->with('data_attachemnt', $array)
            ->with('user',$user);
        // }else{
        //     return redirect()->route('Login');
        // }
            
        }else{
            return redirect()->route('policy');
        }
    }

    public function department_section(Request $request){
        $department = DB::connection('sqlsrv')->select('exec [SP_FETCH_DEPARTMENT]');
        $array =  array();
        
        foreach ($department as $key => $value) {
            $section = DB::connection('sqlsrv')->select('exec [SP_FETCH_SECTION] ?,?',array($value->id,$request->id));
            $value->section = $section;
            $array[] = $value;
        }

        if ($array) {
            return response()->json(['status' => true, 'msg' => 'true','department' => $array]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','department' => '']);
        }
    }
    
    public function edit_department_section(Request $request){
        $department = DB::connection('sqlsrv')->select('exec SP_FETCH_POLICY_SECTION_ACCESS ?',array($request->id));

        if ($department) {
            return response()->json(['status' => true, 'msg' => 'true','department' => $department]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','department' => '']);
        }
    }
    
    public function fetch_table_policy(Request $request){
        $search_bar = $request->search_bar;
        $category_id = $request->category_mast;
        if ($request->ajax()) {

            $data = DB::select('exec SP_FETCH_POLICY ?, ?', array($search_bar,$category_id));

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
    
            $array = Array();
            
            foreach ($data as $key => $value) {
                $cmd = $s3Client->getCommand('GetObject', [
                    'Bucket' => $bucket,
                    'Key'    => 'policy/'.$value->attachment,
                    'Content-type' => 'application/pdf',
                    'Content-disposition' => 'inline',
                    
                ]);
    
                $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
                $presignedUrl = (string)$request->getUri();
                $value->attachment = $presignedUrl;
                // header("Content-Type: {$cmd['ContentType']}");
                $array[] = $value;            
    
            }
    
            // return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $array[0], 'link_image' => $value->S3_url]);

            return Datatables::of($array)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                    $btn = '<a class="btn btn-success btn-sm" id="edit" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</a>

                    <a class="btn btn-danger btn-sm" id="delete" href="#" data-id="'.$row->id.'">Deactivate</a>';   
                    }
                    else{
                        $btn = '
                        <a class="btn btn-info btn-sm" id="active" href="#" data-id="'.$row->id.'">Activate</a>'; 
                    }
                        
                        return $btn;
                })
                ->addColumn('title_link', function($row){     
                    // $link = '<a href="#" data-id="'.$row->id.'" id="link_btn"  data-bs-toggle="modal" data-bs-target="#title_link">'.$row->title.'</a>';
                    // $link = '<a href="'.$row->attachment.'" data-id="'.$row->id.'" target="_blank">'.$row->title.'</a>';
                    $link = '<a href="/title_link/'.$row->id.'" target="_blank" data-id="'.$row->id.'" data-title="'.$row->title.'" data-document_owner="'.$row->document_owner.'" data-document_no="'.$row->document_no.'" data-effectivity_date="'.$row->effectivity_date.'" style="color:blue;cursor:pointer;" id="link_btn">'.$row->title.'</a>';
                        
                        return $link;
                })
                ->rawColumns(['action','title_link'])
                ->make(true);

        }
    }

    public function redirect_to_pdf_view(Request $request){

        $id = $request->id;
        $title = $request->title;
        $document_owner = $request->document_owner;
        $document_no = $request->document_no;
        $effectivity_date = $request->effectivity_date;

        $request->session()->put('id', $id);
        $request->session()->put('title', $title);
        $request->session()->put('document_no', $document_no);
        $request->session()->put('document_owner', $document_owner);
        $request->session()->put('effectivity_date', $effectivity_date);
    }
    
    public function insert_policy(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'owner' => 'required',
            'make_category' => 'required',
            'document_no' => 'required',
            'effectivity_date' => 'required',
            'description' => 'required',
        ]);

        $policy_form = array(
            'title' => 'title',
            'owner' => 'owner',
            'make_category' => 'make_category',
            'document_no' => 'document_no',
            'effectivity_date' => 'effectivity_date',
            'attachment' => 'attachment',
            'description' => 'description',
        );

        $this->MainController->setAttributeNames($policy_form);
        $validator->setAttributeNames($policy_form);

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
        if($request->hasFile('attachment')){
            $image = $request->file('attachment');
            $imagename = $image->getClientOriginalName();

            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'policy/' . $imagename,
                'Body'   => fopen($image, 'r'),
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);
        }else{
            $imagename = '';
        }                
            $row =  DB::connection('sqlsrv')->select('exec [SP_INSERT_POLICY] @title=?,@owner=?,@document_no=?,@effectivity_date=?,@attachment=?,@description=?,@category_id=?', 
            array($request->title, $request->owner, $request->document_no, $request->effectivity_date, $imagename, $request->description, $request->make_category));

            if  ($request->section_access){
                $stuff = $request->section_access;
                    foreach ($stuff as $value) {
                        $row1 = DB::connection('sqlsrv')->select('exec [SP_INSERT_POLICY_SECTION] ?,?',array($value,'-1')); 
                    } 
            
            }
            else{
                    $row1 = DB::connection('sqlsrv')->select('exec [SP_INSERT_POLICY_SECTION] ?,?',array(0,'-1'));
            }
            
            // $stuff = $request->section_access;
            //     foreach ($stuff as $value) {
            //         $row1 = DB::connection('sqlsrv')->select('exec [SP_INSERT_POLICY_SECTION] ?,?',array($value,'-1')); 
            //     } 
            
            if ($row) {
                    return response()->json(['status' => true, 'msg' => ['Success']]);
            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }

            
    }

    public function edit_policy(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_POLICY @id=?', array($request->id));
        $array = Array();
        
        foreach ($data as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'policy/'.$value->attachment,
                'Content-type' => 'application/octet-stream',
                'Content-disposition' => 'application/pdf',
                
                'ResponseContentDisposition' => 'attachment; filename="data.pdf"'
            ]);
            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $presignedUrl = (string)$request->getUri();
            $value->S3_url = $presignedUrl;
            $array[] = $value;
            
        }
        if ($array) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $array[0], 'image' => $value->S3_url]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function update_policy(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_POLICY @id=?', array($request->id));
        
        if($request->hasFile('edit_attachment')){
            $image = $request->file('edit_attachment');
            $imagename = $image->getClientOriginalName();

            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'policy/' . $imagename,
                'Body'   => fopen($image, 'r'),
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);
        }else{
            $imagename = $data[0]->attachment;
        }
        
        $data = DB::select('exec SP_EDIT_UPDATE_POLICY @id=?
                        ,@title=?
                        ,@owner=? 
                        ,@document_no=?
                        ,@effectivity_date=?
                        ,@category=?
                        ,@attachment=?
                        ,@edit_description=?', 
        array($request->id
            ,$request->edit_title
            ,$request->edit_owner
            ,$request->edit_document_no
            ,$request->edit_effectivity_date
            ,$request->edit_make_category
            ,$imagename
            ,$request->edit_description));

            db::statement('[SP_DELETE_POLICY_SECTION_ACCESS] ?',array($request->id));

            if(isset($request->edit_section_access)){
                foreach ($request->edit_section_access as $key => $sect_id) {
                    db::select('[SP_INSERT_POLICY_SECTION] ?,?',array($sect_id,$request->id));
                }
            }
            
            if(isset($request->section)){
                $section_array = explode(',', $request->section);
                foreach ($section_array as $key => $sect_id) {
                    db::select('[SP_INSERT_POLICY_SECTION] ?,?',array($sect_id,$request->id));
            }
            
            }
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
        
        

        
    }

    public function delete_policy(Request $request){
        $data = DB::select('exec SP_UPDATE_POLICY @id=?,@status=?', array($request->id,2));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function active_policy(Request $request){
        $data = DB::select('exec SP_UPDATE_POLICY @id=?,@status=?', array($request->id,1));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function audit_trail_click(Request $request){
        $user = $request->session()->get('user');
        
        $data = DB::update('exec [SP_Audit_Trail_update] @user_id=?,@id=?', array($user->id, $request->id));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }  
        
    }

    public function link_policy(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_POLICY @id=?', array($request->id));
        $array = Array();
        
        foreach ($data as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'policy/'.$value->attachment,
                'Content-type' => 'application/pdf',
                'Content-disposition' => 'inline',
                
            ]);

            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $presignedUrl = (string)$request->getUri();
            $value->S3_url = $presignedUrl;
            $array[] = $value;            

        }

        return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $array[0], 'link_image' => $value->S3_url]);
    }
    
}
