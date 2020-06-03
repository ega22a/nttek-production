<?php $data = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json")) -> school -> enrollment; ?>
<header style="min-height: 100vh;">
        <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
            <div class="container" style="margin-bottom: 15px;">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h2>Общая информация</h2>
                        <p>Бюджетных мест для целевого приема не предусмотрено. Для иногородних студентов есть общежитие. Заключение договоров НА ОКАЗАНИЕ ПЛАТНЫХ ОБРАЗОВАТЕЛЬНЫХ УСЛУГ В СФЕРЕ ПРОФЕССИОНАЛЬНОГО ОБРАЗОВАНИЯ осуществляется после издания приказа о зачислении на обучение на бюджетной основе.</p>
                        <p><strong>Хотите подать документы онлайн?</strong> Вы можете <a href="https://assistant.nttek.ru/modules/enrollment/submit?type=fulltime">нажать здесь для подачи документов на очную форму обучения</a> или же <a href="https://assistant.nttek.ru/modules/enrollment/submit?type=extramural">здесь, если хотите подать документы на заочную форму обучения</a>.</p>
                        <div class="row">
                            <div class="col-lg-5">
                                <ul class="list-group" style="margin-bottom: 15px;">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <span><strong>Адрес</strong></span>
                                            </div>
                                            <div class="col-sm-9">
                                                <span><?php echo $data -> address -> main . $data -> address -> ext; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-3"><span><strong>Режим работы</strong><br></span></div>
                                            <div class="col-sm-9">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>День недели</th>
                                                                <th>Время работы</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Понедельник</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> monday) ? "С {$data -> indexPage -> schedule -> monday[0]} до {$data -> indexPage -> schedule -> monday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Вторник</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> tuesday) ? "С {$data -> indexPage -> schedule -> tuesday[0]} до {$data -> indexPage -> schedule -> tuesday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Среда</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> wednesday) ? "С {$data -> indexPage -> schedule -> wednesday[0]} до {$data -> indexPage -> schedule -> wednesday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Четверг</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> thursday) ? "С {$data -> indexPage -> schedule -> thursday[0]} до {$data -> indexPage -> schedule -> thursday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Пятница</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> friday) ? "С {$data -> indexPage -> schedule -> friday[0]} до {$data -> indexPage -> schedule -> friday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Суббота</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> saturday) ? "С {$data -> indexPage -> schedule -> saturday[0]} до {$data -> indexPage -> schedule -> saturday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Воскресенье</td>
                                                                <td><?php echo !empty($data -> indexPage -> schedule -> sunday) ? "С {$data -> indexPage -> schedule -> sunday[0]} до {$data -> indexPage -> schedule -> sunday[1]}" : "Выходной"; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-7">
                                <iframe allowfullscreen="" frameborder="0" src="https://www.google.com/maps/embed/v1/place?key=<?php echo GOOGLE_API_KEY; ?>&amp;q=<?php echo $data -> address -> main; ?>&amp;zoom=16" width="100%" height="400" style="border-radius: 5px;"></iframe>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h2>Документы</h2>
                        <p>Хотите лучше понять, как происходит процесс приема? Советуем ознакомиться с нижеприведенными документами, чтобы понять практически все. Если же останутся вопросы, можете <a href="tel:<?php echo $data -> telephone; ?>">позвонить нам</a> или <a href="mailto:<?php echo $data -> email; ?>">написать на электронную почту</a>.</p>
                        <div class="list-group">
                            <?php foreach ($data -> indexPage -> docsList as $value) { ?>
                                <a class="list-group-item list-group-item-action d-flex align-items-center" href="<?php echo $value -> href; ?>" <?php echo $value -> isTarget ? "target=\"_blank\"" : ""; ?>>
                                    <i class="far fa-file-pdf" style="font-size: 25px;color: #fb4443;margin-right: 10px;"></i><span><?php echo $value -> name; ?></span>
                                </a>
                            <?php } ?>
                        </div>
                        <style type="text/css">
                            .list-group-item.list-group-item-action.d-flex.align-items-center {
                                cursor: pointer;
                            }
                        </style>
                    </li>
                    <li class="list-group-item">
                        <h2>Контакты</h2>
                        <p>Остались вопросы? Если хотите лично поговорить, то можете позвонить на нижеприведенные телефоны ил написать на электронные адреса. Мы рады вам ответить.</p>
                        <div class="card-columns">
                            <?php foreach ($data -> indexPage -> contacts as $value) { ?>
                                <div class="card">
                                    <div class="card-body">
                                        <i class="<?php echo $value -> faIcon; ?> d-flex justify-content-center" style="font-size: 100px;margin-bottom: 5px;"></i>
                                        <h4 class="text-center card-title"><?php echo $value -> name; ?></h4>
                                        <?php echo !empty($value -> subName) ? "<p class=\"text-center\">{$value -> subName}</p>" : ""; ?>
                                        <?php foreach ($value -> telephones as $telephone) { ?>
                                            <div class="row" style="margin: 5px 0;">
                                                <div class="col-2"><i class="fas fa-phone" style="font-size: 20px;"></i></div>
                                                <div class="col-10"><a href="#<?php echo $telephone; ?>"><?php echo $telephone; ?></a></div>
                                            </div>
                                        <?php } ?>
                                        <?php foreach ($value -> emails as $email) { ?>
                                            <div class="row" style="margin: 5px 0;">
                                                <div class="col-2"><i class="fas fa-envelope" style="font-size: 20px;"></i></div>
                                                <div class="col-10"><a href="#<?php echo $email; ?>"><?php echo $email; ?></a></div>
                                            </div>
                                        <?php }
                                        if (!empty($value -> social)) {
                                            if (!empty($value -> social -> vk)) { ?>
                                                <div class="row" style="margin: 5px 0;">
                                                    <div class="col-2"><i class="fab fa-vk" style="font-size: 20px;"></i></div>
                                                    <div class="col-10"><a href="https://vk.com/<?php echo $value -> social -> vk; ?>"><?php echo $value -> social -> vk; ?></a></div>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
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