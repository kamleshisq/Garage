<?php 
session_start();
if(isset($_REQUEST['email'])){
	$email = $_REQUEST['email'];
}else{
	$email = '';
}
if(isset($_REQUEST['password'])){
	$password = $_REQUEST['password'];
}else{
	$password = '';
}
if(isset($_REQUEST['secretkey'])){
	$secretkey = $_REQUEST['secretkey'];
}else{
	$secretkey = '';
}

$error='';

if($_SESSION['userid']==123 && $_SESSION['userlogintime']!=""){
	header("Location: dashboard.php"); exit;
}


if($email!="" && $password!="" && $secretkey=="")
{	
	if($_REQUEST['email']=="report@coverking.com" && $_REQUEST['password'] == "CoverK!ng")
	{ 
		$_SESSION['userid']=123;
		$_SESSION['userlogintime']=date("Y-m-d h:s:i");
		header("Location: dashboard.php");
		exit;
	}
	else
	{
		$error="Invalid Email/Passowrd, try again!!";
	}
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <!-- Required meta tags -->
        <style type="text/css">
        .loginbackground{background-image: url("images/image.jpg");z-index: -1;background-repeat: no-repeat; background-position: center center;  background-size: cover; }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CoverKing</title>
    <!-- plugins:css -->
   
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    
	<link rel="stylesheet" href="assets/css/shared/style.css?ds=45">
    
	<!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css?ds=45">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
  </head>

<!-- Mirrored from demo.themefisher.com/dlab/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 Mar 2021 07:15:24 GMT -->


<body class="h-100">
    <div class="authincation h-100 loginbackground">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <!-- <div class="col-md-10"> -->
                    <!-- <div class="authincation-content"> -->
                        <!-- <div class="row no-gutters"> -->
                            <!-- <div class="col-xl-6">
                                <div class="welcome-content">
                                    <div class="brand-logo">
                                        <a href="index.html">Spin & Wheel</a>
                                    </div>
                                    <h3 class="welcome-title">Welcome to Spin & Wheel</h3>
                                    
                                </div>
                            </div> -->

                            <div class="card col-xl-6 ">
                                 <div class="auth-form">
                                                           
                                    <div class="row mb-3">
                                <!-- <div class="header"> -->
                                 <img src="images/applogo.png" alt="logo"  style="display: block;margin-left: auto; margin-right: auto; width: 50%;">
                                 </div>
                                    <div class="font-weight-bold" style="font-size: 18px; text-align: center; margin-bottom: 5px; color: #1e8dad;">Sign in your account</div>
                                
                                    <!-- <h4 class="text-center mb-4">Sign in your account</h4> -->
                                    <!-- </div> -->
                                    <?php if($error!=""){?> <div class="errormsg"><?php echo $error?></div><?php }?>
                                    <form action="" method="POST">
                                    <input type="hidden" name="secretkey" value="">
                                        <input type="hidden" name="_token" value="Cgc0RE29qSrDNa73r1uz1ZoeFOthdEGWUev8fPOk">
                                        <div class="form-group">
                                              <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                     <div class="input-group-text"><i class="fa fa-user" style="color: black;"></i></div>
                                                 </div>
                                            <!-- <label><strong>Email</strong></label> -->
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email" autofocus placeholder="Email">
                                        </div>

                                                                        </div>
                                        <div class="form-group">
                                            <!-- <label><strong>Password</strong></label> -->
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                     <div class="input-group-text"><i class="fa fa-key" style="color: black;"></i></div>
                                                 </div>
                                            <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password" placeholder="Password">
                                        </div>
                                                                        </div>
                                      
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-lg" style="background-color: #1e8dad;border-color: #1e8dad;">Login</button>
                                        </div>
                                    </form>
                                   <!--  <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="https://fast.ispltest.com/register">Sign up</a></p>
                                    </div> -->
                                </div>
                            </div>
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</body>

    
<!-- Mirrored from demo.themefisher.com/dlab/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 Mar 2021 07:15:25 GMT -->
</html>
