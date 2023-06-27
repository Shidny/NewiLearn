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
</style>

<template>
<div class="pagetitle">
  <h1 id="title_header">Department Management</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#add_modal"> Create Department </button>
        </div>
        <br>
        <div class="row ml-lg-auto" id="search_style">
            <label> Search Department </label>       
            <div class="col-md-5">
            <select name="filter_department" id="department_id" class="form-control form-control-sm mb-2">    
            </select>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control form-control-sm mb-2" name="search_bar" id="search_bar">
            </div>
            <div class="col-md-2">
                <button @click="btn_filter()"  class="btn btn-primary btn-sm mb-2">Search</button>
            </div>
        </div>    
    </div>
    <br>

    <table id="tbl_category" class="table table-active table-hover table-striped table-responsive" style="width:100%">
        <thead id="table_header">
            <tr>
                <th>Department Name</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th width="18%">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
<!-- end: table -->
<section>
<!-- Modal -->
<div class="modal fade" id="add_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create User</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="department_form">
            <div class="row ml-md-auto">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><strong> Department Name <span class="text-danger">*</span></strong></label>
                        <input type="text" name="department_name" id="section" class="form-control">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_closed" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button @click="department_btn()" class="btn btn-primary">Submit 
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Department</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="edit_department_form">
            <div class="row ml-md-auto">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label><strong>Department Name <span class="text-danger">*</span></strong></label>
                        <input type="text" name="edit_department" id="edit_department" class="form-control">
                    </div>
                </div>

            </div>
        </form>  
      </div>
      <div class="modal-footer">
        <button type="button" id='btn_closed' class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button @click="update_btn()" class="btn btn-primary">Submit 
        </button>
      </div>
    </div>
  </div>
</div>
</section>
<!-- end of edit modal -->
</template>
	
<script>
    export default {
			data(){
                return{
                    department:{
                        id: "",
                        section: "",
                        department: "",
                    },                        
                }
            },
            
            mounted() {
                this.datatable_func();
                var vue = this;
               
                $(document).on('keyup','#search_bar', function (e) {
                    if ($("#search_bar").is(":focus") && e.key == "Enter") {
                        vue.btn_filter();
                    }
                })

                $(document).on('click','#edit', function (e) {
                    var id = $(this).attr('data-id');
                    vue.department.id = id;
                    vue.fetch_btn();
                })  
                $(document).on('click','#delete', function (e) {
                    var id = $(this).attr('data-id');
                    vue.department.id = id;
                    vue.delete_btn();
                })
                
                $(document).on('click','#deactivate', function (e) {
                    var id = $(this).attr('data-id');
                    vue.department.id = id;
                    vue.deactivate();
                })

                $(document).on('click','#activate', function (e) {
                var id = $(this).attr('data-id');
                    vue.department.id = id;
                    vue.activate_btn();
                })

                $("#department_id").empty();
                $.ajax({
                    url: "dropdown_department",
                    success: function (data) {
                        if (data.status == true) {
                            $("#department_id").append('<option '+'value="'+''+'"selected>'+'SELECT Department'+'</option>');
                            $.each(data.dropdown_partment, function (key, value) {
                                $("#department_id").append('<option '+'value="'+value.id+'">'+value.department +'</option>');
                            });
                        }
                    }
                });
                   
            },

			methods:{
				test: function (evt) {
					var vue = this                    
                    // console.log(this.category_data)	
				},
              
                department_btn(e) {
                    var post_form = $("#department_form")[0];
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    $("#department_form :input").prop("disabled", true);
                    $("#department_form")[0].reset();

                        $.ajax({
                        url: "insert_department",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                        $("#department_form :input").prop("disabled", false);

                        },
                        success: function (data) {
                        $('#tbl_category').DataTable().ajax.reload();
                            if (data.status) {
                                Swal.fire('Successful Created!')
                                $('#btn_closed').trigger('click');
                            }
                            else{
                                Swal.fire('Failed');
                            }
                        },
                        error: function (data) {
                        },
                    });
                },

                fetch_btn(e) {
                    var vue = this
                    var id = this.department.id
                    console.log(id);
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }
                        $.ajax({
                            url: "fetch_department",
                            type: "POST",
                            data: data,
                            dataType: "json",
                            complete: function (data) {
                            
                            },
                                success: function (data) {
                                    // vue.edit_department_id = data.data.department_id;
                                    $('#edit_department').val(data.data.department);
                                },
                                error: function (data) {
                                },
                        });    
                }, 
                
                update_btn(e) {
                    var id = this.department.id;
                    var post_form = $("#edit_department_form")[0];
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    data.append('id', id);      
                    $("#edit_department_form :input").prop("disabled", true);
                    $('#edit_modal').modal('hide');

                    $.ajax({
                        url: "update_department",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                            $("#edit_department_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                            if (data.status) {
                                $('#edit_modal').hide();
                                Swal.fire('Successful Updated!')
                                $('#tbl_category').DataTable().ajax.reload();    
                                $('#btn_closed').trigger('click');
                            }
                            else{
                                // Swal.fire('PLease Try Again')
                                // $('#edit_modal').show();
                            }
                        },
                        error: function (data) {
                        },
                    });
                },
                
                delete_btn(e) {
                    var id = this.department.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "delete_department",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_department_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                            $('#tbl_category').DataTable().ajax.reload();
                            Swal.fire('Successful Deleted!')
                        },
                            error: function (data) {
                        },
                    });
                },

                deactivate(e) {
                    var id = this.department.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "deactivate_department",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_department_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                            $('#tbl_category').DataTable().ajax.reload();
                            Swal.fire('Successful Deactivated!')
                        },
                            error: function (data) {
                        },
                    });
                },

                
                activate_btn(e){
                    var id = this.department.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "activate_department",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_department_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                        $('#tbl_category').DataTable().ajax.reload();
                        
                        Swal.fire('Successful Activated!')
                        },
                            error: function (data) {
                        },
                    });
                },
                
                btn_filter(e){     
                    var filter_department = $('#department_id').val();
                    var search_bar = $('#search_bar').val();
                    $('#tbl_category').DataTable({
                    "aaSorting": [[ 2, "desc" ]],
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url:"department_form_filter",
                    
                    data: function(data) {
                        data.filter_department = filter_department,
                        data.search_bar = search_bar 
                        }
                    },
                        columns: [
                            {data: 'department', name: 'department'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},     
                            {data: 'action', name: 'action'},
                        ]
                    });
                },

                datatable_func(e){
                    $('#tbl_category').DataTable({
                    processing: true,
                    "aaSorting": [[ 2, "desc" ]],
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    ajax: "display_department",
                        columns: [
                          
                            {data: 'department', name: 'department'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},     
                            {data: 'action', name: 'action'},
                        ]
                    });
                }
			},
		}
</script>
	