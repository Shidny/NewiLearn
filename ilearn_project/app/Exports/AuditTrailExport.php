<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Libraries\Helper;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuditTrailExport implements FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.export_audit_trail', $this->data);
        // return (new InvoicesExport)->download('invoices.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

}
