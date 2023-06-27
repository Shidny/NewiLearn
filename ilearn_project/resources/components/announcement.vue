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
  <h1 id="title_header">Announcement</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_modal"> New Announcement </button>
    </div>
    <br><br>

    <table id="tbl_category" class="table table-active table-hover table-striped table-responsive" style="width:100%">
        <thead id="table_header">
            <tr>
                <th>Image</th>
                <th>Date Created</th>
                <th>Date Updated</th>
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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Announcement</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
        <form class="form-category" id="announcement_form">
            <div class="row ml-md-auto">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="exampleFormControlFile1"><strong>Attachment File <span class="text-danger">*</span></strong></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment" multiple accept="image/x-png,image/gif,image/jpeg">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Definition <span class="text-danger">*</span></strong></label>
                        <textarea name="description" cols="5" rows="5" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
        <button @click="announcement_btn()" class="btn btn-primary">Submit 
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
        <form class="form-category" id="edit_announcement_form">
            <div class="row ml-md-auto">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlFile1"><strong>Attachment File <span class="text-danger">*</span></strong></label>
                        <div class="custom-file">
                            <img src="#" id="filepath" width="80px" height="50px">
                            <input type="file" class="custom-file-input" id="edit_attachment" name="edit_attachment" multiple accept="image/*">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Description <span class="text-danger">*</span></strong></label>
                        <textarea id="edit_description" name="edit_description" cols="5" rows="5" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-lg-5">
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
            announcement: {
                id: "",
                orig_filename: "",
                description: ""
            }
        }
    },

    mounted() {
        this.datatable_func();
        var vue = this;

        
        $(document).on('click','#edit', function (e) {
            var id = $(this).attr('data-id');
            vue.announcement.id = id;
            vue.fetch_btn();

        })
        $(document).on('click','#deactivate', function (e) {
            var id = $(this).attr('data-id');
            vue.announcement.id = id;
            vue.deactivate_btn();
        }) 
        $(document).on('click','#active', function (e) {
            var id = $(this).attr('data-id');
            vue.announcement.id = id;
            vue.active_btn();
        })
        $(document).on('click','#delete', function (e) {
            var id = $(this).attr('data-id');
            vue.announcement.id = id;
            vue.delete_btn();
        })  
    },

    methods: {
        announcement_btn(e) {
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            } });
            
            var post_form = $("#announcement_form")[0];
            var data = new FormData(post_form);
            data.append("_token", $('meta[name="csrf-token"]').attr("content"));
            $("#announcement_form :input").prop("disabled", true);
            $('#add_modal').modal('hide');
                $.ajax({
                url: "insert_announcement",
                type: "POST",
                data: data,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                complete: function (data) {
                $("#announcement_form :input").prop("disabled", false);

                },
                success: function (data) {
                    setTimeout($.unblockUI, 1);    
                $('#tbl_category').DataTable().ajax.reload();
                    if (data.status) {
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
            var id = this.announcement.id
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "edit_announcement",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#edit_announcement_form :input").prop("disabled", false);
                },
                success: function (data) {
                    setTimeout($.unblockUI, 1);
                    $('#filepath').attr('src',data.image);
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
            var id = this.announcement.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "deactivate_announcement",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#edit_announcement_form :input").prop("disabled", false);
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
            var id = this.announcement.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "active_announcement",
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
            var id = this.announcement.id;
            var token = $('meta[name="csrf-token"]').attr("content");
            var data = {
                id:id,
                _token: token
            }

            $.ajax({
                url: "delete_announcement",
                type: "POST",
                data: data,
                dataType: "json",
                complete: function (data) {
                    $("#edit_announcement_form :input").prop("disabled", false);
                },
                success: function (data) {
                    setTimeout($.unblockUI, 1);
                    $('#tbl_category').DataTable().ajax.reload();
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
            var id = this.announcement.id;
            var post_form = $("#edit_announcement_form")[0];
            var data = new FormData(post_form);
            data.append("_token", $('meta[name="csrf-token"]').attr("content"));
            data.append('id', id);      
            $("#edit_announcement_form :input").prop("disabled", true);
            $("#edit_modal").modal('hide');

            $.ajax({
                url: "update_announcement",
                type: "POST",
                data: data,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                complete: function (data) {
                    $("#edit_announcement :input").prop("disabled", false);
                },
                success: function (data) {
                    if (data.status) {
                        $('#edit_announcement').hide();
                        setTimeout($.unblockUI, 1);
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
        datatable_func(e) {
            $('#tbl_category').DataTable({
                "aaSorting": [[ 2, "desc" ]],
                processing: true,
                destroy: true,
                serverSide: true,
                searching:false,
                ajax: "get_announcement_table",
                columns: [
                    { data: 'image', name: 'image' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
                ]
            });
        }
    },
}
</script>
	