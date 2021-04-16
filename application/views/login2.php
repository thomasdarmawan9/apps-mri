
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Warrior Application</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>inc/mdb/css/mdb.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>inc/mdb/css/bootstrap.min.css">
  <link href="<?= base_url('inc/floating-label.css')?>" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('inc/image/faviconmr.png')?>" />
  <script type="text/javascript" src="<?= base_url();?>inc/jquery/jquery.min.js"></script>
  <!-- Custom styles for this template -->
  <style>
      #changepass,#back{cursor:pointer;}
  </style>
</head>

<body>
	<div style="background:url(<?= base_url('inc/image/bg.jpeg'); ?>);background-size: cover;position:absolute;top:0;left:0;filter: sepia(50%) brightness(50%) contrast(150%) blur(3px) saturate(150%);" class="w-100 h-100"></div>
	<div class="w-100 h-100" style="background: #363638a1;position: absolute;top: 0;left: 0;">
	  
	   <!--  <div class="card">
		  <div class="card-body"> -->
		  <div class="text-center mb-4">
			<img src="<?php echo base_url(); ?>inc/image/logo.png" alt="Touching Heart Changing Lives" style="width: 200px;">
			<h1 class="h3 mb-3 mt-3 font-weight-normal text-white"><strong>Warrior</strong> Login</h1>
			<div class="description">                             
			  <p class="text-white">Supported By <img src="<?php echo base_url(); ?>inc/image/chrome.png" style="width: 100px;border-radius: 10px;"></p>
			</div>
		  </div>
        
        <div id="form-login">
            <form role="form" action="<?php echo base_url(); ?>login/verification" method="post" class="form-signin mt-4">
                  <?= validation_errors(); ?>
                  <?php if(!empty($this->session->flashdata('item'))){ ?>
            	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <?= $this->session->flashdata('item'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
            	  <?php } ?>
        		  <div class="form-label-group">
        			<input type="text" name="user" placeholder="Username" class="form-username form-control" autofocus="" required>
        			<!-- <label for="inputEmail">Username</label> -->
        		  </div>
        
        		  <div class="form-label-group">
        			<input type="password" name="password" placeholder="Password" class="form-password form-control" id="form-password" required>
        			<!-- <label for="inputPassword">Password</label> -->
        		  </div>
        
        		  <button class="btn btn-lg red btn-block" type="submit">Sign in</button>
    		</form>
		 </div>
		 
		 <div id="form-forgetpass" style="display:none;">
		     <form role="form" action="<?php echo base_url(); ?>login/send_changepasslink" method="post" class="form-signin mt-4">
    		     <div class="form-label-group">
        			<input type="email" name="email" placeholder="Email" class="form-username form-control" autofocus="" required>
        			<!-- <label for="inputEmail">Username</label> -->
        		  </div>
        
        		  <button class="btn btn-lg red btn-block" type="submit">Change Password</button>
    		  </form>
		 </div>
		  <div class="form-signin pt-0">
		      <hr style="border-color:white;" class="my-1">
		      <small class="text-white mx-1" id="changepass">Forget Password ?</small>
		      <small class="text-white mx-1" id="back" style="display:none;"><< Back To Login</small>
		  </div>
		  
		  <p class="mt-5 mb-3 text-center text-white">Copyright© 2017 & beyond.<br>Merry Riana Group. All Rights Reserved.</p>
		<!-- </div> -->
		<!-- </div> -->
	</div>
</body>
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/mdb.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/bootstrap.min.js"></script>

<script>
    $('#changepass').click(function (e){
       $("#form-login,#changepass").hide();
       $("#form-forgetpass,#back").show();
    });
    
    $('#back').click(function (e){
       $("#form-forgetpass,#back").hide();
       $("#form-login,#changepass").show();
    });
</script>

</html>
