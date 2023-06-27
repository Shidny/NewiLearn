<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;

class AttachmentController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function attachment_link(Request $request){

        $id = $request->session()->get('id');
        $title = $request->session()->get('title');
        $document_no = $request->session()->get('document_no');
        $document_owner = $request->session()->get('document_owner');
        $effectivity_date = $request->session()->get('effectivity_date');

        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');
        }

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

        $data = DB::select('exec SP_FETCH_EDIT_POLICY @id=?', array($id));
        $array = Array();
        
        foreach ($data as $key => $value) {
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

            if($array[0]->attachment){
                $s3_url = $value->S3_url;
            }else{
                $s3_url = 'assets/img/no_image.png';
            }
        }

        

        return response()->json(['status' => true, 'msg' => ['Success'], 'id' => $id, 'title' => $title, 'document_no' => $document_no, 'document_owner' => $document_owner, 'effectivity_date' => $effectivity_date, 'link' => $s3_url, 'description' => $value->description, 'attachment' => $value->attachment]);
        // $request->session()->put('url', $value->S3_url);

    }
    
}
