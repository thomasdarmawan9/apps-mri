  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="/?auth=task">Task Allocation</a> </li>
			<li><a href="#" class="active">Edit Task Allocation</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Edit <span class="semi-bold">Task Allocation</span></h3>
      </div>
      <div id="container">
		
      <div class="grid simple">
		<div class="grid-title no-border">
		      <h4><span class="semi-bold"> </span></h4>
		      <div class="tools">
		      	<a href="javascript:;" class="collapse"></a>
		      	<a href="#grid-config" data-toggle="modal" class="config"></a>
		      	<a href="javascript:;" class="reload"></a>
		      	<a href="javascript:;" class="remove"></a>
		      </div>
		</div>
		    <div class="grid-body no-border">
		    	
		    	<hr>
		    	<form method="post" action="/display/edit_task">
		    	<div style="display:none;">
			    	<input name="id" class="form-control" required="" type="text" value="<?php echo $_GET['id']; ?>">
			    	<input name="token" class="form-control" required="" type="text" value="<?php echo $_GET['token']; ?>">
		    	</div>
		    	<?php foreach($results as $r){ ?>
			<div class="panel panel-success" style="overflow: hidden;">
				<div class="panel-heading">
					Edit Task Allocation
				</div>
				<div>
					<div class="grid-body no-border"> <br>
						<div class="form-group">
							<label class="form-label">Nama Event</label>
							<span class="help">e.g. "SP LA Or Event Life Mastery"</span>
							<div class="input-with-icon  right">                                       
								<i class=""></i>
								<input name="nama" id="nama" class="form-control" required="" type="text" value="<?php echo $r->event; ?>">                                 
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Lokasi</label>
							<span class="help">e.g. "Puri Indah Or Ibis Style Hotel"</span>
							<div class="input-with-icon  right">                                       
								<i class=""></i>
								<input name="lokasi" id="lokasi" class="form-control" required="" type="text" value="<?php echo $r->location; ?>">                                 
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="form-label">Tanggal</label>
									<span class="help">e.g. "andy@mri.co.id"</span>
									<div class="input-with-icon  right">                                       
										<i class=""></i>
										<input name="tgl" id="tgl" class="form-control" required="" type="date" value="<?php echo $r->date; ?>">                                 
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="form-label">Komisi Dp</label>
									<span class="help">e.g. "50000 etc"</span>
									<div class="input-with-icon  right">                                       
										<i class=""></i>
										<input value="<?php echo $r->komisi_dp; ?>" name="komisi_dp" class="form-control" required="" type="number" >                                 
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="form-label">Komisi Lunas</label>
									<span class="help">e.g. "50000 etc"</span>
									<div class="input-with-icon  right">                                       
										<i class=""></i>
										<input value="<?php echo $r->komisi_lunas; ?>" name="komisi_lunas" class="form-control" required="" type="number" >                                 
									</div>
								</div>
							</div>
						</div>
						          
						<div class="form-actions">  
							<div class="pull-right">
							<button type="submit" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
							<button type="button" class="btn btn-white btn-cons">Cancel</button>
							</div>
						</div>
						
						
			
			
			
					</div>
				</div>
			</div>
		<?php } ?>
		</form>
		
		
		
		    	
		    	
		    </div>
	</div>
		
		
		
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

