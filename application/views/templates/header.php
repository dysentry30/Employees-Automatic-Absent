<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        position: absolute;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }
</style>

<body>
    <header>
        <nav>
            <div class="nav-wrapper grey darken-3">
                <a href="<?= base_url("/"); ?>" class="brand-logo left offset-1">Absensi Karyawan</a>
                <ul class="right">
                    <?php if (!empty($user)) : ?>
                        <?php if ($user["admin"] == "1") : ?>
                            <li><a href="<?= base_url("list-karyawan"); ?>">List Karyawan</a></li>
                            <li><a href="<?= base_url("absen-karyawan"); ?>">Absensi Karyawan</a></li>
                        <?php endif; ?>

                        <li><a href="<?= base_url("logout"); ?>">Logout</a></li>
                    <?php else : ?>
                        <li><a href="<?= base_url("login"); ?>">Login</a></li>
                        <li><a href="<?= base_url("signup"); ?>">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>