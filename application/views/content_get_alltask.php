  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="#" class="active">Task Allocation</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Task <span class="semi-bold">Allocation</span></h3>
      </div>
      <div id="container">
      
      	<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
	</script>
		
		<?php if($this->session->flashdata('msg')<>null ){ ?>
			<?php if($this->session->flashdata('msg') == 'success'){ ?>
				<script>
					function modal(){
						swal("Berhasil Ditambahkan", "Event ditambahkan di List", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal ditambahkan", "", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		<?php if($this->session->flashdata('msgupdate')<>null ){ ?>
			<?php if($this->session->flashdata('msgupdate') == 'success'){ ?>
				<script>
					function modal(){
						swal("Berhasil Diubah", "Pengubahan Berhasil diproses", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal diubah", "", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
		<?php if($this->session->flashdata('msgdelevent')<>null ){ ?>
			<?php if($this->session->flashdata('msgdelevent') == 'success'){ ?>
				<script>
					function modal(){
						swal("Berhasil Didelete", "Penghapusan Event Berhasil diproses", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal dihapus", "", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
		<?php if($this->session->flashdata('msgaddwar')<>null ){ ?>
			<?php if($this->session->flashdata('msgaddwar') == 'success'){ ?>
				<script>
					function modal(){
						swal("Warriors berhasil dimasukan kedalam Event", "Status Berhasil disimpan", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal menambahkan warriors kedalam Event", "", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
		<?php if($this->session->flashdata('msgpd')<>null ){ ?>
			<?php if($this->session->flashdata('msgpd') == 'success'){ ?>
				<script>
					function modal(){
						swal("PD Berhasil ditentukan", "Status Berhasil disimpan", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal merubah status PD", "", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
		<?php if($this->session->flashdata('msgdelwar')<>null ){ ?>
			<?php if($this->session->flashdata('msgdelwar') == 'success'){ ?>
				<script>
					function modal(){
						swal("Warriors berhasil dihapus / Dikurangkan", "Berhasil dihapus", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal Menghapus Warriors", "", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
	
	<div class="grid simple">
		<div class="grid-title no-border">
		      <h4>List <span class="semi-bold">Task Allocation</span></h4>
		      <div class="tools">
		      	<a href="javascript:;" class="collapse"></a>
		      	<a href="#grid-config" data-toggle="modal" class="config"></a>
		      	<a href="javascript:;" class="reload"></a>
		      	<a href="javascript:;" class="remove"></a>
		      </div>
		</div>
		<div class="grid-body no-border">
		    <a href="?auth=addtask"><button type="button" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah</button></a>
		    <hr>
		    
		    <table class="table table-striped table-flip-scroll cf">
		            <thead class="cf">
		               <tr>
		                 <th>No</th>
		                 <th style="width:100px;">Event</th>
		                 <th style="width:150px;">Lokasi</th>
		                 <th>Tanggal</th>
		                 <th style="text-align:center;">Jmh. Warriors | PD</th>
		                 <th>Aksi</th>
		               </tr>
		            </thead>
		            <tbody>
		            <?php if(!empty($results)){ ?>
		            	<?php $no = 1; $loop = 1; $id_sblm = null; ?>
		      
		            	<?php foreach($results as $r){ ?>
		            	
		            		
		            		<?php
		            		
		            		if($loop == 1){
		            			$event = $r->event;
			            		$location = $r->location;
			            		$tgl = date("d-M-Y", strtotime($r->date));
			            		$id = $r->idt;
			            		
			            		//Check pd dibaris awal
			            		if($r->tugas == 'pd'){
			            			$tugas = $r->username;
			            		}
			            		
			            		if($r->id_user == null){
			            			$war = 0;
			            		}else{
			            			$war = 1;
			            		}
			            		
			            		$loop = $loop + 1;
		            		}
		            		elseif($id == $r->idt){
		            			$war = $war + 1;
		            			
		            			//Check pd pada baris setelahnya
		            			if($r->tugas == 'pd'){
			            			$tugas = $r->username;
			            		}
		            		}
		            		elseif($id <> $r->idt){ ?>
		            		
		            			
		            		
		            			<tr>
				            		<td><?php echo $no; ?></td>
				            		<td><?php echo $event;?></td>
				            		<td><?php echo $location;?></td>
				            		<td><?php echo $tgl; ?></td>
				            		<td><a href="?auth=edittaskwarriors&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-success" data-toggle="tooltip" data-placement="left" title="Jumlah Warriors"> <?php echo $war; ?> </button></a> <a href="?auth=choosepd&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
				            		<?php if(empty($tugas)) { ?>
				            			<button type="button" class="btn  btn-danger" data-toggle="tooltip" data-placement="right" title="Siapa PD-nya ?"> PD ? </button>
				            		<?php }else{ ?>
				            			<button type="button" class="btn  btn-info" data-toggle="tooltip" data-placement="right" title="PD"> <?php echo ucwords($tugas); ?></button>
				            		<?php } ?></a></td>
				            		<td><a href="?auth=addtaskwarriors&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah Warriors</button></a> <a href="?auth=editevent&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-warning"><i class="fa fa-edit"></i> Edit Event</button></a> <a href="?auth=delevent&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-danger" id="showtambah"><i class="fa fa-trash"></i> Delete Event</button></a> <a href="?auth=report&id=<?php echo $id; ?>&eventname=<?php echo $event; ?>&tgl=<?php echo $tgl; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-success" id="showtambah">R</button></a></td>
				            	</tr>
				            	<?php $no = $no +1; ?>
				            	
		            		
		            		<?php
		            			$event = $r->event;
			            		$location = $r->location;
			            		$tgl = date("d-M-Y", strtotime($r->date));
			            		$id = $r->idt;
			            		$tugas = $r->tugas;
			            		
			            		if($r->id_user == null){
			            			$war = 0;
			            		}else{
			            			$war = 1;
			            		}
			            		
			            		//Check pd pada baris setelahnya
		            			if($r->tugas == 'pd'){
			            			$tugas = $r->username;
			            		}
		            		
		            		} ?>
			            	
		            	<?php } ?>
		            	
		            			<tr>
				            		<td><?php echo $no; ?></td>
				            		<td><?php echo $event;?></td>
				            		<td><?php echo $location;?></td>
				            		<td><?php echo $tgl; ?></td>
				            		<td><a href="?auth=edittaskwarriors&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-success" data-toggle="tooltip" data-placement="left" title="Jumlah Warriors"> <?php echo $war; ?> </button></a> <a href="?auth=choosepd&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
				            		<?php if(empty($tugas)) { ?>
				            			<button type="button" class="btn  btn-danger" data-toggle="tooltip" data-placement="right" title="Siapa PD-nya ?"> PD ? </button>
				            		<?php }else{ ?>
				            			<button type="button" class="btn  btn-info" data-toggle="tooltip" data-placement="right" title="PD"> <?php echo ucwords($tugas); ?></button>
				            		<?php } ?></a></td>
				            		<td><a href="?auth=addtaskwarriors&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah Warriors</button></a> <a href="?auth=editevent&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-warning"><i class="fa fa-edit"></i> Edit Event</button></a> <a href="?auth=delevent&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-danger" id="showtambah"><i class="fa fa-trash"></i> Delete Event</button></a> <a href="?auth=report&id=<?php echo $id; ?>&eventname=<?php echo $event; ?>&tgl=<?php echo $tgl; ?>&token=<?php echo md5($id); ?>"><button type="button" class="btn  btn-success" id="showtambah">R</button></a></td>
				            	</tr>
		            	
		            <?php } ?>
		            </tbody>
	            </table>
	         
		</div>
		 
		    
	</div>
		
		
		
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

