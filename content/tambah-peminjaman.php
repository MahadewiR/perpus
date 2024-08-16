<?php

if (isset($_GET['detail'])) {
    // DATA PEMINJAM
    $id = $_GET['detail'];
    $detail = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, peminjaman.* , user.nama_lengkap
                FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota 
                LEFT JOIN user ON user.id = peminjaman.id_user
                WHERE peminjaman.id = '$id'");
    $rowDetail = mysqli_fetch_assoc($detail);

    // MENGHITUNG DETAIL DURASI PINJAM
    $tanggal_pinjam = $rowDetail['tgl_pinjam'];
    $tanggal_kembali = $rowDetail['tgl_kembali'];

    $date_pinjam = new DateTime($tanggal_pinjam);
    $date_kembali = new DateTime($tanggal_kembali);
    $interval = $date_pinjam->diff($date_kembali);

    // echo "Durasi buku yang dipinjam selama"  . $interval->days  . "hari";

    // DATA BUKU YANG DIPINJAM
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman 
    LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku 
    LEFT JOIN kategori ON kategori.id = buku.id_kategori
    WHERE id_peminjaman = '$id' ");
}

if (isset($_POST['simpan'])) {
    // jika param detail ada maka updet, selain itu maka tambah
    $id = isset($_GET['detail']) ? $_GET['detail'] : '';

    $kode_transaksi   = $_POST['kode_transaksi'];
    $id_anggota       = $_POST['id_anggota'];
    $id_user          = $_POST['id_user'];
    $tgl_pinjam       = $_POST['tgl_pinjam'];
    $tgl_kembali      = $_POST['tgl_kembali'];

    $id_kategori      = $_POST['id_kategori'];
    $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi, id_anggota, id_user, tgl_pinjam, tgl_kembali, status) 
    VALUES ('$kode_transaksi', '$id_anggota', '$id_user', '$tgl_pinjam', '$tgl_kembali', '1')");
    if ($insert) {
        $id_peminjaman = mysqli_insert_id($koneksi);
        foreach ($id_kategori as $key => $value) {
            $id_kategori      = $_POST['id_kategori'][$key];
            $id_buku     = $_POST['id_buku'][$key];
            $insert = mysqli_query($koneksi, "INSERT INTO detail_peminjaman (id_peminjaman, id_kategori, id_buku )
            VALUES ('$id_peminjaman', '$id_kategori', '$id_buku' )");
            header("location:?pg=peminjaman&tambah=berhasil");
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "UPDATE peminjaman set deleted_at = 1 WHERE id = '$id'");
    header("location:?pg=peminjaman&hapus=berhasil");
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");
// KODE TRANSAKSI
$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans   = mysqli_fetch_assoc($queryKodeTrans);
$no_urut        = $rowKodeTrans['id_transaksi'];
$no_urut++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

$queryAnggota   = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori  = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryBuku      = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
?>

<?php
if (isset($_GET['detail'])): ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Detail Transaksi Peminjaman</div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="" class="form-label">Kode Transaksi</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <?php echo $rowDetail['kode_transaksi'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="" class="form-label">Tanggal Pinjam</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <?php echo date("D, d M Y", strtotime($rowDetail['tgl_pinjam']))  ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <?php echo date("D, d M Y", strtotime($rowDetail['tgl_kembali'])) ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="" class="form-label">Durasi Pinjam</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <?= $interval->days .  "hari" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Anggota</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $rowDetail['nama_anggota'] ?>
                                    </div>
                                </div>
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
                                        <label for="" class="form-label">status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo getStatus($rowDetail['status'])  ?>
                                    </div>
                                </div>
                            </div>

                            <!-- table -->
                            <div class="mb-5 mt-5">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kategori</th>
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
    </div>
<?php else: ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Data Peminjaman</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Kode Transaksi</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="kode_transaksi" value="<?= ($kode_transaksi ?? '') ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Nama Anggota</label>
                                </div>
                                <div class="col-sm-3">
                                    <select name="id_anggota" id="" class="form-control">
                                        <option value="">Pilih Anggota</option>
                                        <?php while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                            <option value="<?= $rowAnggota['id'] ?>"><?= $rowAnggota['nama_lengkap'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Pinjam</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_pinjam" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Kembali</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_kembali" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="" value="<?php echo isset($_SESSION['NAMA_LENGKAP']) ? 
                                    $_SESSION['NAMA_LENGKAP'] : ''; ?>">
                                    <input type="hidden" class="form-control" name="id_user" value="<?php echo isset($_SESSION['ID_USER']) ? 
                                    $_SESSION['ID_USER'] : ''; ?>">
                                </div>
                            </div>

                            <!-- Get Data Katagori Buku dan Buku -->

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Kategori Buku</label>
                                </div>
                                <div class="col-sm-3">
                                    <select id="id_kategori" class="form-control id_kategori">
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($rowKategori = mysqli_fetch_assoc($queryKategori)) : ?>
                                            <option value="<?= $rowKategori['id'] ?>"><?= $rowKategori['nama_kategori'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Nama Buku</label>
                                </div>
                                <div class="col-sm-3">
                                    <select id="id_buku" class="form-control">
                                        <option value="">Pilih Buku</option>

                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="" id="tahun_terbit">
                            <div class="mt-5 mb-5">
                                <div align="right" class="mb-3">
                                    <button type="button" id="tambah-row" class="btn btn-primary tambah-row">Tambah</button>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" name="simpan" value="simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>