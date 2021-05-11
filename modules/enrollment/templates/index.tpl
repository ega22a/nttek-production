<?php $data = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json")) -> school -> enrollment; ?>
<header style="min-height: 100vh;">
        <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
            <div class="container" style="margin-bottom: 15px;">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h2>Общая информация</h2>
                        <p>Для целевого обучения бюджетных мест не предусмотрено.</p>
                        <p>Для иногородних студентов есть общежитие. <b>Заполнение Заявления на предоставление места в общежитии не является гарантией предоставления места в общежитии!</b></p>
                        <?php if (is_object($this -> user)) {
                            $about = $this -> user -> getDecrypted();
                            if (in_array(1003, $about -> levels)) { ?>
                                <p><strong>Не знаете как попасть в личный кабинет абитуриента?</strong> В верхнем меню нажмите на пункт "Приемная комиссия", и там будет кнопка "Личный кабинет абитуриента".</p>
                            <?php } else { ?>
                                <p><strong>Хотите подать документы онлайн?</strong> Вы можете <a href="https://assistant.nttek.ru/modules/enrollment/submit?type=fulltime">нажать здесь для подачи документов на очную форму обучения</a> или же <a href="https://assistant.nttek.ru/modules/enrollment/submit?type=extramural">здесь, если хотите подать документы на заочную форму обучения</a>.</p>
                            <?php }
                        } ?>
                        <p><a href="operational-summary">Оперативная сводка на <?php echo Date("d.m.Y"); ?></a>.</p>
                        <div role="tablist" id="accordion-info" class="accordion">
                            <div class="card">
                                <div role="tab" class="card-header">
                                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-info .item-1" href="#accordion-info .item-1">Контрольные цифры приёма на 2021 - 2022 учебный год</a></h5>
                                </div>
                                <div role="tabpanel" data-parent="#accordion-info" class="collapse item-1">
                                    <div class="card-body">
                                        <div class="table-responsive table-bordered">
                                            <table class="table table-bordered table-sm text-center" style="margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">Код специальности</th>
                                                        <th class="align-middle">Специальность</th>
                                                        <th class="align-middle">Уровень СПО</th>
                                                        <th class="align-middle">Источник финансирования</th>
                                                        <th class="align-middle">Срок обучения</th>
                                                        <th class="align-middle">План приёма</th>
                                                        <th class="align-middle">Квалификация</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th colspan="9" class="align-middle">ОЧНОЕ ОТДЕЛЕНИЕ</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="9" class="align-middle">База 9 классов</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">40.02.01</td>
                                                        <td class="align-middle">Право и организация социального обеспечения</td>
                                                        <td class="align-middle">Углубленная подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">3 года 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Юрист</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">09.02.07</td>
                                                        <td class="align-middle">Информационные системы и программирование</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">3 года 10 мес.</td>
                                                        <td class="align-middle">50</td>
                                                        <td class="align-middle">Специалист по информационным системам</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.06</td>
                                                        <td class="align-middle">Финансы</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">2 года 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Финансист</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.04</td>
                                                        <td class="align-middle">Коммерция (по отраслям)</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">2 года 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Менеджер по продажам</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.01</td>
                                                        <td class="align-middle">Экономика и бухгалтерский учет (по отраслям)</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">2 года 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Бухгалтер</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">42.02.01</td>
                                                        <td class="align-middle">Реклама</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">3 года 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Специалист по рекламе</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">43.02.15</td>
                                                        <td class="align-middle">Поварское и кондитерское дело</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">3 года 10 мес.</td>
                                                        <td class="align-middle">50</td>
                                                        <td class="align-middle">Специалист поварского и кондитерского дела</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">43.02.14</td>
                                                        <td class="align-middle">Гостиничное дело</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">3 года 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Специалист по гостеприимству</td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="9" class="align-middle">База 11 классов</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.04</td>
                                                        <td class="align-middle">Коммерция (по отраслям)</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">1 год 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Менеджер по продажам</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">40.02.01</td>
                                                        <td class="align-middle">Право и организация социального обеспечения</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">1 год 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Юрист</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.01</td>
                                                        <td class="align-middle">Экономика и бухгалтерский учет (по отраслям)</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">1 год 10 мес.</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">Бухгалтер</td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="9" class="align-middle">ЗАОЧНОЕ ОТДЕЛЕНИЕ (база 11 классов)</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.04</td>
                                                        <td class="align-middle">Коммерция (по отраслям)</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">2 год 10 мес.</td>
                                                        <td class="align-middle">15</td>
                                                        <td class="align-middle">Менеджер по продажам</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">43.02.15</td>
                                                        <td class="align-middle">Поварское и кондитерское дело</td>
                                                        <td class="align-middle">Базовая подготовка</td>
                                                        <td class="align-middle">бюджет</td>
                                                        <td class="align-middle">2 года 10 мес.</td>
                                                        <td class="align-middle">15</td>
                                                        <td class="align-middle">Специалист поварского и кондитерского дела</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div role="tab" class="card-header">
                                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-info .item-2" href="#accordion-info .item-2">О результатах приёма в ГАПОУ СО &quot;НТТЭК&quot; в 2020 году</a></h5>
                                </div>
                                <div role="tabpanel" data-parent="#accordion-info" class="collapse item-2">
                                    <div class="card-body">
                                        <div class="table-responsive table-bordered">
                                            <table class="table table-bordered table-sm text-center" style="margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">Код специальности</th>
                                                        <th class="align-middle">Специальность</th>
                                                        <th class="align-middle">Кол-во мест, финансируемых за счет бюджетов РФ</th>
                                                        <th class="align-middle">Средний балл</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th colspan="9" class="align-middle">База 9 классов</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">40.02.01</td>
                                                        <td class="align-middle">Право и организация социального обеспечения</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">4,37</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.03</td>
                                                        <td class="align-middle">Операционная деятельность в логистике</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,95</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">42.02.01</td>
                                                        <td class="align-middle">Реклама</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,42</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.01</td>
                                                        <td class="align-middle">Экономика и бухгалтерский учет (по отраслям)</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">4,22</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.06</td>
                                                        <td class="align-middle">Финансы</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">4,29</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">09.02.07</td>
                                                        <td class="align-middle">Информационные системы и программирование</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">4,04</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">43.02.15</td>
                                                        <td class="align-middle">Поварское и кондитерское дело</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,81</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">19.02.10</td>
                                                        <td class="align-middle">Технология продукции общественного питания</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,87</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">43.02.14</td>
                                                        <td class="align-middle">Гостиничное дело</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,63</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">43.02.01</td>
                                                        <td class="align-middle">Организация обслуживания в общественном питании</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,61</td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="9" class="align-middle">База 11 классов</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">38.02.04</td>
                                                        <td class="align-middle">Коммерция (по отраслям)</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,61</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">40.02.01</td>
                                                        <td class="align-middle">Право и организация социального обеспечения</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">4,16</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">19.02.10</td>
                                                        <td class="align-middle">Технология продукции общественного питания</td>
                                                        <td class="align-middle">25</td>
                                                        <td class="align-middle">3,45</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h3>Запись на личный прием в Приемную комиссию</h3>
                        <p><strong>Обязательно</strong> укажите Ваш адрес электронной почты!</p>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Bookform widget --><script>(function (w,d,s,o,f,js,fjs){w['BookformObject']=o;w[o]=w[o]||function(){(w[o].q=w[o].q||[]).push(arguments)};js=d.createElement(s),fjs=d.getElementsByTagName(s)[0];js.id=o;js.src=f;js.async=1;fjs.parentNode.insertBefore(js,fjs);}(window,document,'script','Bookform','https://widget.bookform.ru/31171/js'));</script><!-- End Bookform widget -->
                                <div id="bookform-embedded-widget-31171"></div><script>Bookform('embedded',{id:31171});</script>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h3>Адрес и время работы</h3>
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
                        <ul class="list-group">
                            <?php foreach ($data -> indexPage -> contacts as $value) { ?>
                                <li class="list-group-item">
                                    <div class="media">
                                        <div class="media-body">
                                            <?php echo !empty($value -> name) ? "<h5 class=\"mt-0\">{$value -> name}</h5>" : ""; ?>
                                            <?php echo !empty($value -> subName) ? "<p>{$value -> subName}</p>" : ""; ?>
                                            <?php foreach ($value -> telephones as $telephone) { ?>
                                                <div class="row" style="margin: 5px 0;">
                                                    <div class="col-1"><i class="fas fa-phone" style="font-size: 20px;"></i></div>
                                                    <div class="col-11"><a href="tel:<?php echo $telephone; ?>"><?php echo $telephone; ?></a></div>
                                                </div>
                                            <?php } ?>
                                            <?php foreach ($value -> emails as $email) { ?>
                                                <div class="row" style="margin: 5px 0;">
                                                    <div class="col-1"><i class="fas fa-envelope" style="font-size: 20px;"></i></div>
                                                    <div class="col-11"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
                                                </div>
                                            <?php }
                                            if (!empty($value -> social)) {
                                                if (!empty($value -> social -> vk)) { ?>
                                                    <div class="row" style="margin: 5px 0;">
                                                        <div class="col-1"><i class="fab fa-vk" style="font-size: 20px;"></i></div>
                                                        <div class="col-11"><a href="https://vk.com/<?php echo $value -> social -> vk; ?>"><?php echo $value -> social -> vk; ?></a></div>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
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
