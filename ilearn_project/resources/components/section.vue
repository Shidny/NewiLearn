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
  <h1 id="title_header">Section Management</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary btn-sm mb-2" @click="new_section" data-bs-toggle="modal" data-bs-target="#add_modal"> Create Section </button>
        </div>
        <br>
        <div class="row ml-lg-auto" id="search_style">
            <label> Search Section </label>       
            <div class="col-md-5">
            <select name="section_id" id="section_id" class="form-control form-control-sm mb-2">    
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
                <th>Section Name</th>
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
        <form class="form-category" id="section_form">
            <div class="row ml-md-auto">
               
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong> Section <span class="text-danger">*</span></strong></label>
                        <input type="text" name="section_name" id="section" class="form-control">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Department <span class="text-danger">*</span></strong></label>
                        <select name="department_name" id="department" class="form-control"></select>
                    </div>
                </div>

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_closed" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button @click="section_btn()" class="btn btn-primary">Submit 
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
        <h5 class="modal-title" id="staticBackdropLabel">Update Section</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="edit_section_form">
            <div class="row ml-md-auto">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Section <span class="text-danger">*</span></strong></label>
                        <input type="text" name="edit_section" id="edit_section" class="form-control">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Department <span class="text-danger">*</span></strong></label>
                        <select name="edit_department" id="edit_department" class="form-control"></select>
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
                    section:{
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
                    vue.section.id = id;
                    vue.fetch_btn();
                })  
                $(document).on('click','#delete', function (e) {
                    var id = $(this).attr('data-id');
                    vue.section.id = id;
                    vue.delete_btn();
                })
                
                $(document).on('click','#deactivate', function (e) {
                    var id = $(this).attr('data-id');
                    vue.section.id = id;
                    vue.deactivate();
                })

                $(document).on('click','#activate', function (e) {
                var id = $(this).attr('data-id');
                    vue.section.id = id;
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
                
                $("#section_id").empty();
                $.ajax({
                    url: "section_dropdown",
                    success: function (data) {
                        if (data.status == true) {
                            $("#section_id").append('<option '+'value="'+''+'"selected>'+'SELECT Section'+'</option>');
                            $.each(data.section_dropdown, function (key, value) {
                                $("#section_id").append('<option '+'value="'+value.id+'">'+value.section +'</option>');
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
                new_section(e){

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
                },
                section_btn(e) {
                    var post_form = $("#section_form")[0];
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    $("#section_form :input").prop("disabled", true);
                    $("#section_form")[0].reset();

                        $.ajax({
                        url: "insert_section",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                        $("#section_form :input").prop("disabled", false);

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
                    var id = this.section.id
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }
                        $.ajax({
                            url: "fetch_section",
                            type: "POST",
                            data: data,
                            dataType: "json",
                            complete: function (data) {
                            
                            },
                                success: function (data) {
                                    vue.edit_department_id = data.data.department_id;
                                    $('#edit_section').val(data.data.section);
                                },
                                error: function (data) {
                                },
                        });    
                    
                    // edit department
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
                            }
                        }
                    });             
                }, 
                
                update_btn(e) {
                    var id = this.section.id;
                    var post_form = $("#edit_section_form")[0];
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    data.append('id', id);      
                    $("#edit_section_form :input").prop("disabled", true);
                    $('#edit_modal').modal('hide');

                    $.ajax({
                        url: "update_section",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                            $("#edit_section_form :input").prop("disabled", false);
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
                    var id = this.section.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "delete_section",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_section_form :input").prop("disabled", false);
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
                    var id = this.section.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "deactivate_section",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_section_form :input").prop("disabled", false);
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
                    var id = this.section.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "activate_section",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#edit_section_form :input").prop("disabled", false);
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
                    var section_id = $('#section_id').val();
                    var search_bar = $('#search_bar').val();
                    $('#tbl_category').DataTable({
                    "aaSorting": [[ 2, "desc" ]],
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url:"section_filter",
                    
                    data: function(data) {
                        data.section_id = section_id,
                        data.search_bar = search_bar 
                        }
                    },
                        columns: [
                            {data: 'section', name: 'section'},
                            {data: 'department_name', name: 'department_name'},
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
                    ajax: "display_section",
                        columns: [
                          
                            {data: 'section', name: 'section'},
                            {data: 'department_name', name: 'department_name'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},     
                            {data: 'action', name: 'action'},
                        ]
                    });
                }
			},
		}
</script>
	