<?php
include 'koneksi.php';
if (empty($_SESSION['petugas']['level'] == 'admin')) {
?>
    <script>
        alert('Akses Di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<script>
    window.print();
</script>

<table border=1 cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th colspan="8">Pembayaran SPP</th>
    </tr>
    <tr>
        <th>NO</th>
        <th>Nama Petugas</th>
        <th>Nama Siswa</th>
        <th>Tanggal Bayar</th>
        <th>Bulan Bayar</th>
        <th>Tahun bayar</th>
        <th>Nominal Dan Tahun</th>
        <th>Jumlah Bayar</th>
    </tr>
    <?php
    $i = 1;
    $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
    while ($data = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $data['nama_petugas'] ?></td>
            <td><?php echo $data['nama'] ?></td>
            <td><?php echo date('d-m-Y', strtotime($data['tgl_bayar'])) ?></td>
            <td><?php echo $data['bulan_bayar'] ?></td>
            <td><?php echo $data['tahun_bayar'] ?></td>
            <td><?php echo $data['tahun'] ?> - Rp. <?php echo $data['nominal'] ?></td>
            <td>Rp. <?php echo $data['jumlah_bayar'] ?></td>
        </tr>
    <?php
        $i++;
    }
    ?>
</table>