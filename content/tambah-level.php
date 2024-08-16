<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM level WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {
    //jika parameter edit ada maka update, kalo gaada = tambah 
    $id = (isset($_GET['edit'])) ? $_GET['edit'] : '';

    $nama_level = $_POST['nama_level'];
    $keterangan = $_POST['keterangan'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO level (nama_level, keterangan) VALUES ('$nama_level', '$keterangan')");
    } else {
        $update = mysqli_query($koneksi, "UPDATE level SET nama_level='$nama_level', keterangan = '$keterangan' WHERE id = '$id'");
    }
    // mysqli query diberikan setiap akan dilakukan perintah/query 
    // sedangkan $koneksi menghubungkan dari config-koneksi.php
    header("Location:?pg=level&tambah=berhasil");
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM level WHERE id = '$id'");
    header("Location:?pg=level&hapus=berhasil");
}
?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah Level</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="label">Nama Level</label>
                            <input type="text" name="nama_level" class="form-control" value="<?php echo ($rowEdit['nama_level'] ?? '') ?>">
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