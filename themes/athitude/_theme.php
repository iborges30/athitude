<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=0">
    <?= $head; ?>
    <link rel="base" href="<?= url();?>"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;0,700;1,100&display=swap"
          rel="stylesheet">

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png"); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/style.css"); ?>"/>


</head>
<body>

<div class="all bg-top">
    <div class="container">
        <div class="row">
            <div class="menu open-menu">
                <input type="checkbox" id="check">
                <label for="check"></label>
                <span></span>

            </div>

            <div class="bag">
                <i class="fas fa-shopping-bag"></i>
                <div class="bag-price">
                    <span class="roboto text-white">0</span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-1">
            <div class="logo center">
                <a href="#">
                    <img src="<?= theme("/assets/images/logo.jpg", CONF_VIEW_THEME);?>" alt="Logo">
                </a>
            </div>
        </div>
    </div>
</div>

<?= $v->section("content"); ?>
<!-- FOOTER -->
<footer class="all bg-footer mt-60">
    <div class="container">
        <div class="row">
            <div class="col-1">
                <div class="footer">
                    <p class="poppins text-default">
                        Athitude Fitness - CNPJ:
                        nº 00.000.000/0001-02,
                        - Campo Novo do Parecis MT</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="<?= theme("/assets/scripts.js"); ?>"></script>
<?= $v->section("scripts"); ?>

<!-- FOOTER -->
</body>
</html>