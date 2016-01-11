<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Register</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>Register to IN+</h3>
            <p>Create account to see it in action.</p>
            <form id="form" class="m-t" role="form" method="post">
                <div class="form-group">
                    <input type="text" name = "Firstname" placeholder="First Name" class="form-control" required="" aria-required="true">
                    <input type="text" name = "Lastname" placeholder="Last Name" class="form-control" required="" aria-required="true">
                </div>
                <div class="form-group">
                    <input type="email" name = "email" placeholder="Email" class="form-control" required="" aria-required="true">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control" name="password" required="" aria-required="true">
                </div>
                <div class="form-group">
                    <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" onclick="return register()" class="btn btn-primary block full-width m-b">Register</button>
                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.php">Already have an account?</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $("input[type=submit]").attr('disabled','disabled');
        });


         $(document).ready(function(){
             $("#form").validate({
                 rules: {
                     password: {
                         required: true,
                         minlength: 6
                     },
                     Firstname: {
                        required: true,
                        minlength: 2
                     },
                     Lastname: {
                        required: true,
                        minlength: 2
                     },
                  },
                  submitHandler: function(form) {
                    $("input[type=submit]").removeAttr('disabled');
                 }
             });
        });
        
        function register(){
                var email = $("[type$='email']").val();
                var password = $(":password").val();
                var first_name = $( "input[name$='Firstname']" ).val();
                var last_name = $( "input[name$='Lastname']" ).val();
                if(email == "" || password == ""){
                    return true;
                }
                else{    
                    $.post("ajax_handler.php", {
                            action: "register",
                            first_name: first_name,
                            last_name: last_name,
                            email: email, 
                            password: password
                        },
                            function(result){
                                console.log(result)
                            }
                        )
                }
                return false;
        };
    </script>
</body>

</html>
