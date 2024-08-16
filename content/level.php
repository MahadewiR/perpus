<?php
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Level</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-level" class="btn btn-primary">Tambah</a> <!-- href=link nya menuju kemana -->
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
                                <th>Nama Level</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php $no = 1;
                            while ($rowLevel = mysqli_fetch_assoc($queryLevel)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowLevel['nama_level'] ?></td>
                                    <td><?php echo $rowLevel['keterangan'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-level&edit=<?php echo $rowLevel['id'] ?>" 
                                        class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <a href="?pg=tambah-level&delete=<?php echo $rowLevel['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('apakah anda yakin akan menghapus data?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>