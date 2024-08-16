<?php


if (isset($_GET['detail'])) {
    //DATA PEMINJAM
    $id = $_GET['detail'];
    $Detail = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, peminjaman.*, user.nama_lengkap 
    FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota 
    LEFT JOIN user ON user.id WHERE peminjaman.id = '$id'");
    $rowDetail = mysqli_fetch_assoc($Detail);

    //menghitung durasi/lama pinjam
    $tanggal_pinjam = $rowDetail['tgl_pinjam'];
    $tanggal_kembali = $rowDetail['tgl_kembali'];

    $date_pinjam = new DateTime($tanggal_pinjam);
    $date_kembali = new DateTime($tanggal_kembali);
    $interval = $date_pinjam->diff($date_kembali);


    //DATA BUKU YG DIPINJAM
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman LEFT JOIN buku 
    ON buku.id = detail_peminjaman.id_buku LEFT JOIN kategori ON kategori.id = buku.id_kategori  
    WHERE id_peminjaman='$id'");
}

if (isset($_POST['simpan'])) {
    //jika parameter edit ada maka update, kalo gaada = tambah 
    $id = (isset($_GET['edit'])) ? $_GET['edit'] : '';

    $id_peminjaman = $_POST['id_peminjaman'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $terlambat = $_POST['terlambat'];
    $denda = $_POST['denda'];

    $insert = mysqli_query($koneksi, "INSERT INTO pengembalian (id_peminjaman, tgl_pengembalian, terlambat, denda) 
    VALUES ('$id_peminjaman', '$tgl_pengembalian', '$terlambat', '$denda')");
    if ($insert) {
        $update = mysqli_query($koneksi, "UPDATE peminjaman SET status = 2 WHERE id = '$id_peminjaman'");
        header("Location:?pg=pengembalian&tambah=berhasil");
    }
}


// mysqli query diberikan setiap akan dilakukan perintah/query 
// sedangkan $koneksi menghubungkan dari config-koneksi.php

// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];

//     $delete = mysqli_query($koneksi, "UPDATE pengembalian SET deleted_at = 1 WHERE id = '$id'");
//     header("Location:?pg=pengembalian&hapus=berhasil");
// }

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

//KODE TRANSAKSI
$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 1 ORDER BY id DESC");

?>

<?php if (isset($_GET['detail'])): ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Detail Transaksi Pengembalian</div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo date('D, d M Y', strtotime($rowDetail['tgl_kembali'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Petugas</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $rowDetail['nama_lengkap'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo getStatus($rowDetail['status']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- tabel ajah untuk detail nya -->
                        <div class="mb-5 mt-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Buku</th>
                                    <th>Judul Buku</th>
                                </tr>
                                <?php $no = 1;
                                while ($rowDetail = mysqli_fetch_assoc($queryDetail)): ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $rowDetail['nama_kategori'] ?></td>
                                        <td><?php echo $rowDetail['judul'] ?></td>
                                    </tr>
                                <?php endwhile ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>


    <div class="container mt-5"> <!-- mt=margin-top -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Transaksi Peminjaman</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Pengembalian</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_pengembalian" value="">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <label for="">Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="" value="<?php echo ($_SESSION['NAMA_LENGKAP'] ?? '') ?>" readonly></input>
                                    <input type="hidden" name="id_user" value="<?php echo ($_SESSION['ID_USER'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mt-5 mb-5">
                                <div class="row mb-5">
                                    <div class="col-sm-2">
                                        <label for="">Kode Peminjaman</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select id="kode_peminjaman" name="id_peminjaman" class="form-control">
                                            <option value="">Pilih Kode Peminjaman</option>
                                            <?php while ($rowPeminjaman = mysqli_fetch_assoc($queryPeminjaman)): ?>
                                                <option value="<?php echo $rowPeminjaman['id'] ?>"><?php echo $rowPeminjaman['kode_transaksi'] ?></option>
                                            <?php endwhile ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Nama Anggota</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="Nama Anggota" type="text" readonly id="nama_anggota" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Tanggal Pinjam</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="Tanggal Pinjam" type="date" readonly id="tgl_pinjam" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Tanggal kembali</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="Tanggal kembali" type="date" readonly id="tgl_kembali" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Terlambat</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="terlambat" type="text" name="terlambat" readonly id="terlambat" value="" class="form-control">
                                            <input type="hidden" name="denda" id="denda">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Get data Kategori Buku dan Buku -->

                            <input type="hidden" id="tahun_terbit">

                            <div class="mt-5 mb-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div align="right" class="total-denda">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                                <a href="?pg=pengembalian" class="btn btn-danger">kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>