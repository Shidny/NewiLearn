<style>
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 30%;
  border-radius: 40%;
}
</style>

<template>
    <div class="pagetitle">
     <h1>My Profile</h1>
       <nav>
           <hr>
       </nav>
   </div>
   <!-- End Page Title -->
   <!-- table  -->
   <div class="container">
    <div id="validation_msg"></div>
        <form class="form-category" id="user_profile">
    <!-- <div class="imgcontainer mb-2">     
      <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" alt="Avatar" class="avatar">    
        <div class="mb-2">
            <input type="file" name="profile_image">
        </div>
    </div> -->
    <br>
    
            <div class="row ml-md-auto">
                <div class="col-sm-4 mb-2">
                    <div class="form-group">
                        <label><strong>FirstName <span class="text-danger">*</span></strong></label> 
                        
                        <input type="text" class="form-control" name='firstname' id="fname" placeholder="FirstName">
                    </div>
                </div>

                <div class="col-sm-4 mb-2">
                    <div class="form-group">
                        <label><strong>MiddleName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='middlename' id="mname" placeholder="MiddleName">
                    </div>
                </div>

                <div class="col-sm-4 mb-2">
                    <div class="form-group">
                        <label><strong>LastName <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='lastname' id="lname" placeholder="LastName">
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Employee ID No. 
                             <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="emp_no" placeholder="(This will served as your login)" disabled>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Email <span class="text-danger">*</span></strong></label>
                        <input type="email" class="form-control" id="email" placeholder="Email" disabled>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><strong>Password
                             <span class="text-danger">*</span></strong></label>
                        <input type="password" class="form-control" name='password' placeholder="Password">
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Role
                             <span class="text-danger">*</span></strong></label>
                        <select name="role_name" id="role" class="form-control" disabled>
                            <option disabled selected>--SELECT STATUS-- </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Position <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='position' placeholder="Position" disabled>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Department
                            <span class="text-danger">*</span></strong></label>
                            <select class="form-control" name="department_name" id="department" disabled></select>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Section <span class="text-danger">*</span></strong></label>
                        <select class="form-control" name="section_name" id="section" disabled>
                            <option disabled selected> --SELECT SECTION-- </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="form-group">
                        <label><strong>Division <span class="text-danger">*</span></strong></label>
                        <select name="division_name" id="division_id" class="form-control" disabled></select>
                    </div>
                </div>

                <div class="col-lg-6 mb-2">
                    <div class="form-group">
                        <label><strong>Status <span class="text-danger">*</span></strong></label>
                        <select name="status_name" id="status_id" class="form-control" disabled>
                            <option disabled selected>--SELECT STATUS-- </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-lg-12 mb-2">
            <button @click="update_btn()" id="update_btn" class="btn btn-primary">Submit 
        </button>
      </div>
   </div> 
   <!-- end: table -->   
   </template>


<script>
    export default {
			data(){
                return{
                    profile_name:{
                        id: ""
                    },    
                    edit_section_id:"",
                    user:[],
                    
                }
            },
            
            mounted() {
                var vue = this;
                var user = window.entities;

                 
                $('#fname').val(user.firstname);
                $('#mname').val(user.middlename);
                $('#lname').val(user.lastname);
                $('#emp_no').val(user.username);
                $('#email').val(user.email);
                $('#position').val(user.position);
                $('#role').val(user.role_id)
                $('#update_btn').attr('data-id', user.id)
        
                $("#department").empty();
                    $.ajax({
                        url: "GET_DEPARTMENT",
                        complete: function (data) {
                            $('#department').val(user.department);
                        },
                        success: function (data) {
                            if (data.status == true) {  
                                $.each(data.user_department, function (key, value) {
                                    $("#department").append('<option '+'value="'+value.id+'">'+value.department +'</option>');
                                });
                                vue.department_section_profile();
                            }
                        }
                    });

                $("#role").empty();
                    $.ajax({
                        url: "GET_ROLE_MASTERFILE",
                        complete: function (data) {
                            $('#role').val(user.role_id);
                        },
                        success: function (data) {
                            if (data.status == true) {
                                $.each(data.user_role, function (key, value) {
                                    $("#role").append('<option '+'value="'+value.id+'">'+value.role_class_name +'</option>');
                                });
                            }
                        }
                    });

                    
                    $("#division_id").empty();
                    $.ajax({
                        url: "GET_DIVISION_MASTERFILE",
                        complete: function (data) {
                            $('#division_id').val(user.division);
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

			methods:{
				test: function (evt) {
					var vue = this                    
				},

                department_section_profile(e){
                    $("#section").empty();
                    let department_section_profile = "department=" + $("#department").val() + "&_token=" + $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "GET_SECTION_MASTERFILE",
                        data:department_section_profile,
                        success: function (data) {
                            if (data.status == true) {  
                                $.each(data.user_section, function (key, value) {
                                    $("#section").append('<option '+'value="'+value.id+'">'+value.section +'</option>');
                                });
                            }
                        }
                    });
                },
                update_btn(e) {
                    var id = $('#update_btn').attr('data-id');
                    var post_form = $("#user_profile")[0];
                    
                    var data = new FormData(post_form);
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    data.append('id', id);      
                    
                    $.ajax({
                        url: "update_profile",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {

                        },
                        success: function (data) {
                            if (data.status) {
                              Swal.fire('Update Successful \n Please relogin to apply changes')
                              $("#user_profile")[0].ajax.reload();
                            }
                            else{

                            }
                        },
                        error: function (data) {
                        },
                    });
                }
			},
		}
</script>
	