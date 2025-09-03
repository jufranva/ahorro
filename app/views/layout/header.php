<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: text/html; charset=UTF-8');
$menu = (function () {
    ob_start();
    include __DIR__ . '/menu.php';
    return ob_get_clean();
})();
echo "<!DOCTYPE html>\n";
?>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>El armario del ahorro</title>
    
    <link rel="icon" href="./assets/favicon.ico">
    <link rel="preload" href="./assets/fonts/fontAwesome/fontawesome-webfont.woff2" as="font" type="font/woff2" crossorigin>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/vendor/fontawesome.min.css">
    <link rel="stylesheet" href="./assets/css/vendor/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="./assets/css/plugins/swiper-bundle.min.css" />
    <link rel="stylesheet" href="./assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" href="./assets/css/plugins/aos.min.css" />
    <link rel="stylesheet" href="./assets/css/plugins/nice-select.min.css" />
    <link rel="stylesheet" href="./assets/css/plugins/jquery-ui.min.css" />
    <link rel="stylesheet" href="./assets/css/plugins/lightgallery.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
</head>


<body>
    <div class="header section">

        <!-- Header Top Start -->
        <div class="header-top bg-light">
            <div class="container">
                <div class="row row-cols-xl-2 align-items-center">

                    <!-- Header Top Language, Currency & Link Start -->
                    <div class="col d-none d-lg-block">
                        <div class="header-top-lan-curr-link">
                            <div class="header-top-links">
                                <span>Pedidos al: </span><a href="https://wa.me/593999591820"> (+593) 99 959 1820</a>
                            </div>
                        </div>
                    </div>
                    <!-- Header Top Language, Currency & Link End -->

                    <!-- Header Top Message Start -->
                    <div class="col">
                        <p class="header-top-message"><b>Productos en oferta: </b>. Revise nuestra lista de productos de 2da mano <a href="./usada.php?perPage=9&sort=new">Ver productos</a></p>
                    </div>
                    <!-- Header Top Message End -->

                </div>
            </div>
        </div>
        <!-- Header Top End -->

        <!-- Header Bottom Start -->
        <div class="header-bottom">
            <div class="header-sticky">
                <div class="container">
                    <div class="row align-items-center">

                        <!-- Header Logo Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-logo">
                                <a href="./index.php"><img src="./assets/images/logo/logo.png" alt="Site Logo" /></a>
                            </div>
                        </div>
                        <!-- Header Logo End -->

                        <!-- Header Menu Start -->
                        <div class="col-xl-8 d-none d-xl-block">
                            <div class="main-menu position-relative">
                                <ul>
                                    <?= $menu ?>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Menu End -->
 <!-- Header Action Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-actions">

                                <!-- Mobile Menu Hambarger Action Button Start -->
                                <a href="javascript:void(0)" class="header-action-btn header-action-btn-menu d-xl-none d-lg-block">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <!-- Mobile Menu Hambarger Action Button End -->

                            </div>
                        </div>
                        <!-- Header Action End -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Header Bottom End -->

        <!-- Mobile Menu Start -->
        <div class="mobile-menu-wrapper">
            <div class="offcanvas-overlay"></div>

            <!-- Mobile Menu Inner Start -->
            <div class="mobile-menu-inner">

                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Mobile Menu Start -->
                <div class="mobile-navigation">
                    <nav>
                        <ul class="mobile-menu">
                        <?= $menu ?>
                        </ul>
                    </nav>
                </div>
              

                <!-- Contact Links/Social Links Start -->
                <div class="mt-auto">

                    <!-- Contact Links Start -->
                    <ul class="contact-links">
                        <li><i class="fa fa-phone"></i><a href="whatsapp://send?phone=593989818620"> +593 989 818 620</a></li>
                        <li><i class="fa fa-calendar"></i> <span>Lunes - Viernes 17:00 - 20:00</span> </li>
                        <li><i class="fa fa-calendar"></i> <span>Sábados - Domingos 09:00 - 20:00</span> </li>
                    </ul>
                    <!-- Contact Links End -->

                    <!-- Social Widget Start -->
                    <div class="widget-social">
                        <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                        <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                        <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                        <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                        <a title="Vimeo" href="#"><i class="fa fa-vimeo"></i></a>
                    </div>
                    <!-- Social Widget Ende -->
                </div>
                <!-- Contact Links/Social Links End -->
            </div>
            <!-- Mobile Menu Inner End -->
        </div>
        <!-- Mobile Menu End -->
    </div>
