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
            <h1>Form <small>Tambah</small></h1>
            <ol class="breadcrumb">
              <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-edit"></i> Form</a></li>
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
            <div class="col-lg-6">
            <div class="table-responsive">
                <h3 align="center">Poliklinik</h3>
            <?php 
                include '../koneksi.php';
                $id_register = $_GET['id_register'];
                $data = mysqli_query($koneksi,
                    "SELECT * FROM mr_pasien WHERE id_register=$id_register;");
                while($d = mysqli_fetch_array($data)){
            ?>
            <?php
              if(isset($_POST['submit'])){
                include '../koneksi.php';
                date_default_timezone_set("Asia/Jakarta");
                $tanggal=date('Y-m-d');
                $jam=date("h:i:sa");
                // menangkap data yang di kirim dari form
                $id_catatan_medik = $_POST['id_catatan_medik'];
                $nama             = $_POST['nama'];
                $alamat           = $_POST['alamat'];
                $kontak           = $_POST['kontak'];
                $id_dokter        = $_POST['id_dokter'];
                $booking_tanggal  = $_POST['booking_tanggal'];
                $id_sesi          = $_POST['id_sesi'];
                $tanggal          = $tanggal;
                $jam              = $jam;
                $status           = '2';
                $keterangan       = $_POST['keterangan'];
                // cek selisih hari
                $tglsekarang  = new DateTime();
                $jadwal     = new DateTime("$booking_tanggal");
                $hasil      = $tglsekarang->diff($jadwal)->format("%a");
                $selisih    = $hasil;
                // cek antrian
                $a = mysqli_query($koneksi,
                  "SELECT COUNT(*) AS antrian
                  FROM booking
                  WHERE id_dokter='$id_dokter'
                  AND booking_tanggal='$booking_tanggal'
                  AND id_sesi='$id_sesi';");
                  while($b = mysqli_fetch_array($a)){

                $antrian       =  $b['antrian']+1;

                $error=array();
                if (empty($id_catatan_medik)){
                  $error['id_catatan_medik']='Nomor RM Harus Diisi!!!';
                }if (empty($nama)){
                  $error['nama']='Nama Harus Diisi!!!';
                }if (empty($alamat)){
                  $error['alamat']='Alamat Harus Diisi!!!';
                }if (empty($kontak)){
                  $error['kontak']='Kontak Harus Diisi!!!';
                }if (empty($id_dokter)){
                  $error['id_dokter']='Dokter Harus Diisi!!!';
                }if (empty($booking_tanggal)){
                  $error['booking_tanggal']='Tanggal Harus Diisi!!!';
                }if (empty($id_sesi)){
                  $error['id_sesi']='Sesi Harus Diisi!!!';
                }if($selisih>30){
                echo "<script>alert('GAGAL!!! Lebih dari 30 Hari!');document.location='booking-tambah'</script>";
                  break;
                }if(empty($error)){
                  $c = mysqli_query($koneksi,
                  "SELECT COUNT(*) AS cek
                  FROM booking
                  WHERE id_catatan_medik = $id_catatan_medik
                  AND id_dokter = $id_dokter
                  AND id_sesi = $id_sesi
                  AND booking_tanggal = '$booking_tanggal';");
                  while($d = mysqli_fetch_array($c)){
                  $cek       =  $d['cek'];
                }if($cek>0){
                  echo "<script>alert('Gagal! Hanya Boleh Mendaftar Sekali!!');document.location='booking-tambah'</script>";
                }else{
                  $simpan=mysqli_query($koneksi,"INSERT INTO booking (id_booking, nama, alamat, kontak, id_catatan_medik, booking_tanggal, tanggal, jam, status, keterangan, id_dokter, id_sesi)
                    VALUES('','$nama','$alamat',
                  '$kontak','$id_catatan_medik','$booking_tanggal','$tanggal','$jam','$status','$keterangan',
                  '$id_dokter','$id_sesi')");
                }
                if($simpan){
                echo "<script>
                    setTimeout(function() {
                        swal({
                            title: 'Antrian $antrian',
                            text: 'Berhasil Mendaftarkan',
                            type: 'success'
                        }, function() {
                            window.location = 'booking-tambah';
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
                            window.location = 'booking-tambah';
                        });
                    }, 10);
                </script>";
                  }
                }
              }
            }
          ?>
            <form method="post" action="" role="form">
              <div class="form-group">
                <label>Nomor Rekam Medik</label>
                <input class="form-control" type="text" name="id_catatan_medik"
                value="<?php echo $d['id_catatan_medik']; ?>" readonly>
                <p style="color:red;"><?php echo ($error['id_catatan_medik']) ? $error['id_catatan_medik'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama"
                value="<?php echo $d['nama']; ?>" readonly>
                <p style="color:red;"><?php echo ($error['nama']) ? $error['nama'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input class="form-control" type="text" name="alamat"
                value="<?php echo $d['alamat']; ?>" required="">
                <p style="color:red;"><?php echo ($error['alamat']) ? $error['alamat'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Kontak</label>
                <input class="form-control" type="text" name="kontak"
                value="<?php echo $d['telp']; ?>" required="">
                <p style="color:red;"><?php echo ($error['kontak']) ? $error['kontak'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Dokter</label>
                <select class="form-control" type="text" name="id_dokter"
                value="<?php echo $d['id_dokter']; ?>" required="">
                <p style="color:red;"><?php echo ($error['id_dokter']) ? $error['id_dokter'] : ''; ?></p>
                  <option disabled selected>Pilih</option>
                  <?php 
                    include '../koneksi.php';
                    $data = mysqli_query($koneksi,
                      "SELECT * FROM dokter WHERE status=1;");
                    while($d = mysqli_fetch_array($data)){
                    echo "<option value='".$d['id_dokter']."'>".$d['nama_dokter']."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Jadwal</label>
                <input class="form-control" type="date" name="booking_tanggal"
                value="<?php echo $d['booking_tanggal']; ?>" required="">
                <p style="color:red;"><?php echo ($error['booking_tanggal']) ? $error['booking_tanggal'] : ''; ?></p>
              </div>
              <div class="form-group">
                <label>Sesi</label>
                <select class="form-control" type="text" name="id_sesi"
                value="<?php echo $d['id_sesi']; ?>" required="">
                <p style="color:red;"><?php echo ($error['id_sesi']) ? $error['id_sesi'] : ''; ?></p>
                  <option disabled selected>Pilih</option>
                  <?php 
                    include '../koneksi.php';
                    $data = mysqli_query($koneksi,
                      "SELECT * FROM sesi;");
                    while($d = mysqli_fetch_array($data)){
                    echo "<option value='".$d['id_sesi']."'>".$d['nama_sesi']."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Keterangan</label>
                <input class="form-control" type="text" name="keterangan" placeholder="Masukkan..">
              </div>
              <button type="submit" name="submit" class="btn btn-success">Tambah</button>
              <button type="reset" class="btn btn-warning">Reset</button>  
            </form><?php } ?>
            </div>
            </div>
            </div>
            </div>

            <div class="tab-pane fade in" id="2">
            <div class="row">
            <div class="col-lg-6">
            <div class="table-responsive">
                <?php include "tumbang-tambah-cari-nama-eksekusi.php";?>
            </div>
            </div>
            </div>
            </div>
          </div>
        </div>
        </div>
          </div>
        </div><!-- /.row -->
      <br><br><?php include "../copyright.php";?><br><br><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <?php include "views/footer.php"; ?>