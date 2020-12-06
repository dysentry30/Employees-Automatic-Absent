<style>
    .container {
        transform: translateY(8%);
    }

    img {
        z-index: -2;
        position: absolute;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100%;
        height: 100vh;
    }
    .bgalpha {
        position: absolute;
        z-index: -1;
        background-color: rgba(0, 0, 0, .5);
        width: 100%;
        height: 100vh;
        top: 0;
        left: 0;
    }
</style>
<img src="<?= base_url("/assets/campaign-creators-gMsnXqILjp4-unsplash.jpg"); ?>">
<div class="bgalpha"></div>
<div class="container">
    <div class="row">
        <div class="col s6 offset-s3">
            <div class="card hoverable z-depth-4">
                <div class="card-content center white-text grey darken-3">
                    <b>Login Form</b>
                </div>
                <div class="card-content grey lighten-4">
                    <div class="row">
                        <?php if($this->session->flashdata("gagal")): ?>
                        <div class="card red darken-2">
                            <div class="card-content white-text">
                                <?= $this->session->flashdata("gagal"); ?><br>
                                Tekan <a href="#">Forgot Password?</a> jika anda lupa password
                            </div>
                        </div>

                        <?php elseif($this->session->flashdata("sukses")): ?>
                        <div class="card green lighten-1">
                            <div class="card-content white-text">
                                <?= $this->session->flashdata("sukses"); ?><br>
                            </div>
                        </div>
                        <?php endif; ?>
                        <form action="<?= base_url("join"); ?>" method="POST" class="col s12">
                            <div class="row">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="validate" required autocomplete="off">
                            </div>
                            <div class="row">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="validate" required autocomplete="off">
                                <label for="see" class="right-align">
                                    <input type="checkbox" id="see" name="see" class="filled-in">
                                    <span>See Password?</span>
                                </label>
                            </div>
                            <div class="row center">
                                <button type="submit" name="submit" class="waves-effect waves-light btn grey darken-4"><i class="material-icons right">login</i>Come In!</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", () => {
        const checkbox_see = document.querySelector("#see");
        const password_input = document.querySelector("#password")

        checkbox_see.addEventListener("change", e => {
            if(e.target.checked) {
                password_input.setAttribute("type", "text")
            } else {
                password_input.setAttribute("type", "password")
            }
        })
    })
</script>