      
    <?php if(!empty($_GET['error'])){ ?>
	<div class="alert alert-info alert-danger">
		<a class="panel-close close" data-dismiss="alert" >×</a> 
		<i class="fa fa-exclamation-triangle"></i>
		Mohon maaf size foto kamu telah melebihi > 500 kb, mohon pastikan ukurannya lebih kecil.
	</div>
    <?php } ?>

    <form action="http://apps.mri.co.id/index.php/display/do_upload" enctype="multipart/form-data" method="post"  class="form-horizontal" role="form" accept-charset="utf-8">
    <!-- left column -->
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="text-center">
        <img src="/assets/profile/pp/<?php echo $this->session->userdata('picture'); ?>" class="avatar img-circle img-thumbnail" alt="avatar">
        <h6>Upload a different photo...</h6>
        <h6> Only size < 500kb</h6>
        <input type="file" class="text-center center-block well well-sm" name="userpic" >
      </div>
    </div>
    <!-- edit form column -->
    
    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
    <?php if(empty($_GET['error'])){ ?>
      <div class="alert alert-info alert-dismissable">
        <a class="panel-close close" data-dismiss="alert" >×</a> 
        <i class="fa fa-coffee"></i>
        Disini kamu bisa merubah semua data kamu.
      </div>
      <?php } ?>
      <h3>Personal info</h3>
        <div class="form-group">
          <label class="col-lg-3 control-label">Name:</label>
          <div class="col-lg-8">
            <input class="form-control" value="<?php echo $this->session->userdata('name'); ?>" type="text" name="name">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Email:</label>
          <div class="col-lg-8">
            <input class="form-control" value="<?php echo $this->session->userdata('email'); ?>" type="text" name="email">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Division:</label>
          <div class="col-lg-8">
            <input class="form-control" value="<?php echo $this->session->userdata('divisi'); ?>" type="text" name="divisi">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Position:</label>
          <div class="col-lg-8">
            <input class="form-control" value="<?php echo $this->session->userdata('position'); ?>" type="text" name="position">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input class="btn btn-primary" value="Save Changes" type="submit">
            <span></span>
            <input class="btn btn-default" value="Cancel" type="reset">
          </div>
        </div>
           
    </div>
</form>
	</div>
	<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12"></div>
	 <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
	 
	 <?php if(!empty($_GET['changepass'])and ($_GET['changepass']='close')){ ?>
		<div class="alert alert-info alert-danger">
			<a class="panel-close close" data-dismiss="alert" >×</a> 
			<i class="fa fa-exclamation-triangle"></i>
			Your password is wrong.
		</div>
	<?php } ?>
	
      <?php if(!empty($_GET['pass'])){ ?>
      <div class="alert alert-success alert-dismissable">
        <a class="panel-close close" data-dismiss="alert" >×</a> 
        <i class="fa fa-info"></i>
        password Anda berhasil dirubah.
      </div>
      <?php } ?>
	
	<form action="http://apps.mri.co.id/index.php/display/next_change_pass" enctype="multipart/form-data" method="post"  class="form-horizontal" role="form" accept-charset="utf-8">
	<h3>Change password</h3>
        <div class="form-group">
          <label class="col-md-3 control-label">Current Password:</label>
          <div class="col-md-8">
            <input class="form-control" value="" type="password" name="pass">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input class="btn btn-primary" value="Next" type="submit">
            <span></span>
            <input class="btn btn-default" value="Cancel" type="reset">
          </div>
        </div>
	</form>
	</div>
