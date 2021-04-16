  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="/?auth=task">Task Allocation</a> </li>
			<li><a href="#" class="active">Confirm Delete Task Allocation</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Confirm Delete <span class="semi-bold">Task Allocation</span></h3>
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
		    	<form method="post" action="/display/delete_task">
		    	<div style="display:none;">
			    	<input name="id" class="form-control" required="" type="text" value="<?php echo $_GET['id']; ?>">
			    	<input name="token" class="form-control" required="" type="text" value="<?php echo $_GET['token']; ?>">
		    	</div>
		    	<?php foreach($results as $r){ ?>
			<div class="panel panel-danger" style="overflow: hidden;">
				<div class="panel-heading">
					Delete Task Allocation
				</div>
				<div>
					<div class="grid-body no-border">
						<div class="col-md-4">
						<h3><span class="semi-bold">Perhatian :</span></h3>
				                  <p>Segala data baik dari sisi : <i><b>Warriors yang bertugas</b></i>, <i><b>jumlah closingan</b></i>, dan <i><b>laporan Event</b></i> <i><b>serta segala bentuk data yang berhubungan</b></i> dengan Event ini akan <b>TERHAPUS</b> dan tidak akan pernah kembali dikarenakan <b>penghapusan bersifat permanen</b>.</p>
				                </div>
				                
				                <div class="col-md-4">
				                  <h3>Apakah  <span class="semi-bold">Kamu Serius ?</span></h3>
				                  <p>Semua data yang berhubungan dengan :<br>
				                   <b style="font-size:2em;"><?php echo $r->event; ?></b><br>
				                   Lokasi : <b style="font-size:1em;"><?php echo $r->location; ?></b><br>
				                   Tanggal : <b style="font-size:1em;"><?php echo date("d-M-Y", strtotime($r->date)); ?></b><br> akan dihapus dari sistem ini. </p>
				                  <br>
				                  <a href="/?auth=task"><button type="button" class="btn btn-white">BATALKAN</button></a> <button type="submit" class="btn btn-danger">YA HAPUS SEKARANG</button>
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

