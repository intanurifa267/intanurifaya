<div class="row">
    <h2>Tambah Barang</h2>
    <hr>
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Tambah Barang Inventaris</div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Kode Inventaris</label>
                        <input type="text" class="form-control" name="kode_inventaris" placeholder="Masukkan Kode Barang">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Inventaris</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Barang">
                    </div>
                    <div class="form-group">
                        <label for="">Kondisi</label>
                        <select name="kondisi" class="form-control">
                            <option value="">- Pilih -</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" placeholder="Masukkan Jumlah Barang">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Inventaris</label>
                        <select name="id_jenis" class="form-control">
                            <option value="">- PILIH -</option>
                            <?php
                            $sql_jenis = "SELECT * FROM jenis";
                            $q_jenis = mysqli_query($koneksi, $sql_jenis);
                            while ($jenis = mysqli_fetch_array($q_jenis)) {
                                ?>
                                <option value="<?= $jenis['id_jenis'] ?>"><?= $jenis['nama_jenis'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ruang</label>
                        <select name="id_ruang" class="form-control">
                            <option value="">- PILIH -</option>
                            <?php
                            $sql_ruang = "SELECT * FROM ruang";
                            $q_ruang = mysqli_query($koneksi, $sql_ruang);
                            while ($ruang = mysqli_fetch_array($q_ruang)) {
                                ?>
                                <option value="<?= $ruang['id_ruang'] ?>"><?= $ruang['nama_ruang'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group hidden">
                        <label for="">Petugas</label>
                        <input type="number" name="id_petugas" value="2" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-md btn-primary" name="simpan">Simpan</button>
                        <a href="?p=list_barang" class="btn btn-md btn-default">Kembali</a>
                    </div>
                </form>

                <?php
                if (isset($_POST['simpan'])) {
                    $kode_inventaris = $_POST['kode_inventaris'];
                    $nama = $_POST['nama'];
                    $kondisi = $_POST['kondisi'];
                    $jumlah = $_POST['jumlah'];
                    $id_jenis = $_POST['id_jenis'];
                    $id_ruang = $_POST['id_ruang'];
                    $keterangan = $_POST['keterangan'];
                    $id_petugas = $_POST['id_petugas'];

                    $sql = "INSERT INTO inventaris (kode_inventaris, nama, kondisi, jumlah, id_jenis, id_ruang, keterangan, id_petugas)
                            VALUES ('$kode_inventaris', '$nama', '$kondisi', '$jumlah', '$id_jenis', '$id_ruang', '$keterangan', '$id_petugas')";

                    $query = mysqli_query($koneksi, $sql);
                    if ($query) {
                        ?>
                        <div class="alert alert-success">Barang Berhasil ditambahkan</div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-danger">Barang Gagal ditambahkan</div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>