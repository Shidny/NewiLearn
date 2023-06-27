<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;

class UploadformsController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }
    
    public function index(Request $request)
    {

        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
            return view('uploadforms')->with('user',$user);
        }else{
            return redirect()->route('Login');
        }
    }

    public function index_newForm(Request $request)
    {
        // $imagename = '1666763292Geduya1SaABgYX7.xlsx';
        // $s3Client = new S3Client([
        //     'version' => 'latest',
        //     'region'  => 'ap-southeast-1',
        //     'credentials' => [
        //         'key'    => 'AKIA3PS4F2Z42PFGRGO7',
        //         'secret' => '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'
        //     ],
        //     'http'    => [
        //         'verify' => false
        //     ]
        // ]);
        // $bucket = 'bucket-policy-portal';

        // $result = $s3Client->getObject(array(
        //     'Bucket' => $bucket,
        //     'Key'    => 'forms/'.$imagename ,
        //     'ResponseContentLanguage'    => 'en-US',
        //     'ResponseCacheControl'       => 'No-cache',
        //     'ResponseExpires'            => gmdate(DATE_RFC2822, time() + 60),
        //     'http'    => [
        //         'verify' => false
        //     ],
        // ));
        // header("Cache-Control: public");
        // header("Content-Description: File Transfer");
        // header("Content-Disposition: attachment; filename=" . $imagename);
        // header("Content-Type: {$result['ContentType']}");
        // echo $result['Body'];   
        // dd($result['Body']);

        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
            return view('new_uploadform')->with('user',$user);
        }else{
            return redirect()->route('Login');
        }
    }

    public function insert_uploadform(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'attachment_path' => 'required',
        ]);

        $upload_form = array(
            'title' => 'title',
            'attachment_path' => 'attachment_path',
        );

        $this->MainController->setAttributeNames($upload_form);
        $validator->setAttributeNames($upload_form);

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
            if($request->hasFile('attachment_path')){
                $destination = 'Files';
                $image = $request->file('attachment_path');
                $imagename = time().$image->getClientOriginalName();

                $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => 'forms/' . $imagename,
                    'Body'   => fopen($image, 'r'),
                    'StorageClass' => 'REDUCED_REDUNDANCY'
                ]);
            }else{
                $imagename = '';
            }
    
            $title = $request->title;
            $attachment = $imagename;
            
            $row =  DB::connection('sqlsrv')->select('exec SP_CREATE_UPLOADFORM @title=?,@attachment_path=?', 
            array($title, $attachment));
            if ($row) {
                    return response()->json(['status' => true, 'msg' => ['Success']]);
            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }
    }
    
    public function download_form_table(Request $request){
        $search_bar = $request->search_bar;
        if ($request->ajax()) {
            $data = DB::select('exec SP_FETCH_DOWNLOAD_FORM ?', array($search_bar));
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){   
                                    
                    $btn = '<a href="#" data-image="'.$row->attachment_path.'" class="download_image">Download</a>';   
                    return $btn;
                })
                ->addColumn('title_link', function($row){     
                    // $link = '<a href="#" data-id="'.$row->id.'" id="link_btn">'.$row->title.'</a>';

                    $link = '<a href="/link_forms/'.$row->id.'" data-id="'.$row->id.'" data-title="'.$row->title.'">'.$row->title.'</a>';
                        return $link;
                })
                ->rawColumns(['action','title_link'])
                ->make(true);
        }
        return view('datatable');     
           
    }

    public function imagedown(Request $request){
        
        $imagename = $request->url;
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

        $result = $s3Client->getObject(array(
            'Bucket' => $bucket,
            'Key'    => 'forms/'.$imagename ,
            'ResponseContentLanguage'    => 'en-US',
            'ResponseCacheControl'       => 'No-cache',
            'ResponseExpires'            => gmdate(DATE_RFC2822, time() + 60),
            'http'    => [
                'verify' => false
            ],
        ));
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $imagename);
        header("Content-Type: {$result['ContentType']}");
        
        echo $result['Body'];   
    }

    public function edit_uploadforms(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_UPDATE_FORM @id=?', array($request->id));
        $array = Array();
        
        foreach ($data as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'forms/'.$value->attachment_path,
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

    public function link_forms(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_UPDATE_FORM @id=?', array($request->id));
        
        if($data){
        $array = Array();
        
        foreach ($data as $key => $value) {
            
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'forms/'.$value->attachment_path,
                'content-type' => 'inline',
                'content-disposition' => 'application/pdf'
            ]);
            

            $t1 = explode('.',$value->attachment_path);
            
            if($t1[1] == 'pdf'){
               $status = true;
            }else{
               $status = false; 
            }

          
            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $presignedUrl = (string)$request->getUri();
            $value->S3_url = $presignedUrl;
            $value->extention = $status;
            $array[] = $value;    
        }
            // return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $array[0], 'link_image' => $array[0]->S3_url, 'extension' => $array[0]->extention]);
            return view('link_form')
            ->with('data_sp', $array['0'])
            ->with('user',$user);
        }else{
            return redirect()->route('newuploadforms');
        }
    }

    public function fetch_all_forms(Request $request){
        $search_bar = $request->search_bar;
        if ($request->ajax()) {
            $data = DB::select('exec SP_FETCH_DOWNLOAD_FORM ?', array($search_bar));
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){   
                                    
                    // $btn = '<a href="#" data-image="'.$row->attachment_path.'" class="download_image">Download</a>';   
                    $btn = '<a class="btn btn-success btn-sm" id="edit" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</a>

                    <a class="btn btn-danger btn-sm" id="delete" href="#" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->addColumn('title_link', function($row){     
                    $link = '<a href="/link_forms/'.$row->id.'" data-id="'.$row->id.'" data-title="'.$row->title.'">'.$row->title.'</a>';
                    // $link = '<a href="#" data-id="'.$row->id.'" id="link_btn">'.$row->title.'</a>';
                        
                        return $link;
                })
                ->rawColumns(['action','title_link'])
                ->make(true);
        }
        return view('datatable');        
    }

    public function update_forms(Request $request){
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

        // $search_bar = '';
        // $data = DB::select('exec SP_FETCH_DOWNLOAD_FORM ?, ?', array($request->id,$search_bar));
        
        if($request->hasFile('edit_attachment_path')){
            $destination = 'Files';
            $image = $request->file('edit_attachment_path');
            $imagename = time().$image->getClientOriginalName();

            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'forms/' . $imagename,
                'Body'   => fopen($image, 'r'),
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);
        }else{
            $imagename = '';
        }
        
        $data = DB::select('exec [SP_EDIT_UPDATE_FORM] @id=?
                        ,@title=?
                        ,@attachment_path=? ', 
        array($request->id
            ,$request->edit_title
            ,$imagename));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function delete_forms(Request $request){
        $data = DB::select('exec [SP_UPDATE_FORM] @id=?,@status=?', array($request->id,2));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }
    
}
