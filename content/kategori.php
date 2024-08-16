<?php
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");

?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Kategori</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-kategori" class="btn btn-primary">Tambah</a> <!-- href=link nya menuju kemana -->
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">
                            Data Berhasil ditambahkan
                        </div>
                    <?php endif ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-danger">
                            Data Berhasil dihapus
                        </div>
                    <?php endif ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php $no = 1;
                            while ($rowKategori = mysqli_fetch_assoc($queryKategori)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowKategori['nama_kategori'] ?></td>
                                    <td><?php echo $rowKategori['keterangan'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-kategori&edit=<?php echo $rowKategori['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <a href="?pg=tambah-kategori&delete=<?php echo $rowKategori['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('apakah anda yakin akan menghapus data?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>