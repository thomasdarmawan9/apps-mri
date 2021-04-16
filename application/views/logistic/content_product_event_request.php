<link rel="stylesheet" href="<?= base_url('inc/fancybox/source/jquery.fancybox.css?v=2.1.7'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url('inc/fancybox/source/jquery.fancybox.pack.js?v=2.1.7'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

<div class="card">
 		<div class="card-header">
 			<h3 class="card-title">Event Request</h3>
 		</div>
 		<div class="card-body">
 			<div class="table-responsive">
 				<div class="table-responsive">
 				    <button data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-cons waves-effect waves-light" type="submit"><i class="icon-ok"></i><i class="fas fa-plus"></i> Add Request</button>
 				    <hr>
 					<table class="table w-100" id="table1">
 						<thead class="text-center">
 							<tr style="background-color: #0d4e6c;color:#fff;">
 							    <th class="align-middle text-center">No</th>
 								<th class="align-middle text-center">Kode</th>
 								<th class="align-middle">Sales</th>
 								<th class="align-middle">Event</th>
 								<th class="align-middle">Date</th>
 								<th class="align-middle">Jmh.<br>Peserta</th>
 								<th class="align-middle">Remark</th>
 								<th class="align-middle">Action</th>
 							</tr>
 						</thead>
 						<tbody class="text-center">
 						    
 							<?php $no = 1; if(!empty($results)){ foreach($results as $r) { ?>
 							<tr>
 							    <td class="align-middle"><?= $no; ?></td>
 								<td class="text-center align-middle"><?= $r->kode_form;?></td>
 								<td class="align-middle"><?= ucfirst($r->username); ?></td>
 								<td class="align-middle"><?= $r->event; ?></td>
 								<td class="align-middle"><span class="badge cyan"><?= date("d-m-Y", strtotime($r->event_date)); ?></span></td>
 								<td class="align-middle"><span class="badge badge-success"><?= $r->jumlah_peserta; ?></span></td>
 								<td class="align-middle text-center"><button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="popover" data-trigger="hover" data-content="<?= $r->remark; ?>" data-placement="top" data-original-title="" title="">?</button></td>
 								<td>
 								    <button onclick="listing_request(<?= $r->id_product_form; ?>)" type="button" class="btn btn-primary" data-toggle="popover" data-placement="top" data-content="Show Listing Product" data-trigger="hover"><i class="fas fa-clipboard-list"></i></button>
 								    <?php if($r->is_done <> 1){ ?>
 								    <button onclick="push_data_update(<?= $r->id_product_form; ?>)" type="button" class="btn btn-warning" data-toggle="popover" data-placement="top" data-content="Update Data ?" data-trigger="hover"><i class="fas fa-edit"></i></button> 
 								    <button onclick="hapus(<?= $r->id_product_form; ?>)" type="button" class="btn btn-danger" data-toggle="popover" data-placement="top" data-content="Delete ?" data-trigger="hover"><i class="fas fa-times"></i></button></td>
 							        <?php } ?>
 							</tr>
 							<?php $no++; }} ?>
 							
 						</tbody>
 					</table>

 				</div>
 			</div>

 		</div>
 		<!-- END PAGE -->
 	</div>
 	
 	
 	<!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?php echo form_open_multipart('logistic/product/add_event_product_request');?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <div class="row">
                           
                            <div class="col-12">
                                  <div class="form-group">
                                    <label for="kode">Kode<span style="color:red;">*</span></label>
                                    <input id="kode" name="kode" type="number" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="sales">Sales<span style="color:red;">*</span></label>
                                    <select type="text" class="form-control" name="sales" id="sales" required>
                                        <option value="">Pilih Sales...</option>
                                        <?php if(!empty($sales)){ foreach($sales as $s){ ?>
                                            <option value="<?= $s->id; ?>"><?= ucfirst($s->username); ?></option>
                                        <?php }} ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="event">Event<span style="color:red;">*</span></label>
                                    <select type="text" class="form-control" name="event" id="event" required>
                                        <option value="">Pilih Event...</option>
                                        <option value="Sesi Perkenalan">Sesi Perkenalan</option>
                                        <?php if(!empty($listEvent)){ foreach($listEvent as $lE){ ?>
                                            <option value="<?= $lE->name; ?>"><?= ucfirst($lE->name); ?></option>
                                        <?php }} ?>
                                        <option value="shop">Shop</option>
                                        <option value="others">Others</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="tgl">Tanggal<span style="color:red;">*</span></label>
                                    <input id="tgl" name="date" type="date" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="peserta">Jumlah peserta</label>
                                    <input id="peserta" name="jmh_peserta" type="number" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label for="remark">Remark</label>
                                    <textarea id="remark" name="remark" col="50" class="form-control"></textarea>
                                  </div>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
    
    
    
              
    <!-- Modal Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?php echo form_open_multipart('logistic/product/update_product_form');?>
                <input name="id" id="updateID" class="form-control" hidden>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <div class="row">
                           
                            <div class="col-12">
                                  <div class="form-group">
                                    <label for="updateKode">Kode<span style="color:red;">*</span></label>
                                    <input id="updateKode" type="number" class="form-control" name="kode" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="updateSales">Sales<span style="color:red;">*</span></label>
                                    <select type="text" class="form-control" name="sales" id="updateSales" required>
                                        <option value="">Pilih Sales...</option>
                                        <?php if(!empty($sales)){ foreach($sales as $s){ ?>
                                            <option value="<?= $s->id; ?>"><?= ucfirst($s->username); ?></option>
                                        <?php }} ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="updateEvent">Event<span style="color:red;">*</span></label>
                                    <select type="text" class="form-control" name="event" id="updateEvent" required>
                                        <option value="">Pilih Event...</option>
                                        <?php if(!empty($listEvent)){ foreach($listEvent as $lE){ ?>
                                            <option value="<?= $lE->name; ?>"><?= ucfirst($lE->name); ?></option>
                                        <?php }} ?>
                                        <option value="shop">Shop</option>
                                        <option value="others">Others</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="updateTgl">Tanggal<span style="color:red;">*</span></label>
                                    <input id="updateTgl" name="date" type="date" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="updatePeserta">Jumlah peserta</label>
                                    <input id="updatePeserta" name="jmh_peserta" type="number" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label for="updateRemark">Remark</label>
                                    <textarea id="updateRemark" name="remark" col="50" class="form-control"></textarea>
                                  </div>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
              

    <!-- Modal Array Transaction -->
    <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title orange-text" id="kodeTransaction">MERCHANDISE FORM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form method="post" id="modalTemporary" action="<?= base_url('logistic/product/add_temporary'); ?>">
                    <div class="modal-body">
                        
                        <div class="card">
                          <div class="card-body">
                            <div hidden>
                                <input type="text" name="formid" id="formid" required>
                                <input type="text" name="userid" id="userid" required>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 col-md-3">Nama Sales</div><div class="col-6 col-md-3" id="usernameTransaction">: </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-3">Nama Event</div><div class="col-6 col-md-3" id="eventTransaction">: </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-3">Tanggal Event</div><div class="col-6 col-md-3" id="tglTransaction">: </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-3">Jumlah Peserta</div><div class="col-6 col-md-3" id="pesertaTransaction">: </div><div class="col-12 col-md-6" id="addRequest"><button onclick="add_request(); return false;" class="btn btn-primary btn-cons waves-effect waves-light float-right" type="submit"><i class="icon-ok"></i><i class="fas fa-plus"></i> Add Request</button></div>
                                    </div>
                                </div>
                            </div>
                        
                          </div>
                        </div>

                        <input id="idf" value="1" type="hidden" />
                        <hr>
                        <div class="card">
                          <div class="card-body">
                            <input type="text" name="kode_form" id="kode_form_transaction" hidden>
                            
                            <table id="tabelTransaction" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                					<tr class="primary-color-dark text-white">
                						<th>Merchandise</th>
                						<th>Out</th>
                						<th>In</th>
                						<th>Action</th>
                					</tr>
                				</thead>
                				<tbody style="font-size:10pt;">
                					
                				</tbody>
            				</table>
            				
            			  </div>
            			</div>
    				
                    </div>
                    <div class="modal-footer" style="display: inherit;">
                        <span id="saveBtnTemporary"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save to Temporary</button></span> <button type="button" class="btn btn-blue-grey" data-dismiss="modal"><i class="fas fa-undo"></i> Close</button>
                        <hr>
                        <div class="alert alert-warning" role="alert">
                          <i class="fas fa-exclamation-triangle"></i> Tombol proses akan mengkalkumulasi stok dan mempengaruhi jumlah stok saat ini, jika proses ini sudah dilakukan maka tidak dapat dikembalikan.
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="btnProccess">Process Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

 	<script type="text/javascript">

 	   $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
        $('#table1').DataTable({
            'scrollX': true,
            'lengthMenu': [
                [10, 15, 20, -1],
                [10, 15, 20, "All"]
            ],
            'rowReorder': {
                'selector': 'td:nth-child(2)'
            },
            'responsive': true,
            'stateSave': true
        });
    });
 		
 		var idf=1;
 		
 		$('#btnProccess').click(function(e){
 		    swal({
              title: 'Apakah kamu yakin?',
              text: "Proses ini akan mempengaruhi stok, dan proses yang sudah dilakukan tidak dapat dikembalikan!",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, Tolong di PROSES!'
            }, function(result){
                if(result){
                    $('#transactionModal').modal('hide');
                	$.ajax({
                        url: '<?= base_url('logistic/product/send_proccess'); ?>',
                        type: 'post',
                        data: $('#modalTemporary').serializeArray(),
                        success: function(response){
                            location.reload();
                            //console.log(response);
                        }
                    });
                }
            });
 		});
 		
 		function add_request(){
 		    $.ajax({
    			url: "<?= base_url('logistic/product/get_json_product'); ?>",
    			type: "POST",
    			dataType: "json",
    			success:function(result){
                    var stre;
                    stre="<tr id='srow" + idf + "'><td><select id='sel" + idf + "' class='form-control' type='text' name='request[]'></select></td><td><input type='number' class='form-control' name='out[]' style='width: 70px;'></td><td><input type='number' name='in[]' min='1' class='form-control' style='width: 70px;'></td><td><a href='#' style=\"color:#3399FD;\" onclick='hapusElemen(\"#srow" + idf + "\"); return false;'><button onclick='' class='btn btn-danger waves-effect waves-light'><i class='fas fa-times'></i></button></a></td></tr>";
                    $('#tabelTransaction').find('tbody').append(stre);
                    $('#sel'+ idf).append("<option value=''>Pilih Product</option>");
                    $.each(result, function(index, value){
                        $('#sel' + idf).append("<option value='"+value.id_product+"'>"+value.nama_product+"</option>");
                    });
                    idf++;
                    
    			}, error: function(e){
    				console.log(e);
    			}
    		});
 		}
 		
 		function hapusElemen(idf) {
         $(idf).remove();
       }
 		
 		function listing_request(id){
 		    $.ajax({
    			url: "<?= base_url('logistic/product/push_event_request'); ?>",
    			type: "POST",
    			dataType: "json",
    			data:{'id': id},
    			success:function(result){
    			    idf = 1;
    			    var formid = result.event.kode_form; 
    				$('#tabelTransaction').find('tbody').empty();
    				$('#formid').val(capitalizeFirstLetter(result.event.kode_form));
            		$('#kodeTransaction').html('[MERCHANDISE FORM] : ' + '<span class="badge badge-primary" id="kdform">' + capitalizeFirstLetter(result.event.kode_form) + '</span>');
            		$('#usernameTransaction').html(': ' + '<b>' + capitalizeFirstLetter(result.event.username) + '<b>');
            		$('#eventTransaction').html(': ' + '<b>' + capitalizeFirstLetter(result.event.event) + '<b>');
            		$('#tglTransaction').html(': ' + '<b>' + result.event.event_date + '<b>');
            		$('#pesertaTransaction').html(': ' + '<b>' + result.event.jumlah_peserta + '<b>');
            		$('#kode_form_transaction').val(result.event.kode_form);
            		$('#userid').val(result.event.id_user);
        			$('#transactionModal').modal('show');
        		
        			$.each(result.detail, function(index, value){
        			    
        			    if(result.event.is_done == 1){
        			        $('#tabelTransaction tbody').append('<tr id="srow'+ idf +'"><td><select id="sel'+ idf +'" class="form-control" type="text" name="request[]"></select></td><td><input type="number" class="form-control" name="out[]" style="width: 70px;" value="'+value.out+'"></td><td><input type="number" class="form-control" name="in[]" style="width: 70px;" value="'+value.in+'"></td><td></td></tr>');
        			        $('#saveBtnTemporary').empty();
        			        $('#addRequest').empty();
        			        $('#btnProccess').prop( "disabled", true );
        			        $('#btnProccess').html('HAS BEEN PROCCESS');
        			        $('#tabelTransaction').find('input, select').prop('disabled', true);
        			    }else{
        			        $('#tabelTransaction tbody').append('<tr id="srow'+ idf +'"><td><select id="sel'+ idf +'" class="form-control" type="text" name="request[]"></select></td><td><input type="number" class="form-control" name="out[]" style="width: 70px;" value="'+value.out+'"></td><td><input type="number" class="form-control" name="in[]" style="width: 70px;" value="'+value.in+'"></td><td><a href="#" style="color:#3399FD;" onclick="hapusElemen(&quot;#srow'+idf+'&quot;); return false;"><button onclick="" class="btn btn-danger waves-effect waves-light"><i class="fas fa-times"></i></button></a></td></tr>');
        			        $('#saveBtnTemporary').html('<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save to Temporary</button>');
        			        $('#addRequest').html('<button onclick="add_request(); return false;" class="btn btn-primary btn-cons waves-effect waves-light float-right" type="submit"><i class="icon-ok"></i><i class="fas fa-plus"></i> Add Request</button>');
        			        $('#btnProccess').prop( "disabled", false );
        			        $('#btnProccess').html('PROCCESS NOW');
        			        $('#tabelTransaction').find('input, select').prop('disabled', false);
        			    }
                        $('#sel'+ idf).append("<option value=''>Pilih Product</option>");
                        $.each(result.product, function(index, hsl){
                            $('#sel' + idf).append("<option value='"+hsl.id_product+"'>"+hsl.nama_product+"</option>");
                            $('#sel' + idf).val(value.id_product).change();
                        });
                        
                        idf++;
        			});
        			
        			
                    
        			//console.log(result);
        			
        			
                    
    			}, error: function(e){
    				console.log(e);
    			}
    		});
    	}
    	
    	
		
		function capitalizeFirstLetter(str) {
          return str.charAt(0).toUpperCase() + str.slice(1);
        }
 		
 		
 		function hapus(id){
    		if(id != ''){
    			swal({
    				title: 'Konfirmasi',
    				text: "Data Merchendise Form ini akan di delete secara permanen.\n Apakah Anda yakin ?",
    				type: 'error',
    				showCancelButton: true,
    				confirmButtonColor: '#dc3545',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Ya, Delete'
    			}, function(result){
    				if (result) {
    					$.ajax({
    						url: "<?= base_url('logistic/product/delete_event_product_request'); ?>",
    						type: "POST",
    						dataType: "json",
    						data:{'id': id},
    						success:function(result){		
    							reload_page();
    						}, error: function(e){
    							console.log(e);
    						}
    					})
    				}
    			});
    		}
    	}
    	
    	function push_data_update(id){
			$.ajax({
				url: "<?= base_url('logistic/product/push_data_product_form') ?>",
				type: "POST",
				dataType: "json",
				data:{'id': id},
				success:function(result){
					if(result != null){
						console.log(result);
						$('#updateID').val(result.id_product_form);
						$('#updateKode').val(result.kode_form);
                        $('#updateSales').val(result.id);
                        $('#updateEvent').val(result.event);
                        $('#updateTgl').val(result.event_date);
                        $('#updatePeserta').val(result.jumlah_peserta);
                        $('#updateRemark').val(result.remark);
						$('#updateModal').modal('show');
					}else{
						swal("Not Found!", "Data peserta tidak ditemukan.", "error");
					}
				}, error: function(e){
					console.log(e);
				}
			});
    	}
    	
    	
    	function reload_page(){
    	    location.reload();   
    	}
    	
    	
 	</script>
