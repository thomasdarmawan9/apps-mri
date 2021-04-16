<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data User</h3>
  </div>
  <div class="card-body">

   <a href="<?= base_url('admin/user/add')?>"><button type="button" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah</button></a>
   <hr>
   <a href="<?= base_url('admin/user/export') ?>" class="btn btn-success float-right mb-5 mr-4"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
   <h4 class="card-title">Data  <span class="semi-bold">User</span></h4>
   <p>Disini anda dapat <code>buat, edit dan delete user</code>.
   </p>

   <br>
     <table class="table table-striped w-100" id="table1">
      <thead>
       <tr style="background-color: #0d4e6c;color:#fff;">
        <th>No</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Status</th>
        <th>Jenis Cuti</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php 
      $no = 1;
      foreach($results as $row){ 
        echo "<tr>";
        echo "<td>".$no++."</td>";
        echo "<td>".$row->name."</td>";
        echo "<td>".$row->username."</td>";
        if($row->status == null || $row->status == 'aktif'){
         echo "<td><label class='badge badge-success'>Aktif</label></td>";
       }else{
         echo "<td><label class='badge badge-danger'>Tidak Aktif</label></td>";
       }
       echo "<td>".$row->jenis_cuti."</td>";
       echo "<td>".$row->email."</td>";
       echo "
       <td>

       <a href='".base_url('admin/user/edit/'.$row->id)."'><button type='button' class='btn  btn-info'><i class='fa fa-edit'></i> Edit</button></a>

       <button type='button' class='btn  btn-danger' onclick='hapus(".$row->id.")'><i class='fa fa-trash'></i> Hapus</button>

       </td>";
       echo "</tr>";
     }
     ?>
   </tbody>
 </table>

</div>

<!-- <a href='http://apps.mri.co.id/?auth=hapususer&id=<?php echo $r->id; ?>'></a> -->
</div>


<script type="text/javascript">
  $(document).ready(function(){
    $('#table1').DataTable({
      'scrollX':true,
      'lengthMenu': [[10, 25, -1], [10, 25, "All"]],
      'rowReorder': {
        'selector': 'td:nth-child(2)'
      },
      'responsive': true
    });
  });

  function reload_page(){
    window.location.reload();
  }

  function hapus(id){
    if(id != ''){
      swal({
        title: 'Konfirmasi',
        text: "Data user akan dihapus, lanjutkan?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }, function(result){
        if (result) {         
          $.ajax({
            url: "<?= base_url('admin/user/delete')?>",
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

