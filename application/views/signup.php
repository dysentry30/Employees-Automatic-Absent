<style>
    .container {
        transform: translateY(0%);
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s6 push-s3">
            <div class="card hoverable z-depth-4">
                <div class="card-content center white-text grey darken-3">
                    <b>Signup Form</b>
                </div>
                <div class="card-content grey lighten-4">
                    <div class="row">
                        <?php if ($this->session->flashdata("gagal")) : ?>
                            <div class="card red darken-2">
                                <div class="card-content white-text">
                                    <?= $this->session->flashdata("gagal"); ?><br>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- <form action="" method="POST" class="col s12" enctype="multipart/form-data"> -->
                        <?= form_open_multipart("signup"); ?>
                            <div class="row">
                                <div class="col s5">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" class="validate" required autocomplete="off">
                                </div>
                                <div class="col s7">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="validate" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <label for="born">Born in</label>
                                    <input type="text" id="born" name="born" class="datepicker" required autocomplete="off">
                                </div>
                                <div class="input-field col s6">
                                    <select name="position" id="position" class="position">
                                        <option value="null" disabled selected>Choose your position...</option>
                                        <option value="Web Programmer">Web Programmer</option>
                                        <option value="Desktop Programmer">Desktop Programmer</option>
                                        <option value="System Analyst">System Analyst</option>
                                    </select>
                                    <label for="position">Position</label>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <label for="file">Upload Photo Profile</label>
                                <input type="file" name="file" id="file" accept="image/*"> -->
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Photo Profile</span>
                                        <input type="file" name="file" id="file" accept="image/*">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input placeholder="Upload Photo Profile" type="text" class="file-path validate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="validate" required autocomplete="off">
                                    <label for="see" class="right-align">
                                        <input type="checkbox" id="see" name="see" class="filled-in">
                                        <span>See Password?</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row center">
                                <button type="submit" name="submit" class="waves-effect waves-light btn grey darken-4"><i class="material-icons right">login</i>Join</button>
                            </div>
                            <?= form_close(); ?>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox_see = document.querySelector("#see");
        const password_input = document.querySelector("#password")

        checkbox_see.addEventListener("change", e => {
            if (e.target.checked) {
                password_input.setAttribute("type", "text")
            } else {
                password_input.setAttribute("type", "password")
            }
        })
    });
</script>

<!-- TODO Makes signup functionality works perfectly and show to home page and makes calcuate of sum -->