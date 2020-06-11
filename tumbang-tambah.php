<?php include "readme.php";?>
<?php 
  include "views/header.php";
  $m = 31;
  $nextN = mktime(0, 0, 0, date("m"), date("d") + $m, date("Y"));
  $mak   = date("Y-m-d", $nextN);

  function format_mak($mak)
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
    $split = explode('-', $mak);
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
    <h1>Daftar <small>Tumbuh Kembang</small></h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"><i class="fa fa-plus"></i> Tambah</li>
    </ol>
    <?php include "../notifikasi1.php"?>
    <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <font size='3'>Registrasi maksimal sampai tanggal <b><?php echo format_mak($mak);?></font></b>
    </div>
  </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="table-responsive">
      <form method="post" action="tumbang-tambah-cari-rm" role="form">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Nomor RM</label>
            <input class="form-control" type="text" name="id_catatan_medik" placeholder="Nomor Rekam Medik">
          </div><button type="submit" class="btn btn-success">Cari</button>
        </div>
      </form>
      <form method="post" action="tumbang-tambah-cari-nama" role="form">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Nama</label>
            <input class="form-control" type="text" name="nama" placeholder="Nama Pasien">
          </div><button type="submit" class="btn btn-success">Cari</button>
        </div>
      </form>
      <div class="col-lg-6">
            <?php
              if(isset($_POST['tumbangsubmit'])){
                include '../koneksi.php';
                date_default_timezone_set("Asia/Jakarta");
                $tanggal=date('Y-m-d');
                $jam=date("h:i:sa");
                // menangkap data yang di kirim dari form
                $id_catatan_medik = '0';
                $nama             = $_POST['nama'];
                $alamat           = $_POST['alamat'];
                $kontak           = $_POST['kontak'];
                $id_petugas       = $_POST['id_petugas'];
                $jadwal           = $_POST['jadwal'];
                $sesi             = $_POST['sesi'];
                $tanggal          = $tanggal;
                $jam              = $jam;
                $status           = '0';
                $keterangan       = $_POST['keterangan'];
                // cek selisih hari
                $tglsekarang  = new DateTime();
                $cekjadwal     = new DateTime("$jadwal");
                $hasil      = $tglsekarang->diff($cekjadwal)->format("%a");
                $selisih    = $hasil;
                // cek antrian
                $a = mysqli_query($koneksi,
                  "SELECT COUNT(*) AS antrian
                  FROM tumbang
                  WHERE id_petugas='$id_petugas'
                  AND jadwal='$jadwal'
                  AND sesi='$sesi';");
                  while($b = mysqli_fetch_array($a)){

                $antrian       =  $b['antrian']+1;

                $error=array();
                if (empty($nama)){
                  $error['nama']='Nama Harus Diisi!!!';
                }if (empty($alamat)){
                  $error['alamat']='Alamat Harus Diisi!!!';
                }if (empty($kontak)){
                  $error['kontak']='Kontak Harus Diisi!!!';
                }if (empty($id_petugas)){
                  $error['id_petugas']='Petugas Harus Diisi!!!';
                }if (empty($jadwal)){
                  $error['jadwal']='Tanggal Harus Diisi!!!';
                }if (empty($sesi)){
                  $error['sesi']='Sesi Harus Diisi!!!';
                }if($selisih>30){
                echo "<script>alert('GAGAL!!! Lebih dari 30 Hari!');document.location='tumbang-tambah'</script>";
                  break;
                }if(empty($error)){
                  $simpan=mysqli_query($koneksi,"INSERT INTO tumbang (id_tumbang, id_catatan_medik, id_petugas, nama, alamat, kontak, jadwal, sesi, tanggal, jam, status, keterangan)
                    VALUES('','$id_catatan_medik','$id_petugas','$nama','$alamat','$kontak','$jadwal','$sesi','$tanggal','$jam','$status','$keterangan')");
                if($simpan){
                echo "<script>
                    setTimeout(function() {
                        swal({
                            title: 'Antrian $antrian',
                            text: 'Mendaftar Tumbuh Kembang',
                            type: 'success'
                        }, function() {
                            window.location = 'tumbang-tambah';
                        });
                    }, 10);
                </script>";
                }else{
                echo "<script>
                    setTimeout(function() {
                        swal({
                            title: 'Gagal!!!',
                            text: 'Hilangkan Tanda Petik di Nama Pasien',
                            type: 'error'
                        }, function() {
                            window.location = 'tumbang-tambah';
                        });
                    }, 10);
                </script>";
                  }
                }
              }
            }
          ?><br><br>
            <form method="post" action="" role="form">
              <div class="form-group">
                <label>Nama Pasien</label>
                <input class="form-control" type="text" name="nama" placeholder="Masukkan..">
                <p style="color:red;"><?php echo ($error['nama']) ? $error['nama'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input class="form-control" type="text" name="alamat" placeholder="Masukkan..">
                <p style="color:red;"><?php echo ($error['alamat']) ? $error['alamat'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Kontak</label>
                <input class="form-control" type="text" name="kontak" placeholder="Masukkan..">
                <p style="color:red;"><?php echo ($error['kontak']) ? $error['kontak'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Petugas</label>
                <select class="form-control" type="text" name="id_petugas" required="">
                <p style="color:red;"><?php echo ($error['id_petugas']) ? $error['id_petugas'] : ''; ?></p>
                  <option disabled selected>Pilih</option>
                  <?php 
                    include '../koneksi.php';
                    $data = mysqli_query($koneksi,
                      "SELECT * FROM tumbang_petugas WHERE status=1;");
                    while($d = mysqli_fetch_array($data)){
                    echo "<option value='".$d['id_petugas']."'>".$d['nama_petugas']."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Jadwal</label>
                <input class="form-control" type="date" name="jadwal">
                <p style="color:red;"><?php echo ($error['jadwal']) ? $error['jadwal'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Sesi</label>
                 <input class="form-control" type="text" name="sesi">
                <p style="color:red;"><?php echo ($error['sesi']) ? $error['sesi'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Keterangan</label>
                <input class="form-control" type="text" name="keterangan" placeholder="Masukkan..">
              </div>
              <button type="submit" name="tumbangsubmit" class="btn btn-success">Tambah</button>
              <button type="reset" class="btn btn-warning">Reset</button>  
            </form>
            </div>
    </div>
  </div><br><br><!-- /.row -->
  </div><!-- /#wrapper -->
  <?php include "views/footer.php"; ?> 