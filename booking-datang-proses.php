<?php include "readme.php";?>
<?php 
include '../koneksi.php';
$id_booking = $_GET['id_booking'];
mysqli_query($koneksi,"update booking set status = '1' where id_booking='$id_booking'");
header("location:dashboard");
?>