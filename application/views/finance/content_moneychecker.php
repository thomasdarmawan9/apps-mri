  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">


      <div id="container">
      
      		<?php if($this->session->flashdata('msg')<> null ){ ?>
			<?php if($this->session->flashdata('msg') == 'success'){ ?>
				<script>
					function modal(){
						swal("Approved", "Proses approved telah disimpan dan terhubung kepada user", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal untuk meng-Approved", "Proses Approve gagal", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
		<?php if($this->session->flashdata('msgnot')<>null ){ ?>
			<?php if($this->session->flashdata('msgnot') == 'success'){ ?>
				<script>
					function modal(){
						swal("Rijected", "Proses approved telah diriject dan info riject telah terhubung kepada user", "success");
					};
					window.onload = modal;
				</script>
			<?php }else{ ?>
				<script>
					function modal(){
						swal("Gagal untuk me-Riject", "Proses Riject gagal", "error");
					};
					window.onload = modal;
				</script>
			<?php } ?>
		<?php } ?>
		
		
		<div class="card">
		  <h3 class="card-header">Money Checker</h3>
		  <div class="card-body">
			
			<table class="table table-striped w-100" id="table1">
					<thead class="cf text-center">
					<tr>
					 <th>User</th>
					 <th>Jenis Income</th>
					 <th>Pengirim</th>
					 <th>Tanggal Transfer</th>
					 <th>Jumlah</th>
					 <th>Ke Rek.</th>
					 <th>Action</th>
					 <th>Tanggal Cek</th>
					</tr>
					</thead>
					<tbody class="text-center">
					<?php if(!empty($results)){ ?>
					<?php foreach ($results as $r){ ?>

						<tr>
							<td><span class="label label-info"><?php echo ucfirst($r->username); ?></span></td>
							<td><?php echo $r->jenis_income; ?></td>
							<td><?php echo $r->bank_pengirim.' - '.$r->nama_pengirim ; ?></td>
							<td><?php echo date("d-M-Y", strtotime($r->tgl_kirim)); ?></td>
							<td><?php echo number_format($r->jumlah); ?></td>
							<td><?php echo $r->ke_rekening ; ?></td>
							<td><?php if($r->approve == null){ ?> 
										<a href="<?= base_url(); ?>finance/incentive/approved_moneychecker/<?php echo $r->cumi; ?>/<?php echo md5($r->cumi); ?>">
											<button type="button" class="btn btn-success" >Approve</button>
										</a> 
										<a href="<?= base_url(); ?>finance/incentive/not_approved_moneychecker/<?php echo $r->cumi; ?>/<?php echo md5($r->cumi); ?>">
											<button type="button" class="btn btn-danger" >RIJECT</button>
										</a>
								<?php }elseif($r->approve == "ya"){ ?>
										<span class="alert alert-success">APPROVED</span> 
								<?php }else{ ?> 
										<span class="alert alert-danger">NOT APPROVED</span> 
								<?php } ?>
							</td>
							<td><?php if($r->tgl_approve <> null){ echo date("d-M-Y", strtotime($r->tgl_approve)); }else{ echo '-'; } ?></td>
						</tr>

					<?php } ?>     
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#table1').DataTable({
      'scrollX':true,
      'lengthMenu': [[10, 25, -1], [10, 25, "All"]
      ],
       'rowReorder': {
        'selector': 'td:nth-child(2)',
        'stateSave': true
      },
      'responsive': true
    });
  });
</script>

