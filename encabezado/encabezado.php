<?php 
include 'inicio.php';
?>


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
                                <span>Pedidos al: </span><a href="tel:+593989818620"> +593 9898 18 620</a>
                            </div>
                        </div>
                    </div>
                    <!-- Header Top Language, Currency & Link End -->

                    <!-- Header Top Message Start -->
                    <div class="col">
                        <p class="header-top-message"><b>Prendas en oferta : </b> tenemos prendas en oferta con hasta el 50% de descuento. <a href="shop-grid.html">Ver Ofertas</a></p>
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
                                <a href="index.php"><img src="assets/images/logo/logo.png" alt="Site Logo" /></a>
                            </div>
                        </div>
                        <!-- Header Logo End -->

                        <!-- Header Menu Start -->
                        <div class="col-xl-8 d-none d-xl-block">
                            <div class="main-menu position-relative">
                                <ul>
                                    <?php include 'menu.php'; ?>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Menu End -->
 <!-- Header Action Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-actions">

                                <!-- Search Header Action Button Start 
                                <a href="javascript:void(0)" class="header-action-btn header-action-btn-search"><i class="pe-7s-search"></i></a>
                                -->
                                <!-- Search Header Action Button End -->

                                <!-- User Account Header Action Button Start 
                                <a href="login-register.html" class="header-action-btn d-none d-md-block"><i class="pe-7s-user"></i></a>
                                -->
                                <!-- User Account Header Action Button End -->

                                <!-- Wishlist Header Action Button Start 
                                <a href="wishlist.html" class="header-action-btn header-action-btn-wishlist d-none d-md-block">
                                    <i class="pe-7s-like"></i>
                                </a>
                                -->
                                <!-- Wishlist Header Action Button End -->

                                <!-- Shopping Cart Header Action Button Start 
                                <a href="javascript:void(0)" class="header-action-btn header-action-btn-cart">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num">3</span>
                                </a>
                                -->
                                <!-- Shopping Cart Header Action Button End -->

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
                            <?php include 'menu.php'; ?>
                        </ul>
                    </nav>
                </div>
              

                <!-- Contact Links/Social Links Start -->
                <div class="mt-auto">

                    <!-- Contact Links Start -->
                    <ul class="contact-links">
                        <li><i class="fa fa-phone"></i><a href="whatsapp://send?phone=593989818620"> +593 989 818 620</a></li>
                        <!-- Contact Links Start
                        <li><i class="fa fa-envelope-o"></i><a href="#"> info@example.com</a></li>
                        -->
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