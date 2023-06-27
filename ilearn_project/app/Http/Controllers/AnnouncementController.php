<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;

class AnnouncementController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
            return view('announcement')->with('user',$user);
        }else{
            return redirect()->route('Login');
        }   
    }

    public function fetch_table_announcement(Request $request){
        if ($request->ajax()) {
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

            $data = DB::select('exec SP_FETCH_ANNOUNCEMENT');
            $array = array();
            
            foreach ($data as $key => $value) {
                $cmd = $s3Client->getCommand('GetObject', [
                    'Bucket' => $bucket,
                        'Key'    => 'annoucements/'.$value->orig_filename,
                ]);
                $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
                
                $presignedUrl = (string)$request->getUri();
                $value->S3_url = $presignedUrl;
                $array[] = $value;
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    if($row->status == '1'){
                    $btn = '
                      <a class="btn btn-success btn-sm" id="edit" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</a>
                      <a class="btn btn-danger btn-sm" id="deactivate" href="#" data-id="'.$row->id.'">Deactivate</a>';   
                    }
                    else{
                        $btn = '<a class="btn btn-info btn-sm" id="active" href="#" data-id="'.$row->id.'">Activate</a>
                        <a class="btn btn-danger btn-sm" id="delete" href="#" data-id="'.$row->id.'"> Delete </a>'; 
                    }
                        
                        return $btn;
                })

                ->addColumn('image', function($row){     
                    $image_link = '<img src="'.$row->S3_url.'" widht="80px" height="80px">';

                    return $image_link;
                })
                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('datatable');        
    }

    public function insert_announcement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attachment' => 'required',
        ]);

        $announcement = array(
            'attachment' => 'attachment',
            'description' => 'description',
        );

        $this->MainController->setAttributeNames($announcement);
        $validator->setAttributeNames($announcement);

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
                $imagename = time().$image->getClientOriginalName();

                $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => 'annoucements/' . $imagename,
                    'Body'   => fopen($image, 'r'),
                    'StorageClass' => 'REDUCED_REDUNDANCY'
                ]);
            }else{
                $imagename = '';
            }
            
            if($request->has('description')){
                $description = $request->description;
            }
            else{
                $description = 'null';
            }
            $attachment = $imagename;
            $row =  DB::connection('sqlsrv')->select('exec [SP_INSERT_ANNOUNCEMENT] @attachment=?,@description=?', 
            array($attachment, $description));
            if ($row) {
                    return response()->json(['status' => true, 'msg' => ['Success']]);
            } else {
                return response()->json(['status' => false, 'msg' => ['No Data']]);
            }
    }

    public function edit_announcement(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_ANNOUNCEMENT @id=?', array($request->id));
        $array = Array();
        
        foreach ($data as $key => $value) {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => 'annoucements/'.$value->orig_filename,
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

    public function update_announcement(Request $request){
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

        $data = DB::select('exec SP_FETCH_EDIT_ANNOUNCEMENT @id=?', array($request->id));
        // for image fetch 
        // dd($data);
        if($request->hasFile('edit_attachment')){
            $image = $request->file('edit_attachment');
            $imagename = time().$image->getClientOriginalName();

            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'annoucements/' . $imagename,
                'Body'   => fopen($image, 'r'),
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);
        }else{
            $imagename = $data[0]->orig_filename;
        }
        
        $data = DB::select('exec SP_EDIT_UPDATE_ANNOUNCEMENT @id=?
                        ,@description=?
                        ,@attachment=?', 
        array($request->id,$request->edit_description,$imagename));
        
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function deactivate_announcement(Request $request){
        $data = DB::select('exec SP_UPDATE_announcements @id=?,@status=?', array($request->id,2));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function delete_announcement(Request $request){
        $data = DB::select('exec SP_UPDATE_announcements @id=?,@status=?', array($request->id,3));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function active_announcement(Request $request){
        $data = DB::select('exec SP_UPDATE_announcements @id=?,@status=?', array($request->id,1));
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success']]);
        } else {
        return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

}
