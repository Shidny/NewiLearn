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

    #image_link{
        width: 100px;
    }
</style>

<template> 
<div class="pagetitle">
  <h1 id="title_header">Category Summary</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="container">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" id="cat_create" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_modal"> New Category </button>
    </div>
    <br>

    
        <div class="row ml-lg-auto mb-2" id="search_style">
            <h5 for="search">Search Category</h5>
            <div class="col-md-11">
                
                <input type="text" class="form-control form-control-sm mb-4" name="search_bar" id="search_bar">
            </div>
            <div class="col-md-1">
                <button @click="btn_filter()"  class="btn btn-primary btn-sm mb-4">Search</button>
            </div>
        </div>
    </div>
    <br>

    <table id="tbl_category" class="table table-active table-hover table-striped table-responsive" style="width:100%">
        <thead id="table_header">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Date Created</th>
                <th>Date Updated</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
<!-- end: table -->

<!-- add category modal -->
<section>
<!-- Modal -->
<div class="modal fade" id="add_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Category</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="category_form">
            <div class="row ml-md-auto">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Category Name <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" v-model="this.category.category_name" name='category_name' placeholder="Category Name">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Status <span class="text-danger">*</span></strong></label>
                        <select name="status" id="status" class="form-control">
                            <option disabled selected>--SELECT STATUS-- </option>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlFile1"><strong>Icon <span class="text-danger">*</span></strong></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="icon" name="icon" multiple accept="image/*">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12 mb-2">
                    <div class="form-group">
                        <label><strong>Description <span class="text-danger">*</span></strong></label>
                        <textarea name="description" v-model="this.category.desc" cols="5" rows="5" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <label><strong>Role Lists </strong></label>
                    <table id="cat_create_table" class="table table-bordered data-table-level table-responsive mb-2" style="width:100%">
                        <thead>
                        <tr>
                            <th width="1px"></th>
                            <th width="99px">Access Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
        <button @click="category_btn()" class="btn btn-primary">Submit 
        </button>
      </div>
    </div>
  </div>
</div>
</section>
<!-- end of add modal -->

<!-- edit modal -->
<section>
    <div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Category</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="category_form_edit">
          <div class="row ml-md-auto">
              <div class="col-lg-12">
                  <div class="form-group">
                      <label><strong>Category Name <span class="text-danger">*</span></strong></label>
                      <input type="text" class="form-control" name='edit_category_name' id='edit_category_name' placeholder="Category Name">
                  </div>
              </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Status <span class="text-danger">*</span></strong></label>
                        <select name="edit_status" id="edit_status" class="form-control">
                            <option value="" selected disabled>Select Here</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                            <option value="3">Deleted</option>
                        </select>
                    </div>
                </div>
                
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlFile1"><strong>Icon <span class="text-danger">*</span></strong></label>
                        <div class="custom-file">
                                <img id="filepaths" width="80px" height="50px">
                            <input type="file" class="custom-file-input" id="edit_icon" name="edit_icon" multiple accept="image/*">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                
                    <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Description <span class="text-danger">*</span></strong></label>
                        <textarea name="edit_description" id="edit_description" cols="5" rows="5" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <label><strong>Role Lists </strong></label>
                    <table id="edit_cat_create_table" class="table table-bordered data-table-level table-responsive mb-2" style="width:100%">
                        <thead>
                        <tr>
                            <th width="1px"></th>
                            <th width="99px">Access Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                    <div class="col-lg-12 pt-md-4">
                        <div class="form-group">
                            
                        </div>
                    </div>
            </div>
        </form>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
        <button @click="update_btn()" class="btn btn-primary">Submit 
        </button>
      </div>
    </div>
  </div>
</div>
</section>
<!-- end of edit modal -->

<!-- access right modal -->
<section>
<!-- Modal -->
<div class="modal fade" id="access_right_level" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Access Rights</h5>
      </div>
      <div class="modal-body">
        <form class="form-category" id="access_level_form">
            <table id="access_level_table" class="table table-bordered data-table-level table-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th width="5px"></th>
                        <th width="95px">Access Name</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</section>

<!-- Link polic modal -->
<!-- Modal -->
<div class="modal fade" id="category_link" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Policy Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row ml-md-auto">
            <div class="col-lg-6 m">
                <div class="form-group">
                    <img src="/Files/RFC.png" alt="RFC Policy Portal" title="RFC Policy Portal" style="float: center; padding-right: 15px; height: 80px;" />
                </div>
            </div>
        
            <div class="col-lg-6">
                <h3>Attachment:</h3>
                <div class="col-lg-12">
                    <img id="image_link" class="mb-2">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-md-12 mb-2"><b>Name:</b> {{ category.category_name }}</div>
                    <div class="col-md-12 mb-2"><b>Status:</b> {{ category.status }}   </div>
                    <div class="col-md-12 mb-2"><b>Description:</b> {{ category.description }} </div>
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
import { hide } from '@popperjs/core';

export default {
    // declaration of valuable for vue.js
    data(){
        return{
            category:{
                id: "",
                category_name: "",
                status: "",
                icon: "",
                desc: ""
            },
            status_name:[],
        }
    },
    // declaration of function for vue.js
    mounted() {
        this.datatable_func();
        // this.datatable_func_level();
        this.status_name = window.entities.status_name;

        var vue = this;
        $(document).on('click','#delete', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.delete_btn();
        })
        // create event to fetch data in datatable
        $(document).on('click','#active', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.active_btn();
        })

        $(document).on('keyup','#search_bar', function (e) {
            if ($("#search_bar").is(":focus") && e.key == "Enter") {
                vue.btn_filter();
            }
            
        })
        
        $(document).on('click','#retrive', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.retrive_btn();
        })

        $(document).on('click','#edit', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.edit_btn();
        })

        $(document).on('click','#update_btn', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.update_btn();  
        })

        $(document).on('click','#cat_level', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.access_level_btn();  
            
        })

        $(document).on('click','#link_btn', function (e) {
            var id = $(this).attr('data-id');
            vue.category.id = id;
            vue.link_btn();

        })

        $("#status").empty();
        $.ajax({
            url: "GET_STATUS_MASTERFILE",
            success: function (data) {
                if (data.status == true) {
                    $("#status").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT STATUS--'+'</option>');
                    $.each(data.user_status, function (key, value) {
                        $("#status").append('<option '+'value="'+value.id+'">'+value.status_name +'</option>');
                    });
                }
            }
        });
    },
    // execution of function when the event is click

    methods:{
        
    category_btn(e) {
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });

        var myArray = [];
        $(".chk_cat_access:checked").each(function() {
        myArray.push(this.value);
        });

        // console.log(myArray);

       var post_form = $("#category_form")[0];
       var data = new FormData(post_form);
       var validation_msg = "";
       data.append("_token", $('meta[name="csrf-token"]').attr("content"));
       data.append("cat_access_level", myArray);
       $("#category_form :input").prop("disabled", true);
       var cat_access_id = $(this).attr('cat_id_access');
       $('#add_modal').modal('hide');
       $("#category_form")[0].reset();

      
        $.ajax({
            url: "insert_categories",
            type: "POST",
            data: data,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            complete: function (data) {
                
            $("#category_form :input").prop("disabled", false);
            
            },
            success: function (data) {
                setTimeout($.unblockUI, 1);
                $('#tbl_category').DataTable().ajax.reload();
                    if (data.status) {
                        $('#add_modal').hide();
                        Swal.fire('Category Added!')
                        $('#tbl_category').DataTable().ajax.reload();    
                        $('.btn_closed').trigger('click');
                    }
                    else{
                        $('#validation_msg').html('');
                        validation_msg += `<div class="alert alert-danger "><ul>`;
                        $.each(data.msg, function (key, value) {
                        validation_msg += '<li>' + value + '</li>';
                        });
                        $('#validation_msg').append(validation_msg)
                    }
            },
                error: function (data) {
            },
        });
        },
        active_btn(e){
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });
            var id = this.category.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "active_category",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#category_form :input").prop("disabled", false);
                },
                success: function (data) {
                $('#tbl_category').DataTable().ajax.reload();
                setTimeout($.unblockUI, 1);
                
                Swal.fire(
                        'Active!')
                },
                    error: function (data) {
                },
            });
        },
        retrive_btn(e){
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });
            var id = this.category.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "active_category",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#category_form :input").prop("disabled", false);
                },
                success: function (data) {
                    setTimeout($.unblockUI, 1);
                $('#tbl_category').DataTable().ajax.reload();
                
        
                Swal.fire('Retrive Data!')
                },
                    error: function (data) {
                },
            });
        },
        delete_btn(e){
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });

            var id = this.category.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "delete_category",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#category_form :input").prop("disabled", false);
                },
                success: function (data) {
                    setTimeout($.unblockUI, 1);
                    $('#tbl_category').DataTable().ajax.reload();
                    Swal.fire(
                            'Inactive!')
                },
                    error: function (data) {
                },
            });
        },
        edit_btn(e){
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });
            var id = this.category.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "edit_category",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#category_form :input").prop("disabled", false);
                    setTimeout($.unblockUI, 1);
                },
                success: function (data) {
                    $('#filepaths').attr('src',data.image);
                    $('#edit_category_name').val(data.data.category_name);
                    $('#edit_status').val(data.data.status);
                    $('#edit_description').val(data.data.description);
                    $('#update_btn').attr('data-id', data.data.id);
                    // setTimeout($.unblockUI, 1);
                },
                error: function (data) {
                },
            });
        },
        update_btn(e){

        var edit_array = [];
            $(".edit_checkbox:checked").each(function() {
            edit_array.push(this.value);
        });

        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });
            var id = this.category.id;
            var post_form = $("#category_form_edit")[0];
            var data = new FormData(post_form);
            data.append("_token", $('meta[name="csrf-token"]').attr("content"));
            data.append('id', id);      
            data.append("edit_cat_access_level", edit_array);
            $("#category_form_edit :input").prop("disabled", true);
            $('#edit_modal').modal('hide');
            
            $.ajax({
                url: "update_categories",
                type: "POST",
                data: data,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                complete: function (data) {
                $("#category_form_edit :input").prop("disabled", false);
                    
                },
                success: function (data) {
                setTimeout($.unblockUI, 1);
                $('#tbl_category').DataTable().ajax.reload();
                    if (data.status) {
                        $('#edit_modal').hide();
                        Swal.fire('Edit Added!');
                        $('#tbl_category').DataTable().ajax.reload();    
                        $('.btn_closed').trigger('click');
                    }
                    else{
                        $('#validation_msg').html('');
                        validation_msg += `<div class="alert alert-danger "><ul>`;
                        $.each(data.msg, function (key, value) {
                        validation_msg += '<li>' + value + '</li>';
                        });
                        $('#validation_msg').append(validation_msg)
                    }
                },
                error: function (data) {
                },
            });
        },
        btn_filter(e){     
            var search_bar = $('#search_bar').val();
            $('#tbl_category').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            searching: false,
            ajax: {
                url:"getcat_filter_table",
            
            data: function(data) {
                data.search_bar = search_bar 
                }
            },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'status_name', name: 'status_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},     
                    {data: 'action', name: 'action'},    
                ]
            });
        },
        link_btn(e) {
            var vue = this
            var id = this.category.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
            url: "link_category",
            type: "POST",
            data: data,
            dataType: "json",
            complete: function (data) {
            },
            success: function (data) {
                vue.category.category_name = data.data.category_name;
                vue.category.status = data.data.status_name;
                vue.category.description = data.data.description;
                $('#image_link').attr('src',data.link_image);
            },
            error: function (data) {
            },
            });

            $.ajax({
            url: "audit_trail_click",
            type: "POST",
            data: data,               
            });  
        },
        datatable_func(e){
            $('#tbl_category').DataTable({
            "aaSorting": [[ 4, "desc" ]],
            processing: true,
            destroy: true,
            serverSide: true,
            searching:   false,
            ajax: "get_value_table",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'category_link', name: 'category_link'},
                {data: 'status_name', name: 'status_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},     
                {data: 'action', name: 'action'},
            ]
            });
            // for new create
            $(document).on('click', '#cat_create', function(){
                // alert('for test');
                $('#cat_create_table').DataTable({
                processing: true,
                destroy: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bInfo : false,
                searching:   false,
                ajax: "cat_create_fetch",
                columns: [
                    {data: 'action', name: 'action'},
                    {data: 'role_class_name', name: 'role_class_name'},
                ]
                });
            });

            $(document).on('click', '#edit', function(){
                
                // alert('for test');
                let catid = $(this).data("id")
                $('#edit_cat_create_table').DataTable({
                processing: true,
                destroy: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bInfo : false,
                searching:   false,
                ajax: {
                        url: "edit_cat_create_fetch",
                        data: function(d) {
                            d.cat_id = catid
                        }
                    },
                // ajax: "edit_cat_create_fetch",
                columns: [
                    {data: 'action', name: 'action'},
                    {data: 'role_class_name', name: 'role_class_name'},
                ]
                });
            });
            // access_level_btn(e){    
        // $.blockUI({ css: { 
        //     border: 'none', 
        //     padding: '15px', 
        //     backgroundColor: '#000', 
        //     '-webkit-border-radius': '10px', 
        //     '-moz-border-radius': '10px', 
        //     opacity: .5, 
        //     color: '#fff' 
        // } });
        //     var id = this.category.id;
        //     var post_form = $("#access_level_form")[0];
        //     var data = new FormData(post_form);
        //     data.append("_token", $('meta[name="csrf-token"]').attr("content"));
        //     data.append('id', id);      
        //     $("#access_level_form :input").prop("disabled", true);

        //     $.ajax({
        //         url: "update_access_level",
        //         type: "POST",
        //         data: data,
        //         dataType: "json",
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         complete: function (data) {
        //         $("#access_level_form :input").prop("disabled", false);
                
        //         },
        //         success: function (data) {
        //             if (data.status) {
        //                 $('#access_level').hide();
        //                 Swal.fire('Updated Access Level!')
        //                 $('#tbl_category').DataTable().ajax.reload();    
        //                 $('.btn_closed').trigger('click');
        //                 setTimeout($.unblockUI, 1);
        //             }
        //             else{
        //             }
        //         },
        //         error: function (data) {
        //         },
        //     });
        // },
            // for access level button
            // $('#tbl_category').on('click', '#catlevel', function(){
            // let catid = $(this).data("id")
            //    $('#access_level_table').DataTable({
            //         aaSorting: [
            //             [1, 'asc']
            //         ],
            //         destroy: true,
            //         processing: true,
            //         serverSide: true,
            //         stateSave: false,
            //         paging: true,
            //         lengthChange: false,
            //         searching:   false,
            //         ordering: true,
            //         info:     true,
            //         responsive: true,
            //         ajax: {
            //             url: "category_session",
            //             data: function(d) {
            //                 d.cat_id = catid
            //             }
            //         },
            //         columns: [
            //             {
            //                 "data": "action"
            //             },
                        
            //             {
            //                 "data": "role_class_name"
            //             }
            //         ],
            //         columnDefs: [{
            //                 className: "center",
            //                 "targets": [0]
            //             },
            //             {
            //                 className: "center",
            //                 "targets": [1]
            //             },
            //         ],
            //         "drawCallback": function(settings) {}
            //     });
            // });

            // $('#access_level_table').on('click', '#chk_access', function(){
            //     let access_level = "&access_id=" + $(this).data('accessid') + "&_token=" + $('meta[name="csrf-token"]').attr('content');

            //         $.ajax({url: "update_access_level",data: access_level});
            // });
            
            // $('#cat_create_table').on('click', '#chk_cat_access', function(){
            //     let cat_access_level = "&cat_access_id=" + $(this).data('cat_id_access') + "&_token=" + $('meta[name="csrf-token"]').attr('content');

            //         $.ajax({url: "update_cat_access_level",data: cat_access_level});
            // });
        },
    },
}

</script>
	
