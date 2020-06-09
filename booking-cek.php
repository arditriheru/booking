<?php include "readme.php";?>
<?php include "views/header.php"; ?>
  <nav>
    <div id="wrapper">
      <?php include "menu.php"; ?>
        </div><!-- /.navbar-collapse -->
      </nav>
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Registrasi <small><?php include 'tanggal-sekarang.php';?></small></h1>
            <ol class="breadcrumb">
              <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</li></a>
              <li class="active"><i class="fa fa-check-square-o"></i> Hari Ini</li>
            </ol>  
            <?php include "../notifikasi1.php"?>
          </div>
          <div class="col-lg-12">
        <div class="table-responsive">
          <ul class="nav nav-pills" style="margin-bottom: 15px;">
            <li class="active"><a href="#1" data-toggle="tab">Poliklinik</a></li>
            <li><a href="#2" data-toggle="tab">Tumbuh Kembang</a></li>
          </ul>
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="1">
            <div class="row">
            <div class="col-lg-12">
            <div class="table-responsive">
                <div align="right">
              <?php 
                  date_default_timezone_set("Asia/Jakarta");
                  $tanggalHariIni=date('Y-m-d');
                    include '../koneksi.php';
                    $data = mysqli_query($koneksi,
                      "SELECT COUNT(id_booking) AS total
                      FROM booking
                      WHERE booking.tanggal='$tanggalHariIni';");
                    while($d = mysqli_fetch_array($data)){
              ?>
              <h1><small>Total <?php echo $d['total']; }?> Pasien</small></h1>
            </div>
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                    <tr>
                    <th><center>No. RM</th>
                    <th><center>Nama Pasien</th>
                    <th><center>Kontak</th>
                    <th><center>Dokter</th>
                    <th><center>Jadwal</th>
                    <th><center>Sesi</th>
                    <th><center>Keterangan</th>
                    <th><center>Action</th>
                   </tr>
                </thead>
                <tbody>
                  <?php 
                    include '../koneksi.php';
                    date_default_timezone_set("Asia/Jakarta");
                    $tanggalsekarang=date('Y-m-d');
                    $no = 1;
                    $data = mysqli_query($koneksi,
                      "SELECT *, dokter.nama_dokter, sesi.nama_sesi
                      FROM booking, dokter, sesi
                      WHERE booking.id_dokter=dokter.id_dokter
                      AND booking.id_sesi=sesi.id_sesi
                      AND booking.tanggal = '$tanggalsekarang'
                      ORDER BY booking.id_booking DESC;");
                    while($d = mysqli_fetch_array($data)){
                      $booking_tanggal = $d['booking_tanggal'];
                  ?>
                  <tr>
                    <td><center><?php echo $d['id_catatan_medik']; ?></td>
                    <td><center><?php echo $d['nama']; ?></td>
                    <td><center><?php echo $d['kontak']; ?></td>
                    <td><center><?php echo $d['nama_dokter']; ?></td>
                    <td><center><?php echo date("d/m/Y", strtotime($booking_tanggal)); ?></td>
                    <td><center><?php echo $d['nama_sesi']; ?></td>
                    <td><center><?php echo $d['keterangan']; ?></td>
                    <td>
                      <div align="center">
                        <a href="booking-detail?id_booking=<?php echo $d['id_booking']; ?>"
                        <button type="button" class="btn btn-warning">Detail</a><br><br>
                      </div>
                    </td>
                  </tr>
                  <?php 
                    }
                    ?>
                    </tbody>
                  </table>
            </div>
            </div>
            </div>
            </div>

            <div class="tab-pane fade in" id="2">
            <div class="row">
            <div class="col-lg-12">
            <div class="table-responsive">
                <div align="right">
              <?php 
                  date_default_timezone_set("Asia/Jakarta");
                  $tanggalHariIni=date('Y-m-d');
                    include '../koneksi.php';
                    $data = mysqli_query($koneksi,
                      "SELECT COUNT(id_tumbang) AS total
                      FROM tumbang
                      WHERE tumbang.tanggal='$tanggalHariIni';");
                    while($d = mysqli_fetch_array($data)){
              ?>
              <h1><small>Total <?php echo $d['total']; }?> Pasien</small></h1>
            </div>
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                    <tr>
                    <th><center>No. RM</th>
                    <th><center>Nama Pasien</th>
                    <th><center>Kontak</th>
                    <th><center>Petugas</th>
                    <th><center>Jadwal</th>
                    <th><center>Sesi</th>
                    <th><center>Keterangan</th>
                    <th><center>Action</th>
                   </tr>
                </thead>
                <tbody>
                  <?php 
                    include '../koneksi.php';
                    date_default_timezone_set("Asia/Jakarta");
                    $tanggalsekarang=date('Y-m-d');
                    $no = 1;
                    $data = mysqli_query($koneksi,
                      "SELECT *, tumbang_petugas.nama_petugas
                      FROM tumbang, tumbang_petugas
                      WHERE tumbang.id_petugas=tumbang_petugas.id_petugas
                      AND tumbang.tanggal = '$tanggalsekarang'
                      ORDER BY tumbang.id_tumbang DESC;");
                    while($d = mysqli_fetch_array($data)){
                      $jadwal = $d['jadwal'];
                  ?>
                  <tr>
                    <td><center><?php echo $d['id_catatan_medik']; ?></td>
                    <td><center><?php echo $d['nama']; ?></td>
                    <td><center><?php echo $d['kontak']; ?></td>
                    <td><center><?php echo $d['nama_petugas']; ?></td>
                    <td><center><?php echo date("d/m/Y", strtotime($jadwal)); ?></td>
                    <td><center><?php echo $d['sesi']; ?></td>
                    <td><center><?php echo $d['keterangan']; ?></td>
                    <td>
                      <div align="center">
                        <a href="tumbang-detail?id_tumbang=<?php echo $d['id_tumbang']; ?>"
                        <button type="button" class="btn btn-warning">Detail</a><br><br>
                      </div>
                    </td>
                  </tr>
                  <?php 
                    }
                    ?>
                    </tbody>
                  </table>
            </div>
            </div>
            </div>
            </div>
          </div>
        </div>
        </div>
<br><br><?php include "../copyright.php";?>
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <?php include "views/footer.php"; ?>
