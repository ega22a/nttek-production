<?php $forms = $this -> database -> query("SELECT * FROM `frm_forms`;"); ?>
<header style="min-height: 100vh;background-size: cover;background-repeat: no-repeat;">
    <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
        <div class="container">
            <div class="row col-md-12" style="margin: 0 auto;">
                <div class="col-md-3">
                    <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical">
                        <?php if ($forms -> num_rows != 0) {
                            $counter = 0;
                            while ($form = $forms -> fetch_assoc()) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $counter == 0 ? "active" : ""; ?>" id="v-pills-<?php echo $form["id"]; ?>-tab" href="#v-pills-<?php echo $form["id"]; ?>" data-toggle="pill" role="tab" aria-controls="v-pills-<?php echo $form["id"]; ?>" aria-selected="true"><?php echo $form["name"]; ?></a>
                                </li>
                                <?php $counter++;
                            }
                        }?>
                    </ul>
                </div>
                <div class="border rounded col-md-9 tab-content" style="padding: 15px; margin-bottom: 15px;">
                    
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
<script src="../assets/js/admin/archive.js?<?php echo time(); ?>"></script>
</body>
</html>