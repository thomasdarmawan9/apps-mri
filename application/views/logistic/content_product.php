<link rel="stylesheet" href="<?= base_url('inc/fancybox/source/jquery.fancybox.css?v=2.1.7'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url('inc/fancybox/source/jquery.fancybox.pack.js?v=2.1.7'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
 	
 	<div class="card">
 		<div class="card-header">
 			<h3 class="card-title">Product</h3>
 		</div>
 		<div class="card-body">
 			<div class="table-responsive">

 				<button data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-cons waves-effect waves-light" type="submit"><i class="icon-ok"></i><i class="fas fa-plus"></i> Add Product</button>
 				<hr>
 				<div class="table-responsive">
 					<table class="table w-100" id="table1">
 						<thead class="text-center">
 							<tr style="background-color: #0d4e6c;color:#fff;">
 								<th class="text-center">No</th>
 								<th>img</th>
 								<th>Product Name</th>
 								<th>Price (Rp)</th>
 								<th>Stock</th>
 								<th>Remark</th>
 								<th>Date</th>
 								<th style="min-width: 220px;">Action</th>
 							</tr>
 						</thead>
 						<tbody class="text-center">
 						    
 							<?php $no = 1; if(!empty($results)){ foreach($results as $r) { ?>
 							<tr>
 								<td class="text-center align-middle"><?= $no++;?></td>
 								<td class="text-center align-middle">
 								    <?php if(empty($r->picture)){ ?>
 								        <a class="fancybox" href="http://via.placeholder.com/64x64.jpg" data-fancybox-group="gallery" title="<?= $r->nama_product; ?>"><img class="img-thumbnail" src="https://via.placeholder.com/64x64"></a>
 								    <?php }else{ ?>
 								        <a class="fancybox" href="<?= base_url('inc/image/product/'.$r->picture); ?>" data-fancybox-group="gallery" title="<?= $r->nama_product; ?>"><img width="64" heigh="64" class="img-thumbnail" src="<?= base_url('inc/image/product/thumb/'.$r->picture); ?>"></a>
 								    <?php } ?>
 								</td>
 								<td class="align-middle"><?= $r->nama_product; ?></td>
 								<td class="align-middle"><span class="badge badge-success"><?= number_format($r->price); ?></span></td>
 								<td class="align-middle text-center"><span class="badge badge-warning"><?= $r->stok; ?></span></td>
 								<td class="align-middle text-center"><button type="button" class="btn btn-primary" data-toggle="popover" data-trigger="hover" data-content="<?= $r->remark; ?>" data-placement="top">?</button></td>
 								<td class="align-middle"><span class="badge cyan"><?= date("d-m-Y", strtotime($r->timestamp)); ?></span></td>
 								<td><button onclick="push_data(<?= $r->id_product; ?>)" type="button" class="btn btn-success" data-toggle="popover" data-placement="top" data-content="Add Product" data-trigger="hover"><i class="fas fa-plus"></i></button> <button onclick="push_data_update(<?= $r->id_product; ?>)" type="button" class="btn btn-warning" data-toggle="popover" data-placement="top" data-content="Update Product" data-trigger="hover"><i class="fas fa-edit"></i></button> <button onclick="hapus(<?= $r->id_product; ?>)" type="button" class="btn btn-danger" data-toggle="popover" data-placement="top" data-content="Delete Product" data-trigger="hover"><i class="fas fa-trash"></i></button>  <button onclick="push_data_history(<?= $r->id_product; ?>)" type="button" class="btn btn-info" data-toggle="popover" data-placement="top" data-content="See History" data-trigger="hover"><i class="fas fa-history"></i></button></td>
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
                                    <label for="productprice">Price<span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" name="price" id="productprice" required>
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
                                <img id="photoAddTransaction" src="http://via.placeholder.com/250x250" alt="placeholder" class="img-thumbnail">
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
                                    <input type="number" min="1" name="qty" class="form-control" id="addStokTransaction" required>
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
                                    <label for="priceUpdate">Price<span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" name="price" id="priceUpdate" required>
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
                
                <table id="tabelDetail" class="table" cellspacing="0" width="100%">
                <thead class="mdb-color darken-3 text-white">
					<tr>
						<th>No</th>
						<th>By</th>
						<th>Remark</th>
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
         	
            $('[data-toggle="popover"]').popover();
    		$('#table1, #tabelDetail').DataTable({
    			'scrollX': true,
     			'lengthMenu': [
    				 [10, 15, 20, -1], [10, 15, 20, "All"]
    				 ],
    				 'rowReorder': {
                     'selector': 'td:nth-child(2)'
                 },
                 'responsive': true,
                 'stateSave': true
     		});
    		
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
    	
 		
 		function hapus(id){
    		if(id != ''){
    			swal({
    				title: 'Konfirmasi',
    				text: "Product ini akan terhapus dari system dan segala log transaksi akan terhapus. \n\nApakah Anda yakin ?",
    				type: 'error',
    				showCancelButton: true,
    				confirmButtonColor: '#f35958',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Ya, Hapus'
    			}, function(result){
    				if (result) {
    					$.ajax({
    						url: "<?= base_url('logistic/product/delete_product'); ?>",
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
    	
    	
    	function push_data(id){
    				$.ajax({
    					url: "<?= base_url('logistic/product/push_data') ?>",
    					type: "POST",
    					dataType: "json",
    					data:{'id': id},
    					success:function(result){
    						if(result != null){
    							console.log(result);
    							$('#IdAddTransaction').val(result.id_product);
    							if(result.picture !== null && result.picture !== ''){
    							    $('#photoAddTransaction').attr('src',"<?= base_url('/inc/image/product/')?>"+result.picture);
    							}else{
    							    $('#photoAddTransaction').attr('src',"http://via.placeholder.com/250x250");
    							}
                                $('#productNameTransaction').val(result.nama_product);
                                $('#addStokTransaction').val('');
                                $('#addTransactionRemark').val('');
    							$('#addTransaction').modal('show');
    						}else{
    							swal("Not Found!", "Data peserta tidak ditemukan.", "error");
    						}
    					}, error: function(e){
    						console.log(e);
    					}
    				});
    	}
    	
    	function push_data_update(id){
    				$.ajax({
    					url: "<?= base_url('logistic/product/push_data') ?>",
    					type: "POST",
    					dataType: "json",
    					data:{'id': id},
    					success:function(result){
    						if(result != null){
    							console.log(result);
    							$('#idUpdate').val(result.id_product);
    							if(result.picture !== null && result.picture !== ''){
    							    $('#photoUpdate').attr('src',"<?= base_url('/inc/image/product/')?>"+result.picture);
    							}else{
    							    $('#photoUpdate').attr('src',"http://via.placeholder.com/250x250");
    							}
                                $('#nameUpdate').val(result.nama_product);
                                $('#priceUpdate').val(result.price);
                                $('#remarkUpdate').val(result.remark);
    							$('#updateModal').modal('show');
    						}else{
    							swal("Not Found!", "Data peserta tidak ditemukan.", "error");
    						}
    					}, error: function(e){
    						console.log(e);
    					}
    				});
    	}
    	
    	function push_data_history(id){
    				$.ajax({
    					url: "<?= base_url('logistic/product/push_data_history') ?>",
    					type: "POST",
    					dataType: "json",
    					data:{'id': id},
    					success:function(result){
    					    $('#tabelDetail').DataTable().destroy();
    					    $('#tabelDetail').find('tbody').empty();
    						if(result != null){
    							var no = 1;
    							var stok = 0;
    							var name = "";
            					$.each(result, function(index, value){
            					    $('#nameHistoryProduct').html(capitalizeFirstLetter(value.nama_product));
            					    if (value.status == "in") {
                                        stok += parseInt(value.qty);
                                        $('#tabelDetail').find('tbody').append("<tr><td>"+no+++"</td><td>"+capitalizeFirstLetter(value.username)+"</td><td>"+value.remark+"</td><td><span class='badge badge-success'>"+value.status+"</span></td><td><span class='badge badge-light'>"+value.qty+"</span></td><td><span class='badge badge-light'>"+stok+"</span></td><td><span class='badge badge-primary'>"+toDate(new Date(value.timestamp))+"</span></td></tr>");
                                    }else if((value.status == "out") && (value.is_approve == "1")){
                                        stok -= parseInt(value.qty);
                                        $('#tabelDetail').find('tbody').append("<tr><td>"+no+++"</td><td>"+capitalizeFirstLetter(value.username)+"</td><td>"+value.remark+"</td><td><span class='badge badge-danger'>"+value.status+"</span></td><td><span class='badge badge-light'>"+value.qty+"</span></td><td><span class='badge badge-light'>"+stok+"</span></td><td><span class='badge badge-primary'>"+toDate(new Date(value.timestamp))+"</span></td></tr>");
                                    }
            												
            					});
                                $('#tabelDetail').DataTable({
                                    'order' : false,
            						'destroy' :true,
            						'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
            					});
            					$('#historyModal').modal('show');
    						}else{
    							swal("Not Found!", "Data peserta tidak ditemukan.", "error");
    						}
    					}, error: function(e){
    						console.log(e);
    					}
    				});
    	}
    	
    	
    	function toDate(date){
			var d = date;
			var month = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des"];
			return d.getDate()+'-'+month[d.getMonth()]+'-'+d.getFullYear();
		}
		
		function capitalizeFirstLetter(str) {
          return str.charAt(0).toUpperCase() + str.slice(1);
        }
    	
    	
 	</script>
 	
