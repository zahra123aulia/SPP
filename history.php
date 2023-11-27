<?php
if (isset($_POST['nisn'])) {
    $id_petugas = $_SESSION['petugas']['id_petugas'];
    $nama = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $bulan_bayar = $_POST['bulan_bayar'];
    $tahun_bayar = $_POST['tahun_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $query = mysqli_query($koneksi, "INSERT INTO pembayaran (id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_bayar,id_spp,jumlah_bayar) VALUES('$id_petugas','$nama','$tgl_bayar','$bulan_bayar','$tahun_bayar','$id_spp','$jumlah_bayar')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=laporan"</script>';
    }
}
if (empty($_SESSION['petugas']['level'])) {
?>
    <script>
        alert('Akses Di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3" style="text-align: center;">History Siswa</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Petugas</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Bayar</th>
                            <th>Bulan Bayar</th>
                            <th>Tahun Bayar</th>
                            <th>SPP</th>
                            <th>Jumlah Bayar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['id'])) {
                            $i = 1;
                            $id = $_GET['id'];
                            $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$id'");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo date('d-m-Y', strtotime($data['tgl_bayar'])) ?></td>
                                <td><?php echo $data['bulan_bayar'] ?></td>
                                <td><?php echo $data['tahun_bayar'] ?></td>
                                <td><?php echo $data['tahun'] ?> - Rp. <?php echo $data['nominal'] ?></td>
                                <td>Rp. <?php echo $data['jumlah_bayar'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editpembayaran<?php echo $data['id_pembayaran']; ?>">
                                        Lunasi
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editpembayaran<?php echo $data['id_pembayaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Data Pembayaran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Petugas</label>
                                                    <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas']; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Siswa</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Bayar</label>
                                                    <input type="date" name="tgl_bayar" class="form-control" value="<?php echo $data['tgl_bayar']; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bulan Bayar</label>
                                                    <input type="text" name="bulan_bayar" class="form-control" value="<?php echo $data['bulan_bayar']; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tahun bayar</label>
                                                    <input type="text" name="tahun_bayar" class="form-control" value="<?php echo $data['tahun_bayar']; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tahun Dan Nominal</label>
                                                    <input type="text" name="id_spp" class="form-control" value="<?php echo $data['tahun']; ?> - Rp. <?php echo $data['nominal']; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah Bayar</label>
                                                    <input type="text" name="jumlah_bayar" class="form-control" value="<?php echo $data['jumlah_bayar']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                if (!empty($_SESSION['petugas']['level'] == 'admin')) {
                ?>
                    <div class="container" style="text-align: center;">
                        <a href="cetak_history.php?nisn=<?php echo $_GET['id'] ?>" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#laporan').DataTable();
    })
</script>