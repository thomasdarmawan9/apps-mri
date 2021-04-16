<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit User</h3>
    </div>
    <div class="card-body">
        <?php foreach ($results as $r) { ?>
        <form method="post" action="<?= base_url('admin/user/submit_edit');?>">
            <input name="id" value="<?php echo $r->idu; ?>" id="id" class="form-control" type="hidden" required="">                                 

            <div class="form-group row">
                <label class="col-form-label col-sm-2">Nama</label>
                <div class="col-sm-10">
                    <input name="nama" value="<?php echo $r->name; ?>" id="nama" class="form-control" type="text" placeholder="e.g. Andy Ajhis R" required="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2">Jenis Cuti</label>
                <div class="col-sm-10">
                    <select name="cuti" id="cuti" class="form-control">
                        <option value="<?php echo $r->jenis_cuti; ?>"><?php echo ucfirst($r->jenis_cuti); ?></option>
                        <?php if($r->jenis_cuti == 'tahunan'){ ?>
                        <option value="bulanan">Bulanan</option>
                        <?php }else{ ?>
                        <option value="tahunan">Tahunan</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Divisi</label>
                <div class="col-sm-10">
                    <select name="depart" id="depart" class="form-control">
                        <option value="<?php echo $r->id_divisi; ?>"><?php echo ucfirst($r->departement); ?></option>
                        <?php foreach($divisi as $d){ ?>
                        <option value="<?php echo $d->id; ?>"><?php echo ucfirst($d->departement); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Status</label>
                <div class="col-sm-10">
                    <select name="status" id="status" class="form-control">
                        <?php if($r->status == null){ ?>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                        <?php  }elseif($r->status == 'tidak aktif'){ ?>
                        <option value="tidak aktif">Tidak Aktif</option>
                        <option value="aktif">Aktif</option>
                        <?php  }else{ ?>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2"></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                    <a href="<?= base_url('admin/user')?>"><button type="button" class="btn btn-blue-grey">Cancel</button></a>
                </div>
            </div>
        </form>
     <?php } ?>
    </div>
</div>

