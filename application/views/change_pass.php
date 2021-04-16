
    <form action="<?php echo base_url(); ?>display/change_pass" enctype="multipart/form-data" method="post"  class="form-horizontal" role="form" accept-charset="utf-8">
    <!-- left column -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		
	<div class="form-group">
	<label class="col-lg-5 control-label"></label>
		<div class="col-lg-3">
			<div class="text-center">
				<img src="/assets/profile/pp/<?php echo $this->session->userdata('picture'); ?>" class="avatar img-circle img-thumbnail" alt="avatar">
			</div>
			<?php if(!empty($_GET['wrong'])){ ?>
			<div class="alert alert-info alert-danger">
				<a class="panel-close close" data-dismiss="alert" >×</a> 
				<i class="fa fa-exclamation-triangle"></i>
				Confirm Password is wrong.
			</div>
			<?php } ?>
			<?php if(!empty($_GET['sumpass'])){ ?>
			<div class="alert alert-info alert-danger">
				<a class="panel-close close" data-dismiss="alert" >×</a> 
				<i class="fa fa-exclamation-triangle"></i>
				The number of characters must be more than 5 .
			</div>
			<?php } ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-5 control-label">New Password:</label>
		<div class="col-sm-3">
			<input class="form-control" value="" type="password" name="np">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 control-label">Confirm Password:</label>
		<div class="col-sm-3">
			<input class="form-control" value="" type="password" name="cp">
		</div>
	</div>
	<div class="form-group">
          <label class="col-sm-5 control-label"></label>
          <div class="col-sm-3" style="text-align:right;">
            <input class="btn btn-primary" value="Save Changes" type="submit">
            <span></span>
            <input class="btn btn-default" value="Cancel" type="reset">
          </div>
        </div>
	</div>

</form>