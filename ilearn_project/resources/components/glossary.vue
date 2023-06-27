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
  <h1 id="title_header">Glossary</h1>
    <nav>
        <hr>
    </nav>
</div>
<!-- End Page Title -->
<!-- table  -->
<div class="container">
    <div class="row ml-lg-auto mb-2" id="search_style">
        <h5 for="search">Search Glossary</h5>
        <div class="col-md-11">
            
            <input type="text" class="form-control form-control-sm mb-4" name="search_bar" id="search_bar">
        </div>
        <div class="col-md-1">
            <button @click="btn_filter()"  class="btn btn-primary btn-sm mb-4">Search</button>
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
                <th>Date Updated</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
<!-- end: table -->
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

        $(document).on('keyup','#search_bar', function (e) {
            if ($("#search_bar").is(":focus") && e.key == "Enter") {
                vue.btn_filter();
            }
        });
    },

    methods: {
        btn_filter(e){     
            var search_bar = $('#search_bar').val();
            $('#tbl_category').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            searching: false,
            ajax: {
                url:"fetch_table_glossary_master",
            
            data: function(data) {
                data.search_bar = search_bar 
                }
            },
                columns: [
                { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status_name', name: 'status_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },     
                ]
            });
        },
        datatable_func(e) {
            $('#tbl_category').DataTable({
                processing: true,
                destroy: true,
                serverSide: true,
                searching: false,
                ajax: "fetch_table_glossary_master",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status_name', name: 'status_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                ]
            });
        }
    },
}
</script>
	