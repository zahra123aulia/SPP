<?php
if (isset($_POST['simpan'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=spp"</script>';
    }
}

if (isset($_POST['hapus'])) {
    $id_spp = $_POST['id_spp'];
    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=spp";</script>';
    }
}

if (isset($_POST['editspp'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "UPDATE spp SET tahun='$tahun', nominal='$nominal' WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Update");location.href="?page=spp"</script>';
    }
}

if (empty($_SESSION['petugas']['level'] == 'admin')) {
?>
    <script>
        alert('Akses Di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3" style="text-align: center;">SPP</h1>


<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahspp">
                    + Tambah SPP
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Tahun</th>
                            <th>Nominal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM spp");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['tahun'] ?></td>
                                <td>Rp. <?php echo $data['nominal'] ?></td>
                                <td>
                                    <button data-toggle="modal" data-target="#editspp<?php echo $data['id_spp']; ?>" data-tahun="<?php echo $data['tahun']; ?>" data-nominal="<?php echo $data['nominal']; ?>" class="btn btn-warning btn-sm editspp">Edit</button>
                                    <button data-toggle="modal" data-target="#hapus<?php echo $data['id_spp']; ?>" class="btn btn-danger btn-sm hapusspp">Hapus</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="hapus<?php echo $data['id_spp']; ?>" tabindex="-1" aria-labelledby="HapusLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="HapusLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_spp" value="<?php echo $data['id_spp']; ?>">
                                                <p>Anda yakin ingin menghapus data petugas ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="editspp<?php echo $data['id_spp']; ?>" tabindex="-1" aria-labelledby="editsppLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editsppLabel">Edit SPP</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_spp" value="<?php echo $data['id_spp']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Tahun</label>
                                                    <input type="text" name="tahun" class="form-control" value="<?php echo $data['tahun'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nominal</label>
                                                    <input type="text" name="nominal" class="form-control" value="<?php echo $data['nominal'] ?>" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary" name="editspp">Simpan Perubahan</button>
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
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#spp').DataTable();
    })
</script>
<div class="modal fade" id="tambahspp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" name="tahun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="text" name="nominal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>