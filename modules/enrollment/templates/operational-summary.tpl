<style>
    html {
        scroll-behavior: smooth;
    }

    body {
        position: relative;
    }
    
    table {
        font-size: .9rem;
    }
</style>
<header style="min-height: 100vh;">
    <div style="width: 100%; min-height: 100vh; padding-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="list-group">
                    <?php $specialties = $this -> database -> query("SELECT `fullname`, `budget`, `contract`, `id` FROM `enr_specialties` WHERE `forExtramural` = 0;");
                        while ($specialty = $specialties -> fetch_assoc()) { ?>
                            <a class="list-group-item list-group-item-action list-group-item-action" href="#specialty-fulltime-<?php echo $specialty["id"];?>"><?php echo explode("@", $specialty["fullname"])[0] . (!empty(explode("@", $specialty["fullname"])[0]) ? " <i>" . explode("@", $specialty["fullname"])[1] . "</i>" : ""); ?></a>
                        <?php } ?>
                        <br>
                        <?php $specialties = $this -> database -> query("SELECT `fullname`, `budget`, `contract`, `id` FROM `enr_specialties` WHERE `forExtramural` = 1;");
                        while ($specialty = $specialties -> fetch_assoc()) { ?>
                            <a class="list-group-item list-group-item-action list-group-item-action" href="#specialty-extramural-<?php echo $specialty["id"];?>"><?php echo explode("@", $specialty["fullname"])[0] . (!empty(explode("@", $specialty["fullname"])[0]) ? " <i>" . explode("@", $specialty["fullname"])[1] . "</i>" : ""); ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-9">
                    <h2>Очное отделение</h2>
                    <p><sub>Данные актуальны на <?php echo Date("d.m.Y H:i:s") . " GTM+5"; ?></sub></p>
                    <ul class="list-group">
                        <?php $specialties = $this -> database -> query("SELECT `fullname`, `budget`, `contract`, `id` FROM `enr_specialties` WHERE `forExtramural` = 0;");
                        while ($specialty = $specialties -> fetch_assoc()) { ?>
                            <li class="list-group-item">
                                <h4 id="specialty-fulltime-<?php echo $specialty["id"];?>"><?php echo explode("@", $specialty["fullname"])[0] . (!empty(explode("@", $specialty["fullname"])[0]) ? " <i>" . explode("@", $specialty["fullname"])[1] . "</i>" : ""); ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Поданных документов:</td>
                                                <td><b><?php echo $this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1;") -> fetch_assoc()["cnt"];?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Из них с оригиналами документов об образовании:</td>
                                                <td><b><?php echo $this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1;") -> fetch_assoc()["cnt"];?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Средний балл по всем абитуриентам:</td>
                                                <td><b><?php echo round($this -> database -> query("SELECT AVG(`averageMark`) AS `avg` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1;") -> fetch_assoc()["avg"], 2);?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Средний балл абитуриентов с оригиналами документов об образовании:</td>
                                                <td><b><?php echo round($this -> database -> query("SELECT AVG(`averageMark`) AS `avg` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1;") -> fetch_assoc()["avg"], 2);?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Средний балл у последнего места, попадающего на бюджет:</td>
                                                <?php
                                                    $averageMark = 0.0;
                                                    $allMarks = $this -> database -> query("SELECT `averageMark` FROM `enr_statements` WHERE `averageMark` IS NOT NULL AND `specialty` = {$specialty["id"]} ORDER BY `averageMark` DESC;");
                                                    $cnt_pointer = 1;
                                                    if ($allMarks -> num_rows != 0)
                                                        while ($pointer = $allMarks -> fetch_assoc()) {
                                                            if ($specialty["budget"] == strval($cnt_pointer))
                                                                $averageMark = $pointer["averageMark"];
                                                            $cnt_pointer++;
                                                        }
                                                    if ($cnt_pointer < intval($specialty["budget"]))
                                                        $averageMark = $this -> database -> query("SELECT `averageMark` FROM `enr_statements` WHERE `averageMark` IS NOT NULL AND `specialty` = {$specialty["id"]} ORDER BY `averageMark` ASC LIMIT 1;") -> fetch_assoc()["averageMark"];
                                                ?>
                                                <td><b><?php echo $averageMark; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Средний балл у первого места, попадающего на бюджет:</td>
                                                <td><b><?php echo $this -> database -> query("SELECT `averageMark` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 ORDER BY `averageMark` DESC LIMIT 1;") -> fetch_assoc()["averageMark"]; ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li> 
                        <?php } ?>
                    </ul>
                    <h2 style="margin-top: 15px;">Заочное отделение</h2>
                    <p><sub>Данные актуальны на <?php echo Date("d.m.Y H:i:s") . " GTM+5"; ?></sub></p>
                    <ul class="list-group" style="margin-bottom: 15px;">
                        <?php $specialties = $this -> database -> query("SELECT `fullname`, `budget`, `contract`, `id` FROM `enr_specialties` WHERE `forExtramural` = 1;");
                        while ($specialty = $specialties -> fetch_assoc()) { ?>
                            <li class="list-group-item">
                                <h4 id="specialty-extramural-<?php echo $specialty["id"];?>"><?php echo explode("@", $specialty["fullname"])[0] . (!empty(explode("@", $specialty["fullname"])[0]) ? " <i>" . explode("@", $specialty["fullname"])[1] . "</i>" : ""); ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Поданных документов:</td>
                                                <td><b><?php echo $this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1;") -> fetch_assoc()["cnt"];?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Из них с оригиналами документов об образовании:</td>
                                                <td><b><?php echo $this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1;") -> fetch_assoc()["cnt"];?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Средний балл по всем абитуриентам:</td>
                                                <td><b><?php echo round($this -> database -> query("SELECT AVG(`averageMark`) AS `avg` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1;") -> fetch_assoc()["avg"], 2);?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Средний балл абитуриентов с оригиналами документов об образовании:</td>
                                                <td><b><?php echo round($this -> database -> query("SELECT AVG(`averageMark`) AS `avg` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1;") -> fetch_assoc()["avg"], 2);?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li> 
                        <?php } ?>
                    </ul>
                </div>
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
