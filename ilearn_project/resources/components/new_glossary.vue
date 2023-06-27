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
  <h1 id="title_header">Glossary Summary</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_modal"> New Glossary </button>
        </div>
        <br>
        <div class="row ml-lg-auto mb-2" id="search_style">
            <h5 for="search">Search Glossary</h5>
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
                <th>Word</th>
                <th>Definition</th>
                <th>Status</th>
                <th>Date Created</th>
                <th width="18%">Action</th>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Glossary</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="glossary_form">
            <div class="row ml-md-auto">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Word <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='word_name1'
                            placeholder="Category Name">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="description1" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Word <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='word_name2'
                            placeholder="Category Name">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="description2" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Word <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='word_name3'
                            placeholder="Category Name">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="description3" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Word <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='word_name4'
                            placeholder="Category Name">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="description4" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Word <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='word_name5'
                            placeholder="Category Name">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="description5" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
        <button @click="glossary_btn()" class="btn btn-primary">Submit 
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
        <h5 class="modal-title" id="staticBackdropLabel">Update Glossary</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="glossary_form_edit">
            <div class="row ml-md-auto">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Word <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" name='edit_word_name' id='edit_word_name'
                            placeholder="Title">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="edit_description" id="edit_description" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
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

        $(document).on('click','#edit', function (e) {
            var id = $(this).attr('data-id');
            vue.glossary.id = id;
            vue.fetch_btn();

        })
        
        $(document).on('keyup','#search_bar', function (e) {
            if ($("#search_bar").is(":focus") && e.key == "Enter") {
                vue.btn_filter();
            }
        })
        
        $(document).on('click','#deactivate', function (e) {
            var id = $(this).attr('data-id');
            vue.glossary.id = id;
            vue.deactivate_btn();
        }) 
        $(document).on('click','#active', function (e) {
            var id = $(this).attr('data-id');
            vue.glossary.id = id;
            vue.active_btn();
        })
        $(document).on('click','#delete', function (e) {
            var id = $(this).attr('data-id');
            vue.glossary.id = id;
            vue.delete_btn();
        })  
    },

    methods: {
        glossary_btn(e) {
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            } });
            
            var post_form = $("#glossary_form")[0];
            var data = new FormData(post_form);
            data.append("_token", $('meta[name="csrf-token"]').attr("content"));
            $("#glossary_form :input").prop("disabled", true);
            $('#add_modal').modal('hide');
            
                $.ajax({
                url: "insert_glossary",
                type: "POST",
                data: data,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                complete: function (data) {
                $("#glossary_form :input").prop("disabled", false);
                $("#glossary_form")[0].reset();

                },
                success: function (data) {
                $('#tbl_category').DataTable().ajax.reload();
                    if (data.status) {
                        setTimeout($.unblockUI, 1); 
                        Swal.fire('Created Successful')
                        $('.btn_closed').trigger('click');
                    }
                    else{
                    }
                },
                error: function (data) {
                },
            });
        },
        fetch_btn(e) {
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            } });
            var vue = this
            var id = this.glossary.id
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "edit_glossary",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#glossary_form_edit :input").prop("disabled", false);
                },
                success: function (data) {
                    setTimeout($.unblockUI, 1);
                    $('#edit_word_name').val(data.data.name);
                    $('#edit_description').val(data.data.description);
                },
                error: function (data) {
                },
            });
        },
        deactivate_btn(e) {
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            } });
            var id = this.glossary.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "deactivate_glossary",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#glossary_form_edit :input").prop("disabled", false);
                },
                success: function (data) {
                    $('#tbl_category').DataTable().ajax.reload();
                    setTimeout($.unblockUI, 1);
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

            var id = this.glossary.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "active_glossary",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#glossary_form_edit :input").prop("disabled", false);
                },
                success: function (data) {
                setTimeout($.unblockUI, 1);
                $('#tbl_category').DataTable().ajax.reload();
                
                Swal.fire(
                        'Active!')
                },
                    error: function (data) {
                },
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
            var id = this.glossary.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "delete_glossary",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#glossary_form_edit :input").prop("disabled", false);
                },
                success: function (data) {
                    $('#tbl_category').DataTable().ajax.reload();
                    setTimeout($.unblockUI, 1);
                    Swal.fire('Deleted!')
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

            var id = this.glossary.id;
            var post_form = $("#glossary_form_edit")[0];
            var data = new FormData(post_form);
            data.append("_token", $('meta[name="csrf-token"]').attr("content"));
            data.append('id', id);      
            $("#glossary_form_edit :input").prop("disabled", true);
            $("#edit_modal").modal('hide');

            $.ajax({
                url: "update_glossary",
                type: "POST",
                data: data,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                complete: function (data) {
                    $("#editmodal_glossary :input").prop("disabled", false);
                },
                success: function (data) {
                    if (data.status) {
                        setTimeout($.unblockUI, 1);
                        $('#editmodal_glossary').hide();
                        Swal.fire('Edit Successful')
                        $('#tbl_category').DataTable().ajax.reload();    
                        $('.btn_closed').trigger('click');
                    }
                    else{
                        // $('#validation_msg').html('');
                        // validation_msg += `<div class="alert alert-danger "><ul>`;
                        // $.each(data.msg, function (key, value) {
                        // validation_msg += '<li>' + value + '</li>';
                        // });
                        // $('#validation_msg').append(validation_msg)
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
                url:"get_filter_table",
            
            data: function(data) {
                data.search_bar = search_bar 
                }
            },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status_name', name: 'status_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' },    
                ]
            });
        },
        datatable_func(e) {
            $('#tbl_category').DataTable({
                "aaSorting": [[ 3, "desc" ]],
                processing: true,
                destroy: true,
                serverSide: true,
                searching: false,
                ajax: "get_glossary_table",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status_name', name: 'status_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });
        }
    },
}
</script>
	