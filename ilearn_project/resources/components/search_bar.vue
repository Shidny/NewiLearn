<template>
    <div class="row ml-lg-auto mb-2" id="search_style">
        <h5 for="search">Search:</h5>
        <div class="col-md-11">
            <input type="text" class="form-control form-control-sm mb-4" name="search_bar" id="search_bar">
        </div>
        <div class="col-md-1">
            <button @click="btn_search()"  class="btn btn-primary btn-sm mb-4">Search</button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                category_name:{
                id: "",
                icon: "",
                },
                name_category:[],
            }
        },
        mounted() {
            var vue = this;
 
            // for search bar btn for dashboard
            $(document).on('keyup','#search_bar', function (e) {
            if ($("#search_bar").is(":focus") && e.key == "Enter") {
                vue.btn_search();
            }
            });
        },

        methods: {
            
            btn_search(){
                var search_bar = $('#search_bar').val();
                window.location.href = "masterlist/"+search_bar;

            },
        },
    }
</script>