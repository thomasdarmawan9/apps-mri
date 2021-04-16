<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Warriors Application</title>

        <!-- CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets2/img/faviconmr.png" />

    </head>

    <body style="background:url(https://apps.mri.co.id/assets/img/backgrounds/1.jpg);background-size:100% 100%;background-repeat:no-repeat;">

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg" style="padding:50px 0 170px 0;">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                        <img src="<?php echo base_url(); ?>assets2/img/logo-mr.png" alt="Touching Heart Changing Lives" style="width: 200px;">
                            <h1><strong>Warrior</strong> Login</h1>
                            <div class="description">                            	
                            	
                            	<p>Supported By <img src="<?php echo base_url(); ?>assets/img/chrome.png" style="width: 100px;border-radius: 10px;"></p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-bottom">
                             	<?php echo validation_errors(); ?>
                             	
			                    <form role="form" action="<?php echo base_url(); ?>login/verification" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="user" placeholder="USERNAME" class="form-username form-control" id="form-username" autofocus="">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="PASSWORD" class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">LOGIN</button>
			                    </form>
		            </div>
                        </div>
                    </div>
                    	

                </div>
            </div>
            <p>Copyright© 2017 & beyond. PT Merry Riana Indonesia. All Rights Reserved.  </p>
            
        </div>


        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>assets2/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets2/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="<?php echo base_url(); ?>/assets2/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets2/js/scripts.js"></script>-->


    </body>

</html>