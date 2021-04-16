<link rel="stylesheet" href="<?= base_url('inc/fancybox/source/jquery.fancybox.css?v=2.1.7'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url('inc/fancybox/source/jquery.fancybox.pack.js?v=2.1.7'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

<div class="card">
 		<div class="card-header">
 			<h3 class="card-title">Logistic</h3>
 		</div>
 		<div class="card-body">
 			<div class="table-responsive">

 			
 				<div class="table-responsive">
 					<table class="table w-100" id="table1">
 						<thead>
 							<tr style="background-color: #0d4e6c;color:#fff;">
 								<th class="text-center">No</th>
 								<th>img</th>
 								<th>Product Name</th>
 								<th>Stock</th>
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
 								<td class="align-middle"><?= $r->nama_product; ?></td>
 								<td class="align-middle text-center"><?= $r->stok; ?></td>
 								<td class="align-middle text-center"><button type="button" class="btn btn-primary" data-toggle="popover" data-trigger="hover" data-content="<?= $r->remark; ?>" data-placement="top">?</button></td>
 								<td class="align-middle"><span class="badge cyan"><?= date("d-m-Y", strtotime($r->timestamp)); ?></span></td>
 								<td><button onclick="push_data(<?= $r->id_product; ?>)" type="button" class="btn btn-success" data-toggle="popover" data-placement="top" data-content="Add Product" data-trigger="hover"><i class="fas fa-people-carry"></i> Request</button></td>
 							</tr>
 							<?php }} ?>
 							
 						</tbody>
 					</table>

 				</div>
 			</div>

 		</div>
 		<!-- END PAGE -->
 	</div>
 	
 	
 	
 	<!-- Modal Request -->
    <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <?php echo form_open_multipart('user/logistic/add_request');?>
                <input id="requestId" name="id" style="display:none;"  required>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-5">
                                <img id="requestPhoto" src="http://via.placeholder.com/250x250" alt="placeholder" class="img-thumbnail">
                                <table class="table table-bordered my-2">
                                  <tr><td style="max-width:80px;">Name</td><td id="tdName"></td></tr>
                                  <tr><td style="max-width:80px;">Stock</td><td id="tdStock"></td></tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-7">
                                    <div class="alert alert-primary" role="alert">
                                        Request hanya dapat dilakukan jika tidak melebihi stok yang tersedia.
                                    </div>
                                  <hr>
                                  <div class="form-group">
                                    <label for="requestStok">Berapa jumlah yang ingin direquest ?<span style="color:red;">*</span></label>
                                    <input type="number" min="1" name="qty" class="form-control" id="requestStok" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="requestRemark">Remark<span style="color:red;">*</span></label>
                                    <textarea id="requestRemark" name="remark" col="50" class="form-control" required></textarea>
                                  </div>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
    


 	<script type="text/javascript">
 		$('#table1').DataTable({
 			'order' : false,
 			'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]]
 		});
 		
 		
 		function push_data(id){
    				$.ajax({
    					url: "<?= base_url('user/logistic/push_data') ?>",
    					type: "POST",
    					dataType: "json",
    					data:{'id': id},
    					success:function(result){
    						if(result != null){
    							console.log(result);
    							$('#IdAddTransaction').val(result.id_product);
    							if(result.picture !== null && result.picture !== ''){
    							    $('#requestPhoto').attr('src',"<?= base_url('/inc/image/product/')?>"+result.picture);
    							}else{
    							    $('#requestPhoto').attr('src',"http://via.placeholder.com/250x250");
    							}
    							$('#requestStok').val('');
    							$('#requestRemark').val('');
                                $('#tdName').html(result.nama_product);
                                $('#tdStock').html(result.stok);
                                $('#requestId').val(result.id_product);
                                $('#requestStok').attr({ "max" : result.stok, "min" : 1 });
    							$('#requestModal').modal('show');
    						}else{
    							swal("Not Found!", "Data product tidak ditemukan.", "error");
    						}
    					}, error: function(e){
    						console.log(e);
    					}
    				});
    	}
 	</script>
