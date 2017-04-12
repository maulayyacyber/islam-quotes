
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title ?>
            <small>Web Applications</small>
        </h1>
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-picture-o"></i> Add Quotes</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="add-quotes">
                            <?php
                            $attributes = array('id' => 'frm_login');
                            echo form_open_multipart('apps/quotes/save?source=header&utf8=✓', $attributes)
                            ?>
                            <div class="form-group">
                                <label>Images Quotes</label>
                                <input type="file" class="form-control" name="userfile" style="margin-bottom: 10px">
                                <input type="hidden" name="type" value="<?php echo $type ?>">
                                <span class="label label-danger">
                                   NOTE!
                                </span>
                                <span>
                                    Gambar disarankan ukuran 1092 X 1080 PX
                                 </span>
                            </div>
                            <div class="form-group">
                                <label>Catgory Quotes</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="" selected="selected">- - Pilih Category Quotes - -</option>
                                    <?php
                                    foreach($select_category->result_array() as $row)
                                    {
                                        if($row['id_category']== $select_category)
                                        {
                                            ?>
                                            <option value="<?php echo $row['id_category']; ?>" selected="selected"><?php echo $row['nama_category']; ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $row['id_category']; ?>"><?php echo $row['nama_category']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Judul Quotes</label>
                                <input type="text" class="form-control" name="judul_quotes" placeholder="Judul Quotes">
                            </div>
                            <div class="submit" style="margin-bottom: 7px">
                                <button type="submit" class="btn  bg-olive btn-flat btn-save btn-fill"><i class="fa fa-save"></i> Simpan</button>
                                <button type="reset" class="btn bg-orange btn-flat btn-fill"><i class="fa fa-repeat"></i> Reset</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->