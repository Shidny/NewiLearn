<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;

class HomeController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
            $user_role_id = $request->session()->get('user')->role_id;
            
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
        
        $data = DB::select('exec SP_dashboard_ANNOUNCEMENT');
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

        $categories = DB::select('exec SP_FETCH_CATEGORY_ACTIVE');
        $array_category = array();

        if ($user_role_id == 1){
            foreach($categories as $key => $categories_data){
            
                $categories_data->descrion_count = substr($categories_data->description,0,150).'<a href="/categories"> (Click More) </a>' ;
                // $array_category.$descrion_count;
                $array_category[] = $categories_data;
            }
            return view('home')->with('user',$user)->with('dashboard_item',$array)->with('category_array', $array_category);
        
        }else{
            foreach($categories as $key => $categories_data){
            
                $categories_data->descrion_count = substr($categories_data->description,0,150).'<a href="/home"> (Click More) </a>' ;
                // $array_category.$descrion_count;
                $array_category[] = $categories_data;
            }
            return view('home')->with('user',$user)->with('dashboard_item',$array)->with('category_array', $array_category);
        }
        }else{
            return view('Login');
        }
        
    }

}
