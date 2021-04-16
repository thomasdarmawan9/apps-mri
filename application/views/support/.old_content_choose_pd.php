  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="/?auth=task">Task Allocation</a> </li>
			<li><a href="#" class="active">Choose PD</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Choose PD <span class="semi-bold"></span></h3>
      </div>
      <div id="container">
		
      <div class="grid simple">
		<div class="grid-title no-border">
		      <h4>Add <span class="semi-bold">Warriors to Task</span></h4>
		      <div class="tools">
		      	<a href="javascript:;" class="collapse"></a>
		      	<a href="#grid-config" data-toggle="modal" class="config"></a>
		      	<a href="javascript:;" class="reload"></a>
		      	<a href="javascript:;" class="remove"></a>
		      </div>
		</div>
		<div class="grid-body no-border">
			<?php foreach($results as $r) { ?>
				<form action="/display/getpd" method="post">
		   		<h3 style="text-align: center;">Event : <?php echo $r->event; ?></h3>
		   		<h3 style="text-align: center;">Lokasi : <?php echo $r->location; ?></h3>
		   		<h3 style="text-align: center;">Tanggal : <?php echo date("d-M-Y", strtotime($r->date)); ?></h3>
		    		<hr>
		    		
		    		 <div class="rows">
		                      <div class="col-md-6 col-md-offset-3">
					<div class="form-group">
						<div style="display:none;">
							<input type="text" value="<?php echo $_GET['id'];?>" name="id" required>
							<input type="text" value="<?php echo $_GET['token'];?>" name="token" required>
						</div>
		                        <label class="form-label">Name</label>
		                        <span class="help">e.g. "andy"</span>
						<div class="input-with-icon  right">                                       
							<i class=""></i>
							 <select name="getpd" class="form-control" style="padding:0;border:0px;font-size: 1.5em;    background: #f5f5f5;" required>
					                    <option value=""></option>
					                   <?php foreach($hasil as $gn){ ?>
										<?php if($gn->username<>'admin'){ ?>
					                    <option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
										<?php } ?>
					                    <?php } ?>
					                </select>                                 
						</div>
		                      </div>
		                      
		                      <div class="form-group" style="text-align: center;">
		                      	<button type="submit" class="btn  btn-primary" id="showtambah" >Jadikan PD</button>
		                      </div>
	                      
		                     </div>
		               </div> 
		               
		               </form>
	                     
	                      
	                    
		            
			
			<?php } ?>
		</div>
		 
		    
	</div>
		
		
		
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

