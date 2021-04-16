  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      
      <div id="container">
      
		<div class="card">
		  <div class="card-header">
			<h3>Management HR</h3>
		  </div>
		  <div class="card-body">
		      
	        <button type="button" class="btn btn-primary" id="btnAddHR"><i class="fas fa-plus"></i> Tambah HR</button>
	        <hr>
	        <table class="table table-striped w-100" id="table1">
              <thead class="text-center">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Username</th>
                  <th scope="col">Email</th>
                  <th scope="col">Divisi</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody class="text-center">
                  <?php if(!empty($hr)){ $no=0; foreach ($hr as $h){ $no++; ?>
                      <tr>
                          <td><?= $no; ?></td>
                          <td><?= $h->username; ?></td>
                          <td><?= $h->email; ?></td>
                          <td>
                             <?php $divisi = unserialize($h->hr_access_divisi);
                             foreach ($divisi as $d){
                                 $this->db->where('id',$d);
                                 $dvs = $this->db->get('divisi');
                                 if($dvs->num_rows() > 0){
                                        echo '<span class="badge badge-success">'.$dvs->row()->departement.'</span> ';
                                 }else{
                                        echo '<span class="badge badge-secondary">Division has been deleted</span> ';
                                 }
                             } ?>
                          </td>
                          <td> <button class="btn btn-info" onclick="edit(<?= $h->id; ?>)"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-danger" onclick="hapus(<?= $h->id; ?>)"><i class="fa fa-times"></i> Delete</button> </td>
                      </tr>
                  <?php } } ?>
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



<!-- Modal Add HR -->
<div class="modal fade" id="modalAddHR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add HR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formAddHR" method="post" action="<?= base_url('admin/hr/add_hr'); ?>">
      <div class="modal-body">
        <div class="card">
        <div class="card-body">
                <div class="form-group">
                    <label for="addusername">Username</label>
                    <input type="text" class="form-control" name="username" id="addusername" placeholder="Enter username" required>
                    <small>Digunakan untuk aktifitas login HR.</small>
                </div>
                <div class="form-group">
                    <label for="addemail">Email</label>
                    <input type="email" class="form-control" name="email" id="addemail" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="addpassword">Password</label>
                    <input type="password" class="form-control" name="pass" id="addpassword" placeholder="Password" pattern=".{6,}"   required title="6 characters minimum">
                </div>
                <div class="form-group">
                    <label for="addpassword">Divisi</label>
                    <select name="divisi[]" id="adddivisi" class="form-control" multiple="multiple" required>
                        <option value="">-Pilih Divisi-</option>
                        <?php if(!empty($results)){ foreach($results as $dpr){ ?>
                            <option value="<?= $dpr->divisiid; ?>"><?= $dpr->departement; ?></option>
                        <?php } } ?>
                    </select>
                    <small>Pilih divisi yang akan dihandle.</small>
                </div>
        </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success waves-effect waves-light" id="btnProcessAddHR">Add Now</button>
          <button type="button" class="btn btn-light text-dark waves-effect waves-light" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div><!-- End Modal Add HR -->


<!-- Modal Edit HR -->
<div class="modal fade" id="modalEditHR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit HR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formEditHR" method="post" action="<?= base_url('admin/hr/edit_hr'); ?>">
      <div class="modal-body">
        <div class="card">
        <div class="card-body">
                <input type="hidden" name="id" id="editid" required>
                <div class="form-group">
                    <label for="editusername">Username</label>
                    <input type="text" class="form-control" name="username" id="editusername" placeholder="Enter username" required>
                    <small>Digunakan untuk aktifitas login HR.</small>
                </div>
                <div class="form-group">
                    <label for="editemail">Email</label>
                    <input type="email" class="form-control" name="email" id="editemail" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="editpassword">Password</label>
                    <input type="password" class="form-control" name="pass" id="editpassword" placeholder="Password" pattern=".{6,}" title="6 characters minimum">
                    <small>Biarkan password dalam keadaan kosong, jika tidak ingin merubah password sebelumnya.</small>
                </div>
                <div class="form-group">
                    <label for="editpassword">Divisi</label>
                    <select name="divisi[]" id="editdivisi" class="form-control" multiple="multiple" required>
                        <option value="">-Pilih Divisi-</option>
                        <?php if(!empty($results)){ foreach($results as $dpr){ ?>
                            <option value="<?= $dpr->divisiid; ?>"><?= $dpr->departement; ?></option>
                        <?php } } ?>
                    </select>
                    <small>Pilih divisi yang akan dihandle.</small>
                </div>
        </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success waves-effect waves-light" id="btnProcessEditHR">Add Now</button>
          <button type="button" class="btn btn-light text-dark waves-effect waves-light" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div><!-- End Modal Add HR -->

<link rel="stylesheet" href="<?= base_url('inc/bootstrap-select2/select2.min.css'); ?>">
<script type="text/javascript" src="<?= base_url('inc/bootstrap-select2/select2.min.js'); ?>"></script>

<script>

    $("#adddivisi,#editdivisi").select2({
     	placeholder: "Select Division"
    });
    
    $(document).ready(function() {
        var table = $('#table1').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });
    } );
    
    $('#btnAddHR').click(function(e){
        $('#formAddHR').find('input').val('');
        $("#adddivisi").select2("val",[]);
        $('#modalAddHR').modal('show');
    });
    
    function edit(id){
        $.ajax({
            url: "<?= base_url('admin/hr/push_data_hr'); ?>",
            type: "post",
            dataType: "json",
            data: { 'id' : id },
            success: function(response){
                $('#editid').val(response.detail.id);
                $('#editusername').val(response.detail.username);
                $('#editemail').val(response.detail.email);
                $("#editdivisi").select2("val", response.hr);
                console.log(response);
            }, error: function(e){
                console.log(e);
            }
        });
        
        $('#modalEditHR').modal('show');
    }
    
    function hapus(id){
    if(id != ''){
      swal({
        title: 'Data HR akan dihapus',
        text: "Hak akses login HR ini akan didelete dari system, apakah tetap ingin dilanjutkan?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes Delete!'
      }, function(result){
        if (result) {
          $.ajax({
            url: "<?= base_url('admin/hr/delete_hr'); ?>",
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
    
    
</script>




        