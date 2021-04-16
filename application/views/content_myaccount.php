  <div class="card">
    <div class="card-header">
      <h3 class="card-title">My Account</h3>
    </div>
    <div class="card-body">
      
        <?php echo form_open_multipart('account/change_pass');?>
		<div class="row">
		    <div class="col-md-12">
		        
		        <div class="row">
		            <div class="col-md-4 text-center mb-3">
            	        <?php 
            				if(!empty($this->session->userdata('picture'))){
            					$foto = base_url().'inc/image/warriors/pp/'.$this->session->userdata('picture');
            				}else{
            					$foto = base_url().'inc/image/user.png';
            				}
        				?>
            		    <img src="<?= $foto?>" id="photo" class="img-thumbnail">
            		    <hr>
            		    <div class="form-group border">
                            <input type="file" class="form-control-file" id="imgInp" accept="image/*" name="photo">
                        </div>
                        
                        <div class="card" style="box-shadow: none;">
                          <div class="card-body">
                            
                                <?= '<b>'.$this->session->userdata('name').'</b>'; ?>
                                    <?php if(!empty($this->session->userdata('birthday'))){ 
                                        $usia = date('Y') - date('Y', strtotime($this->session->userdata('birthday')));
                                        $length = strlen($usia);
                                        if((empty($usia)) or ($usia == 0)){
                                            $ordinal = "";    
                                        }elseif((($length == 1) && ($usia == 1)) or ((($length > 1) && (substr($usia, -1)) == 1 ) && ($usia <> 11))){
                                            $ordinal = 'st';
                                        }elseif((($length == 1) && ($usia == 2)) or (($length > 1) && (substr($usia, -1)) == 2)){
                                            $ordinal = 'nd';
                                        }elseif((($length == 1) && ($usia == 3)) or (($length > 1) && (substr($usia, -1)) == 3)){
                                            $ordinal = 'rd';
                                        }else{
                                            $ordinal = 'th';
                                        }
                                    echo "<span class='badge badge-primary'>".$usia.$ordinal."</span>"; ?>
                                    <br>
                                    Birthdate : <?= date("d-M-Y", strtotime($this->session->userdata('birthday'))); ?>
                                    <?php } ?>
                            
                          </div>
                        </div>

    	            </div>
    	            <div class="col-md-8">				
                    
                        <div class="alert alert-dark border" role="alert">
                          <i class="fas fa-info-circle"></i> Jika hanya ingin merubah foto anda bisa sambil merubah password atau membiarkannya kosong untuk tidak mengganti
                        </div>
                        
                        <div class="form-group">
                            <label for="lp">Last Password</label>
                            <input class="form-control" id="lp" type="password" name="lp" placeholder="Password terakhir">
                        </div>
                        
                        <div class="form-group">
                            <label for="np">New Password</label>
                            <input class="form-control" id="np" type="password" name="np" placeholder="Password baru">
                        </div>
                        
                        <div class="form-group">
                            <label for="lp">Confirm Password</label>
                            <input class="form-control" id="cp" type="password" name="cp" placeholder="Ulangi password baru">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                            <button type="reset" class="btn btn-blue-grey" onclick="history.go(-1)">Cancel</button>
                        </div>
        
        
                    </div><!--col 9 -->
		        </div>
		        
		        
		    </div>
        </div><!--row-->
        </form>
        
        <?php if($this->session->userdata('level') == 'user'){ ?>
                   
        <hr>
        
        <form method="post" action="<?= base_url('account/personal_data'); ?>">
        <div class="alert alert-dark border" role="alert">
          <i class="fas fa-info-circle"></i> Personal Data
        </div>
        <small>*) Wajib diisi.</small>
        <hr>
        
        <div class="form-group">
            <label>Nama Lengkap*</label>
            <input class="form-control" type="text" name="namalengkap" value="<?= $my->nama_lengkap; ?>" required>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Kota Kelahiran*</label>
                    <input class="form-control" type="text" name="kotalahir" value="<?= $my->tempat_lahir; ?>" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Tanggal Lahir*</label>
                    <input class="form-control" type="date" name="tanggallahir" value="<?= $my->birthday; ?>" required>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>No. KTP*</label>
            <input class="form-control" type="text" name="ktp" value="<?= $my->no_ktp; ?>" required>
        </div>
        
        <div class="form-group">
            <label>No. NPWP*</label>
            <input class="form-control" type="text" name="npwp" value="<?= $my->no_npwp; ?>" required>
        </div>
        
        <div class="form-group">
            <label>No. KK*</label>
            <input class="form-control" type="text" name="kk" value="<?= $my->no_kk; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email Pribadi*</label>
            <input class="form-control" type="text" name="emailpribadi" value="<?= $my->email_pribadi; ?>" required>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Jenis Kelamin*</label>
                    <select class="custom-select" name="jeniskelamin" required>
                        <option value="">-Pilih Jenis Kelamin-</option>
                        <option value="pria" <?= ($my->jenis_kelamin == 'pria')? 'selected' : ''; ?>>Pria</option>
                        <option value="wanita" <?= ($my->jenis_kelamin == 'wanita')? 'selected' : ''; ?>>Wanita</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Status Diri*</label>
                    <select class="custom-select" name="statusdiri" required>
                        <option value="">-Pilih Status-</option>
                        <option value="menikah" <?= ($my->status_diri == 'menikah')? 'selected' : ''; ?>>Menikah</option>
                        <option value="belum menikah" <?= ($my->status_diri == 'belum menikah')? 'selected' : ''; ?>>Belum Menikah</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Agama*</label>
            <select class="custom-select" name="agama" required>
                <option value="">-Pilih Agama-</option>
                <option value="islam" <?= ($my->agama == 'islam')? 'selected' : ''; ?>>Islam</option>
                <option value="kristen protestan" <?= ($my->agama == 'kristen protestan')? 'selected' : ''; ?>>Kristen Protestan</option>
                <option value="katolik" <?= ($my->agama == 'katolik')? 'selected' : ''; ?>>Katolik</option>
                <option value="hindu" <?= ($my->agama == 'hindu')? 'selected' : ''; ?>>Hindu</option>
                <option value="buddha" <?= ($my->agama == 'buddha')? 'selected' : ''; ?>>Buddha</option>
                <option value="kong hu cu" <?= ($my->agama == 'kong hu cu')? 'selected' : ''; ?>>Kong Hu Cu</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Alamat Tinggal*</label>
            <textarea class="form-control" name="alamattinggal" required><?= $my->alamat_tinggal; ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Alamat Asal*</label>
            <textarea class="form-control" name="alamatasal" required><?= $my->alamat_asal; ?></textarea>
        </div>
        
        <div class="form-group">
            <label>No. Telp Rumah</label>
            <input class="form-control" type="text" name="telprumah" value="<?= $my->telp_rumah; ?>">
        </div>
        
        <div class="form-group">
            <label>Nama Universitas / Sekolah*</label>
            <input class="form-control" type="text" name="universitas" value="<?= $my->universitas; ?>" required>
        </div>
        
        <hr>
        <div class="alert alert-dark border" role="alert">
          <i class="fas fa-info-circle"></i> Data Orang Tua
        </div>
        
        <div class="form-group">
            <label>Nama Ayah*</label>
            <input class="form-control" type="text" name="namaayah" value="<?= $my->nama_ayah; ?>" required>
        </div>
        
        <div class="form-group">
            <label>No. Telp Ayah</label>
            <input class="form-control" type="text" name="telpayah" value="<?= $my->no_hp_ayah; ?>">
        </div>
        
        <div class="form-group">
            <label>Nama Ibu*</label>
            <input class="form-control" type="text" name="namaibu" value="<?= $my->nama_ibu; ?>" required>
        </div>
        
        <div class="form-group">
            <label>No. Telp Ibu</label>
            <input class="form-control" type="text" name="telpibu" value="<?= $my->no_hp_ibu; ?>">
        </div>
        
        <hr>
        <div class="alert alert-dark border" role="alert">
          <i class="fas fa-info-circle"></i> Data Saudara
        </div>
        
        <div class="form-group">
            <label>Nama Saudara*</label>
            <input class="form-control" type="text" name="namasaudara" value="<?= $my->nama_saudara; ?>" required>
        </div>
        
        <div class="form-group">
            <label>No. Telp Saudara</label>
            <input class="form-control" type="text" name="telpsaudara" value="<?= $my->no_hp_saudara; ?>">
        </div>
        
        <div class="form-group">
            <label>Hubungan keluarga*</label>
            <input class="form-control" type="text" name="hubungankeluarga" value="<?= $my->hubungan_keluarga; ?>" required>
            <small>Misal. Paman</small>
        </div>
        
        <hr>
        <div class="alert alert-dark border" role="alert">
          <i class="fas fa-info-circle"></i> Data orang terdekat
        </div>
        
        <div class="form-group">
            <label>Nama orang terdekat*</label>
            <input class="form-control" type="text" name="namaorgterdekat" value="<?= $my->nama_org_terdekat; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Alamat orang terdekat</label>
            <textarea class="form-control" type="text" name="alamatorgterdekat" placeholder=""><?= $my->alamat_org_terdekat; ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Hubungan orang terdekat*</label>
            <input class="form-control" type="text" name="hubunganorgterdekat" value="<?= $my->hubungan_org_terdekat; ?>" required>
            <small>Misal. Sahabat</small>
        </div>
        
        <div class="form-group">
            <label>No. Telp orang terdekat</label>
            <input class="form-control" type="text" name="telporgterdekat" value="<?= $my->no_hp_org_terdekat; ?>">
        </div>
        
        <hr>
        <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
        <?php } ?>
                   
                   
        </div><!--card body-->
     </div><!--card-->
        
        
        </div>
        
        
        


   </div>
   <!-- END PAGE -->
 </div>
</div>
<!-- END CONTAINER -->
</div>



<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
  } );
  
  
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
	});
	
  </script>
