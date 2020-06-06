<header style="min-height: 100vh;">
        <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
            <div class="container">
                <h2>Очное отделение</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <caption>Таблица актуальна на <?php echo Date("d.m.Y H:i:s") . " GTM+5"; ?></caption>
                        <thead style="text-align: center;">
                            <tr>
                                <th rowspan="2">Специальность</th>
                                <?php $counter = 0;
                                $levels = $this -> database -> query("SELECT `name` FROM `enr_education_levels`;");
                                while ($level = $levels -> fetch_assoc()) {
                                    $counter++; ?>
                                    <th colspan="2"><?php echo $level["name"]; ?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php for ($i = 0; $i < $counter; $i++) { ?>
                                    <th>Оригиналов документов об образовании</th>
                                    <th>Без оригиналов документов образовании</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $specialties = $this -> database -> query("SELECT `fullname`, `budget`, `contract`, `id` FROM `enr_specialties` WHERE `forExtramural` = 0;");
                            while ($specialty = $specialties -> fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo explode("@", $specialty["fullname"])[0] . (!empty(explode("@", $specialty["fullname"])[0]) ? " <i>" . explode("@", $specialty["fullname"])[1] . "</i>" : ""); ?></td>
                                    <?php $levels = $this -> database -> query("SELECT `id` FROM `enr_education_levels`;");
                                    while ($level = $levels -> fetch_assoc()) {
                                        echo "
                                        <td style=\"text-align: center;\">{$this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1;") -> fetch_assoc()["cnt"]}</td>
                                        <td style=\"text-align: center;\">{$this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 0;") -> fetch_assoc()["cnt"]}</td>
                                        ";
                                    } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <h2>Заочное отделение</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <caption>Таблица актуальна на <?php echo Date("d.m.Y H:i:s") . " GTM+5"; ?></caption>
                        <thead style="text-align: center;">
                            <tr>
                                <th rowspan="2">Специальность</th>
                                <?php $counter = 0;
                                $levels = $this -> database -> query("SELECT `name` FROM `enr_education_levels`;");
                                while ($level = $levels -> fetch_assoc()) {
                                    $counter++; ?>
                                    <th colspan="2"><?php echo $level["name"]; ?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php for ($i = 0; $i < $counter; $i++) { ?>
                                    <th>Оригиналов документов об образовании</th>
                                    <th>Без оригиналов документов образовании</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $specialties = $this -> database -> query("SELECT `fullname`, `budget`, `contract`, `id` FROM `enr_specialties` WHERE `forExtramural` = 1;");
                            while ($specialty = $specialties -> fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo explode("@", $specialty["fullname"])[0] . (!empty(explode("@", $specialty["fullname"])[1]) ? " <i>" . explode("@", $specialty["fullname"])[1] . "</i>" : ""); ?></td>
                                    <?php $levels = $this -> database -> query("SELECT `id` FROM `enr_education_levels`;");
                                    while ($level = $levels -> fetch_assoc()) {
                                        echo "
                                        <td style=\"text-align: center;\">{$this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1;") -> fetch_assoc()["cnt"]}</td>
                                        <td style=\"text-align: center;\">{$this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 0;") -> fetch_assoc()["cnt"]}</td>
                                        ";
                                    } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="/global-assets/js/dropdown-bootstrap.js"></script>
</body>

</html>
