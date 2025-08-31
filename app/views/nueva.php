<?php include __DIR__ . '/layout/header.php'; ?>

<!-- Breadcrumb Section Start -->
<div class="section">
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">ROPA NUEVA</h1>
                <ul>
                    <li>
                        <a href="index.php">Inicio </a>
                    </li>
                    <li class="active"> Ropa nueva</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->
</div>
<!-- Breadcrumb Section End -->
<!-- Shop Section Start -->
<div class="section section-margin">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9 col-12 col-custom">

                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper flex-column flex-md-row mb-10">

                    <!-- Shop Top Bar Left start -->
                    <div class="shop-top-bar-left mb-md-0 mb-2">
                        <div class="shop-top-show">
                            <span>Mostrando 1–<?= $total ?> de <?= $total ?> resultados</span>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <div class="shop-short-by mr-4">
                            <select class="nice-select" aria-label=".form-select-sm example">
                                <option selected>Ordenado por</option>
                                <option value="1">Más barato</option>
                                <option value="2">Más Nuevo</option>
                            </select>
                        </div>
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i class="fa fa-th"></i></button>
                            <button data-role="grid_list" type="button" class="btn-list" title="List"><i class="fa fa-th-list"></i></button>
                        </div>
                    </div>
                    <!-- Shopt Top Bar Right End -->
                </div>
                <!--shop toolbar end-->

                <!-- Shop Wrapper Start -->
                <div class="row shop_wrapper grid_3">
                    <?php foreach ($garments as $garment): ?>
                    <!-- Single Product Start -->
                    <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-inner">
                            <div class="thumb">
                                <a href="#" class="image" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>">
                                    <img class="first-image" src="<?= htmlspecialchars($garment['image_primary']); ?>" alt="Product" />
                                    <img class="second-image" src="<?= htmlspecialchars(!empty($garment['image_secondary']) ? $garment['image_secondary'] : $garment['image_primary']); ?>" alt="Product" />
                                </a>
                                <?php if (!empty($garment['tag_text'])): ?>
                                <span class="badges">
                                    <span class="<?= htmlspecialchars($garment['tag_color']); ?>" style="background-color:<?= htmlspecialchars($garment['tag_bg_color']); ?>;color:<?= htmlspecialchars($garment['tag_text_color']); ?>;">
                                        <?= htmlspecialchars($garment['tag_text']); ?>
                                    </span>
                                </span>
                                <?php endif; ?>
                                <div class="actions">
                                    <a href="#" title="Quickview" class="action quickview" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><i class="pe-7s-search"></i></a>
                                </div>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="#" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><?= htmlspecialchars($garment['name']); ?></a></h5>
                                
                                
                                 <!-- SKU Start -->
                            <?php if (!empty($garment['unique_code'])): ?>
                            <div class="sku mb-3">
                                <span>Código único: <?= htmlspecialchars($garment['unique_code']); ?></span>
                            </div>
                            <?php endif; ?>
                            <!-- SKU End -->

                                
                                
                                <span class="ratings">
                                    <span class="rating-wrap">
                                        <span class="star" style="width: <?= (int)$garment['condition']; ?>%"></span>
                                    </span>
                                    <span class="rating-num">(<?= round($garment['condition'] / 20); ?>)</span>
                                </span>
                                <?php if (!empty($garment['comment'])): ?>
                                <p><?= htmlspecialchars($garment['comment']); ?></p>
                                <?php endif; ?>
                                <span class="price">
                                    <span class="new">$<?= number_format((float)$garment['sale_value'], 2); ?></span>
                                </span>
                                <div class="shop-list-btn">
                                    <a href="https://wa.me/593989818620" class="btn btn-sm btn-outline-dark btn-hover-primary">Preguntar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Product End -->
                    <?php endforeach; ?>
                </div>
                <!-- Shop Wrapper End -->

                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper mt-10">

                    <!-- Shop Top Bar Left start -->
                    <div class="shop-top-bar-left">
                        <div class="shop-short-by mr-4">
                            <select class="nice-select rounded-0" aria-label=".form-select-sm example">
                                <option selected>Show 12 Per Page</option>
                                <option value="1">Show 12 Per Page</option>
                                <option value="2">Show 24 Per Page</option>
                                <option value="3">Show 15 Per Page</option>
                                <option value="3">Show 30 Per Page</option>
                            </select>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Shopt Top Bar Right End -->

                </div>
                <!--shop toolbar end-->

            </div>
            <div class="col-lg-3 col-12 col-custom">
                <!-- Sidebar Widget Start -->
                <aside class="sidebar_widget mt-10 mt-lg-0">
                    <div class="widget_inner" data-aos="fade-up" data-aos-delay="200">

                        <div class="widget-list mb-10">
                            <h3 class="widget-title">Categorias</h3>
                            <div class="sidebar-body">
                                <ul class="sidebar-list">
                                    <li><a href="nueva.php"<?= $categoryId === null ? ' class="active"' : '' ?>>Todas</a></li>
                                    <?php foreach ($categories as $cat): ?>
                                    <li><a href="nueva.php?category=<?= $cat['id']; ?>"<?= $categoryId === (int)$cat['id'] ? ' class="active"' : '' ?>><?= htmlspecialchars($cat['name']); ?> (<?= $cat['usage_count']; ?>)</a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- Sidebar Widget End -->
            </div>
        </div>
    </div>
</div>
<!-- Shop Section End -->

<?php foreach ($garments as $garment): ?>
    <!-- Modal Start  -->
    <div class="modalquickview modal fade" id="quickview-<?= $garment['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button class="btn close" data-bs-dismiss="modal">×</button>
                <div class="row">
                    <div class="col-md-6 col-12">

                        <!-- Product Details Image Start -->
                        <div class="modal-product-carousel">

                            <!-- Single Product Image Start -->
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <a class="swiper-slide" href="#">
                                        <img class="w-100" src="<?= htmlspecialchars($garment['image_primary']); ?>" alt="Product">
                                    </a>
                                    <?php if (!empty($garment['image_secondary'])): ?>
                                    <a class="swiper-slide" href="#">
                                        <img class="w-100" src="<?= htmlspecialchars($garment['image_secondary']); ?>" alt="Product">
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <!-- Next Previous Button Start -->
                                <div class="swiper-product-button-next swiper-button-next"><i class="pe-7s-angle-right"></i></div>
                                <div class="swiper-product-button-prev swiper-button-prev"><i class="pe-7s-angle-left"></i></div>
                                <!-- Next Previous Button End -->
                            </div>
                            <!-- Single Product Image End -->

                        </div>
                        <!-- Product Details Image End -->

                    </div>
                    <div class="col-md-6 col-12 overflow-hidden position-relative">

                        <!-- Product Summery Start -->
                        <div class="product-summery">

                            <!-- Product Head Start -->
                            <div class="product-head mb-3">
                                <h2 class="product-title"><?= htmlspecialchars($garment['name']); ?></h2>
                            </div>
                            <!-- Product Head End -->

                            <!-- Price Box Start -->
                            <div class="price-box mb-2">
                                <span class="regular-price">$<?= number_format((float)$garment['sale_value'], 2); ?></span>
                            </div>
                            <!-- Price Box End -->

                            <!-- SKU Start -->
                            <?php if (!empty($garment['unique_code'])): ?>
                            <div class="sku mb-3">
                                <span>Código único: <?= htmlspecialchars($garment['unique_code']); ?></span>
                            </div>
                            <?php endif; ?>
                            <!-- SKU End -->

                            <!-- Description Start -->
                            <?php if (!empty($garment['comment'])): ?>
                            <p class="desc-content mb-5"><?= htmlspecialchars($garment['comment']); ?></p>
                            <?php endif; ?>
                            <!-- Description End -->

                            <!-- Product Meta Start -->
                            <?php if (!empty($garment['size'])): ?>
                            <div class="product-meta mb-3">
                                <!-- Product Size Start -->
                                <div class="product-size">
                                    <span>Talla :</span>
                                    <span><strong><?= htmlspecialchars($garment['size']); ?></strong></span>
                                </div>
                                <!-- Product Size End -->
                            </div>
                            <?php endif; ?>
                            <!-- Product Meta End -->


                            <!-- Cart & Wishlist Button Start -->
                            <div class="cart-wishlist-btn pb-4 mb-n3">
                                <div class="add-to_cart mb-3">
                                    <a class="btn btn-outline-dark btn-hover-primary" href="https://wa.me/593989818620">Preguntar</a>
                                </div>
                            </div>
                            <!-- Cart & Wishlist Button End -->



                        </div>
                        <!-- Product Summery End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End  -->
<?php endforeach; ?>

<?php include __DIR__ . '/layout/footer.php'; ?>
