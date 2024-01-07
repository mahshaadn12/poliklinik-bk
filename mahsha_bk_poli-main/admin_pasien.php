<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) { 
    header("Location: index_admin.php?page=login_admin");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                                            nama = '" . $_POST['nama'] . "',
                                            alamat = '" . $_POST['alamat'] . "',
                                            no_ktp = '" . $_POST['no_ktp'] . "',
                                            no_hp = '" . $_POST['no_hp'] . "',
                                            no_rm = '" . $_POST['no_rm'] . "',
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                                            VALUES (
                                                '" . $_POST['nama'] . "',
                                                '" . $_POST['alamat'] . "',
                                                '" . $_POST['no_ktp'] . "',
                                                '" . $_POST['no_hp'] . "',
                                                '" . $_POST['no_rm'] . "'
                                            )");
    }
    echo "<script> 
                document.location='index_admin.php?page=admin_pasien';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index_admin.php?page=admin_pasien';
                </script>";
}
?>
<h2 class="text-center">Mengelola Pasien</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $no_ktp = '';
        $no_hp = '';
        $no_rm = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM pasien 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_ktp = $row['no_ktp'];
                $no_hp = $row['no_hp'];
                $no_rm = $row['no_rm'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama Pasien
            </label>
            <div>
                <input type="text" class="form-control" name="nama_poli" id="inputNama" placeholder="nama Pasien" value="<?php echo $nama ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="alamat" class="form-label fw-bold">
                Alamat Pasien
            </label>
            <div>
                <input type="text" class="form-control" name="alamat" id="alamatpasien" placeholder="alamat pasien" value="<?php echo $alamat ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="no_ktp" class="form-label fw-bold">
                No. KTP Pasien
            </label>
            <div>
                <input type="text" class="form-control" name="noktppasien" id="noktppasien" placeholder="no ktp pasien" value="<?php echo $no_ktp ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="no_hp" class="form-label fw-bold">
                No. HP Pasien
            </label>
            <div>
                <input type="text" class="form-control" name="nohppasien" id="nohppasien" placeholder="no hp pasien" value="<?php echo $no_hp ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="no_rm" class="form-label fw-bold">
                No. RM Pasien
            </label>
            <div>
                <input type="text" class="form-control" name="normpasien" id="normpasien" placeholder="no rm pasien" value="<?php echo $no_rm ?>">
            </div>
        </div>
        <div class="row mt-3">
            <br>
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
            </br>
        </div>
    </form>
    <br>
    <br>
    <!-- Table Data pasien-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nama Pasien</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. KTP</th>
                <th scope="col">No. HP</th>
                <th scope="col">No. RM</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM pasien");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index_admin.php?page=admin_poli&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index_admin.php?page=admin_poli&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>