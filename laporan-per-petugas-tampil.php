<?php include "readme.php";?>
<?php include "views/header.php"; ?>
<?php
  $id_petugas = $_POST['id_petugas'];
  $awal       = $_POST['awal'];
  $akhir      = $_POST['akhir'];
  $sesi       = $_POST['sesi'];

  function awal($awal)
          {
            $bulan = array (1 =>   'Januari',
                  'Februari',
                  'Maret',
                  'April',
                  'Mei',
                  'Juni',
                  'Juli',
                  'Agustus',
                  'September',
                  'Oktober',
                  'November',
                  'Desember'
                );
            $split = explode('-', $awal);
            return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
          }

          function akhir($akhir)
          {
            $bulan = array (1 =>   'Januari',
                  'Februari',
                  'Maret',
                  'April',
                  'Mei',
                  'Juni',
                  'Juli',
                  'Agustus',
                  'September',
                  'Oktober',
                  'November',
                  'Desember'
                );
            $split = explode('-', $akhir);
            return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
          }
?>
  <nav>
    <div id="wrapper">
      <?php include "menu.php"; ?>
        </div><!-- /.navbar-collapse -->
      </nav>
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Pencarian <small> <?php echo awal($awal);?> - <?php echo akhir($akhir);?></small></h1>
            <ol class="breadcrumb">
              <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="laporan-per-dokter"><i class="fa fa-search"></i> Cari</a></li>
              <li class="active"><i class="fa fa-list"></i> List</li>
            </ol>  
            <?php include "../notifikasi1.php"?>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-12">
          <div class="table-responsive">
            <div class="col-lg-8">
            <form method="post" action="laporan-per-dokter-export" role="form">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input class="form-control" type="hidden" name="id_petugas" value="<?php echo $id_petugas?>">
                    </div>
                    <div class="form-group">
                      <input class="form-control" type="hidden" name="awal" value="<?php echo $awal?>">
                    </div>
                  <div class="form-group">
                      <input class="form-control" type="hidden" name="akhir" value="<?php echo $akhir?>">
                  </div>
                  <div class="form-group">
                      <input class="form-control" type="hidden" name="sesi" value="<?php echo 
                      $sesi?>">
                  </div>
                  <button type="submit" class="btn btn-success">EXPORT</button><br><br>
                  </div>
              </form>
            </div>
            <div align="right" class="col-lg-4">
              <?php 
                include '../koneksi.php';
                  $data = mysqli_query($koneksi,
                    "SELECT COUNT(id_tumbang) AS total
                    FROM tumbang
                    WHERE jadwal BETWEEN '$awal' AND '$akhir'
                    AND sesi = $sesi
                    AND id_petugas='$id_petugas' ORDER BY id_tumbang ASC;");
                  while($d = mysqli_fetch_array($data)){
              ?>
              <h1><small>Total <?php echo $d['total']; }?> Pasien</small></h1>
            </div>
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                    <tr>
                    <th><center>No</th>
                    <th><center>No.RM</th>
                    <th><center>Nama</th>
                    <th><center>Alamat</th>
                    <th><center>Kontak</th>
                    <th><center>Petugas</th>
                    <th><center>Jadwal</th>
                    <th><center>Sesi</th>
                    <th><center>Status</th>
                    <th><center>Action</th>
                   </tr>
                </thead>
                <tbody>
                  <?php 
                    include '../koneksi.php';
                    $no = 1;
                    date_default_timezone_set("Asia/Jakarta");
                    $tanggalHariIni=date('Y-m-d');
                    $data = mysqli_query($koneksi,
                      "SELECT *, tumbang_petugas.nama_petugas,
                      IF (tumbang.status='1', 'Datang', 'Belum Datang') AS status
                      FROM tumbang, tumbang_petugas
                      WHERE tumbang.id_petugas=tumbang_petugas.id_petugas
                      AND tumbang.jadwal BETWEEN '$awal' AND '$akhir'
                      AND tumbang.sesi = $sesi
                      AND tumbang.id_petugas='$id_petugas' ORDER BY tumbang.id_tumbang ASC;");
                    while($d = mysqli_fetch_array($data)){
                  ?>
                  <tr>
                    <td><center><?php echo $no++; ?></td>
                    <td><center><?php echo $d['id_catatan_medik']; ?></td>
                    <td><center><?php echo $d['nama']; ?></td>
                    <td><center><?php echo $d['alamat']; ?></td>
                    <td><center><?php echo $d['kontak']; ?></td>
                    <td><center><?php echo $d['nama_petugas']; ?></td>
                    <td><center><?php echo $d['jadwal']; ?></td>
                    <td><center><?php echo $d['sesi']; ?></td>
                    <td><center><?php echo $d['status']; ?></td>
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
        </div><!-- /.row -->
<br><br><?php include "../copyright.php";?>
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <?php include "views/footer.php"; ?>