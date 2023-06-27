<style>
    #title_header {
        border: 1px solid black; 
        width: 30%; 
        text-align: center; 
        padding: 10px; 
        border-radius: 25px 10px ; 
        background-color: gray; 
        color: white;
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

    #iframes_pdf{
        /* width: 100%;
        height: 600px;
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none; */
        display: block;
        pointer-events: none;
        width: 100%;
        height: 200vh;
        overflow-x: hidden  !important;
        border: none;
    }
    ::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }
</style>

<template>
<div class="pagetitle">
  <h1 id="title_header">Masterlist Generator</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container mb-2">
    <div class="container">
        <div class="row ml-lg-auto mb-2" id="search_style" >
            <label> Search Document</label>
            <br>
            <div class="col-md-5">
            <select name="category_mast" id="category_mast" class="form-control mb-2">    
            </select>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control mb-2" name="search_bar" id="search_bar" v-model="search_data">
            </div>
            <div class="col-md-2">
                <button @click="btn_filter()"  class="btn btn-primary mb-2">Search</button>
            </div>
        </div>    
    </div>
    <table id="tbl_category" class="table table-active table-hover table-striped table-responsive" style="width:100%">
        <thead id="table_header">
            <tr>
                <th>Document Title </th>
                <th>Owner</th>
                <th>Document Number </th>
                <th>Effectivity Date </th>
                <th>Category </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
<!-- end: table -->   

<section>
<!-- Modal -->
<div class="modal fade" id="title_link" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Masterlist Details</h5>
      </div>
      <div class="modal-body">
        <div id="validation_msg"></div>
            <div class="row ml-md-auto">
                <div class="col-lg-6">
                    <div class="form-group">
                        <img src="/Files/RFC.png" alt="RFC Policy Portal" title="RFC Policy Portal" style="float: center; padding-right: 15px; height: 80px;" />
                    </div>
                </div>
            
                <div class="col-lg-6">
                    <div class="form-group">
                        <div class="col-md-12"><b>Title:</b> {{ master.category_name}} </div>
                        <div class="col-md-12"><b>Owner:</b> {{ master.owner}} </div>
                        <div class="col-md-12" ><b>Document No.:</b> {{ master.document_no }} </div>
                        <div class="col-md-12" ><b>Effectivity Date:</b> {{ master.effectivity_date }} </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h3>Attachment:</h3>
                    <div class="col-md-12" id="description_det_img"></div>
                    <div class="col-lg-12" style="overflow: scroll; height: 500px;">
                        <iframe id="iframes_pdf" frameborder="0" scrolling="no"></iframe>
                    </div>
                    
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_closed" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
</section>
</template>
	
<script>
import { hide } from '@popperjs/core';

export default {
			data(){
                return{
                    master:{
                        id: "",
                        category_name: "",
                        status: "",
                        icon: "",
                        attachment: "",
                        desc: ""
                    },
                    search_bar: "",
                    category_mast: "",
                    search_data: "",
                    
                }
            },  
            
            mounted() {
                // console.log(window.entities.search_category);
                this.datatable_func(window.entities.search_data,window.entities.search_category);
                this.search_data = window.entities.search_data;
                this.search_category = window.entities.search_category;
                var vue = this;
                
                $(document).on('click','#title_link', function (e) {
                    
                })        
                $(document).on('click','#link_btn', function (e) {
                    var id = $(this).attr('data-id');
                    vue.master.id = id;
                    vue.link_btn();
                })

                $(document).on('keyup','#search_bar', function (e) {
                    if ($("#search_bar").is(":focus") && e.key == "Enter") {
                        vue.btn_filter();
                    }
                });

                

                $("#category_mast").empty();
                $.ajax({
                    url: "/category_mast",
                    success: function (data) {
                        if (data.status == true) {
                            $("#category_mast").append('<option '+'value="'+''+'"selected>'+'SELECT CATEGORY'+'</option>');
                            $.each(data.user_status, function (key, value) {
                                $("#category_mast").append('<option '+'value="'+value.id+'">'+value.category_name +'</option>');
                            });
                        }
                    }
                });    
                
                $(document).on('click','#link_btn', function (e) {
        
                    let details = "id=" + $(this).data("id") + 
                    "&title=" + $(this).data("title") + 
                    "&document_owner=" + $(this).data("document_owner") + 
                    "&document_no=" + $(this).data("document_no") + 
                    "&effectivity_date=" + $(this).data("effectivity_date") + 
                    "&_token=" + $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "/master_redirect_to_pdf_view",
                        data: details,
                        success: function (data) {
                            // location.reload();
                        }
                    });

                    // redirect_to_pdf_view

                })
            },

            async created() {
                this.test();
            },
			methods:{
				test: function (evt) {
					var vue = this                    
                    // console.log(this.category_data)	
                    // function injectJS(){    
                    //     var frame =  $('#iframes_pdf');
                    //     var contents =  frame.contents();
                    //     var body = contents.find('body').attr("oncontextmenu", "return false");
                    //     var body = contents.find('body').append('<div>New Div</div>');    
                    // }
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
                        url:"/master_filter",
                    
                    data: function(data) {
                        data.category_mast = category_mast,
                        data.search_bar = search_bar 
                        }
                    },
                        columns: [
                            {data: 'title_link', name: 'title_link'},    
                            {data: 'document_owner', name: 'document_owner'},
                            {data: 'document_no', name: 'document_no'},
                            {data: 'effectivity_date', name: 'effectivity_date'},
                            {data: 'category', name: 'category'},     
                        ]
                    });
                },
                link_btn(e) {

                    var vue = this
                    var id = this.master.id
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var data = {
                        id:id,
                        _token: token
                    }

                    $.ajax({
                    url: "masterList",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    complete: function (data) {
                        $("#policy_form_edit :input").prop("disabled", false);
                        $('#editpolicy').modal('show');
                    },
                    success: function (data) {
                        vue.master.category_name = data.data.title;
                        vue.master.owner = data.data.document_owner;
                        vue.master.document_no = data.data.document_no;
                        vue.master.effectivity_date = data.data.effectivity_date;
                        // vue.policy.attachment = data.data.attachment;
                        // $('#iframes_pdf').attr('src',data.image);
                        // $('#iframes_pdf').attr('src',data.image);
                        
                        if(data.data.description != 'None'){
                            $('#description_det_img').html(data.data.description);
                        }else{
                            $('#description_det_img').html(' ');
                        }
                        
                        if (data.data.attachment == ''){
                            // $('#iframe_pdf').prop('src',' ');
                            
                        }else{
                            // $('#iframe_pdf').html();
                            $('#iframes_pdf').attr('src',data.image+'#toolbar=0');
                        }

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
                
                datatable_func(search_data,search_category){
                    // alert(search_data);
                    $('#tbl_category').DataTable({
                    "aaSorting": [[ 3, "desc" ]],
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    searching: false,
                    // ajax: "/get_value_table_ajax",
                    ajax: {
                            url: "/get_value_table_ajax",
                            data: function(d) {
                                d.search_data = search_data,
                                d.search_category = search_category
                            }
                        },
                        columns: [
                            {data: 'title_link', name: 'title_link'},    
                            {data: 'document_owner', name: 'document_owner'},
                            {data: 'document_no', name: 'document_no'},
                            {data: 'effectivity_date', name: 'effectivity_date'},
                            {data: 'category', name: 'category'},     
                        ]
                    });
                }
			},
		}
</script>
	