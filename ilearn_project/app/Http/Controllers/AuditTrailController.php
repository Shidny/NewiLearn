<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AuditTrailExport;
use DataTables;

class AuditTrailController extends Controller
{
        public function index(Request $request){
            if ($request->session()->has('user')) {
                $user = $request->session()->get('user');
                return view('audit_trail')->with('user',$user);
            }else{
                return redirect()->route('Login');
            }
        }

    public function export() 
    {
        $data = DB::select('exec [SP_Audit_Trail]');
        $array = array();

        foreach ($data as $key => $value) {
            $array[] = $value;
        }
        $data_array =  [
            'success' => 'success',
            'apps' => $array,
        ];
        return Excel::download(new AuditTrailExport($data_array), 'Audit_trail.xlsx');
        // return Excel::download($data, 'audit_trail_'.$dnow.'.xlsx');
    }

    public function get_audit_trail(Request $request){
        if ($request->ajax()) {
            $data = DB::select('exec SP_Audit_Trail');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('datatable');        
    }
}
