<div class="card">
  <div class="card-header">
    <h3 class="card-title">Divisi</h3>
  </div>
  <div class="card-body">

   <button type="button" class="btn  btn-primary" id="btnAddDivision"><i class="fa fa-plus"></i> Tambah Divisi</button>
   <hr>

   <br>
   <div class="table-reponsive">
     <table class="table table-striped w-100" id="table1">
          <thead class="text-center">
           <tr style="background-color: #0d4e6c;color:#fff;">
            <th>No</th>
            <th>Divisi</th>
            <th>Supervisor</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          foreach($results as $r){ 
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$r->departement."</td>";
            echo "<td>".ucfirst($r->username)."</td>";
           echo "
           <td>
    
           <button type='button' class='btn  btn-success' onclick='detail(".$r->divisiid.")'><i class='fa fa-eye'></i> Detail</button>
           <button type='button' class='btn  btn-info' onclick='edit(".$r->divisiid.")'><i class='fa fa-edit'></i> Edit</button>
           <button type='button' class='btn  btn-danger' onclick='hapus(".$r->divisiid.")'><i class='fa fa-trash'></i> Hapus</button>
            
           </td>";
           echo "</tr>";
         }
         ?>
       </tbody>
     </table>
     
        <!-- Start Modal Add Divisi -->
        <div class="modal  fade" tabindex="-1" id="modalAddDivision" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Add Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                          Perubahan SPV akan mempengaruhi proses apply jam lembur < 2 Jam, hanya dapat di acc oleh New SPV.
                        </div>
                        <form id="formadddivisi" method="post" action="<?= base_url('admin/divisi/add_divisi'); ?>">
                            <div class="card">
                                <div class="card-body">
                                    <input class="form-control" name="adddivisiname" id="adddivisiname" placeholder="Masukan nama divisi baru" required>
                                    <select class="form-control mt-2" name="addspvuserid" id="addspvuserid" required></select>
                                </div>
                            </div>
            			</form>
        			</div>
    			</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnSvgaddDivision">Save changes</button>
                <button type="button" class="btn btn-light text-dark" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div><!-- End Modal Add Divisi -->
     
        <!-- Start Edit Divisi -->
        <div class="modal  fade" tabindex="-1" id="editdivisi" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Update Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                          Perubahan SPV akan mempengaruhi proses apply jam lembur < 2 Jam, hanya dapat di acc oleh New SPV.
                        </div>
                        <form id="formeditdivisi" method="post" action="<?= base_url('admin/divisi/set_divisi_user'); ?>">
                            <div hidden>
                                <input type="hidden" id="ideditdivisi" name="ideditdivisi">
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <input class="form-control" name="editdivisiname" id="editdivisiname" required>
                                    <select class="form-control mt-2" name="editspvuserid" id="editspvuserid" required></select>
                                </div>
                            </div>
            			</form>
        			</div>
    			</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btneditdivisi">Save changes</button>
                <button type="button" class="btn btn-light text-dark" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div><!-- End Edit Divisi -->
        
        <!-- Start Detail Divisi-->
        <div class="modal  fade" tabindex="-1" id="detaildivisi" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Divisi : <span id="divisiname"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                
                <div class="card w-100 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                Spv : <span id="spvname" class="badge badge-primary"></span>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary float-right" onclick="adduser()"><i class="fas fa-plus"></i> Add User</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card w-100">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                          Perubahan divisi user akan menghilangkan nama user pada divisi lainnya.
                        </div>
                        <form id="formsetdivisi" method="post" action="<?= base_url('admin/divisi/set_divisi_user'); ?>">
                            <div hidden>
                                <input type="hidden" id="iddivisi" name="iddivisi">
                            </div>
                        <table id="tabelDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
            					<tr class="primary-color-dark text-white">
            						<th>User</th>
            						<th>Action</th>
            					</tr>
            				</thead>
            				<tbody style="font-size:10pt;"></tbody>
            			</table>
            			</form>
        			</div>
    			</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnsetdivisi">Save changes</button>
                <button type="button" class="btn btn-light text-dark" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div><!-- End Detail Divisi -->

</div>
</div>

<!-- <a href='http://apps.mri.co.id/?auth=hapususer&id=<?php echo $r->id; ?>'></a> -->
</div>

<div class="card mt-5">
  <div class="card-header">
    <h3 class="card-title">Manager</h3>
  </div>
  <div class="card-body">
      <button type="button" class="btn  btn-primary waves-effect waves-light" id="btnpushmanager"><i class="fa fa-plus"></i> Tambah Manager</button>
      <hr>
      <div class="table-reponsive">
         <table class="table table-striped w-100" id="table2">
              <thead>
               <tr style="background-color: #0d4e6c;color:#fff;">
                <th>No</th>
                <th>Name</th>
                <th>Divisi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(!empty($manager)){
              $no = 1;
              
              foreach($manager as $m){
                $drt = "";
                $select_division = unserialize($m->detail_access_divisi);
                
                  for($x=0;$x < count($select_division);$x++){
                      $this->db->where('id',$select_division[$x]);
                      if(empty($drt)){
                          $drt = '<span class="badge badge-secondary">'.$this->db->get('divisi')->row()->departement.'</span>';
                      }else{
                          $drt = $drt.', <span class="badge badge-secondary">'.$this->db->get('divisi')->row()->departement.'</span>';
                      }
                  }
              
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".ucfirst($m->username)."</td>";
                echo "<td>".$drt."</td>";
               echo "
               <td>
               <button type='button' class='btn  btn-info' onclick='edit_manager(" . $m->id_manager . ")'><i class='fa fa-edit'></i> Edit</button>
               <button type='button' class='btn  btn-danger' onclick='hapus_manager(".$m->id_manager.")'><i class='fa fa-trash'></i> Hapus</button>
               </td>";
               echo "</tr>";
               }
               }
             ?>
           </tbody>
         </table>
  </div>
</div>


<div class="modal  fade" tabindex="-1" id="addmanager" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Manager</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card w-100">
            <div class="card-body">
                <div class="alert alert-primary" role="alert">
                  Silahkan pilih manager baru dan set divisi yang dihandle oleh manager tersebut. Manager mempunyai Hak Akses ACC jam lembur > 2 Jam <I>(Lebih dari 2 Jam)</I>.
                </div>
                <form id="formaddmanager" method="post" action="<?= base_url('admin/divisi/add_manager'); ?>">
                <table id="tabelDetailManager" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
    					<tr class="primary-color-dark text-white">
    						<th>Manager</th>
    						<th>Divisi</th>
    					</tr>
    				</thead>
    				<tbody style="font-size:10pt;">
    				    <tr>
    				     <td><select id="managername" name="userid" class="form-control" required></select></td>
    				     <td><select id="adddivision" name="adddivision[]" class="form-control" multiple="multiple" required></td>
    				    </tr>
    				</tbody>
    			</table>
    			</form>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnsetmanager">Save changes</button>
        <button type="button" class="btn btn-light text-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

 <div class="modal  fade" tabindex="-1" id="editmanager" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Manager</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card w-100">
            <div class="card-body">
              <div class="alert alert-primary" role="alert">
                Divisi yang akan ditambahkan adalah divisi yang akan dihandle oleh manager tersebut
              </div>
              <form id="formeditmanager" method="post" action="<?= base_url('admin/divisi/edit_manager'); ?>">
                <input type="hidden" name="id" id="editid" required>
                <table id="tabelDetailManager" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr class="primary-color-dark text-white">
                      <th class="text-center">Manager</th>
                      <th class="text-center">Divisi</th>
                    </tr>
                  </thead>
                  <tbody style="font-size:10pt;">
                    <tr>
                      <td>
                        <input id="editmanagername" name="editmanagername" class="form-control" required readonly>
                      </td>
                      <td><select id="editdivision" name="editdivision[]" class="form-control" multiple="multiple" required>
                          <?php if (!empty($divisi)) {
                            foreach ($divisi as $d) { ?>
                              <option value="<?= $d->id; ?>"><?= $d->departement; ?></option>
                          <?php }
                          } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
    
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save changes</button>
          <button type="button" class="btn btn-light text-dark" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
    </div>
</div>
      
<link rel="stylesheet" href="<?= base_url('inc/bootstrap-select2/select2.min.css'); ?>">
<script type="text/javascript" src="<?= base_url('inc/bootstrap-select2/select2.min.js'); ?>"></script>

<script type="text/javascript" src="<?= base_url('inc/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('inc/datatables/RowReorder-1.2.4/js/dataTables.rowReorder.min.js'); ?>"></script>


<script type="text/javascript">

    $("#adddivision, #editdivision").select2({
     	placeholder: "Select Division"
    });
 			

  var idf = 1;
  
  $(document).ready(function(){
    $('#table1,#table2').DataTable({
      'scrollX':true,
      'lengthMenu': [[10, 25, -1], [10, 25, "All"]],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      responsive: true
    });
  });
  
  
  
  function jsucfirst(string) 
  {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
  
  $('#btnpushmanager').click(function (e){
     $.ajax({
        url: '<?= base_url('admin/divisi/push_new_manager'); ?>',
        type: 'post',
        dataType: "json",
        success: function(response){
            $('#managername').empty();
            $('#adddivision').empty();
            $("#adddivision").select2("val", "");
            
            $('#addmanager').modal('show');
            $('#managername').append('<option value="">- Pilih Manager Baru -</option>')
            $.each(response.user, function(index, value){
                $('#managername').append('<option value="'+value.id+'">'+jsucfirst(value.username)+'</option>');
            });
            $.each(response.divisi, function(index, d){
                $('#adddivision').append('<option value="'+d.divisiid+'">'+d.departement+'</option>');
            });
            //location.reload();
            console.log(response);
        }
    });
  });
  
  $('#btnsetmanager').click(function (e){
        $.ajax({
            url: '<?= base_url('admin/divisi/add_manager'); ?>',
            type: 'post',
            data: $('#formaddmanager').serializeArray(),
            success: function(response){
                location.reload();
                //console.log(response);
            }, error : function(e){
                console.log(e);
            }
        });
  });

  $('#btnAddDivision').click(function(e){
      $('#adddivisiname').val('');
      $('#addspvuserid').val('');
      $.ajax({
         url: '<?= base_url('admin/divisi/get_user'); ?>',
         type: 'post',
         dataType: "json",
         success: function(response){
             $('#addspvuserid').append('<option value="">- Pilih SPV - </option>')
             $.each(response, function(index, value){
                 $('#addspvuserid').append('<option value="'+value.id+'">'+jsucfirst(value.username)+'</option>');
             });
             $('#modalAddDivision').modal('show');
         }, error: function(e){
             console.log(e);
         }
      });
      
  });
  
  $('#btnSvgaddDivision').click(function(e){
      $.ajax({
            url: '<?= base_url('admin/divisi/add_divisi'); ?>',
            type: 'post',
            data: $('#formadddivisi').serializeArray(),
            success: function(response){
                location.reload();
                //swal("Update Success","Data telah berhasil diubah!","success")
                //console.log(response);
            }
        });
  });
  
  $('#btneditdivisi').click(function(e){
      $.ajax({
            url: '<?= base_url('admin/divisi/edit_divisi'); ?>',
            type: 'post',
            data: $('#formeditdivisi').serializeArray(),
            success: function(response){
                location.reload();
                //console.log(response);
            }
        });
  });
  
  $('#btnsetdivisi').click(function (e){
        $.ajax({
            url: '<?= base_url('admin/divisi/set_divisi_user'); ?>',
            type: 'post',
            data: $('#formsetdivisi').serializeArray(),
            success: function(response){
                $('#detaildivisi').modal('hide');
                swal("Update Success","Data telah berhasil diubah!","success")
                //location.reload();
                //console.log(response);
            }
        });
  });

  function reload_page(){
    window.location.reload();
  }

  
  function edit(id){
      $.ajax({
         url: '<?= base_url('admin/divisi/push_divisi'); ?>',
         type: 'post',
         dataType: "json",
         data:{'id' : id},
         success: function(response){
             $('#editspvuserid').append('<option value="">- Pilih SPV - </option>')
             $.each(response.user, function(index, value){
                 $('#editspvuserid').append('<option value="'+value.id+'">'+jsucfirst(value.username)+'</option>');
             });
             $('#ideditdivisi').val(response.divisi[0].divisiid);
             $('#editdivisiname').val(response.divisi[0].departement);
             $('#editspvuserid').val(response.divisi[0].id_user_spv).change();
             $('#editdivisi').modal('show');
             console.log(response);
         }, error: function(e){
             console.log(e);
         }
      });
  }
  
  
  
  function hapus(id){
    if(id != ''){
      swal({
        title: 'Konfirmasi',
        text: "Data divisi akan dihapus, semua user pada divisi ini akan diset divisinya menjadi kosong lanjutkan?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }, function(result){
        if (result) {         
          $.ajax({
            url: "<?= base_url('admin/divisi/delete_divisi')?>",
            type: "POST",
            data:{'id': id},
            success:function(result){         
              location.reload();
            }, error: function(e){
              console.log(e);
            }
          })
        }
      });
    }
  }
  
   function edit_manager(id) {
          $.ajax({
            url: '<?= base_url('admin/divisi/push_manager'); ?>',
            type: "post",
            dataType: "json",
            data: {
              'id': id
            },
            success: function(response) {
              $('#editid').val(response.detail.id_manager);
              $('#editmanagername').val(jsucfirst(response.detail.username));
              $("#editdivision").select2("val", response.division);

              console.log(response);
            },
            error: function(e) {
              console.log(e);
            }
          });

          $('#editmanager').modal('show');
        }v
  
  function hapus_manager(id){
    if(id != ''){
      swal({
        title: 'Konfirmasi',
        text: "Apa kamu serius untuk mendelete manager ini ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }, function(result){
        if (result) {         
          $.ajax({
            url: "<?= base_url('admin/divisi/delete_manager')?>",
            type: "POST",
            data:{'id': id},
            success:function(result){         
              location.reload();
            }, error: function(e){
              console.log(e);
            }
          })
        }
      });
    }
  }
  
  function adduser(){
      $.ajax({
         url: "<?= base_url('admin/divisi/get_user'); ?>",
         dataType: "json",
         success:function(result){
             console.log(result);
             
             $('#tabelDetail').find('tbody').append('<tr id="truser'+idf+'"><td><select name="user[]" id="sel'+idf+'" class="form-control"></select></td><td class="text-center"><button class="btn btn-danger" onclick="hapusUser('+idf+');"><i class="fas fa-trash"></button></td></tr>');
             $('#sel'+ idf).append("<option value=''>Pilih User</option>");
             $.each(result, function(index, r){
                $('#sel' + idf).append("<option value='"+r.id+"'>"+jsucfirst(r.username)+"</option>");
             });
             
             idf++;
             
         }, error: function(e){
			console.log(e);
		 }
      });
  }
  
  function detail(id){
      $('#detaildivisi').modal('toggle');
      $.ajax({
          url: "<?= base_url('admin/divisi/get_user_divisi'); ?>",
          type: "POST",
		  dataType: "json",
		  data:{'id': id},
		  success:function(result){
		        
		        $('#iddivisi').val(result.detail[0].divisiid);
		        $('#tabelDetail').find('tbody').empty();
		        
		        $('#divisiname').html(jsucfirst(result.detail[0].departement));
		        $('#spvname').html(jsucfirst(result.detail[0].username));
		        
		        $.each(result.divisi, function(index, divisi){
    		        $('#tabelDetail').find('tbody').append('<tr id="truser'+idf+'"><td><select id="sel'+idf+'" class="form-control" name="user[]"></select></td><td class="text-center"><button class="btn btn-danger" onclick="hapusUser('+idf+');"><i class="fas fa-trash"></button></td></tr>');
		            $('#sel'+ idf).append("<option value=''>Pilih User</option>");
		            
                    $.each(result.user, function(index, value){
                        $('#sel' + idf).append("<option value='"+value.id+"'>"+jsucfirst(value.username)+"</option>");
                        $('#sel' + idf).val(divisi.usi).change();
                    });
                    
                    idf++;
		        });
		        
		        
		            
		        /*var idf = 1;
    		    $('#sel'+ idf).append("<option value=''>Pilih User</option>");
                $.each(result.product, function(index, hsl){
                    $('#sel' + idf).append("<option value='"+hsl.id_product+"'>"+hsl.nama_product+"</option>");
                    $('#sel' + idf).val(value.id_product).change();
                });
                
                idf++;*/
                
                console.log(result);
                
		  }, error: function(e){
			 console.log(e);
		  }
      })
  }
  
  function hapusUser(id){
      $('#truser'+id).remove();
  }
  
  
</script>

