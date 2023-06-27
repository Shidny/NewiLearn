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
  <h1 id="title_header">User Management</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary btn-sm mb-2" @click="new_user" data-bs-toggle="modal" data-bs-target="#add_modal"> Create New User </button>
        </div>
        <br>
        <div class="row ml-lg-auto" id="search_style">
            <label> Search Department </label>       
            <div class="col-md-5">
            <select name="department" id="department_id" class="form-control form-control-sm mb-2">    
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
                <th>Role</th>
                <th>Department</th>
                <th>FullName</th>
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
        <form class="form-category" id="user_form">
            <div class="row ml-md-auto">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label><strong>FirstName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='firstname' placeholder="FirstName">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label><strong>MiddleName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='middlename' placeholder="MiddleName">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label><strong>LastName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='lastname' placeholder="LastName">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Employee ID No.
                             <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='username' placeholder="(This will served as your login)">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Email <span class="text-danger">*</span></strong></label>
                        <input type="email" class="form-control" name='email' placeholder="Email">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Password
                             <span class="text-danger">*</span></strong></label>
                        <input type="password" class="form-control" name='password' placeholder="Password">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Role
                             <span class="text-danger">*</span></strong></label>
                        <select name="role_name" id="role" class="form-control">
                            <option disabled selected>--SELECT STATUS-- </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Position <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='position' placeholder="Position">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Department
                            <span class="text-danger">*</span></strong></label>
                            <select @change="department_section" class="form-control" name="department_name" id="department"></select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Section <span class="text-danger">*</span></strong></label>
                        <select class="form-control" name="section_name" id="section">
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Division <span class="text-danger">*</span></strong></label>
                        <select name="division_name" id="division" class="form-control"></select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Status <span class="text-danger">*</span></strong></label>
                        <select name="status_name" id="status" class="form-control">
                            <option disabled selected>--SELECT STATUS-- </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_closed" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button @click="user_btn()" class="btn btn-primary">Submit 
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
        <h5 class="modal-title" id="staticBackdropLabel">Update Policy</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="edit_user_form">
            <div class="row ml-md-auto">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label><strong>FirstName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='edit_firstname'  id='edit_firstname'>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label><strong>MiddleName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='edit_middlename' id="edit_middlename">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label><strong>LastName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='edit_lastname' id="edit_lastname">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Employee ID No.
                             <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='edit_username' id="edit_username">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Email <span class="text-danger">*</span></strong></label>
                        <input type="email" class="form-control" name='edit_email' id='edit_email'>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Password
                             <span class="text-danger">*</span></strong></label>
                        <input type="password" class="form-control" name='edit_password' id="edit_password">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Role
                             <span class="text-danger">*</span></strong></label>
                        <select name="edit_role_name" id="edit_role" class="form-control">

                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Position <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='edit_position' id='edit_position'>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Department
                            <span class="text-danger">*</span></strong></label>
                            <select @change="department_section_edit" class="form-control" name="department_name_edit" id="edit_department"></select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Section <span class="text-danger">*</span></strong></label>
                        <select class="form-control" name="edit_section_name" id="edit_section">
                            <option disabled selected> --SELECT SECTION-- </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Division <span class="text-danger">*</span></strong></label>
                        <select name="division_id" id="division_id" class="form-control"></select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Status <span class="text-danger">*</span></strong></label>
                        <select name="status_name_edit" id="status_id" class="form-control">
                        </select>
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
                    users:{
                        id: "",
                        username: "",
                        password: "",
                        firstname: "",
                        middlename: "",
                        lastname: "",
                        email: "",
                        position: "",
                        section: "",
                        division: "",
                        department: "",
                        status: "", 
                    },    
                    edit_section_id:"",
                    edit_department_id:"",
                    global_div:"",
                    global_sec:"",
                    edit_role_id:"",
                    
                }
            },
            
            mounted() {
                this.datatable_func();
                this.status_name = window.entities.status_name;
                this.department_name = window.entities.department;
                var vue = this;
               
                $(document).on('keyup','#search_bar', function (e) {
                    if ($("#search_bar").is(":focus") && e.key == "Enter") {
                        vue.btn_filter();
                    }
                })

                $(document).on('click','#edit', function (e) {
                    var id = $(this).attr('data-id');
                    vue.users.id = id;
                    vue.fetch_btn();
                })  
                $(document).on('click','#delete', function (e) {
                    var id = $(this).attr('data-id');
                    vue.users.id = id;
                    vue.delete_btn();
                })   
                $(document).on('click','#active', function (e) {
                var id = $(this).attr('data-id');
                    vue.users.id = id;
                    vue.active_btn();
                })

                $("#department_id").empty();
                $.ajax({
                    url: "dropdown_department",
                    success: function (data) {
                        if (data.status == true) {
                            $("#department_id").append('<option '+'value="'+''+'"selected>'+'SELECT Department'+'</option>');
                            $.each(data.user_status, function (key, value) {
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
                new_user(e){
                    $("#department").empty();
                    $.ajax({
                        url: "GET_DEPARTMENT_MASTERFILE",
                        success: function (data) {
                            if (data.status == true) {
                                $("#department").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT DEPARTMENT--'+'</option>');
                                $.each(data.user_department, function (key, value) {
                                    $("#department").append('<option '+'value="'+value.id+'">'+value.department +'</option>');
                                });
                            }
                        }
                    });

                    $("#division").empty();
                    $.ajax({
                        url: "GET_DIVISION_MASTERFILE",
                        success: function (data) {
                            if (data.status == true) {
                                $("#division").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT DIVISION--'+'</option>');
                                $.each(data.user_division, function (key, value) {
                                    $("#division").append('<option '+'value="'+value.id+'">'+value.division +'</option>');
                                });
                            }
                        }
                    });

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
                    
                    $("#role").empty();
                    $.ajax({
                        url: "GET_ROLE_MASTERFILE",
                        success: function (data) {
                            if (data.status == true) {
                                $("#role").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT STATUS--'+'</option>');
                                $.each(data.user_role, function (key, value) {
                                    $("#role").append('<option '+'value="'+value.id+'">'+value.role_class_name +'</option>');
                                });
                            }
                        }
                    });
                },
                
                department_section(e){
                    let department_section = "department=" + $("#department").val() + "&_token=" + $('meta[name="csrf-token"]').attr('content');
                    $("#section").empty();
                    $.ajax({
                        url: "GET_SECTION_MASTERFILE",
                        data:department_section,
                        success: function (data) {
                            
                            if (data.status == true) {
                                $("#section").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT SECTION--'+'</option>');
                                $.each(data.user_section, function (key, value) {
                                    $("#section").append('<option '+'value="'+value.id+'">'+value.section +'</option>');
                                });
                            }
                        }
                    });
                },
                user_btn(e) {
                    var post_form = $("#user_form")[0];
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    $("#user_form :input").prop("disabled", true);

                        $.ajax({
                        url: "insert_user",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                        $("#user_form :input").prop("disabled", false);

                        },
                        success: function (data) {
                        $('#tbl_category').DataTable().ajax.reload();
                            if (data.status) {
                                Swal.fire('Created Successful')
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

                department_section_edit(e){
                    var vue = this;
                    console.log(vue.edit_section_id);
                    $('#edit_section').empty();
                    let department_section_edit = "edit_department=" + $('#edit_department').val() + "&_token=" + $('meta[name="csrf-token"]').attr('content');    
                    $.ajax({
                        url: "GET_SECTION_ID",
                        data:department_section_edit,
                        complete: function (data) {
                            // $('#edit_section').val(vue.edit_section_id);
                        },
                        success: function (data) {
                            // console.log(data.user_section);
                            if (data.status == true) {  
                                $.each(data.user_section, function (key, value) {
                                    $("#edit_section").append('<option '+'value="'+value.id+'">'+value.section +'</option>');
                                });
                            }
                        }
                    });
                },

                fetch_btn(e) {
                    var vue = this
                    var id = this.users.id
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                        $.ajax({
                            url: "edit_users",
                            type: "POST",
                            data: data,
                            dataType: "json",
                            complete: function (data) {
                             $('#edit_section').empty();
                                var department_section_edit = "edit_department=" + vue.edit_department_id + "&_token=" + $('meta[name="csrf-token"]').attr('content');    
                                $.ajax({
                                    url: "GET_SECTION_ID",
                                    data:department_section_edit,
                                    complete: function (data) {
                                        $('#edit_section').val(vue.edit_section_id);
                                        console.log(vue.edit_department_id)
                                    },
                                    success: function (data) {
                                        // console.log(data.user_section);
                                        if (data.status == true) {  
                                            $.each(data.user_section, function (key, value) {
                                                $("#edit_section").append('<option '+'value="'+value.id+'">'+value.section +'</option>');
                                            });
                                        }
                                    }
                                });
                            },
                                success: function (data) {

                                vue.global_div = data.data.division;
                                vue.edit_section_id = data.data.section;
                                vue.edit_department_id = data.data.department;
                                vue.edit_role_id = data.data.role_id;

                                $('#edit_firstname').val(data.data.firstname);
                                $('#edit_middlename').val(data.data.middlename);
                                $('#edit_lastname').val(data.data.lastname);
                                $('#edit_username').val(data.data.username);
                                // $('#division_id').val(vue.global_div);
                                $('#edit_email').val(data.data.email);
                                $('#edit_role').val(data.data.role_id);
                                $('#edit_department').val(data.data.department);
                                $('#edit_position').val(data.data.position);
                                
                                $('#status_id').val(data.data.status);
                                // $('#edit_section').val(data.data.section);
                                   
                                },
                                error: function (data) {
                                },
                        });    
                    
                    // edit role
                    $("#edit_role").empty();
                    $.ajax({
                        url: "GET_ROLE_MASTERFILE",
                        complete: function (data) {
                            $('#edit_role').val(vue.edit_role_id);
                        },
                        success: function (data) {
                            if (data.status == true) {  
                                $.each(data.user_role, function (key, value) {
                                    $("#edit_role").append('<option '+'value="'+value.id+'">'+value.role_class_name +'</option>');
                                });
                                // vue.department_section_edit();
                            }
                        }
                        // success: function (data) {
                        //     if (data.status == true) {
                        //         $.each(data.user_role, function (key, value) {
                        //             $("#edit_role").append('<option '+'value="'+value.id+'">'+value.role_class_name +'</option>');
                        //         });
                        //     }
                        // }
                    });

                    $("#edit_department").empty();
                    $.ajax({
                        url: "GET_DEPARTMENT_MASTERFILE",
                        complete: function (data) {
                            $('#edit_department').val(vue.edit_department_id);
                        },
                        success: function (data) {
                            if (data.status == true) {  
                                $.each(data.user_department, function (key, value) {
                                    $("#edit_department").append('<option '+'value="'+value.id+'">'+value.department +'</option>');
                                });
                                // vue.department_section_edit();
                            }
                        }
                    });
                    
                    $("#division_id").empty();
                    $.ajax({
                        url: "GET_DIVISION_MASTERFILE",
                        complete: function (data) {
                            $('#division_id').val(vue.global_div);
                        },
                        success: function (data) {
                            if (data.status) {
                                $.each(data.user_division, function (key, value) {
                                    $("#division_id").append('<option '+'value="'+value.id+'">'+value.division +'</option>');
                                });
                            }
                        }
                    });

                    $("#status_id").empty();
                    $.ajax({
                        url: "GET_STATUS_MASTERFILE",
                        success: function (data) {
                            if (data.status == true) {
                                $.each(data.user_status, function (key, value) {
                                    $("#status_id").append('<option '+'value="'+value.id+'">'+value.status_name +'</option>');
                                });
                            }
                        }
                    });



                                 
                }, 
                update_btn(e) {
                    var id = this.users.id;
                    var post_form = $("#edit_user_form")[0];
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    data.append('id', id);      
                    $("#edit_user_form :input").prop("disabled", true);
                    $('#edit_modal').modal('hide');

                    $.ajax({
                        url: "update_users",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                            $("#edit_user_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                            if (data.status) {
                                $('#edit_modal').hide();
                                Swal.fire('Edit Successful')
                                $('#tbl_category').DataTable().ajax.reload();    
                                $('#btn_closed').trigger('click');
                            }
                            else{

                            }
                        },
                        error: function (data) {
                        },
                    });
                }, 
                delete_btn(e) {
                    var id = this.users.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "deactivate_users",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_user_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                            $('#tbl_category').DataTable().ajax.reload();
                            Swal.fire(
                                    'Inactive!')
                        },
                            error: function (data) {
                        },
                    });
                },
                active_btn(e){
                    var id = this.users.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "activate_users",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_user_form :input").prop("disabled", false);
                        },
                        success: function (data) {
                        $('#tbl_category').DataTable().ajax.reload();
                        
                        Swal.fire(
                                'Active!')
                        },
                            error: function (data) {
                        },
                    });
                },
                btn_filter(e){     
                    var department_id = $('#department_id').val();
                    var search_bar = $('#search_bar').val();
                    $('#tbl_category').DataTable({
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url:"department_filter",
                    
                    data: function(data) {
                        data.department_id = department_id,
                        data.search_bar = search_bar 
                        }
                    },
                        columns: [
                        {data: 'role_class_name', name: 'role_class_name'},
                            {data: 'department', name: 'department'},
                            {data: 'fullname', name: 'fullname'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},     
                            {data: 'action', name: 'action'},
                        ]
                    });
                },
                datatable_func(e){
                    $('#tbl_category').DataTable({
                    "aaSorting": [[ 4, "desc" ]],
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    ajax: "get_user_management_table",
                        columns: [
                            {data: 'role_class_name', name: 'role_class_name'},
                            {data: 'department', name: 'department'},
                            {data: 'fullname', name: 'fullname'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},     
                            {data: 'action', name: 'action'},
                        ]
                    });
                }
			},
		}
</script>
	