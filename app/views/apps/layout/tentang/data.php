
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
                <?php echo $this->session->flashdata('notif') ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> Tentang Aplikasi</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>
                            <b><span style="font-size: 16px">Mutiara Islam Apps</span></b>
                        </p>
                        <p>
                            MUTIARA ISLAM adalah aplikasi yang menyediakan gambar tentang hadist, ayat-ayat suci alqu'an dan motivasi tentang islam, untuk menggunakan aplikasi ini anda bisa mengunjungi laman resmi dari Mutiara Islam di <a href="<?php echo base_url() ?>">http://mutiara-islam.id/</a> atau anda juga bisa mengunduh aplikasi resmi kami di bawah.
                        </p>
                        <br>
                        <a href="<?php echo base_url() ?>download/"> <img src="<?php echo base_url() ?>resources/images/play-google.png" style="width: 200px" data-toggle="tooltip" data-placement="top" title="Download on Google Play"> </a>
                        <a href="<?php echo base_url() ?>download/"> <img src="<?php echo base_url() ?>resources/images/apps-store.png" style="width: 200px" data-toggle="tooltip" data-placement="top" title="Download on Apps Store"> </a>
                        <br>
                    <br>
                        <p>
                            <b><span style="font-size: 16px">jika punya pertanyaan bisa hubungi kami melalui :</span></b>
                        </p>
                        <p>
                            <i class="fa fa-envelope"></i> Alamat Email : support@mutiara-islam.id<br><br>
                            <i class="fa fa-whatsapp"></i> SMS / WA : +62 857-8585-2224 </span><br><br>
                            <i class="fa fa-globe"></i> Website : http://mutiara-silam.id
                        </p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
