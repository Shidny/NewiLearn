<style>
    #title_header {
        border: 1px solid black; 
        width: 30%; 
        text-align: center; 
        padding: 10px; 
        border-radius: 25px 10px ; 
        background-color: gray; 
        color: white;
        font-family: Arial;
    }

    #search_style {
        border: 1px solid black; 
        width: 102%;  
        padding: 10px; 
        border-radius: 7px; 
        background-color: lightgoldenrodyellow; 
        color: black;
    }

    #table_header{
        background-color: lightslategray;
        color: white;
    }
    #iframe_pdf{
      
        display: block;
        pointer-events: none;
        width: 100%;
        height: 200vh;
        overflow-x: hidden  !important;
        border: none;
    }
</style>
<template>
<div class="pagetitle">
  <h1 id="title_header">Forms</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="row ml-lg-auto mb-2" id="search_style">
        <h3 for="search">Search Forms</h3>
        <div class="col-md-11">
            
            <input type="text" class="form-control form-control-sm mb-4" name="search_bar" id="search_bar">
        </div>
        <div class="col-md-1">
            <button @click="btn_filter()"  class="btn btn-primary btn-sm mb-4">Search</button>
        </div>
    </div>
    <table id="tbl_category" class="table table-active table-hover table-responsive" style="width:100%">
        <thead id="table_header">
            <tr>
                <th>Title</th>
                <th>Date Created</th>
                <th>Date Updated</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
<!-- end: table -->
<!-- Link polic modal -->
<!-- Modal -->
<div class="modal fade" id="title_link" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Policy Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row ml-md-auto">        
            <div class="col-lg-12">
                <h3>Attachment:</h3>
                <div class="col-lg-12">
                    <iframe id="iframe_pdf"></iframe>
                </div>
                
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end -->
</template>

<script>
export default {
    data(){
        return{
            upload:{
                id: "",
                title: "",
                attachment_path: ""
            },
            // category_data:[],
        }
    },
    
    mounted() {
        this.datatable_func();
        var vue = this;      

        $(document).on('keyup','#search_bar', function (e) {
            if ($("#search_bar").is(":focus") && e.key == "Enter") {
                vue.btn_filter();
            }
        });

        $(document).on('click','#link_btn', function (e) {
            var id = $(this).attr('data-id');
            vue.upload.id = id;
            vue.link_btn();

        });
        
        $(document).on("click", ".download_image", function (e) {
            e.preventDefault();
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            } });
        
            var url = $(this).attr('data-image');
            $.ajax({
                xhrFields: {
                responseType: 'blob',
                },
                type: 'POST',
                url: 'files_url',
                data: {
                url:url,
                _token: $('meta[name="csrf-token"]').attr('content')
                },
                complete: function (data) {
                    setTimeout($.unblockUI, 1);
                },
                success: function (blob, status, xhr) {
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }
        
                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);
            
                        if (filename) {
                        var a = document.createElement("a");
                            if (typeof a.download === 'undefined') {
                                window.location.href = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.click();
                            }
                        } else {
                            window.location.href = downloadUrl;
                        }
                        setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 5); // cleanup
                    }
                }
            });
        });  
                
    },
    methods:{
        test: function (evt) {
            var vue = this                    
            // console.log(this.category_data)	
        },
        btn_filter(e){     
            var search_bar = $('#search_bar').val();
            $('#tbl_category').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            searching: false,
            ajax: {
                url:"getdownload_form_filter",
            
            data: function(data) {
                data.search_bar = search_bar 
                }
            },
                columns: [
                    {data: 'title_link', name: 'title_link'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},     
                    {data: 'action', name: 'action'},    
                ]
            });
        },
        link_btn(e) {
            // alert('for test');
            var vue = this
            var id = this.upload.id
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
            url: "link_forms",
            type: "POST",
            data: data,
            dataType: "json",
            complete: function (data) {
            
            },
            success: function (data) {
                // vue.policy.attachment = data.data.attachment;
                // $('#iframe_pdf').attr('src',data.image);
                if (data.extension) {
                    $('#title_link').modal('show');
                    $('#iframe_pdf').attr('src',data.link_image+'#toolbar=0');  
                   
                }else{
                    $('#iframe_pdf').attr('src',data.link_image+'#toolbar=0');  
                }
            },
            error: function (data) {
            },
            });
        },
        datatable_func(e){
            $('#tbl_category').DataTable({
                "aaSorting": [[ 1, "desc" ]],
                processing: true,
                serverSide: true,
                searching: false,
                ajax: "getdownload_form",
                columns: [
                    
                    {data: 'title_link', name: 'title_link'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},     
                    {data: 'action', name: 'action'},
                ]
            });
        }
    },
}		

</script>