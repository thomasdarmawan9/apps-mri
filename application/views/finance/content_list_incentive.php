  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      
      <div id="container">
	
		
		<div class="card">
		  <div class="card-header">
			<h3>Future Task</h3>
		  </div>
		  <div class="card-body">
			<table class="table table-striped w-100" id="table1">
			   <thead style="color: white;background: rgb(13, 78, 108) !important;" class="text-center">
			      <tr>
			         <th>No</th>
			         <th style="width:100px;">Date</th>
			         <th>Event</th>
			         <th>Location</th>
			         <th>Closing</th>
					 <th>Status</th>
					 <th style="width:150px;">Action</th>
			      </tr>
			    </thead>
			    <tbody class="text-center">
			     	<?php if(!empty($results)){ ?>
						<?php $no=1;$i=1; ?>
						<?php foreach($results as $r){ ?>
						
							<tr>
								<td style="vertical-align:middle;text-align:center;"><?= $no; ?></td>
								<td><?php echo date("d-M-Y", strtotime($r->date)); ?></td>
								<td><?php echo $r->event; ?></td>
								<td style="width:200px;"><?php echo $r->location; ?></td>
								<td><?php echo $r->jmh; ?></td>
								<td>
									<?php if(($r->jmh > 0) AND ($r->status_acc == null)){ ?>
										<span class="badge badge-warning">Menunggu ACC</span> 
									<?php }elseif(($r->jmh > 0) AND ($r->status_acc <> null)){ ?> 
										<span class="badge badge-primary">APPROVED</span>
									<?php } ?>
									</td>
								<td>
									<a href="<?= base_url(); ?>finance/incentive/detail/?id=<?php echo $r->tid; ?>&token=<?php echo md5($r->tid); ?>&event=<?php echo $r->event; ?>&loc=<?php echo $r->location; ?>&tgl=<?php echo date("d-M-Y", strtotime($r->date)); ?>" >
										<button class="btn btn-primary">Detail</button>
									</a> | 
									<a href="<?= base_url(); ?>finance/incentive/send_notif_incentive?idt=<?php echo $r->id_task; ?>&token=<?php echo md5($r->id_task); ?>">
										<button class="btn btn-amber"><i class="fas fa-bullhorn"></i></button>
									</a>
								</td>
								
							</tr>
							
							<?php $i++;$no++; ?>
						<?php } ?>
			      	<?php } ?>
			   	
			   </tbody>
			</table>
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
