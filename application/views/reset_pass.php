
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
		  <div class="text-center mb-4 mt-3">
			<img src="<?php echo base_url(); ?>inc/image/logo.png" alt="Touching Heart Changing Lives" style="width: 200px;">
			<h1 class="h3 mb-3 mt-3 font-weight-normal text-white"><strong>Warrior</strong> Reset Password</h1>
		  </div>
        
        <div id="form-login">
            <form role="form" action="<?php echo base_url(); ?>login/resetpass" method="post" class="form-signin mt-4">
                  <input type="hidden" name="id" value="<?= $id; ?>" required>
        		  <div class="form-label-group">
        			<input type="password" name="np" id="np" placeholder="New Password" class="form-username form-control" autofocus="" required>
        			<small class="text-white" style="display:none;" id="fb-np">Minimal 6 character</small>
        		  </div>
        
        		  <div class="form-label-group">
        			<input type="password" name="cp" id="cp" placeholder="Confirm Password" class="form-password form-control" required>
        			<small class="text-white" style="display:none;" id="fb-cp">Tidak sesuai dengan New Password!</small>
        		  </div>
        
        		  <button class="btn btn-lg btn-success btn-block" type="submit" id="btn-submit" disabled>Change Password</button>
    		</form>
		 </div>
		  
		  <p class="mt-5 mb-3 text-center text-white">Copyright© 2017 & beyond.<br>PT Merry Riana Group. All Rights Reserved.</p>
		<!-- </div> -->
		<!-- </div> -->
	</div>
</body>
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/mdb.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/bootstrap.min.js"></script>

<script>
    var sts_np = '';
    var sts_cp = '';
    
    $('#np,#cp').change(function (e){
       check();
    });
    
    function check(){
        
        
        if($('#np').val().length < 6){
           $('#np').removeClass('is-valid');
           $('#np').addClass('is-invalid');
           $('#fb-np').show();
           sts_np = 0;
       }else{
           $('#np').addClass('is-valid');
           $('#np').removeClass('is-invalid');
           $('#fb-np').hide();
           sts_np = 1;
       }
    
        if($('#np').val() != $('#cp').val()){
            $('#cp').removeClass('is-valid');
            $('#cp').addClass('is-invalid');
            $('#fb-cp').show();
            sts_cp = 0;
        }else{
            $('#cp').addClass('is-valid');
            $('#cp').removeClass('is-invalid');
            $('#fb-cp').hide();
            sts_cp = 1;
        }
        
        if((sts_np == 1) && (sts_cp == 1)){
            $("#btn-submit").prop("disabled",false);
        }else{
            $("#btn-submit").prop("disabled",true);
        }
    }
    
</script>

</html>
