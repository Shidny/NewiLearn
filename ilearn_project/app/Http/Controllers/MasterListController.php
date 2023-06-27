<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use App\http\Controllers\MainController;
use Illuminate\Support\Facades\DB;
use Aws\S3\S3Client;

class MasterListController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {

            $data = DB::select('exec SP_FETCH_CATEGORY');
            $array = Array();
            $array['category_data'] = $data;
            $user = $request->session()->get('user');
            return view('master_list')
                ->with('entities', $array)
                ->with('user',$user);
            }else{
                return redirect()->route('Login');
            }
    }
    
    public function index2(Request $request, $search_bar)
    {
        if ($request->session()->has('user')) {

            $data = DB::select('exec SP_FETCH_CATEGORY');
            $array = Array();
            $array['category_data'] = $data;
            $array['search_data'] = $search_bar; 
            $user = $request->session()->get('user');
            
            return view('master_list')
                ->with('entities', $array)
                ->with('user',$user);
            }else{
                return redirect()->route('Login');
            }
    }

    public function index3(Request $request, $search_category)
    {
        if ($request->session()->has('user')) {

            $data = DB::select('exec SP_FETCH_CATEGORY');
            $array = Array();
            $array['category_data'] = $data;
            $array['search_category'] = $search_category; 
            $user = $request->session()->get('user');
            
            return view('master_list')
                ->with('entities', $array)
                ->with('user',$user);
            }else{
                return redirect()->route('Login');
            }
    }

    public function get_value_table(Request $request){
        $user = $request->session()->get('user');
        
        if($request->search_data){
            $data = DB::select('exec SP_FETCH_MASTER_LIST @ID=?, @SEARCH_BAR=?, @SEARCH_CATEGORY=?', array($user->role_id,$request->search_data,''));
        }
        else if($request->search_category){
            $data = DB::select('exec SP_FETCH_MASTER_LIST @ID=?, @SEARCH_BAR=?, @SEARCH_CATEGORY=?', array($user->role_id,'',$request->search_category));
        }
        else{
            $data = DB::select('exec SP_FETCH_MASTER_LIST @ID=?, @SEARCH_BAR=?, @SEARCH_CATEGORY=?', array($user->role_id,'',''));
        }
        
        return Datatables::of($data)
            ->addIndexColumn()                
            ->addColumn('title_link', function($row){ 
                    
                $link = '<a href="/title_link/'.$row->id.'" target="_blank" data-id="'.$row->id.'" data-title="'.$row->title.'" data-document_owner="'.$row->document_owner.'" data-document_no="'.$row->document_no.'" data-effectivity_date="'.$row->effectivity_date.'" style="color:blue;cursor:pointer;" id="link_btn">'.$row->title.'</a>'; 
                return $link;   
            })
            ->rawColumns(['action','title_link'])
            ->make(true);
    }

    public function master_redirect_to_pdf_view(Request $request){

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

    public function masterList(Request $request){
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

    public function category_mast(Request $request){
        $department_id = $request->department;
        $result_status =  DB::select('EXEC [SP_FETCH_CATEGORY_ACTIVE]');
        if ($result_status) {
            return response()->json(['status' => true, 'msg' => 'true','user_status' => $result_status]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_status' => '']);
        }
    }

    public function cat_filter(Request $request){
        $user = $request->session()->get('user');
        $search_bar = $request->search_bar;
        $category_id = $request->category_mast;
        $data_result =  DB::select('EXEC [SP_Masterfile_CATEGORY] ?,?,?', array($search_bar,$category_id,$user->role_id));
        return Datatables::of($data_result)
            ->addIndexColumn()                
            ->addColumn('title_link', function($row){ 
                    
                $link = '<a href="/title_link/'.$row->id.'" target="_blank" data-id="'.$row->id.'" data-title="'.$row->title.'" data-document_owner="'.$row->document_owner.'" data-document_no="'.$row->document_no.'" data-effectivity_date="'.$row->effectivity_date.'" style="color:blue;cursor:pointer;" id="link_btn">'.$row->title.'</a>';
                return $link;    
            })
            ->rawColumns(['action','title_link'])
            ->make(true);
    }
}
