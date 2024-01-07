<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) { 
    header("Location: index.php?page=login_pasien");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE daftar_poli SET 
                                            id_pasien = '" . $_POST['id_pasien'] . "',
                                            id_jadwal = '" . $_POST['id_jadwal'] . "'
                                            keluhan = '" . $_POST['keluhan'] . "'
                                            no_antrian = '" . $_POST['no_antrian'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) 
                                            VALUES (
                                                '" . $_POST['id_pasien'] . "',
                                                '" . $_POST['id_jadwal'] . "',
                                                '" . $_POST['keluhan'] . "',
                                                '" . $_POST['no_antrian'] . "'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=daftar_poli';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM daftar_poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=daftar_poli';
                </script>";
}
?>
<h2 class="text-center">Daftar Poli</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $id_pasien = '';
        $id_jadwal = '';
        $keluhan = '';
        $no_antrian = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM daftar_poli 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $id_pasien = $row['id_pasien'];
                $id_jadwal = $row['id_-jadwal'];
                $keluhan = $row['keluhan'];
                $no_antrian = $row['no_antrian'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="nomorrm" class="form-label fw-bold">
                Nomor Rekam Medis
            </label>
            <select class="form-control" name="no_rm" id="no_rm">
                    <?php
                    $resultPasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                    if ($resultPasien) {
                        while ($dataPasien = mysqli_fetch_array($resultPasien)) {
                            $selectedPasien = ($dataPasien['id'] == $id_pasien) ? 'selected="selected"' : '';
                    ?>
                            <option value="<?php echo $dataPasien['id'] ?>" <?php echo $selectedPasien ?>><?php echo $dataPasien['nama'] ?></option>
                    <?php
                        }
                    } else {
                        echo "Error: " . mysqli_error($mysqli);
                    }
                    ?>
            </select>
        </div>
        <div class="row">
            <label for="idjadwal" class="form-label fw-bold">
                Pilih Jadwal
            </label>
            <select class="form-control" name="pilihjadwal" id="pilihjadwal">
                    <?php
                    $resultPasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                    if ($resultPasien) {
                        while ($dataPasien = mysqli_fetch_array($resultPasien)) {
                            $selectedPasien = ($dataPasien['id'] == $id_jadwal) ? 'selected="selected"' : '';
                    ?>
                            <option value="<?php echo $dataPasien['id'] ?>" <?php echo $selectedPasien ?>><?php echo $dataPasien['nama'] ?></option>
                    <?php
                        }
                    } else {
                        echo "Error: " . mysqli_error($mysqli);
                    }
                    ?>
            </select>
        </div>
        <div class="row">
        <label for="inputpoli" class="form-label fw-bold">
            Input Poli
        </label>
        <div>
            <input type="text" class="form-control" name="inputpoli" id="inputpoli" placeholder="Input Poli" value="<?php echo $keluhan ?>">
        </div>
        </div>
        <div class="row">
        <label for="keluhan" class="form-label fw-bold">
            Keluhan
        </label>
        <div>
            <input type="text" class="form-control" name="keluhan" id="keluhan" placeholder="Keluhan" value="<?php echo $keluhan ?>">
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
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Pilihan Poli</th>
                <th scope="col">Keterangan Poli</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM daftar_poli");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_poli'] ?></td>
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