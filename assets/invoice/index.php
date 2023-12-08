<?php
include('../../config/koneksi.php');
session_start();
include('../../admin/login/login-session-cek.php');
$id_transaksi = $_GET['id_transaksi'];
$query_select_tr = $koneksi->query("SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'");
$hasil_select_tr = $query_select_tr->fetch_object();
$query_select_dt = $koneksi->query(" SELECT * FROM detail_transaksi
                                            JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi
                                            JOIN menu ON detail_transaksi.id_menu = menu.id_menu
                                            WHERE transaksi.id_transaksi = '$id_transaksi'");
date_default_timezone_set('Asia/Jakarta');
$waktu_transaksi = date('Y-m-d H:i:s', time());

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>INVOICE <?= $hasil_select_tr->nomor_transaksi ?></title>
  <link rel="stylesheet" href="style.css" media="all" />
</head>

<body>
  <header class="clearfix">
    <div id="logo">
      <img src="logo.png">
    </div>
    <div id="company">
      <h2 class="name">Company Name</h2>
      <div>455 Foggy Heights, AZ 85004, US</div>
      <div>(602) 519-0450</div>
      <div><a href="mailto:company@example.com">company@example.com</a></div>
    </div>
    </div>
  </header>
  <main>
    <div id="details" class="clearfix">
      <div id="client">
        <div class="to">INVOICE TO: </div>
        <h2 class="name"><?= $hasil_select_tr->nama_pembeli ?></h2>
        <div class="address">796 Silver Harbour, TX 79273, US</div>
        <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
      </div>
      <div id="invoice">
        <h1><?= $hasil_select_tr->nomor_transaksi ?></h1>
        <div class="date"></div>
        <div class="date">Due Date : <?= $waktu_transaksi ?></div>
      </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th class="no">#</th>
          <th class="desc">Nama Menu</th>
          <th class="desc">Deskripsi Menu</th>
          <th class="unit">Harga Menu</th>
          <th class="qty">Jumlah</th>
          <th class="total">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($hasil_select_dt = $query_select_dt->fetch_object()) {


        ?>
          <tr>
            <td class="no"><?= $no ?></td>
            <td class="desc"><?= $hasil_select_dt->nama_menu ?></td>
            <td class="desc"><?= $hasil_select_dt->deskripsi_menu ?></td>
            <td width="20%" class="unit">Rp. <?= number_format($hasil_select_dt->harga_menu, 2, ".", ".") ?></td>
            <td class="qty"><?= $hasil_select_dt->jumlah_menu ?></td>
            <td width="20%" class="total">Rp. <?= number_format($hasil_select_dt->total_harga, 2, ".", ".") ?></td>
          </tr>
        <?php
          $no++;
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">GRAND TOTAL</td>

          <td>Rp. <?= number_format($hasil_select_tr->grand_total_harga, 2, ".", ".") ?></td>
        </tr>

      </tfoot>
    </table>
    <div id="thanks">Thank you!</div>
    <div id="notices">
      <div>NOTICE:</div>
      <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
  </main>
  <footer>
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>
</body>

</html>
<script>
  window.print();
</script>