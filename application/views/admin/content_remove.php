  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="#" class="active">Hapus User</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Hapus <span class="semi-bold">User</span></h3>
      </div>
      <div id="container">
      
      
		<form method="POST" action="display/remove_user">
		<input type="text" value="ok" name="status" style="display:none;" readonly>
		<input type="text" value="<?php echo $_GET['id']; ?>" name="idrem" style="display:none;" readonly>
		<div class="alert alert-block alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert"></button>
		  <h4 class="alert-heading"><i class="icon-warning-sign"></i> Konfirmasi!</h4>
		  <p> Semua data akan terhapus dari sistem atas user yang bernama <b style="font-size: 30px;"><?php echo $name; ?></b>. Apakah kamu mau melanjutkan ?  </p>
		  <div class="button-set">
			<button class="btn btn-danger btn-cons" type="submit">YA, Hapus Sekarang</button>
			<a href="http://apps.mri.co.id/?auth=user"><button class="btn btn-white btn-cons" type="button">Batalkan</button></a>
		  </div>
		</div>
		</form>
                
                
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

