<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {
    //jika parameter edit ada maka update, kalo gaada = tambah 
    $id = (isset($_GET['edit'])) ? $_GET['edit'] : '';

    $nama_kategori = $_POST['nama_kategori'];
    $keterangan = $_POST['keterangan'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nama_kategori', '$keterangan')");
    } else {
        $update = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama_kategori', keterangan = '$keterangan' WHERE id = '$id'");
    }
    // mysqli query diberikan setiap akan dilakukan perintah/query 
    // sedangkan $koneksi menghubungkan dari config-koneksi.php
    header("Location:?pg=kategori&tambah=berhasil");
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM kategori WHERE id = '$id'");
    header("Location:?pg=kategori&hapus=berhasil");
}
?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah Kategori</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" value="<?php echo ($rowEdit['nama_kategori'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="<?php echo ($rowEdit['keterangan'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan"> <!-- value = inputan yg akan terlihat kepada user -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>