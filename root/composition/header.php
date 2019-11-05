<header>
    <div id="header" class="header fixed">
        <div class="container">
            <div class="row">
                <div class="col col-2">
                    <h1 class="company">ShakePrime</h1>
                </div>
                <div class="col col-8">
                    <?php require_once("navigation.php"); ?>
                </div>
                <div class="col col-2">
                    <ul class="nav right">
                        <?php if ($account->isLogged()) { ?>
                            <li><a href="./pags/d/"><i
                                            class="far fa-user-circle"></i> <?= $account->getName() ?></a></li>
                        <?php } else { ?>
                            <li><a href="./pags/login"><i class="far fa-door-closed"></i> Minha Conta
                                </a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</header>