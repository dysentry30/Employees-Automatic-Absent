<div class="row">
    <div class="col s3 blue darken-4">
        <div class="container">
            <div class="card center">
                <div class="card-content">
                    <div class="row">
                        <?php $img_name = $data_user["profile_img"] == null ? "default.jpg" : $data_user["profile_img"]; ?>
                        <img src="<?= base_url("/assets/profile-image/$img_name"); ?>" width="75" height="75" alt="profile" class="circle responsive-img">
                        <?= form_open_multipart("upload_image"); ?>
                        <!-- <div class="file-field input-field">
                                    <div class="btn-small">
                                        <span>Upload Image</span>
                                        <input type="file" name="image" id="image" accept="image/*">
                                    </div>
                                </div> -->
                        <?= form_close(); ?>
                        <p><b><?= $user["nama"]; ?></b></p>
                        <p class="grey-text text-darken-2"><?= $user["username"]; ?></p>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <div class="row">
                            <div class="col left-align">
                                <ul class="list">
                                    <li><a class="waves-effect black-text" href="#"><i class="material-icons left">how_to_reg</i> Kehadiran</a></li>
                                    <li><a class="waves-effect black-text" href="#"><i class="material-icons left">alarm_off</i>Terlambat</a></li>
                                    <li><a class="waves-effect black-text" href="#"><i class="material-icons left">not_interested</i>Tidak Masuk</a></li>
                                    <li><a class="waves-effect black-text" href="<?= base_url("edit-profile"); ?>"><i class="material-icons left">account_circle</i>Edit Profile</a></li>
                                    <li><a class="waves-effect black-text" href="<?= base_url("logout"); ?>"><i class="material-icons left">assignment_return</i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section copyright">
                        <p class="grey-text text-darken-1">Created by Bagas Satria N</p>
                        <p class="center grey-text text-darken-1">in 2020</p>
                    </div>
                </div>
            </div>
        </div>
    </div>