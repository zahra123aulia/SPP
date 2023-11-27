<?php
if (isset($_POST['simpan'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
    $cek_nisn = mysqli_num_rows($cek);
    $cek1 = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
    $cek_nis = mysqli_num_rows($cek1);

    if ($cek_nisn > 0) {
        echo '<script>alert("Nisn Sudah Di Gunakan");location.href="?page=siswa";</script>';
    } elseif ($cek_nis > 0) {
        echo '<script>alert("Nis Sudah Di Gunakan");location.href="?page=siswa";</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa (nisn,nis,nama,id_kelas,alamat,no_telp,password) VALUES('$nisn','$nis','$nama','$id_kelas','$alamat','$no_telp','$password')");
        if ($query) {
            echo '<script>alert("Data Berhasil di tambah");location.href="?page=siswa"</script>';
        }
    }
}

if (isset($_POST['edit-siswa'])) {
    $oldnisn = $_POST['oldnisn'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp' WHERE nisn='$oldnisn'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=siswa"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp', password='$password' WHERE nisn='$oldnisn'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=siswa"</script>';
        }
    }
}

if (isset($_POST['hapus'])) {
    $nisn = $_POST['nisn'];
    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=siswa";</script>';
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


<h1 class="h3 mb-3" style="text-align: center;">Siswa</h1>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <?php
                if (!empty($_SESSION['petugas']['level'] == 'admin')) {
                ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahsiswa">
                        + Tambah Siswa
                    </button>
                <?php
                }
                ?>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>No<i class="fas fa-icon-name"></i></th>
                            <th>NiSN<i class="fas fa-icon-name"></i></th>
                            <th>NIS<i class="fas fa-icon-name"></i></th>
                            <th>Nama Siswa<i class="fas fa-icon-name"></i></th>
                            <th>Kelas Dan Jurusan<i class="fas fa-icon-name"></i></th>
                            <th>Alamat<i class="fas fa-icon-name"></i></th>
                            <th>No Telp<i class="fas fa-icon-name"></i></th>
                            <th>Action<i class="fas fa-icon-name"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nisn'] ?></td>
                                <td><?php echo $data['nis'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['nama_kelas'] ?> - <?php echo $data['jurusan'] ?></td>
                                <td><?php echo $data['alamat'] ?></td>
                                <td><?php echo $data['no_telp'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($_SESSION['petugas']['level'] == 'admin')) {
                                    ?>
                                        <button data-toggle="modal" data-target="#editsiswa<?php echo $data['nisn']; ?>" class="btn btn-danger btn-sm edit-siswa">Edit</button>
                                        <button data-toggle="modal" data-target="#hapus<?php echo $data['nisn']; ?>" class="btn btn-warning btn-sm hapus-siswa">Hapus</button>
                                    <?php
                                    }
                                    ?>
                                    <a href="?page=history&id=<?php echo $data['nisn'] ?>" class="btn btn-success btn-sm">History</i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="hapus<?php echo $data['nisn']; ?>" tabindex="-1" aria-labelledby="HapusLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="HapusLabel">Konfirmasi Hapus Data Siswa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="nisn" value="<?php echo $data['nisn']; ?>">
                                                <p>Anda yakin ingin menghapus data siswa ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger" name="hapus">Ya,Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="editsiswa<?php echo $data['nisn']; ?>" tabindex="-1" aria-labelledby="editsiswaLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editsiswaLabel">Edit Siswa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="oldnisn" value="<?php echo $data['nisn']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">NISN</label>
                                                    <input type="text" name="nisn" class="form-control" value="<?php echo $data['nisn'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIS</label>
                                                    <input type="text" name="nis" class="form-control" value="<?php echo $data['nis'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Siswa</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kelas Dan Jurusan</label>
                                                    <select name="id_kelas" class="form-control">
                                                        <?php
                                                        $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                        while ($data1 = mysqli_fetch_array($query1)) {
                                                        ?>
                                                            <option value="<?php echo $data1['id_kelas'] ?>" <?php if ($data['id_kelas'] == $data1['id_kelas']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>>
                                                                <?php echo $data1['nama_kelas'] ?> - <?php echo $data1['jurusan'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No Telp</label>
                                                    <input type="text" name="no_telp" class="form-control" value="<?php echo $data['no_telp'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary" name="edit-siswa">Simpan Perubahan</button>
                                                </div>
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
        $('#siswa').DataTable();
    })
</script>

<!-- Modal -->
<div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nisn</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nis</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas Dan Jurusan</label>
                        <select name="id_kelas" class="form-control">
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <option value="<?php echo $data['id_kelas'] ?>"><?php echo $data['nama_kelas'] ?> - <?php echo $data['jurusan'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
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