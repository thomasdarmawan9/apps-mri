<link rel="stylesheet" href="<?= base_url('inc/fancybox/source/jquery.fancybox.css?v=2.1.7'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url('inc/fancybox/source/jquery.fancybox.pack.js?v=2.1.7'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

<div class="card">
 		<div class="card-header">
 			<h3 class="card-title">Product Request</h3>
 		</div>
 		<div class="card-body">
 			<div class="table-responsive">
 				<div class="table-responsive">
 					<table class="table w-100" id="table1">
 						<thead>
 							<tr style="background-color: #0d4e6c;color:#fff;">
 								<th class="text-center">No</th>
 								<th>img</th>
 								<th>Username</th>
 								<th>Product Name</th>
 								<th>Qty</th>
 								<th>Remark</th>
 								<th>Date</th>
 								<th>Action</th>
 							</tr>
 						</thead>
 						<tbody>
 						    
 							<?php $no = 1; if(!empty($results)){ foreach($results as $r) { ?>
 							<tr>
 								<td class="text-center align-middle"><?= $no++;?></td>
 								<td class="text-center">
 								    <?php if(empty($r->picture)){ ?>
 								        <a class="fancybox" href="http://via.placeholder.com/64x64.jpg" data-fancybox-group="gallery" title="<?= $r->nama_product; ?>"><img class="img-thumbnail" src="https://via.placeholder.com/64x64"></a>
 								    <?php }else{ ?>
 								        <a class="fancybox" href="<?= base_url('inc/image/product/'.$r->picture); ?>" data-fancybox-group="gallery" title="<?= $r->nama_product; ?>"><img width="64" heigh="64" class="img-thumbnail" src="<?= base_url('inc/image/product/thumb/'.$r->picture); ?>"></a>
 								    <?php } ?>
 								</td>
 								<td class="align-middle"><?= $r->username; ?></td>
 								<td class="align-middle"><?= $r->nama_product; ?></td>
 								<td class="align-middle text-center"><?= $r->qty; ?></td>
 								<td class="align-middle text-center"><button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="popover" data-trigger="hover" data-content="<?= $r->remark; ?>" data-placement="top" data-original-title="" title="">?</button></td>
 								<td class="align-middle"><span class="badge cyan"><?= date("d-m-Y", strtotime($r->timestamp)); ?></span></td>
 								<td><button onclick="approve_request(<?= $r->id_log_product; ?>)" type="button" class="btn btn-success" data-toggle="popover" data-placement="top" data-content="Approve Request ?" data-trigger="hover"><i class="fas fa-check"></i></button> <button onclick="reject(<?= $r->id_log_product; ?>)" type="button" class="btn btn-danger" data-toggle="popover" data-placement="top" data-content="Reject Request ?" data-trigger="hover"><i class="fas fa-times"></i></button></td>
 							</tr>
 							<?php }} ?>
 							
 						</tbody>
 					</table>

 				</div>
 			</div>

 		</div>
 		<!-- END PAGE -->
 	</div>
 	
 	
 	<!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <?php echo form_open_multipart('logistic/product/add_product');?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img src="http://via.placeholder.com/250x250" alt="placeholder" id="photo" class="img-thumbnail">
                                
                                <div class="form-group my-2">
                                    <input type="file" class="form-control-file" id="imgInp" accept="image/*" name="photo">
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                  <div class="form-group">
                                    <label for="productname">Product name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="name" id="productname" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="stok">Stok<span style="color:red;">*</span></label>
                                    <input type="number" min="0" name="stock" class="form-control" id="stok" required>
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
    
    
    <!-- Modal Add Transaksi -->
    <div class="modal fade" id="addTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <?php echo form_open_multipart('logistic/product/add_stok_product');?>
                <input id="IdAddTransaction" name="id" style="display:none;"  required>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stok Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img id="photoAddTransaction" src="http://via.placeholder.com/250x250" alt="placeholder" id="photoupdate" class="img-thumbnail">
                            </div>
                            <div class="col-12 col-md-8">
                                  <div class="alert alert-primary" role="alert">
                                     Tambah Stok disini diartikan adanya penambahan jumlah, <b>bukan total jumlah saat ditambahkan</b>.
                                  </div>
                                  <div class="form-group">
                                    <label for="productNameTransaction">Product name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="name" id="productNameTransaction" readonly required>
                                  </div>
                                  <div class="form-group">
                                    <label for="addStokTransaction">Tambah Stok, Berapa ?<span style="color:red;">*</span></label>
                                    <input type="number" min="0" name="qty" class="form-control" id="addStokTransaction" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="addTransactionRemark">Remark</label>
                                    <textarea id="addTransactionRemark" name="remark" col="50" class="form-control"></textarea>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <?php echo form_open_multipart('logistic/product/update_product');?>
                <input id="idUpdate" name="id" style="display:none;"  required>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img id="photoUpdate" src="http://via.placeholder.com/250x250" alt="placeholder" id="photoUpdate" class="img-thumbnail">
                                <div class="form-group my-2">
                                    <input type="file" class="form-control-file" id="imgInpUpdate" accept="image/*" name="photo">
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                  <div class="form-group">
                                    <label for="nameUpdate">Product name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="name" id="nameUpdate" required>
                                  </div>
                                  <div class="form-group">
                                    <label for=remarkUpdate">Remark</label>
                                    <textarea id="remarkUpdate" name="remark" col="50" class="form-control"></textarea>
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
              

    <!-- Modal History -->
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameHistoryProduct">Detail - Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                <table id="tabelDetail" class="table table-striped" cellspacing="0" width="100%">
                <thead>
					<tr>
						<th>No</th>
						<th>By</th>
						<th>Status</th>
						<th>Qty</th>
						<th>Balance</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody style="font-size:10pt;">
					
				</tbody>
				</table>
				
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

 	<script type="text/javascript">
 	
     	$(document).ready( function() {
		
        	$(document).on('change', '.btn-file :file', function() {
    		var input = $(this),
    			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    		input.trigger('fileselect', [label]);
    		});
    
    		$('.btn-file :file').on('fileselect', function(event, label) {
    		    
    		    var input = $(this).parents('.input-group').find(':text'),
    		        log = label;
    		    
    		    if( input.length ) {
    		        input.val(log);
    		    } else {
    		        if( log ) alert(log);
    		    }
    	    
    		});
    		function readURL(input) {
    		    if (input.files && input.files[0]) {
    		        var reader = new FileReader();
    		        
    		        reader.onload = function (e) {
    		            $('#photo').attr('src', e.target.result);
    		        }
    		        
    		        reader.readAsDataURL(input.files[0]);
    		    }
    		}
    
    		$("#imgInp").change(function(){
    		    readURL(this);
    		});
    		
    		function readURLUpdate(input) {
    		    if (input.files && input.files[0]) {
    		        var reader = new FileReader();
    		        
    		        reader.onload = function (e) {
    		            $('#photoUpdate').attr('src', e.target.result);
    		        }
    		        
    		        reader.readAsDataURL(input.files[0]);
    		    }
    		}
    
    		$("#imgInpUpdate").change(function(){
    		    readURLUpdate(this);
    		});
    		
    	});

 	
 		$('#table1').DataTable({
 			'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]]
 		});
 		
 		
 		
 		$('[data-toggle="popover"]').popover(); 
 		
 		function reject(id){
    		if(id != ''){
    			swal({
    				title: 'Konfirmasi',
    				text: "Permintaan ini akan direject.\n Apakah Anda yakin ?",
    				type: 'error',
    				showCancelButton: true,
    				confirmButtonColor: '#dc3545',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Ya, Reject'
    			}, function(result){
    				if (result) {
    					$.ajax({
    						url: "<?= base_url('logistic/product/reject_request'); ?>",
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
    	
    	
    	function reload_page(){
    	    location.reload();   
    	}
    	
    	
    	function approve_request(id){
    		if(id != ''){
    			swal({
    				title: 'Konfirmasi',
    				text: "Apakah Anda yakin akan melakukan Approve, action ini akan mengurangi stok product.",
    				type: 'info',
    				showCancelButton: true,
    				confirmButtonColor: '#00bcd4',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Ya, kurangi'
    			}, function(result){
    				if (result) {
    					$.ajax({
    						url: "<?= base_url('logistic/product/approve_request'); ?>",
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
    	
    	
    	
 	</script>
