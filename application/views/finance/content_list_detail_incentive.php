  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content">

      <div id="container">
	  
	  
		<div class="card mb-3">
		  <h3 class="card-header">Detail</h3>
		  <div class="card-body">
			
			<div class="row">
				<div class="col-md-6">
				
				<div class="form-group row">
					<label for="inputEvent" class="col-sm-3 col-form-label">Event</label>
					<div class="col-sm-6">
					  <input type="text" name="eventp" class="form-control" id="inputEvent" value="<?= $_GET['event']; ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputLoc" class="col-sm-3 col-form-label">Location</label>
					<div class="col-sm-6">
					  <input type="text" name="locp" class="form-control" id="inputLoc" value="<?= $_GET['loc']; ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputDate" class="col-sm-3 col-form-label">Date</label>
					<div class="col-sm-6">
					  <input type="text" name="tglp" class="form-control" id="inputDate" value="<?= $_GET['tgl']; ?>" readonly>
					</div>
				</div>
			
				</div><!-- Akhir md 6-->
				<div class="col-md-6" style="text-align: center;">					
					<?php if(!empty($results)){ ?>
						<?php foreach($results as $r){ ?>
							<?php if($cek_app_incen == true){ 
								$btn = '<b>APPROVE ALL</b>';
								$pesan = 'Jika sudah Ok, bisa tekan tombol Approved. Jika ada kesalahan silahkan Hubungi PD-nya.';
								$hsl = '<a href="'.base_url().'finance/incentive/approved_incentive?id='.$_GET['id'].'&token='.$_GET['token'].'"><button class="btn btn-success" data-toggle="popover" data-content="1 kali klik untuk approve semua task ini, batalkan bisa kapan saja" data-placement="top" data-trigger="hover">'.$btn.'</button></a>';
							 
							    $paid='';
							}else{ 
							 	$pesan = 'Status Approved telah dilakukan.';
								$btn = 'UNAPPROVE ALL';
								$hsl = '<a href="'.base_url().'finance/incentive/unapproved_incentive?id='.$_GET['id'].'&token='.$_GET['token'].'"><button class="btn btn-danger" data-toggle="popover" data-content="1 kali klik untuk meng-unapprove semua task ini & Merubah semua menjadi Unpaid" data-placement="top" data-trigger="hover">'.$btn.'</button></a>';
								
								if($cek_paid_incen == true){
								    $paid = '<a href="'.base_url().'finance/incentive/approved_paid_all?id='.$_GET['id'].'&token='.md5($_GET['id']).'&idu='.$r->ii.'&token_incen='.md5($r->ii).'"><button class="btn btn-success" data-toggle="popover" data-content="1 kali klik untuk merubah semua status menjadi paid, batalkan bisa kapan saja" data-placement="top" data-trigger="hover"><i class="fa fa-money"></i> PAID ALL</button></a>';
								}else{
								    $paid = '<a href="'.base_url().'finance/incentive/unapproved_paid_all?id='.$_GET['id'].'&token='.md5($_GET['id']).'&idu='.$r->ii.'&token_incen='.md5($r->ii).'"><button class="btn btn-danger"  data-toggle="popover" data-content="1 kali klik untuk merubah semua status menjadi unpaid" data-placement="top" data-trigger="hover"><i class="fa fa-money"></i> UNPAID ALL</button></a>';
								}
								
							 } ?>
							
						<?php } ?>
						
						<div class="alert alert-info" role="alert" style="text-align: left;"><?php echo $pesan; ?></div>
						<?php echo $hsl.' '.$paid; ?>
					
					<?php } ?>
					
					
				</div>
			</div><!-- Akhir row--> 
			
			<hr>
			<form method="post" action="<?= base_url(); ?>finance/incentive/add_row_incentive_finance">
        	    <input type="text" name="redirect" value="<?= base_url();?>finance/incentive/detail/?id=<?php echo $_GET['id']; ?>&token=<?php echo $_GET['token']; ?>&event=<?php echo $_GET['event']; ?>&loc=<?php echo $_GET['loc']; ?>&tgl=<?php echo $_GET['tgl']; ?>" style="display:none;">
        	    <?php if(!empty($_GET['baris'])){$baris = $_GET['baris'];}else{ $baris = ""; }?>
				
        	        <div class="form-row align-items-center">
						<div class="col-sm-2">
							<input type="number" min="0" name="baris" class="form-control" value="<?= $baris; ?>">
						</div>
						<div class="col-sm-2">
						  <button class="btn btn-success" type="submit"> Tambah Row</button>
						</div>
					</div>
        	</form>
			
			
			<hr>
					<table class="table table-striped w-100" id="table1">
					   <thead class="cf">
					      <tr style="background: rgb(13, 78, 108) !important;color: white;">
					         <th></th>
					         <th>Warriors</th>
					         <th style="width: 150px;">Participant</th>
					         <th>Amount</th>
					         <th>Comm.</th>
					         <th>Dp</th>
					         <th>Lunas</th>
					         <th style="min-width:250px;">Action</th>
					         <th></th>
					      </tr>
					    </thead>
					    <tbody>
					     <?php if(!empty($results)){ ?>
							<?php $i=1; ?>
					      	<?php foreach($results as $r){ ?>
					      		<tr>
					      		    <td style="vertical-align: middle;text-align: center;"><?php 
					      		    
					      		             $singkat = $r->program_lain;
					      		             
					      		             if(!empty($singkat)){
    					      		              $words = explode(" ", $singkat);
                                                    $acronym = "";
                                                    
                                                    foreach ($words as $w) {
                                                      $acronym .= $w[0];
                                                    }
                                                    
    					      		              echo "<span class='badge pink' data-toggle='popover' data-content='Program $r->program_lain' data-placement='top' data-trigger='hover'>".$acronym."</span>";
					      		             }else{
					      		                 echo "<span class='badge cyan' data-toggle='popover' data-content='Program Default' data-placement='top' data-trigger='hover'>DF</span>";
					      		             }
					      		       ?>
					      		    </td>
					      			<td><?php echo ucfirst($r->username); ?></td>
									<td><?php echo $r->peserta; ?></td>
									<td>Rp <?php echo number_format($r->total); ?></td>
									
									
									<?php if($r->jenis_lunas == 'dp'){ ?>
									    <?php if($r->program_lain == null){ ?>
										    <td>Rp <?php echo number_format($r->komisi_dp); ?></td>
										<?php }else{ ?>
										    <td>Rp <?php echo number_format($r->komisi_program_lain); ?></td>
										<?php } ?>
										<td style="font-size: 20px;color: #33ca04;" class="text-center"><i class="fas fa-check"></i></td>
										<td style="font-size: 20px;color: #33ca04;"></td>
									<?php }else{ ?>
										<?php if($r->program_lain == null){ ?>
										    <td>Rp <?php echo number_format($r->komisi_lunas); ?></td>
										<?php }else{ ?>
										    <td>Rp <?php echo number_format($r->komisi_program_lain); ?></td>
										<?php } ?>
										<td style="font-size: 20px;color: #33ca04;"></td>
										<td style="font-size: 20px;color: #33ca04;" class="text-center"><i class="fas fa-check"></i></td>
									<?php } ?>
									
									
									    <td style="font-size: 20px;color: #33ca04;">
									        <?php if($r->status_acc == null){ ?>
									            <a href="<?= base_url(); ?>finance/incentive/approved_incentive_satuan?id=<?php echo $_GET['id']; ?>&token=<?php echo md5($_GET['id']); ?>&idu=<?php echo $r->ii; ?>&token_incen=<?php echo md5($r->ii); ?>"><button class="btn btn-success" data-toggle="popover" data-content="Lakukan Approve sekarang, dan batalkan bisa kapan saja." data-placement="top" data-trigger="hover"><i class="fa fa-check"></i>  <b>Approve</b></button></a>
									        <?php }else{ ?>
									        
									            <a href="<?= base_url(); ?>finance/incentive/can_approved_incentive_satuan?id=<?php echo $_GET['id']; ?>&token=<?php echo md5($_GET['id']); ?>&idu=<?php echo $r->ii; ?>&token_incen=<?php echo md5($r->ii); ?>"><button class="btn btn-danger" data-toggle="popover" data-content="Dengan Unapprove status paid juga akan menjadi unpaid" data-placement="top" data-trigger="hover"><i class="fa fa-times"></i>  <b>Unapprove</b></button></a>
									            | 
									            
									            <?php if(($r->status_paid == null) OR ($r->status_paid == 'unpaid')){ ?>
									                <a href="<?= base_url(); ?>finance/incentive/approved_paid_satuan?id=<?php echo $_GET['id']; ?>&token=<?php echo md5($_GET['id']); ?>&idu=<?php echo $r->ii; ?>&token_incen=<?php echo md5($r->ii); ?>"><button class="btn btn-danger" data-toggle="popover" data-content="Ubah status menjadi Paid dengan 1 kali klik" data-placement="top" data-trigger="hover"><i class="fa fa-money"></i>  <b>Unpaid</b></button></a>
									            <?php }else{ ?>
									                <a href="<?= base_url(); ?>finance/incentive/can_approved_paid_satuan?id=<?php echo $_GET['id']; ?>&token=<?php echo md5($_GET['id']); ?>&idu=<?php echo $r->ii; ?>&token_incen=<?php echo md5($r->ii); ?>"><button class="btn btn-success" data-toggle="popover" data-content="Ubah status menjadi Unpaid dengan 1 kali klik" data-placement="top" data-trigger="hover"><i class="fa fa-money"></i>  <b>paid</b></button></a>
									            <?php } ?>
									        <?php } ?>
									    </td>
									    <!--<td style="border-left:1px solid lightgray;"><button onclick="tes()" type="button" class="btn  btn-danger" id="showtambah"><i class="fa fa-eraser"></i> Delete</button></td>-->
									    <td style="border-left:1px solid lightgray;"><button onclick="del('<?php echo $r->ii; ?>','<?php echo md5($r->ii); ?>','<?php echo $_GET['id']; ?>','<?php echo $_GET['event']; ?>','<?php echo $_GET['loc']; ?>','<?php echo $_GET['tgl']; ?>')" type="button" class="btn  btn-danger" id="showtambah"><i class="fa fa-eraser"></i> Delete</button></td>
					      		</tr>
					      	<?php $i++; ?>
							<?php } ?>
					     <?php } ?>
					     
					   </tbody>
					</table>
					
					
		  </div>
		</div><!-- END CARD -->
		
		<?php if(!empty($_GET['baris'])){ ?>
		<div class="card">
			<h5 class="card-header">Add Paid</h5>
			<div class="card-body">
				
			
					<div class="alert alert-info" role="alert" style="text-align: left;">Silahkan isi list dibawah ini untuk menambahkan data closing.</div>
					
					<form action="<?= base_url(); ?>finance/incentive/add_incentive_by_finance" method="post">
					    <input type="text" name="baris" 	value="<?php echo $_GET['baris']; 	?>" 	hidden required>
					    <input type="text" name="id_event" 	value="<?php echo $_GET['id']; 		?>" 	hidden required>
						<input type="text" name="eventp" 	value="<?= $_GET['event']; 			?>" 	hidden required>
						<input type="text" name="locp" 		value="<?= $_GET['loc']; 			?>" 	hidden required>
						<input type="text" name="tglp" 		value="<?= $_GET['tgl']; 			?>" 	hidden required>
						
    					<table class="table table-striped w-100" id="table2">
    					    <thead class="cf">
    					       <tr style="background: #5d9ceb;color: white;">
    					            <th>Warriors</th>
    					            <th>Participant</th>
    					            <th>Program</th>
    					            <th>Amount</th>
    					            <th>Closing Type</th>
    					       </tr>
    					    </thead>
    					    <tbody>
    					        
    					            <?php for($i=0;$i < $_GET['baris'];$i++){ ?>
            					        <tr>
            					            <td>
            					                <select name="war<?php echo $i; ?>"  class="form-control"  required>
            					                    <option value="">PIlih Warriors</option>
            					                    <?php if(!empty($username)){ ?>
            					                        <?php foreach($username as $u){ ?>
            					                            <option value="<?php echo $u->id; ?>"><?php echo ucfirst($u->username); ?></option>
            					                        <?php } ?>
            					                    <?php } ?>
            					                </select>
            					            </td>
            					            <td><input type="text" name="peserta<?php echo $i; ?>" class="form-control" required></td>
            					            <td>
            					                <select name="program<?php echo $i; ?>"  class="form-control"  required>
            					                    <option value="">Pilih Program</option>
            					                    <?php if(!empty($pro_lain)){ ?>
            					                        <?php foreach($pro_lain as $pl){ ?>
            					                            <option value="<?php echo $pl->id; ?>"><?php echo ucfirst($pl->name); ?></option>
            					                        <?php } ?>
            					                    <?php } ?>
            					                </select>
            					            </td>
            					             <td><input type="number" name="byr<?php echo $i; ?>"  class="form-control"  required></td>
            					             <td>
            					                <select name="jenis<?php echo $i; ?>" class="form-control" required>
            					                    <option value="">Jenis Closing</option>
            					                    <option value="dp">Dp</option>
            					                    <option value="lunas">Lunas</option>
            					                </select>
            					            </td>
            					        </tr>
        					        <?php } ?>    					                
    					    </tbody>
    					</table>
										<button class="btn btn-primary btn-cons">Save</button>
    				</form>
				    
				
			</div>
		</div>
		
		<?php } ?>

      

              
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
});

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table1').DataTable({
      'scrollX':true,
      'lengthMenu': [[10, 25, -1], [10, 25, "All"]]
    });
  });
</script>

<script>
    function del(id,token,ide,event,loc,tgl)
{
    swal({
      title: "Are you sure? This will be REMOVE",
      text: "Setelah konfirmasi data tidak dapat dikembalikan!",
      type: "info",
      showCancelButton: true,
      confirmButtonText: "Delete",
      cancelButtonText: "Batal",
      closeOnConfirm: false,
      closeOnCancel: false
    },function(isConfirm){
      if (isConfirm) {
          window.location.href = "<?= base_url(); ?>finance/incentive/delete_list_incentive/?&id="+id+"&token="+token+"&ide="+ide+"&event="+event+"&loc="+loc+"&tgl="+tgl;
      }else {
        swal("Cancelled", "dibatalkan", "error");
      }
    });

}
</script>

