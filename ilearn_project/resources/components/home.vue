	<template>        
        <div class="row" id="category_names"></div>
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
                this.name_category = window.category_array;                
                // console.log(window.category_array)
    
                $.each(window.category_array, function( index, value ) {
                    // console.log(value);
                    $('#category_names').append('<div class="col-sm-4"><div class="card"><div class="card-body"><h5 class="card-title"><b>'+value.category_name+'</b></h5><p class="card-text" style="height: 140px; max-height: 140px;">'+value.descrion_count+'</p><a href="#" data-name="'+value.category_name+'" class="btn d-grid gap-2 d-md-block btn-primary category_btn">View</a>  </div></div></div>');                
                });     
                
                // for category btn for dashboard
                $(document).on('click', '.category_btn', function(e){
                    var seach_category = $(this).attr('data-name');
                    vue.category_btn(seach_category);
                });
            
            },
    
            methods: {
                category_btn(seach_category){
                    window.location.href = "masterlist_category/"+seach_category;
                }
            },
        }
    </script>