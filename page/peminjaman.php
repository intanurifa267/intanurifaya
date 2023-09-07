<?php
$sql = "SELECT max(id_peminjaman) as maxKode FROM peminjaman";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);

$maxKode = $data['maxKode'];
if ($maxKode == null) {
    $noUrut = 1;
} else {
    $noUrut = (int) substr($maxKode, 3, 3);
    $noUrut = ($noUrut == 999) ? 1 : $noUrut + 1;
}

$char = "PMJ";
$kodePeminjaman = $char . sprintf("%03s", $noUrut);
?>

<div class="row">
    <center>
        <h2>Peminjaman Inventaris</h2>
    </center>
    <hr>
    <div class="col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Peminjaman</div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Kode Peminjaman</label>
                            <input type="text" class="form-control" name="id_peminjaman" value="<?= $kodePeminjaman ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Peminjam</label>
                            <select name="id_pengawai" id="" class="form-control">
                                <option value="">Nama Pegawai</option>
                                <?php
                                $sql_pengawai = "SELECT * FROM pengawai";
                                $q_pengawai = mysqli_query($koneksi, $sql_pengawai);
                                while ($pengawai = mysqli_fetch_array($q_pengawai)) {
                                    ?>
                                    <option value="<?= $pengawai['id_pengawai'] ?>"><?= $pengawai['nama_pengawai'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Barang</label>
                            <select name="id_inventaris" id="" class="form-control">
                                <option value="">Nama Barang</option>
                                <?php
                                $sql_inventaris = "SELECT * FROM inventaris";
                                $q_inventaris = mysqli_query($koneksi, $sql_inventaris);
                                while ($inventaris = mysqli_fetch_array($q_inventaris)) {
                                    ?>
                                    <option value="<?= $inventaris['id_inventaris'] ?>"><?= $inventaris['nama'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah">
                        </div>
                        <div>
                            <button class="btn btn-md btn-primary" name="simpan">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            
            if (isset($_POST['simpan'])) {
            $id_peminjaman = $_POST['id_peminjaman'];
            $id_pengawai = $_POST['id_pengawai'];
            $id_inventaris = $_POST['id_inventaris'];
            $jumlah = $_POST['jumlah'];

            $sql_peminjaman = "INSERT INTO peminjaman (id_peminjaman, id_pengawai, status_peminjaman) VALUES ('$id_peminjaman', '$id_pengawai', '0')";

            $query_input = mysqli_query($koneksi, $sql_peminjaman);
            if ($query_input) {
                $sql_detail_pinjam = "INSERT INTO detail_pinjam (jumlah, id_inventaris, id_peminjaman) VALUES ('$jumlah', '$id_inventaris', '$id_peminjaman')";
                $query_detail_pinjam = mysqli_query($koneksi, $sql_detail_pinjam);
                if ($query_detail_pinjam) {
                    ?>
                    <script type="text/javascript">
                        window.location.href = "?p=peminjaman";
                    </script>
                    <?php
                } else {
                    echo "Gagal menyimpan detail peminjaman";
                }
            } else {
                echo "Gagal menyimpan peminjaman";
            }
        }
            ?>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-primary">
            <div class="panel-heading">Daftar Pinjam Barang</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pinjam</th>
                        <th>Tgl.Pinjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Jml</th>
                        <th>Tgl.Kembali</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $hari = date('d-m-Y');
                        $d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam
                        LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman
                        LEFT JOIN inventaris ON inventaris.id_inventaris = detail_pinjam.id_inventaris
                        LEFT JOIN pengawai ON pengawai.id_pengawai = peminjaman.id_pengawai";
                        $d_query = mysqli_query($koneksi, $d_peminjaman);
                        $cek = mysqli_num_rows($d_query);

                    if ($cek > 0) {
                        $no = 1;
                        while ($data_d = mysqli_fetch_array($d_query)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data_d['id_peminjaman']?></td>
                                <td><?= $hari?></td>
                                <td><?= $data_d['nama_pengawai']?></td>
                                <td><?= $data_d['nama']?></td>
                                <td><?= $data_d['jml']?></td>
                                <td><?= $data_d['tanggal_kembali']?></td>
                                <td>
                                    <?php
                                        if($data_d['status_peminjaman'] == '0'){
                                            echo "<label class= 'label label-danger'>Konfirmasi</label>";
                                        }else if($data_d['status_peminjaman'] == '1'){
                                            echo "<label class= 'label label-warning'>Dipinjam</label>";
                                        }else{
                                            echo "<label class= 'label label-success'>Dikembalikan</label>";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($data_d['status_peminjaman'] == '0'){
                                            ?>
                                            <a onclick="return confirm('Apakah anda yakin?')" href="page/proses_peminjaman.php?=id_peminjaman=<?=$data_d
                                            ['id_peminjaman']?>" class="btn btn-sm btn-primary">Proses</a>
                                            <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            
                        }
                    }
                    ?>

                    <!-- tr>
                        <td>1</td>
                        <td>PJM001</td>
                        <td>10-11-2021</td>
                        <td>Oktavia</td>
                        <td>Laptop</td>
                        <td>10</td>
                        <td>00-00-0000</td>
                        <td>
                            <label for="" class="label label-danger">Belum</label>
                        </td>
                        <td>
                            <a href="" class="btn btn-primary btn-ms">Proses</a>
                        </td>
                    </!-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>