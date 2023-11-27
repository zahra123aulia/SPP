<?php
if (!empty($_SESSION['petugas']['level'])) {
?>

    <h1 class="h3 mb-3" style="text-align: center;">Aplikasi Pembayaran SPP</h1>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Petugas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $petugas = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM petugas");
                                $count = mysqli_fetch_assoc($petugas);
                                echo $count['total'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Kelas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $kelas = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
                                $count = mysqli_fetch_assoc($kelas);
                                echo $count['total'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $siswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
                                $count = mysqli_fetch_assoc($siswa);
                                echo $count['total'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $pembayaran = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total FROM pembayaran");
                                $sum = mysqli_fetch_assoc($pembayaran);
                                echo 'Rp. ' . $sum['total'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
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
                                <th>Tahun bayar</th>
                                <th>SPP</th>
                                <th>Jumlah Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $id = $_SESSION['petugas']['nisn'];
                            $i = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$id'");

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
                                                        <input type="text" name="tahun_bayar" class="form-control" value="<?php echo $data['tahun_dibayar']; ?>" disabled>
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
                                        </div>
                                        </form>
                                    </div>
                                </div>
                </div>

            </div>


        <?php
                            }
        ?>
        </tbody>
        </table>
    <?php
}
    ?>