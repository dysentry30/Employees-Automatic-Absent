<!-- <?= var_dump($time); ?> -->
<style>
    .list li a {
        position: relative;
        padding: .7rem .2rem;
        width: 150%;
        transition: background .3s ease-out;
        margin-bottom: 1rem;
    }

    .list li:hover a {
        background: #F1F1F1;
    }

    .copyright {
        transform: translateY(-50%);
    }
</style>
<div class="col s9">
    <div class="container">
        <div class="row">
            <div class="section">
                <?php if (!empty($time)) : ?>
                    <?php
                    $now = new DateTime("now");
                    $time_work = new DateTime($time["time_work"]);
                    $formatted_time_now = $now->format("H:i:s");
                    $formatted_time_work = $time_work->format("H:i:s");
                    ?>

                    <?php if ($now > $time_work) : ?>
                        <a class="tooltipped" data-position="left" data-tooltip="Click to close it" onclick="removeThis(this)">
                            <div class="card" style="cursor: pointer;">
                                <div class="card-content red darken-4 white-text center-align flow-text hoverable">
                                    <b>Hello, <?= $user["nama"]; ?></b><br>
                                    <b>Absen now, you late <?= $now->diff($time_work)->h; ?>:<?= $now->diff($time_work)->i; ?> hours ago</b>
                                </div>
                            </div>
                        </a>
                    <?php else : ?>
                        <a class="tooltipped" data-position="left" data-tooltip="Click to close it" onclick="removeThis(this)">
                            <div class="card" style="cursor: pointer;">
                                <div class="card-content green darken-4 white-text center-align flow-text hoverable">
                                    <b>Hello, <?= $user["nama"]; ?></b><br>
                                    <p>Absen now, absen closed in <b><?= $now->diff($time_work)->h; ?>:<?= $now->diff($time_work)->i; ?> hours later</b></p>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="section">
                <div class="col m4">
                    <?php if ($this->session->flashdata("gagal")) : ?>
                        <div class="notification hoverable">
                            <div class="card red darken-2">
                                <a href="#" class="tooltipped" data-position="right" data-tooltip="Click to close this notif" onclick="removeThis(this)">
                                    <div class="card-content white-text">
                                        <b class="red-text text-darken-4">Notification!!</b>
                                        <?= $this->session->flashdata("gagal"); ?><br>
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php elseif ($this->session->flashdata("sukses")) : ?>
                        <div class="notificiation hoverable">
                            <div class="card green lighten-1">
                                <a href="#" class="tooltipped" data-position="right" data-tooltip="Click to close this notif" onclick="removeThis(this)">
                                    <div class="card-content white-text">
                                        <b class="green-text text-darken-4">Notification!!</b>
                                        <b><?= $this->session->flashdata("sukses"); ?></b><br>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-content green darken-1 white-text flow-text">
                            <b>Jumlah Kehadiran</b>
                            <?php $total_kehadiran = $data_user["total_kehadiran"] == null ? 0 : $data_user["total_kehadiran"] ?>
                            <p><?= $total_kehadiran; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col m4">
                    <div class="card">
                        <div class="card-content red darken-2 white-text flow-text">
                            <b>Jumlah Terlambat</b>
                            <?php $total_terlambat =  $data_user["total_terlambat"] == null ? 0 : $data_user["total_terlambat"] ?>
                            <p><?= $total_terlambat; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col m4">
                    <div class="card">
                        <div class="card-content red darken-4 white-text flow-text">
                            <b>Jumlah Tidak Masuk</b>
                            <?php $total_tidakmasuk = $data_user["total_tidakmasuk"] == null ? 0 : $data_user["total_tidakmasuk"] ?>
                            <p><?= $total_tidakmasuk; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($user_time)) : ?>
            <div class="row">
                <div class="col m6">
                    <a href="<?= base_url("absen-now") ?>">
                        <div class="card hoverable">
                            <div class="card-content blue lighten-1 white-text flow-text">
                                <b style="font-size: 20px;"><i class="material-icons right">assignment_turned_in</i> Absen Masuk Sekarang</b>
                            </div>
                        </div>
                    </a>
                </div>
            <?php elseif ($user_time["work_at"] == null || $user_time["home_at"] != null) : ?>
                <?php if ($now->diff($time_work)->i > 0) : ?>
                    <div class="row">
                        <div class="col m6">
                            <a href="#popup-warning" class="modal-trigger">
                                <div class="card hoverable">
                                    <div class="card-content blue lighten-1 white-text flow-text">
                                        <b style="font-size: 20px;"><i class="material-icons right">assignment_turned_in</i> Absen Masuk Sekarang</b>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php else : ?>
                        <div class="row">
                            <div class="col m6">
                                <a href="<?= base_url("absen-now") ?>">
                                    <div class="card hoverable">
                                        <div class="card-content blue lighten-1 white-text flow-text">
                                            <b style="font-size: 20px;"><i class="material-icons right">assignment_turned_in</i> Absen Masuk Sekarang</b>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        <?php endif; ?>
                        <!-- Card divider -->
                    <?php elseif ($user_time["work_at"] != null && $user_time["home_at"] == null) : ?>
                        <div class="col m6">
                            <a href="<?= base_url("home-now") ?>">
                                <div class="card hoverable">
                                    <div class="card-content grey darken-1 white-text flow-text">
                                        <b style="font-size: 20px;"><i class="material-icons right">person_remove</i> Absen Pulang</b>
                                    </div>
                                </div>
                            </a>
                        </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($user["admin"] == 1) : ?>
                        <div class="row">
                            <div class="col m6">
                                <a href="<?= base_url("setting-time"); ?>">
                                    <div class="card hoverable">
                                        <div class="card-content pink darken-1 white-text">
                                            <b style="font-size: 20px;"><i class="material-icons right">alarm_add</i>Tentukan Waktu Masuk</b>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
            </div>
            <!-- TODO POP UP MODAL -->
            <div class="modal" id="popup-warning">
                <div class="modal-content red darken-4 white-text flow-text">
                    <h4 class="center-align"><b>Warning!!!</b></h4>
                    <p>Anda sudah telat <b><?= $now->diff($time_work)->h; ?> jam <?= $now->diff($time_work)->i; ?> menit yang lalu</b></p>
                    <p>Berikan kami alasan kenapa anda telat?</p>
                    <form method="POST" action="<?= base_url("absen-now") ?>">
                        <div class="input-field">
                            <label for="excuse">Alasan</label>
                            <textarea name="excuse" id="excuse" style="padding: 1rem 1rem;" class="materialize-textarea white-text" cols="30" rows="10"></textarea>
                        </div>
                </div>
                <div class="modal-footer red darken-4">
                    <button type="submit" class=" waves-effect btn green darken-3">Absen Now!</button>
                    <a href="#" class="modal-close waves-effect btn grey darken-4">I don't want it!</a>
                </div>
                </form>
            </div>

            <script>
                const notification = document.querySelector(".notificiation");

                notification.addEventListener("click", e => {
                    e.stopPropagation()
                    e.preventDefault()

                    notification.classList.add("hide");
                })

                function removeThis(element) {
                    element.classList.add("hide");
                }
            </script>