<?= var_dump($all_data["list_tidak_masuk"]); ?>
<style>
    body {
        overflow-y: visible !important;
    }
</style>
<div class="container">
    <h1>Absen Karyawan</h1>
    <div class="input-field">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#kehadiran">Karyawan Hadir</a></li>
                    <li class="tab col s3"><a href="#keterlambatan">Karyawan Terlambat</a></li>
                    <li class="tab col s3"><a href="#tidak-masuk">Karyawan Tidak Masuk</a></li>
                </ul>
            </div>
        </div>
        <!-- TODO TABS 1 -->
        <?php if (!empty($all_data["list_kehadiran"])) : ?>
            <div class="col s12" id="kehadiran">
                <table class="striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Telat</th>
                            <th>Masuk Jam</th>
                            <th>Pulang Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($all_data["list_kehadiran"] as $user) : ?>
                            <?php $work_at = date_format(date_create($user["work_at"]), "d F Y, H:i:s") ?>
                            <?php $home_at = $user["home_at"] == null ? "Belom Pulang" : date_format(date_create($user["home_at"]), "d F Y, H:i:s") ?>
                            <tr class="default-table">
                                <td><?= ++$no; ?></td>
                                <td><?= $user["nama"]; ?></td>
                                <td><?= $user["username"]; ?></td>
                                <td><?= $user["is_late"] == 0 ? "Tidak Telat" : "Telat" ?></td>
                                <td><?= $work_at ?></td>
                                <td><?= $home_at ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <?= $this->pagination->create_links(); ?> -->
            </div>
        <?php else : ?>
            <p><b>Tidak Ada Data</b></p>
        <?php endif; ?>

        <!-- TODO TABS 2 -->
        <?php if (!empty($all_data["list_keterlambatan"])) : ?>
            <div class="col s12" id="keterlambatan">
                <table class="striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Masuk Jam</th>
                            <th>Alasan Telat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no2 = 0 ?>
                        <?php foreach ($all_data["list_keterlambatan"] as $user) : ?>
                            <?php $come_at = date_format(date_create($user["come_at"]), "d F Y, H:i:s") ?>
                            <tr class="default-table">
                                <td><?= ++$no2; ?></td>
                                <td><?= $user["nama"]; ?></td>
                                <td><?= $user["username"]; ?></td>
                                <td><?= $come_at; ?></td>
                                <td class="" style="max-width: 200px;overflow-wrap: break-word;"><?= $user["excuse"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else : ?>
            <p><b>Tidak ada data</b></p>
        <?php endif; ?>

        <!-- TODO TABS 3 -->
        <div class="col s12" id="tidak-masuk">
            <?php if (!empty($all_data["list_tidak_masuk"])) : ?>
                <div class="col s12">
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Masuk Jam</th>
                                <th>Alasan Telat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no2 = 0 ?>
                            <?php foreach ($all_data["list_keterlambatan"] as $user) : ?>
                                <?php $come_at = date_format(date_create($user["come_at"]), "d F Y, H:i:s") ?>
                                <tr class="default-table">
                                    <td><?= ++$no2; ?></td>
                                    <td><?= $user["nama"]; ?></td>
                                    <td><?= $user["username"]; ?></td>
                                    <td><?= $come_at; ?></td>
                                    <td class="" style="max-width: 200px;overflow-wrap: break-word;"><?= $user["excuse"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else : ?>
                <p><b>Tidak ada data</b></p>
            <?php endif; ?>
        </div>
    </div>
</div>