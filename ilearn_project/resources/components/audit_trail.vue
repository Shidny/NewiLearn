<template>
 <div class="pagetitle">
  <h1>Audit Trail</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button @click="audit_trail" class="btn btn-primary">Export</button>
    </div>
    <br><br>

    <table id="tbl_category" class="table table-active table-hover table-striped table-responsive" style="width:100%">
        <thead>
            <tr>
                <th>Department</th>
                <th>User</th>
                <th>Document Title</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
<!-- end: table -->   
</template>
	
<script>
import { hide } from '@popperjs/core';

export default {
    data() {
        return {
            glossary: {
                id: "",
                word_name: "",
                description: ""
            }
        }
    },

    mounted() {
        this.datatable_func();
        var vue = this;
    },

    methods: {
        datatable_func(e) {
            
            $('#tbl_category').DataTable({
                aaSorting: [
                    [3, 'desc']
                ],
                processing: true,
                destroy: true,
                serverSide: true,
                ajax: "fetch_audit_trail_table",
                columns: [

                    {data: 'Department', name: 'Department' },
                    {data: 'Fullname', name:'Fullname'},
                    {data:'title', name: 'title'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'start_time', name: 'start_time'},
                    {data: 'end_time', name: 'end_time'}
                   
                ]
            });
        },
        audit_trail(e){
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            } });
            var token = $('meta[name="csrf-token"]').attr('content');
            var today = new Date();
            var date_today = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            $.ajax({
                xhrFields: {
                    responseType: 'blob',
                },
                type: 'POST',
                url: 'download_export',
                data: {
                    _token: token
                },
                complete: function (data) {
                
                },
                success: function (result, status, xhr) {
                    setTimeout($.unblockUI, 1);
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0');
                    var yyyy = today.getFullYear();
                    var datetoday = mm + '/' + dd + '/' + yyyy;
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] : 'Audit_Trail_'+datetoday+'.xlsx');

                    // The actual download
                    var blob = new Blob([result], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;

                    document.body.appendChild(link);

                    link.click();
                    document.body.removeChild(link);

                }
            });
        }
        
    },
    
    
    
}
</script>
	