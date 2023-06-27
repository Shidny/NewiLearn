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
        width: 100%;
        height: 600px;
    }
</style>

<template>
<div class="pagetitle">
  <h1 id="title_header">Policy Summary</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" id='new_policy' class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#add_modal"> New Policy </button>
        </div>
        <br>
        <div class="row ml-lg-auto" id="search_style">
            <label> Seach Document </label>       
            <div class="col-md-5">
            <select name="category_mast" id="category_mast" class="form-control form-control-sm mb-2">    
            </select>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control form-control-sm mb-2" name="search_bar" id="search_bar">
            </div>
            <div class="col-md-2">
                <button @click="btn_filter()" class="btn btn-primary btn-sm mb-2">Search</button>
            </div>
        </div>    
    </div>
    <br>

    <table id="tbl_category" class="table table-active table-hover table-striped table-responsive" style="width:100%">
        <thead id="table_header">
            <tr>
                <th> Category </th>
                <th> Title </th>
                <th> Owner </th>
                <th> Document No. </th>
                <th> Date Created </th>
                <th> Date Updated </th>
                <th width="18%"> Action </th>
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
        <h5 class="modal-title" id="staticBackdropLabel">Add Policy</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="policy_form" enctype="multipart/form-data">
	        <div class="row ml-md-auto">
                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label><strong>Title <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='title' name='title' placeholder="Title" v-model="this.make_title" :class="applyInputStyle(this.make_title, 'Intput')">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label><strong>Owner <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='owner' name='owner' placeholder="Owner">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label><strong>Document No. <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='document_no' name='document_no' placeholder="Document No.">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label><strong>Effectivity Date <span class="text-danger">*</span></strong></label>
                        <input type="date" class="form-control" id='effectivity_date' name='effectivity_date' placeholder="Effectivity Date">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group mb-2">
                        <label><strong>Category <span class="text-danger">*</span></strong></label>
                        <select name="make_category" id="category" class="form-control">
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label for="exampleFormControlFile1"><strong>Attachment File <span class="text-danger">*</span></strong></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment" accept="application/pdf,application/vnd.ms-excel">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="form-group mb-2">
                        <label><strong>Description <span class="text-danger">*</span></strong></label>
                        <textarea name="description" cols="5" rows="5" class="form-control summernote" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label><strong>Permitted Department/Section to Access <span class="text-danger">*</span></strong></label>
                    <select id='lstBox1' class="form-control" style="font-size: 12px;" size="20" multiple>
                    </select>
                </div>
                <div class="col-lg-3 text-center">
                    <label><strong>Actions:</strong></label>
                    <div class="subject-info-arrows text-center">
                        <input type="button" id="btnAllRight" value=">>" class="btn btn-danger arrowBtn" style="width: 100px"/><br />
                        <input type="button" id="btnRight" value=">" class="btn btn-warning arrowBtn" style="width: 100px"/><br />
                        <input type="button" id="btnLeft" value="<" class="btn btn-warning arrowBtn" style="width: 100px"/><br />
                        <input type="button" id="btnAllLeft" value="<<" class="btn btn-danger arrowBtn" style="width: 100px"/><br />
                    </div>
                </div>
                <div class="col-lg-4">
                    <label><strong>Permitted Department/Section to Access <span class="text-danger">*</span></strong></label>
                    <div class="subject-info-box-2">
                        <select multiple="multiple" id='lstBox2' name="section_access[]" class="form-control" style="font-size: 12px;" size="20">
                            
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
	    </form>
      </div>
      <div class="modal-footer mb-2">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
        <button @click="policy_btn()" class="btn btn-primary">Submit 
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
        <h5 class="modal-title" id="staticBackdropLabel">Update Policy</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="policy_form_edit">
            <div class="row ml-md-auto">
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Title <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='edit_title' name='edit_title' placeholder="Title">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Owner <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='edit_owner' name='edit_owner' placeholder="Owner">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Document No. <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id='edit_document_no' name='edit_document_no' placeholder="Document No.">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>Effectivity Date <span class="text-danger">*</span></strong></label>
                        <input type="date" class="form-control" id='edit_effectivity_date' name='edit_effectivity_date' placeholder="Effectivity Date">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Category <span class="text-danger">*</span></strong></label>
                        <select name="edit_make_category" id="edit_make_category" class="form-control">
                            <option disabled selected>--SELECT Category-- </option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlFile1"><strong>Attachment File <span class="text-danger">*</span></strong></label>
                        <div class="custom-file">
                            <img src="#" id="filepath" width="80px" height="50px">
                            <input type="file" class="custom-file-input" id="edit_attachment" name="edit_attachment">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Description <span class="text-danger">*</span></strong></label>
                        <textarea id="edit_description" name="edit_description" cols="5" rows="5" class="form-control summernote" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label><strong>Permitted Department/Section to Access <span class="text-danger">*</span></strong></label>
                    <select id='edit_lstBox1' name="old_section_access[]" class="form-control" style="font-size: 12px;" size="20" multiple>
                    </select>
                </div>
                <div class="col-lg-3 text-center">
                    <label><strong>Actions:</strong></label>
                    <div class="subject-info-arrows text-center">
                        <input type="button" id="edit_btnAllRight" value=">>" class="btn btn-danger arrowBtn" style="width: 100px"/><br />
                        <input type="button" id="edit_btnRight" value=">" class="btn btn-warning arrowBtn" style="width: 100px"/><br />
                        <input type="button" id="edit_btnLeft" value="<" class="btn btn-warning arrowBtn" style="width: 100px"/><br />
                        <input type="button" id="edit_btnAllLeft" value="<<" class="btn btn-danger arrowBtn" style="width: 100px"/><br />
                    </div>
                </div>
                <div class="col-lg-4">
                    <label><strong>Permitted Department/Section to Access <span class="text-danger">*</span></strong></label>
                    <div class="subject-info-box-2">
                        <select multiple="multiple" id='edit_lstBox2' name="edit_section_access[]" class="form-control" style="font-size: 12px;" size="20">
                            
                        </select>
                    </div>
                    <div class="clearfix"></div>
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
            <div class="col-lg-6">
                <div class="form-group">
                    <img src="/Files/RFC.png" alt="RFC Policy Portal" title="RFC Policy Portal" style="float: center; padding-right: 15px; height: 80px;" />
                </div>
            </div>
        
            <div class="col-lg-6">
                <div class="form-group">
                    <div class="col-md-12"><b>Title:</b> {{ policy.category_name}} </div>
                    <div class="col-md-12"><b>Owner:</b> {{ policy.owner}} </div>
                    <div class="col-md-12" ><b>Document No.:</b> {{ policy.document_no }} </div>
                    <div class="col-md-12" ><b>Effectivity Date:</b> {{ policy.effectivity_date }} </div>
                </div>
            </div>
            <div class="col-lg-14"></div>
            <div class="col-lg-12">
                <h3>Attachment:</h3>
                <div class="col-md-12" id="description_det_img"></div>
                <div class="col-lg-12">
                    <object data="iframe_pdf" type="application/pdf">
                        <iframe  id="iframe_pdf" type="application/pdf"></iframe >
                    </object>
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
	<style scoped>
    .input-has-value-style {
      border: 2px solid green;
      background-color: lightgreen;
    }
    
    .input-no-value-style {
      border: 3px solid rgba(255, 0, 0, 0.897);
    }
    </style>
	<script>
		export default {
			data(){
                return{
                    policy:{
                        id: "",
                        category_name: "",
                        status: "",
                        icon: "",
                        attachment: "",
                        desc: ""
                    },
                    make_title:"",
                    submitted: false,
                    category_data:[],
                }
            },
            
            mounted() {
                this.datatable_func();
                this.category_data = window.entities.category_data;
                var vue = this;
                
                $(document).on('click','#link_btn', function (e) {
                    // var id = $(this).attr('data-id');
                    // vue.policy.id = id;
                    // vue.link_btn();

                    // alert($(this).data("url"));

                    // let url = $(this).data("id");
                    let details = "id=" + $(this).data("id") + 
                    "&title=" + $(this).data("title") + 
                    "&document_owner=" + $(this).data("document_owner") + 
                    "&document_no=" + $(this).data("document_no") + 
                    "&effectivity_date=" + $(this).data("effectivity_date") + 
                    "&_token=" + $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "redirect_to_pdf_view",
                        data: details,
                        success: function (data) {
                            // location.reload();
                        }
                    });

                    // redirect_to_pdf_view

                })

                $("#edit_make_category").empty();
                        $.ajax({
                        url: "GET_CATEGORIES_MASTERFILE",
                        success: function (data) {
                            if (data.status == true) {
                                $("#edit_make_category").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT CATEGORY--'+'</option>');
                                $.each(data.user_status, function (key, value) {
                                    $("#edit_make_category").append('<option '+'value="'+value.id+'">'+value.category_name +'</option>');
                                });
                            }
                        }
                    });
                $(document).on('click','#edit', function (e) {
                    var id = $(this).attr('data-id');
                    var token = $('meta[name="csrf-token"]').attr("content");
                    
                    var data = {
                        id:id,
                        _token: token
                    }
                    
                    

                    $("#edit_lstBox1").empty();
                    var data_APPEND3 = '';  
                    var data_APPEND4 = ''; 
                    $.ajax({
                        url: "department_section",
                        data: data,
                        success: function (data) {
                            if (data.status == true) {
                                $.each(data.department, function (key, value) {
                                    
                                    $.each(value.section, function (key, value) {
                                        data_APPEND4 += '<option value="'+value.id+'">'+value.section+'</option>';
                                    });
                                    
                                    data_APPEND3 += '<optgroup class="opt_group" '+'label="'+value.department +'">'+data_APPEND4+'</optgroup>';
                                    
                                    data_APPEND4 = '';
                                    $("#edit_lstBox1").append(data_APPEND3);
                                    data_APPEND3 = '';
                                });
                            }
                            
                        }
                    });

                    $("#edit_lstBox2").empty();
                    var data_APPEND = ''; 
                    var data_APPEND2 = '';   
                    $.ajax({
                        url: "edit_department_section",
                        data: data,
                        success: function (data) {
                            if (data.status == true) {
                                $.each(data.department, function (key, value) {
                                    
                                data_APPEND2 += '<option class="old_section_lvl" data-id="'+value.section_id+'" value="'+value.section_id+'">'+value.section+'</option>';
                                    
                                
                                    $("#edit_lstBox2").append(data_APPEND2);
                                    data_APPEND2 = '';
                                });
                            }
                            
                        }
                    });

                    vue.policy.id = id;
                    vue.fetch_btn();

                })   
                $(document).on('keyup','#search_bar', function (e) {
                    if ($("#search_bar").is(":focus") && e.key == "Enter") {
                        vue.btn_filter();
                    }
                })

                $(document).on('click','#delete', function (e) {
                    var id = $(this).attr('data-id');
                    vue.policy.id = id;
                    vue.delete_btn();
                })   

                
                $(document).on('click','#active', function (e) {
          
                var id = $(this).attr('data-id');
                    vue.policy.id = id;
                    vue.active_btn();
                })
                
                $(document).on('click','#new_policy', function (e) {
                    $("#lstBox1").empty();
                    var data_APPEND = ''; 
                    var data_APPEND2 = '';   

                    $("#category").empty();
                        $.ajax({
                            url: "GET_CATEGORIES_MASTERFILE",
                            success: function (data) {
                                if (data.status == true) {
                                    $("#category").append('<option '+'value="'+''+'"selected disabled>'+'--SELECT CATEGORY--'+'</option>');
                                    $.each(data.user_status, function (key, value) {
                                        $("#category").append('<option '+'value="'+value.id+'">'+value.category_name +'</option>');
                                    });
                                }
                            }
                        });
                        
                    $.ajax({
                        url: "department_section",
                        success: function (data) {
                            if (data.status == true) {
                                $.each(data.department, function (key, value) {
                                    
                                    $.each(value.section, function (key, value) {
                                        data_APPEND2 += '<option value="'+value.id+'">'+value.  section+'</option>';
                                    });
                                    
                                    data_APPEND += '<optgroup class="opt_group" '+'label="'+value.department +'">'+data_APPEND2+'</optgroup>';
                                    
                                    data_APPEND2 = '';
                                    $("#lstBox1").append(data_APPEND);
                                    data_APPEND = '';
                                });
                            }
                            
                        }
                    });
                })

                $("#category_mast").empty();
                    $.ajax({
                        url: "category_mast",
                        success: function (data) {
                            if (data.status == true) {
                                $("#category_mast").append('<option '+'value="'+''+'"selected>'+'SELECT CATEGORY'+'</option>');
                                $.each(data.user_status, function (key, value) {
                                    $("#category_mast").append('<option '+'value="'+value.id+'">'+value.category_name +'</option>');
                                });
                            }
                        }
                    });                   
            },

            async created() {
                this.test();
            },
			
            methods:{
                applyInputStyle: function (targetInput, type) {
                    if (targetInput && targetInput.length > 0) {
                        return "";
                    } else if (this.submitted){
                        
                        return "input-no-value-style";
                    }
                    // console.log([targetInput, targetInput.length,type]);
                },
				test: function (evt) {
					var vue = this                    
                    // console.log(this.category_data)	
				},
                policy_btn(e) {

                    $.blockUI({ css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .5, 
                        color: '#fff' 
                    } });

                    this.submitted = true;
                    var post_form = $("#policy_form")[0];
                    var data = new FormData(post_form);
                    $('#add_modal').modal('hide');
                    $("#policy_form")[0].reset();
                    $('#summernote').summernote('reset');
                    
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    $("#policy_form :input").prop("disabled", true);
                        $.ajax({
                        url: "insert_policy",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                            $("#policy_form :input").prop("disabled", false); 
                            setTimeout($.unblockUI, 1); 
                        },
                        success: function (data) {
                        $('#tbl_category').DataTable().ajax.reload();
                            if (data.status) {
                                Swal.fire('Created Successful')
                                $('.btn_closed').trigger('click');
                            }
                            else{
                                // let title = document.forms["policy_form"]["title"].value;
                                // let owner = document.forms["policy_form"]["owner"].value;
                                // if (title == "") {
                                //     alert("title must be filled out");
                                // return false;
                                // }
                                // else if (owner == "") {
                                //     alert("owner must be filled out");
                                // return false;
                                // }
                            }
                        },
                        error: function (data) {
                        },
                    });
                },
                update_btn(e) {
                    $.blockUI({ css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .5, 
                        color: '#fff' 
                    } });

                    var id = this.policy.id;
                    var post_form = $("#policy_form_edit")[0];
                    var data = new FormData(post_form);
                    var section = $(".old_section_lvl").map(function () {
                        return $(this).attr('data-id');
                    }).get();
                    $('#edit_modal').modal('hide');

                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    data.append('id', id);
                    data.append('section', section);      
                    $("#policy_form_edit :input").prop("disabled", true);

                    $.ajax({
                        url: "update_policy",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                            $("#edit_modal :input").prop("disabled", false);
                        },
                        success: function (data) {
                            if (data.status) {
                                $('#edit_modal').hide();
                                Swal.fire('Edit Successful')
                                $('#tbl_category').DataTable().ajax.reload();    
                                $('.btn_closed').trigger('click');
                                setTimeout($.unblockUI, 1);
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
                fetch_btn(e) {
                    var vue = this
                    var id = this.policy.id
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                    url: "edit_policy",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    complete: function (data) {
                        $("#policy_form_edit :input").prop("disabled", false);
                        $('#editpolicy').modal('show');
                    },
                    success: function (data) {
                        $('#filepath').attr('src',data.image);
                        $('#edit_title').val(data.data.title);
                        $('#edit_owner').val(data.data.document_owner);
                        $('#edit_document_no').val(data.data.document_no);
                        $('#edit_effectivity_date').val(data.data.effectivity_date);
                        $('#edit_make_category').val(data.data.category_id);
                        // $('#edit_description').val(data.data.description);
                        $('#update_btn').attr('data-id', data.data.id);

                        $('#edit_description').summernote({
                            placeholder: data.data.description,
                            tabsize: 2,
                            height: 100
                        }).summernote('code', data.data.description);
                        // $('#edit_description').summernote({
                        //     height: 300,
                        //     onKeyup: function(e) {
                        //     $("#edit_description").html($(this).code());
                        //     }
                        // });

  
                    },
                    error: function (data) {
                    },
                    });
                },
                link_btn(e) {
                    var vue = this
                    var id = this.policy.id
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                    url: "link_policy",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    complete: function (data) {
                        $("#policy_form_edit :input").prop("disabled", false);
                        $('#editpolicy').modal('show');
                        
                    },
                    success: function (data) {
                        vue.policy.category_name = data.data.title;
                        vue.policy.owner = data.data.document_owner;
                        vue.policy.document_no = data.data.document_no;
                        vue.policy.effectivity_date = data.data.effectivity_date;
                        if(data.data.description != 'None'){
                            $('#description_det_img').html(data.data.description);
                        }else{
                            $('#description_det_img').html(' ');
                        }
                        
                        if (data.data.attachment == ' '){
                            $('#iframe_pdf').prop('src',' ');
                            
                        }else{
                            // $('#iframe_pdf').html();
                            $('#iframe_pdf').prop('src',data.link_image+'#toolbar=0');
                        }
                        
                        
                        // vue.policy.attachment = data.data.attachment;
                        // $('#iframe_pdf').attr('src',data.image);

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
                
                delete_btn(e) {
                    $.blockUI({ css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .5, 
                        color: '#fff' 
                    } });

                    var id = this.policy.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "delete_policy",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#policy_form_edit :input").prop("disabled", false);
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

                    var id = this.policy.id;
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                        url: "active_policy",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        complete: function (data) {
                            $("#policy_form_edit :input").prop("disabled", false);
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
                btn_filter(e){     
                    var category_mast = $('#category_mast').val();
                    var search_bar = $('#search_bar').val();
                    $('#tbl_category').DataTable({
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url:"get_filter_policy_table",
                    
                    data: function(data) {
                        data.category_mast = category_mast,
                        data.search_bar = search_bar 
                        }
                        
                    },
                        columns: [
                            {data: 'category_name', name: 'category_name'},
                            {data: 'title_link', name: 'title_link'},
                            {data: 'document_owner', name: 'document_owner'},
                            {data: 'document_no', name: 'document_no'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},
                            {data: 'action', name: 'action'}    
                        ]
                    });
                },
                datatable_func(e){
                    $('#tbl_category').DataTable({
                    "aaSorting": [[ 5, "desc" ]],
                    processing: true,
                    destroy: true,
                    searching: false,
                    serverSide: true,
                    ajax: "get_policy_table",
                        columns: [
                            {data: 'category_name', name: 'category_name'},
                            {data: 'title_link', name: 'title_link'},
                            {data: 'document_owner', name: 'document_owner'},
                            {data: 'document_no', name: 'document_no'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'updated_at', name: 'updated_at'},
                            {data: 'action', name: 'action'}
                        ]
                    });
                }
			},
		}
	</script>
	