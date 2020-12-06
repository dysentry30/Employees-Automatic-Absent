<style>
    body {
        overflow-y: visible !important;
    }
</style>
<div class="container">
    <h1>Search Karyawan</h1>
    <div class="input-field">
        <div class="row">
            <form action="<?= base_url("list-karyawan/search"); ?>" method="POST">
                <div class="col s6">
                    <!-- <label for="nama">Name</label> -->
                    <input type="text" placeholder="Search by name" name="nama" id="nama" class="validate" autocomplete="off">
                </div>
                <div class="col s6">
                    <button type="submit" class="btn">Search</button>
                </div>
            </form>
        </div>
    </div>
    <?php if (!empty($list_karyawan)) : ?>
        <table class="striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Tanggal Lahir</th>
                    <th>Total Kehadiran</th>
                    <th>Total Terlambat</th>
                    <th>Total Tidak Masuk</th>
                    <th>Tanggal dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($list_karyawan as $user) : ?>
                    <?php $born_date = date_format(date_create($user["tanggal-lahir"]), "d F Y") ?>
                    <?php $createad_at = date_format(date_create($user["created_at"]), "d F Y") ?>
                    <tr class="default-table">
                        <td><?= $no++; ?></td>
                        <td><?= $user["nama"]; ?></td>
                        <td><?= $user["pangkat"] == null ? "-" : $user["pangkat"]; ?></td>
                        <td><?= $born_date; ?></td>
                        <td><?= $user["total_kehadiran"] == null ? 0 : $user["total_kehadiran"]; ?></td>
                        <td><?= $user["total_terlambat"] == null ? 0 : $user["total_terlambat"]; ?></td>
                        <td><?= $user["total_tidakmasuk"] == null ? 0 : $user["total_tidakmasuk"]; ?></td>
                        <td><?= $createad_at; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <b>Cannot find the results</b><br>
        <p>search with another name</p>
    <?php endif; ?>
</div>