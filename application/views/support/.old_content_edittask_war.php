  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="/?auth=task">Task Allocation</a> </li>
			<li><a href="#" class="active">Delete Warriors From Task</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Choose PD <span class="semi-bold"></span></h3>
      </div>
      <div id="container">
		
      <div class="grid simple">
		<div class="grid-title no-border">
		      <h4>Add <span class="semi-bold">Delete Warriors From Task</span></h4>
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
					<table class="table table-striped table-flip-scroll cf">
					<thead class="cf">
						<tr>
						 <th>No</th>
						 <th>Username</th>
						 <th>Aksi</th>
						</tr>
						</thead>
					<tbody>
						<?php if(!empty($hasil)){ ?>
							<?php $no = 1; ?>
							<?php foreach($hasil as $gn){ ?>
							<tr>
								<td style="border: 1px solid lightgray;text-align:center;"><?php echo $no; ?></td>
								<td style="border: 1px solid lightgray;"><b><?php echo ucfirst($gn->username); ?><?php if($gn->paytask ==
 1){ ?> - <span class="label label-info">Additional</span> <?php } ?></b></td>
								<td style="border: 1px solid lightgray;"><a href="/display/delete_wartask/<?php echo $_GET['id']; ?>/<?php echo $_GET['token']; ?>/<?php echo $gn->id ?>/<?php echo md5($gn->id); ?>"><button type="button" class="btn  btn-danger" ><i class="fa fa-trash"></i> Delete Warriors</button></a></td>
							</tr>
							<?php $no = $no + 1; ?>
							<?php } ?>
						<?php } ?>
					</tbody>
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

