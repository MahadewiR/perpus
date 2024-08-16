<?php
$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");

?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Anggota</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-anggota" class="btn btn-primary">Tambah</a>
                        <!-- href=link nya menuju kemana -->
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
                                <th>No.</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>No. Telp</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php $no = 1;
                            while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowAnggota['nisn'] ?></td>
                                    <td><?php echo $rowAnggota['nama_lengkap'] ?></td>
                                    <td><?php echo $rowAnggota['no_telp'] ?></td>
                                    <td><?php echo $rowAnggota['jenis_kelamin'] ?></td>
                                    <td><?php echo $rowAnggota['alamat'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-anggota&edit=<?php echo $rowAnggota['id'] ?>" 
                                        class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <a href="?pg=tambah-anggota&delete=<?php echo $rowAnggota['id'] ?>" 
                                        class="btn btn-sm btn-outline-danger" 
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