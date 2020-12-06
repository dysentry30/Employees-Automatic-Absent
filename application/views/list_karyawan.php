<style>
    body {
        overflow-y: visible !important;
    }
</style>
<div class="container">
    <h1>List Karyawan</h1>
    <div class="input-field">
        <div class="row">
            <form action="<?= base_url("list-karyawan/search"); ?>" method="POST">
                <div class="col s6">
                    <input type="text" placeholder="Search by name" name="nama" id="nama" class="validate" autocomplete="off">
                </div>
                <div class="col s6">
                    <button type="submit" class="btn">Search</button>
                </div>
            </form>
        </div>
    </div>
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
                <th>Online</th>
            </tr>
        </thead>
        <tbody>
            <?php $iteration = 0; ?>
            <?php foreach ($all_users as $user) : ?>
                <?php $born_date = date_format(date_create($user["tanggal-lahir"]), "d F Y") ?>
                <?php $createad_at = date_format(date_create($user["created_at"]), "d F Y") ?>
                <tr class="default-table">
                    <td><?= ++$no; ?></td>
                    <td><?= $user["nama"]; ?></td>
                    <td><?= $user["pangkat"] == null ? "-" : $user["pangkat"]; ?></td>
                    <td><?= $born_date; ?></td>
                    <td><?= $user["total_kehadiran"] == null ? 0 : $user["total_kehadiran"]; ?></td>
                    <td><?= $user["total_terlambat"] == null ? 0 : $user["total_terlambat"]; ?></td>
                    <td><?= $user["total_tidakmasuk"] == null ? 0 : $user["total_tidakmasuk"]; ?></td>
                    <td><?= $createad_at; ?></td>
                    <?php if ($user["is_online"] == 1) : ?>
                        <td><i class="material-icons left green-text lighten-2 tiny">fiber_manual_record</i>Online</td>
                    <?php else : ?>
                        <td><i class="material-icons left grey-text lighten-2 tiny">fiber_manual_record</i>Offline</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->pagination->create_links(); ?>
</div>