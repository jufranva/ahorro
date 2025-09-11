<?php include __DIR__ . '/layout/header.php'; ?>

<!-- Breadcrumb Section Start -->
<div class="section">
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">PRODUCTOS NUEVOS</h1>
                <ul>
                    <li>
                        <a href="index.php">Inicio </a>
                    </li>
                    <li class="active"> PRODUCTOS NUEVOS</li>
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
                    <?php
                    $start = $total > 0 ? ($perPage * ($page - 1)) + 1 : 0;
                    $end = min($start + $perPage - 1, $total);
                    ?>
                    <div class="shop-top-bar-left mb-md-0 mb-2">
                        <div class="shop-top-show">
                            <span>Mostrando <?= $start ?>–<?= $end ?> de <?= $total ?> resultados</span>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <div class="shop-short-by mr-4">
                            <form method="get">
                                <?php if ($categoryId !== null): ?>
                                    <input type="hidden" name="category" value="<?= $categoryId; ?>">
                                <?php endif; ?>
                                <input type="hidden" name="perPage" value="<?= $perPage; ?>">
                                <select name="sort" class="nice-select" aria-label=".form-select-sm example" onchange="this.form.submit()">
                                    <option value=""<?= $sort === null ? ' selected' : '' ?>>Ordenado por</option>
                                    <option value="price"<?= $sort === 'price' ? ' selected' : '' ?>>Más barato</option>
                                    <option value="new"<?= $sort === 'new' ? ' selected' : '' ?>>Más Nuevo</option>
                                </select>
                            </form>
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
                                     <img class="first-image" src="<?= htmlspecialchars(asset($garment['image_primary']), ENT_QUOTES, 'UTF-8'); ?>" alt="Product" />
                                    <img class="second-image" src="<?= htmlspecialchars(asset(!empty($garment['image_secondary']) ? $garment['image_secondary'] : $garment['image_primary']), ENT_QUOTES, 'UTF-8'); ?>" alt="Product" />
                                </a>
                                <?php if (!empty($garment['tag_text'])): ?>
                                <span class="badges">
                                    <span class="<?= htmlspecialchars($garment['tag_color'], ENT_QUOTES, 'UTF-8'); ?>" style="background-color:<?= htmlspecialchars($garment['tag_bg_color'], ENT_QUOTES, 'UTF-8'); ?>;color:<?= htmlspecialchars($garment['tag_text_color'], ENT_QUOTES, 'UTF-8'); ?>;">
                                        <?= htmlspecialchars($garment['tag_text'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </span>
                                <?php endif; ?>
                                <div class="actions">
                                    <a href="#" title="Quickview" class="action quickview" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><i class="pe-7s-search"></i></a>
                                </div>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="#" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?></a></h5>                                
                                
                                 <!-- SKU Start -->
                            <?php if (!empty($garment['unique_code'])): ?>
                            <div class="sku mb-3">
                                <span>Código único: <?= htmlspecialchars($garment['unique_code'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <?php endif; ?>
                            <!-- SKU End -->

                                
                                
                                <span class="ratings">
                                    <span class="rating-wrap">
                                        <span class="star" style="width: <?= (int)$garment['condition']; ?>%"></span>
                                    </span>
                                    <span class="rating-num">(<?= round($garment['condition']); ?>/100)</span>
                                </span>
                                <?php if (!empty($garment['comment'])): ?>
                                <p><?= htmlspecialchars($garment['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php endif; ?>
                                <span class="price">
                                    <span class="new">$<?= number_format((float)$garment['sale_value'], 2); ?></span>
                                </span>
                                <?php
                                $tag = strtolower($garment['tag_text'] ?? '');
                                $showCart = $tag !== 'reservado' && $tag !== 'vendido';
                                $showAsk  = $tag !== 'vendido';
                                ?>
                                <div class="shop-list-btn">
                                    <?php if ($showCart): ?>
                                    <form method="post" action="<?= htmlspecialchars(asset('cart.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline">
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="id" value="<?= (int)$garment['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Agregar al carrito"><i class="fa fa-cart-plus"></i></button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($showAsk): ?>
                                    <?php
                                    $waMessage = 'Por favor necesito  información de la prenda ' . $garment['name'] . ' de código: ' . $garment['unique_code'];
                                    $waLink = 'https://wa.me/593999591820?text=' . urlencode($waMessage);
                                    ?>
                                    <a href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-success ms-1" title="Preguntar por esta prenda"><i class="fa fa-whatsapp"></i></a>
                                    <?php endif; ?> 
                                    <?php $detailUrl = asset('prenda.php') . '?id=' . urlencode((string)$garment['id']); ?>
                                    <a href="<?= htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-secondary btn-hover-primary ms-1" title="Ver detalles"><i class="pe-7s-look"></i></a>
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
                            <form method="get">
                                <?php if ($categoryId !== null): ?>
                                    <input type="hidden" name="category" value="<?= $categoryId; ?>">
                                <?php endif; ?>
                                <?php if ($sort !== null): ?>
                                    <input type="hidden" name="sort" value="<?= $sort; ?>">
                                <?php endif; ?>
                                <select name="perPage" class="nice-select rounded-0" aria-label=".form-select-sm example" onchange="this.form.submit()">
                                    <?php foreach ([9, 15, 24, 36, 51] as $pp): ?>
                                        <option value="<?= $pp; ?>"<?= $perPage === $pp ? ' selected' : '' ?>>Ver <?= $pp; ?> por pagina</option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <nav>
                            <ul class="pagination">
                                <?php
                                $queryBase = [];
                                if ($categoryId !== null) { $queryBase['category'] = $categoryId; }
                                if ($sort !== null) { $queryBase['sort'] = $sort; }
                                $queryBase['perPage'] = $perPage;

                                $firstDisabled = $page <= 1 ? ' disabled' : '';
                                $lastDisabled  = $page >= $pages ? ' disabled' : '';

                                $firstQuery = http_build_query(array_merge($queryBase, ['page' => 1]));
                                $prevQuery  = http_build_query(array_merge($queryBase, ['page' => $page - 1]));
                                $nextQuery  = http_build_query(array_merge($queryBase, ['page' => $page + 1]));
                                $lastQuery  = http_build_query(array_merge($queryBase, ['page' => $pages]));

                                if ($pages <= 5) {
                                    $startPage = 1;
                                    $endPage   = $pages;
                                } elseif ($page <= 3) {
                                    $startPage = 1;
                                    $endPage   = 5;
                                } elseif ($page >= $pages - 2) {
                                    $startPage = $pages - 4;
                                    $endPage   = $pages;
                                } else {
                                    $startPage = $page - 2;
                                    $endPage   = $page + 2;
                                }
                                ?>
                                <li class="page-item<?= $firstDisabled; ?>">
                                    <a class="page-link" href="<?= $firstDisabled ? '#' : 'nueva.php?' . $firstQuery; ?>" title="Primera página">
                                        &laquo;&laquo;
                                    </a>
                                </li>
                                <li class="page-item<?= $firstDisabled; ?>">
                                    <a class="page-link" href="<?= $firstDisabled ? '#' : 'nueva.php?' . $prevQuery; ?>" title="Página anterior">
                                        &laquo;
                                    </a>
                                </li>
                                <?php if ($startPage > 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <?php for ($i = $startPage; $i <= $endPage; $i++):
                                    $pageQuery = http_build_query(array_merge($queryBase, ['page' => $i]));
                                ?>
                                    <li class="page-item"><a class="page-link<?= $page === $i ? ' active' : '' ?>" href="nueva.php?<?= $pageQuery; ?>"><?= $i; ?></a></li>
                                <?php endfor; ?>
                                <?php if ($endPage < $pages): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item<?= $lastDisabled; ?>">
                                    <a class="page-link" href="<?= $lastDisabled ? '#' : 'nueva.php?' . $nextQuery; ?>" title="Página siguiente">
                                        &raquo;
                                    </a>
                                </li>
                                <li class="page-item<?= $lastDisabled; ?>">
                                    <a class="page-link" href="<?= $lastDisabled ? '#' : 'nueva.php?' . $lastQuery; ?>" title="Última página">
                                        &raquo;&raquo;
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
                                    <li><a href="nueva.php<?= $sort || $perPage ? '?' . http_build_query(array_filter(['sort' => $sort, 'perPage' => $perPage])) : '' ?>"<?= $categoryId === null ? ' class="active text-danger"' : '' ?>>Todas</a></li>
                                    <?php foreach ($categories as $cat): ?>
                                        <li><a href="nueva.php?<?= http_build_query(array_filter(['category' => $cat['id'], 'sort' => $sort, 'perPage' => $perPage])) ?>"<?= $categoryId === (int)$cat['id'] ? ' class="active text-danger"' : '' ?>><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8'); ?> (<?= $cat['usage_count']; ?>)</a></li>
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
                                        <img class="w-100" src="<?= htmlspecialchars(asset($garment['image_primary']), ENT_QUOTES, 'UTF-8'); ?>" alt="Product">
                                    </a>
                                    <?php if (!empty($garment['image_secondary'])): ?>
                                    <a class="swiper-slide" href="#">
                                        <img class="w-100" src="<?= htmlspecialchars($garment['image_secondary'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product">
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
                                <h2 class="product-title"><?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
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
                                <span>Código único: <?= htmlspecialchars($garment['unique_code'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <?php endif; ?>
                            <!-- SKU End -->

                            <!-- Description Start -->
                            <?php if (!empty($garment['comment'])): ?>
                            <p class="desc-content mb-5"><?= htmlspecialchars($garment['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                            <!-- Description End -->

                            <!-- Product Meta Start -->
                            <?php if (!empty($garment['size'])): ?>
                            <div class="product-meta mb-3">
                                <!-- Product Size Start -->
                                <div class="product-size">
                                    <span>Talla :</span>
                                    <span><strong><?= htmlspecialchars($garment['size'], ENT_QUOTES, 'UTF-8'); ?></strong></span>
                                </div>
                                <!-- Product Size End -->
                            </div>
                            <?php endif; ?>
                            <!-- Product Meta End -->


                            <!-- Cart & Wishlist Button Start -->
                            <?php
                            $tag = strtolower($garment['tag_text'] ?? '');
                            $showCart = $tag !== 'reservado' && $tag !== 'vendido';
                            $showAsk  = $tag !== 'vendido';
                            ?>
                            <div class="cart-wishlist-btn pb-4 mb-n3">
                                <div class="add-to_cart mb-3">
                                    <?php if ($showCart): ?>
                                    <form method="post" action="<?= htmlspecialchars(asset('cart.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline">
                                        <input type="hidden" name="action" value="add">
                                      <input type="hidden" name="id" value="<?= (int)$garment['id']; ?>">
                                      <input type="hidden" name="quantity" value="1">
                                      <button type="submit" class="btn btn-outline-danger" title="Agregar al carrito"><i class="fa fa-cart-plus"></i></button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($showAsk): ?>
                                    <?php
                                    $waMessage = 'Por favor necesito  información de la prenda ' . $garment['name'] . ' de código: ' . $garment['unique_code'];
                                    $waLink = 'https://wa.me/593999591820?text=' . urlencode($waMessage);
                                    ?>
                                    <a class="btn btn-success ms-1" href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" title="Preguntar por esta prenda"><i class="fa fa-whatsapp"></i></a>
                                    <?php endif; ?>
                                    <?php $detailUrl = asset('prenda.php') . '?id=' . urlencode((string)$garment['id']); ?>
                                    <a class="btn btn-secondary btn-hover-primary ms-1" href="<?= htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" title="Ver detalles"><i class="pe-7s-look"></i></a>
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
