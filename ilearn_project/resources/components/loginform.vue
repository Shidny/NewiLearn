<template>
    <section>
        <div class="container-fluid h-custom">
            <div class="col-lg-4 left-panel">
                <!-- <div class="col-md-10 col-md-offset-1"> -->
                    <div id='validation_msg'></div>
                    <legend>
                        <h1 style="color: #030f99;"><b>iLEARN PORTAL</b></h1>
                    </legend>
                    <form class="form-login">
                        <!-- Email input -->
                        <div class="form-outline mb-2">
                            <input type="text" v-model="this.login.username" class="form-control form-control-lg" style="width: 100%;height: 35px;"
                            placeholder="Enter your username" id="username"/>
                        </div>
                        <!-- Password input -->
                        <div class="form-outline mb-2">
                            <input type="password" v-model="this.login.password" class="form-control form-control-lg" style="width: 100%;height: 35px;"
                            placeholder="Enter your password" id="password"/>
                        </div>
                        <!-- Forget Password -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="/forgot_password" class="text-body">Forgot password?</a>
                        </div>
                        <!-- Login Button -->
                    </form>
                        <div class="text-center text-lg-start">
                            <button @click="Login()" id="login_btn" class="btn btn-primary btn-lg">Login</button>
                        </div>
                <!-- </div> -->
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                login:{
                    username: "",
                    password: ""
                }
            }
        },

        mounted() {
            var vue = this 
            $(document).on('keyup','input', function (e) {
                if($("#username").is(":focus") && e.key == "Enter"){
                    vue.Login();
                }
                else if ($("#password").is(":focus") && e.key == "Enter") {
                    vue.Login();
                }
            })
        },

        methods:{
            Login(e){     
                var vue = this 
                var validation_msg = ""                   
                $.ajax({
                    url: 'Login',
                    type: "POST",
                    data: {
                        username:vue.login.username,
                        password:vue.login.password,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    
                    },
                    dataType: "JSON",
                    complete: function(data) {
                    },
                    success: function(data) {
                        console.log(data.status);
                        if (data.status) {
                            
                            location.reload();
                        }
                        else{
                            $('#validation_msg').html('');
                            validation_msg += `<div class="alert alert-danger "><ul>`;
                            $.each(data.msg, function (key, value) {
                            validation_msg += '<li>' + value + '</li>';
                            });
                            $('#validation_msg').append(validation_msg)
                        }
                    }
                    // ,
                    // error: function(data) {
                    //  // window.location.href= "login.php";
                    // }
                });
            },
        },
    }
</script>
