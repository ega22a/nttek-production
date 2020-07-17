<header style="background-image: url('/global-assets/img/background-0.jpg');min-height: 100vh;background-size: cover;background-repeat: no-repeat;">
        <div style="background-color: rgba(0, 0, 0, 0.5);width: 100vw;padding-top: 35vh;min-height: 100vh;">
            <div>
                <div class="container text-light">
                    <div>
                        <h1 class="text-center display-3">Ассистент</h1>
                        <p class="text-center" style="max-width: 350px;margin: 0 auto; font-size: 20px;">Единая информационная система для студентов, сотрудников и абитуриентов образовательного учреждения.&nbsp;</p>
                        <?php if (!is_object($this -> user)) { ?>
                        <div style="max-width: 250px;margin: 0 auto; font-size: 20px; padding-top: 25px;">
                            <a class="btn btn-primary" style="width: 100%;" href="/login" type="button">Войти</a>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="buttons"></div>
                </div>
            </div>
        </div>
    </header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="/global-assets/js/dropdown-bootstrap.js"></script>
    <style type="text/css">
        #button-login {
            display: none;
        }
    </style>
</body>

</html>