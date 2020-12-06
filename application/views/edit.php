<!-- <?= var_dump($user); ?> -->
<style>
    body {
        overflow-y: visible !important;
    }
</style>
<div class="container">
    <div class="row">
        <h3>Edit Profile</h3>
        <?php if ($this->session->flashdata("gagal")) : ?>
            <div class="card red darken-2">
                <div class="card-content white-text">
                    <?= $this->session->flashdata("gagal"); ?><br>
                </div>
            </div>
        <?php endif; ?>
        <?= form_open_multipart("edit-profile"); ?>
        <div class="col">
            <label for="nama">Nama</label>
            <input type="text" class="validate" name="nama" id="nama" value="<?= $user["nama"]; ?>" required>
        </div>
        <div class="col">
            <label for="username">Username</label>
            <input type="text" class="validate" name="username" id="username" value="<?= $user["username"]; ?>" required>
        </div>
        <div class="col">
            <label for="password">Password</label>
            <input type="password" class="validate" name="password" id="password">
            <label for="see" class="right-align">
                <input type="checkbox" id="see" name="see" class="filled-in">
                <span>See Password?</span>
            </label>
        </div>
        <div class="col">
            <?php $position = empty($data_user["pangkat"]) ? null : $data_user["pangkat"]; ?>
            <label for="position">Position</label>
            <select name="position" id="position" class="position">
                <option value="null" disabled <?= $position == null ? "selected" : ""; ?>>Choose your position...</option>
                <option value="Web Programmer" <?= $position == "Web Programmer" ? "selected" : ""; ?>>Web Programmer</option>
                <option value="Desktop Programmer" <?= $position == "Desktop Programmer" ? "selected" : ""; ?>>Desktop Programmer</option>
                <option value="System Analyst" <?= $position == "System Analyst" ? "selected" : ""; ?>>System Analyst</option>
            </select>
            <label for="pangkat">Posisi</label>
        </div>
        <div class="col">
            <label for="tanggal-lahir">Tanggal Lahir</label>
            <?php $tanggal_lahir = empty($data_user["tanggal-lahir"]) ? "" : date_format(date_create($data_user["tanggal-lahir"]), "d F Y"); ?>
            <input type="text" class="datepicker" name="tanggal-lahir" id="tanggal-lahir" value="<?= $tanggal_lahir; ?>" required>
        </div>
        <div class="col">
            <div class="file-field input-field">
                <div class="btn blue lighten-2">
                    <span>Upload Photo Profile</span>
                    <input type="file" name="foto" id="foto" accept="image/*">
                </div>
                <div class="file-path-wrapper">
                    <!-- <?php $name_file = $data_user["profile_img"] == "" ? "" : $data_user["profile_img"] ?> -->
                    <input placeholder="For your profile pict" type="text" class="file-path validate">
                </div>
            </div>
        </div>
        <input type="hidden" name="admin" value="<?= $user["admin"]; ?>">
        <div class="row">
            <button type="submit" class="btn grey darken-3 col m5">Edit</button>
            <button class="btn-flat col push-m1"><a href="<?= base_url("/"); ?>" class=""><i class="material-icons left">keyboard_backspace</i>Back</a></button>
        </div>
        <?= form_close(); ?>
    </div>
</div>