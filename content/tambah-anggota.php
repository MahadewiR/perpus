<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id= '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])) {
    // jika param edit ada maka updet, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';
    $nisn           = $_POST['nisn'];
    $nama_lengkap   = $_POST['nama_lengkap'];
    $jenis_kelamin  = ($_POST['jenis_kelamin']);
    $no_telp        = ($_POST['no_telp']);
    $alamat         = ($_POST['alamat']);


    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO anggota (nisn, nama_lengkap, jenis_kelamin, no_telp, alamat) 
    VALUES ('$nisn', '$nama_lengkap', '$jenis_kelamin', '$no_telp', '$alamat')");
        header("location:?pg=anggota&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE anggota SET nisn = '$nisn', 
        nama_lengkap = '$nama_lengkap', jenis_kelamin = '$jenis_kelamin', no_telp = '$no_telp', alamat = '$alamat' WHERE id = '$id'");
    }
    header("location:?pg=anggota&ubah=berhasil");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM anggota WHERE id = '$id'");
    header("location:?pg=anggota&hapus=berhasil");
}
$anggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Data Anggota</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Nisn</label>
                            <input value="<?= ($rowEdit['nisn'] ?? '') ?>" type="text" class="form-control" name="nisn">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input value="<?= ($rowEdit['nama_lengkap'] ?? '') ?>" type="text" class="form-control" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" <?= isset($rowEdit['jenis_kelamin']) && $rowEdit['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="Perempuan" <?= isset($rowEdit['jenis_kelamin']) && $rowEdit['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">No. Telp</label>
                            <input value="<?= ($rowEdit['no_telp'] ?? '') ?>" type="text" class="form-control" name="no_telp">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat </label>
                            <textarea name="alamat" class="form-control" id=""><?= ($rowEdit['alamat'] ?? '') ?></textarea>
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