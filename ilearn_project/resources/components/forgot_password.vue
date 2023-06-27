<style>
.margin_left{
    margin-left: 10%;
    margin-top: 20%;
}
</style>

<template>
    <section>
        <div class="container-fluid ">
            <!-- <div class="row"> -->
            <center>
                <div class="col-lg-10 left-panel margin_left">
                    <form class="form-category" id="forget_password_form" enctype="multipart/form-data">
                        
                        <div id='validation_msg'></div>
                            <legend>
                                <h1 style="color: #030f99;"><b>Forgot Password</b></h1>
                            </legend>
                        <div class="col-md-12">    
                            <input class="form-control form-control-lg mb-4" type="text" name="forgetempno" placeholder="Enter your Employee Number">                          
                        </div>

                        <div class="col-md-12">    
                            <input class="form-control form-control-lg mb-4" type="email" name="forgetemail" placeholder="Enter your e-mail">                          
                        </div>

                        <div class="col-md-12">
                            <button @click="forget_btn()" id="login_btn" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </form>
                </div>        
            </center>
            <!-- </div> -->
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                forgetpassword:{
                    id: "",
                    email: ""
                }
            }
        },

        mounted() {
            var vue = this 
            $(document).on('keyup','input', function (e) {
                if($("#forgetempno").is(":focus") && e.key == "Enter"){
                    vue.forget_btn();
                }
                else if ($("#forgetemail").is(":focus") && e.key == "Enter") {
                    vue.forget_btn();
                }
            })
        },

        methods:{
            forget_btn(e){     
                this.submitted = true;
                    var post_form = $("#forget_password_form")[0];
                    var data = new FormData(post_form);
                    $("#forget_password_form")[0].reset();
                    
                    data.append("_token", $('meta[name="csrf-token"]').attr("content"));
                    $("#forget_password_form :input").prop("disabled", true);
                        $.ajax({
                        url: "forgot_password_url",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        complete: function (data) {
                            $("#forget_password_form :input").prop("disabled", false); 
                            setTimeout($.unblockUI, 1); 
                        },
                        success: function (data) {

                            if (data.status) {
                               alert('Reset Password Completed');
                                // Swal.fire('Reset Password Completed');
                                // $('.btn_closed').trigger('click');
                            }
                            else{
                                // Swal.fire('Data Not Found');
                                alert('Data Not Found');
                                // $('.btn_closed').trigger('click');
                            }
                        },
                        error: function (data) {
                            alert('Please report this to MIS Department');
                        },
                    });
            },
        },
    }
</script>
