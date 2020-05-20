<?php
    $about = json_decode(file_get_contents(__DIR__ . "/../configurations/json/about.json"));
?>
    <nav class="navbar navbar-light navbar-expand-md" style="background-color: #eeefef; position: absolute;width:100%; z-index: 10;">
        <div class="container-fluid"><a class="navbar-brand" href="/"><?php echo $about -> systemName; ?></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                <?php
                    require __DIR__ . "/../configurations/database/class.php";
                    $menu = $database -> query("SELECT * FROM `main_modules`;");
                    while ($row = $menu -> fetch_assoc()) {
                        $path = $row["relativePath"];
                        $dropdown = json_decode($row["menuPieces"]); ?>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><?php echo $row["name"]; ?></a>
                            <div class="dropdown-menu" role="menu">
                                <?php foreach ($dropdown as $first) {
                                    if (!$first -> forAuth) {
                                        $allowed = true;
                                        if (is_object($this -> user)) {
                                            $levels = $this -> user -> getDecrypted()["levels"];
                                            if (isset($first -> notFor))
                                                foreach ($first -> notFor as $value)
                                                    if (in_array($value, $levels))
                                                        $allowed = false;
                                        }
                                        if (is_array($first -> submenu) && $allowed) { ?>
                                            <div class="dropdown-submenu dropright">
                                                <a class="dropdown-toggle dropdown-item" data-toggle="dropdown" href="#"><?php echo $first -> name; ?></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php foreach($first -> submenu as $second) { ?>
                                                        <li><a class="dropdown-item" role="presentation" href="<?php echo "/modules/{$path}/{$second -> href}"; ?>"><?php echo $second -> name; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } elseif ($allowed) { ?>
                                            <a class="dropdown-item" role="presentation" href="<?php echo "/modules/{$path}/{$first -> href}"; ?>"><?php echo $first -> name; ?></a>
                                        <?php }
                                    } elseif (is_object($this -> user)) {
                                        $levels = $this -> user -> getDecrypted()["levels"];
                                        $access = false;
                                        $allowed = true;
                                        foreach ($first -> forLevels as $value)
                                            if (in_array($value, $levels))
                                                $access = true;
                                        if (isset($first -> notFor))
                                            foreach ($first -> notFor as $value)
                                                if (in_array($value, $levels))
                                                    $allowed = false;
                                        if ($access && $allowed) {
                                            if (is_array($first -> submenu)) { ?>
                                                <div class="dropdown-submenu dropright">
                                                    <a class="dropdown-toggle dropdown-item" data-toggle="dropdown" href="#"><?php echo $first -> name; ?></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <?php foreach($first -> submenu as $second) {
                                                            $access = false;
                                                            foreach ($second -> forLevels as $value)
                                                                if (in_array($value, $levels))
                                                                    $access = true; 
                                                            if ($access) { ?>
                                                                <li><a class="dropdown-item" role="presentation" href="<?php echo "/modules/{$path}/{$second -> href}"; ?>"><?php echo $second -> name; ?></a></li>
                                                            <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            <?php } else { ?>
                                                <a class="dropdown-item" role="presentation" href="<?php echo "/modules/{$path}/{$first -> href}"; ?>"><?php echo $first -> name; ?></a>
                                            <?php }
                                        }
                                    }
                                } ?>
                            </div>
                        </li>
                    <?php }
                    $database -> close();
                ?>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                <?php if (is_object($this -> user)) {
                    $about = $this -> user -> getDecrypted();
                ?>
                    <li class="nav-item" style="margin-right:15px;">
                        <a class="nav-link" href="/cabinet"><?php echo "{$about['lastname']} {$about['firstname']}"; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary text-primary" id="button-logout" href="#" type="button" onclick="$.post('/cabinet/api/user/exit', {token: Cookies.get('token')}, (d) => { Cookies.remove('token'); location.href = '/'; });">Выйти</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item" role="presentation" style="margin: 10px 0px;">
                        <a class="btn btn-outline-primary text-primary" id="button-login" href="/login" type="button">Войти</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </nav>