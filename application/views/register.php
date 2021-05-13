<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Signup in CodeIgniter using Ajax from Scratch</title>
        <!--Include Jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!--Include Bootstrap-->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">

        <style>

            body{
                background-image: url("<?php echo base_url(); ?>assets/images/gray-background.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }

            #login .container #login-row #login-column #login-box {
                margin-top: 60px;
                max-width: 600px;
                height: 320px;
                background-color: #f7f6f6;
            }

            #login .container #login-row #login-column #login-box #signup-form {
                padding: 20px;
            }

            #response{
                color: red;
            }
            #back{
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div class="login-wrap">
            <div id="login">
                <h3 class="text-center text-white pt-5">Sign up in CodeIgniter using Ajax</h3>
                <div class="container">
                    <div id="login-row" class="row justify-content-center align-items-center">
                        <div id="login-column" class="col-md-6">
                            <div id="login-box" class="col-md-12">
                                <!--HTML FORM-->
                                <div id="signup-form" class="form">
                                    <h3 class="text-info">Sign up</h3>
                                    <p id="response"></p>
                                    <div class="form-group">
                                        <label for="fullname" class="text-info">Full Name:</label><br>
                                        <input type="text" name="fullname" id="fullname" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="text-info">Username:</label><br>
                                        <input type="text" name="username" id="username" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="text-info">Password:</label><br>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="reset" id="reg_reset" name="submit" class="btn btn-danger btn-md" value="Reset" >
                                        <input type="submit" id="reg_submit" name="submit" class="btn btn-info btn-md" value="Submit" >
                                        <br>
                                        <br>
                                        <a class="small" id="back" href="<?php echo base_url(); ?>LoginController">Back</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
        <script>

             $(document).ready(function() {
                $('#reg_submit').on('click', function(event){
                    event.preventDefault();
                    var fullname = $('#fullname').val();
                    var username = $('#username').val();
                    var password = $('#password').val();
                    if(fullname == ''){
                        $('#fullname',).focus();
                        swal('Required', 'Full name is required', 'warning')
                        return false;
                    }
                    if(username == ''){
                        $('#username',).focus();
                        swal('Required', 'Username is required', 'warning')
                        return false;
                    }
                    if(password == ''){
                        $('#password',).focus();
                        swal('Required', 'Password is required', 'warning')
                        return false;
                    }
                    $.ajax({
                        url: "<?= base_url() ?>LoginController/create_user",
                        method: 'POST',
                        //data: "UserName=" + username + "&Password=" + password,
                        data:{
                            fullname : fullname,
                            username : username,
                            password : password
                        },
                        dataType:"json",
                        success: function (data) {
                            if(data.status == true){
                                // swal({
                                //     title:data.title,
                                //     text:data.message,
                                //     type:"success"
                                // }, function(){
                                //     //$('#signup-form').trigger('reset');
                                //     //$('#username').focus();
                                //     window.location = "<?php echo base_url(); ?>LoginController";
                                // });
                                swal({
                                    title:data.title,
                                    text:data.message,
                                    type:"success"
                                }).then(function(){
                                    window.location = "<?php echo base_url(); ?>LoginController";
                                })
                            }else{
                                swal({
                                    title:data.title,
                                    text:data.message,
                                    type:"error"
                                },function(){
                                    $('#signup-form').trigger('reset');
                                });
                            }
                        }

                    });
                });
            })
        </script>
    
    </body>
</html>