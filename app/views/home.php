<?php include __DIR__ . '/layout/header.php'; ?>

<?php if (isset($_SESSION['username'])): ?>
<div class="container my-3">
    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#slideModal">Editar Slide</button>
</div>
<?php endif; ?>

<!-- Hero/Intro Slider Start -->
<div class="section">
    <div class="hero-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
              <?php foreach ($slides as $slide): ?>
              <?php if ((int)$slide['estado'] !== 1) continue; ?>
              <?php $textClass = ((int)$slide['color'] === 2) ? 'text-white' : 'text-dark'; ?>
              <div class="hero-slide-item swiper-slide">
                      <div class="hero-slide-bg">
                          <img src="<?= htmlspecialchars($slide['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Slider Image" />                      
                        </div>
                      <div class="container">
                          <div class="hero-slide-content">
                               <h2 class="title <?= $textClass ?>"><?= nl2br(htmlspecialchars($slide['title'], ENT_QUOTES, 'UTF-8')) ?></h2>
                              <p class="<?= $textClass ?>"><?= htmlspecialchars($slide['description'], ENT_QUOTES, 'UTF-8') ?></p>
                              <a href="<?= htmlspecialchars($slide['link'] ?: 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="btn btn-lg btn-primary btn-hover-dark">Ver más</a>
                          </div>
                      </div>
                  </div>
                  <?php endforeach; ?>
            </div>
            <div class="swiper-pagination d-md-none"></div>
            <div class="home-slider-prev swiper-button-prev main-slider-nav d-md-flex d-none"><i class="pe-7s-angle-left"></i></div>
            <div class="home-slider-next swiper-button-next main-slider-nav d-md-flex d-none"><i class="pe-7s-angle-right"></i></div>
        </div>
    </div>
</div>
<!-- Hero/Intro Slider End -->

<!-- Banner Section Start -->
<div class="section section-margin">
  <?php if (isset($_SESSION['username'])): ?>
  <div class="container my-3">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bannerModal">Editar Banner</button>
  </div>
  <?php endif; ?>
    <div class="container">
        <div class="row mb-n6 overflow-hidden">
            <?php foreach ($banners as $index => $banner): ?>
            <div class="col-md-6 col-12 mb-6" data-aos="<?= $index % 2 === 0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="300">
                <div class="banner">
                    <div class="banner-image">
 <a href="<?= htmlspecialchars($banner['link'], ENT_QUOTES, 'UTF-8') ?>"><img src="<?= htmlspecialchars($banner['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Banner Image"></a>                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <?php $bannerTextClass = ((int)$banner['color'] === 2) ? 'text-white' : 'text-dark'; ?>
                            <h4 class="sub-title <?= $bannerTextClass ?>"><?= htmlspecialchars($banner['subtitle'], ENT_QUOTES, 'UTF-8') ?></h4>
                            <h3 class="title <?= $bannerTextClass ?>"><?= htmlspecialchars($banner['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <a href="<?= htmlspecialchars($banner['link'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary btn-hover-dark btn-sm">Ver más</a>                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Banner Section End -->

<!-- Feature Section Start -->
<div class="section">
  <?php if (isset($_SESSION['username'])): ?>
  <div class="container my-3">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#featureModal">Editar Opciones</button>
  </div>
  <?php endif; ?>
    <div class="container">
        <div class="feature-wrap">
            <div class="row row-cols-lg-4 row-cols-xl-auto row-cols-sm-2 row-cols-1 justify-content-between mb-n5">
                <?php foreach ($features as $index => $feature): ?>
                <div class="col mb-5" data-aos="fade-up" data-aos-delay="<?= 300 + $index * 200 ?>">
                    <div class="feature">
                        <div class="icon text-primary align-self-center">
                            <img src="<?= htmlspecialchars($feature['icon'], ENT_QUOTES, 'UTF-8') ?>" alt="Feature Icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><?= htmlspecialchars($feature['title'], ENT_QUOTES, 'UTF-8') ?></h5>
                            <p><?= nl2br(htmlspecialchars($feature['description'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- Feature Section End -->

<!-- Product Section Start -->
<div class="section section-padding mt-0">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <div class="col-12">
                MERCADERIA RECIEN LLEGADA
                <ul class="product-tab-nav nav justify-content-center mb-10 title-border-bottom mt-n3">
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="300"><a class="nav-link active mt-3" data-bs-toggle="tab" href="#tab-new-arrivals">NUEVA</a></li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="400"><a class="nav-link mt-3" data-bs-toggle="tab" href="#tab-used-arrivals">2DA MANO</a></li>
                </ul>
            </div>
        </div>
        <!-- Section Title & Tab End -->

        <!-- Products Tab Start -->
        <div class="row">
            <div class="col">
                <div class="tab-content position-relative">
                    <div class="tab-pane fade show active" id="tab-new-arrivals">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper mb-n10">
                                    <?php foreach ($newArrivals as $garment): ?>
                                    <div class="swiper-slide product-wrapper">
                                        <div class="product product-border-left mb-10" data-aos="fade-up" data-aos-delay="200">
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
                                                    <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><i class="pe-7s-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><a href="#" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?></a></h5>                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: <?= (int)$garment['condition']; ?>%"></span>
                                                    </span>
                                                    <span class="rating-num">(<?= round($garment['condition']); ?>/100)</span>
                                                </span>
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
                                                  $waMessage = 'Por favor necesito  información de la prenda ' . $garment['name'] . ' de código:' . $garment['unique_code'];
                                                  $waLink = 'https://wa.me/593999591820?text=' . urlencode($waMessage);
                                                  ?>
                                                  <a href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-success ms-1" title="Preguntar por esta prenda"><i class="fa fa-whatsapp"></i></a>
                                                  <?php endif; ?>
                                                  <?php $detailUrl = asset('prenda.php') . '?id=' . urlencode((string)$garment['id']); ?>
                                                  <a href="<?= htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-secondary btn-hover-primary ms-1" title="Ver detalles"><i class="pe-7s-look"></i></a>                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination d-md-none"></div>
                                <div class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-right"></i></div>
                                <div class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-left"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-used-arrivals">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper mb-n10">
                                    <?php foreach ($usedArrivals as $garment): ?>
                                    <div class="swiper-slide product-wrapper">
                                        <div class="product product-border-left mb-10" data-aos="fade-up" data-aos-delay="200">
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
                                                    <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><i class="pe-7s-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><a href="#" data-bs-toggle="modal" data-bs-target="#quickview-<?= $garment['id']; ?>"><?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?></a></h5>                                                
                                                <span class="ratings">
                                                  <span class="rating-wrap">
                                                        <span class="star" style="width: <?= (int)$garment['condition']; ?>%"></span>
                                                    </span>
                                                    <span class="rating-num">(<?= round($garment['condition']); ?>/100)</span>
                                                </span>
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
                                                  $waMessage = 'Por favor necesito  información de la prenda ' . $garment['name'] . ' de código:' . $garment['unique_code'];
                                                  $waLink = 'https://wa.me/593999591820?text=' . urlencode($waMessage);
                                                  ?>
                                                 <a href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-success ms-1" title="Preguntar por esta prenda"><i class="fa fa-whatsapp"></i></a>
                                                  <?php endif; ?>
                                                  <?php $detailUrl = asset('prenda.php') . '?id=' . urlencode((string)$garment['id']); ?>
                                                  <a href="<?= htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-secondary btn-hover-primary ms-1" title="Ver detalles"><i class="pe-7s-look"></i></a>                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination d-md-none"></div>
                                <div class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-right"></i></div>
                                <div class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-left"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products Tab End -->
    </div>
</div>
<!-- Product Section End -->

<?php foreach (array_merge($newArrivals, $usedArrivals) as $garment): ?>
    <div class="modalquickview modal fade" id="quickview-<?= $garment['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button class="btn close" data-bs-dismiss="modal">×</button>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="modal-product-carousel">
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
                                <div class="swiper-product-button-next swiper-button-next"><i class="pe-7s-angle-right"></i></div>
                                <div class="swiper-product-button-prev swiper-button-prev"><i class="pe-7s-angle-left"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 overflow-hidden position-relative">
                        <div class="product-summery">
                            <div class="product-head mb-3">
                                <h2 class="product-title"><?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                            </div>
                            <div class="price-box mb-2">
                                <span class="regular-price">$<?= number_format((float)$garment['sale_value'], 2); ?></span>
                            </div>
                            <?php if (!empty($garment['unique_code'])): ?>
                            <div class="sku mb-3">
                                <span>Código único: <?= htmlspecialchars($garment['unique_code'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($garment['comment'])): ?>
                            <p class="desc-content mb-5"><?= htmlspecialchars($garment['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($garment['size'])): ?>
                            <div class="product-meta mb-3">
                                <div class="product-size">
                                    <span>Talla :</span>
                                    <span><strong><?= htmlspecialchars($garment['size'], ENT_QUOTES, 'UTF-8'); ?></strong></span>
                                </div>
                            </div>
                            <?php endif; ?>
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
                                        $waMessage = 'Por favor necesito  información de la prenda ' . $garment['name'] . ' de código:' . $garment['unique_code'];
                                        $waLink = 'https://wa.me/593999591820?text=' . urlencode($waMessage);
                                        ?>
                                        <a class="btn btn-success ms-1" href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" title="Preguntar por esta prenda"><i class="fa fa-whatsapp"></i></a>
                                        <?php endif; ?>
                                        <?php $detailUrl = asset('prenda.php') . '?id=' . urlencode((string)$garment['id']); ?>
                                        <a class="btn btn-secondary btn-hover-primary ms-1" href="<?= htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" title="Ver detalles"><i class="pe-7s-look"></i></a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (isset($_SESSION['username'])): ?>




  <!-- Slide Modal -->
<div class="modal fade" id="slideModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Slides</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<div class="modal-body">

  <?php foreach ($slides as $slide): ?>
  <form id="slide-form-<?= $slide['id'] ?>" method="post" action="slides.php" enctype="multipart/form-data"></form>
  <form id="slide-toggle-<?= $slide['id'] ?>" method="post" action="slides.php"></form>
  <?php endforeach; ?>
  <form id="slide-form-new" method="post" action="slides.php" enctype="multipart/form-data"></form>
<table class="table">
          <thead>
              <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Texto</th>
                <th>Link</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
          </thead>
       <tbody>






              <?php foreach ($slides as $slide): ?>
              <tr>
                <td>
                  <img src="<?= htmlspecialchars($slide['image'], ENT_QUOTES, 'UTF-8') ?>" alt="" class="img-thumbnail mb-1" style="max-width:80px;" id="preview-<?= $slide['id'] ?>">    
                  <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'preview-<?= $slide['id'] ?>')" form="slide-form-<?= $slide['id'] ?>">
                  <input type="hidden" name="current_image" value="<?= htmlspecialchars($slide['image'], ENT_QUOTES, 'UTF-8') ?>" form="slide-form-<?= $slide['id'] ?>">
                </td>
                <td><input type="text" name="title" value="<?= htmlspecialchars($slide['title'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
                <td><input type="text" name="description" value="<?= htmlspecialchars($slide['description'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
                <td><input type="text" name="link" value="<?= htmlspecialchars($slide['link'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
                <td>
                  <input type="hidden" name="color" value="<?= $slide['color'] ?>" id="color-<?= $slide['id'] ?>" form="slide-form-<?= $slide['id'] ?>">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="color-check-<?= $slide['id'] ?>" <?= $slide['color']==2?'checked':'' ?> onchange="toggleColor(<?= $slide['id'] ?>, this.checked)">
                    <label class="form-check-label" for="color-check-<?= $slide['id'] ?>">Texto blanco</label>
                  </div>
                </td>
                <td>
                  <input type="hidden" name="id" value="<?= $slide['id'] ?>" form="slide-toggle-<?= $slide['id'] ?>">
                  <input type="hidden" name="action" value="toggle" form="slide-toggle-<?= $slide['id'] ?>">
                  <input type="hidden" name="estado" value="<?= $slide['estado'] ?>" id="estado-toggle-<?= $slide['id'] ?>" form="slide-toggle-<?= $slide['id'] ?>">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="switch-<?= $slide['id'] ?>" <?= $slide['estado']==1?'checked':'' ?> onchange="toggleEstado(<?= $slide['id'] ?>, this.checked)">
                    <label class="form-check-label" for="switch-<?= $slide['id'] ?>">Activo</label>
                  </div>
                  <input type="hidden" name="estado" value="<?= $slide['estado'] ?>" id="estado-update-<?= $slide['id'] ?>" form="slide-form-<?= $slide['id'] ?>">
                </td>
                <td>
                  <input type="hidden" name="id" value="<?= $slide['id'] ?>" form="slide-form-<?= $slide['id'] ?>">
                  <button class="btn btn-success btn-sm" name="action" value="update" form="slide-form-<?= $slide['id'] ?>">Guardar</button>
                  <button class="btn btn-danger btn-sm" name="action" value="delete" onclick="return confirm('¿Eliminar?')" form="slide-form-<?= $slide['id'] ?>">Eliminar</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>

                <tr>
                  <td>
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="" class="img-thumbnail mb-1 d-none" style="max-width:80px;" id="preview-new">
                    <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'preview-new')" form="slide-form-new">
                  </td>
                  <td><input type="text" name="title" class="form-control" placeholder="Título" form="slide-form-new"></td>
                <td><input type="text" name="description" class="form-control" placeholder="Texto" form="slide-form-new"></td>
                <td><input type="text" name="link" class="form-control" placeholder="Link" form="slide-form-new"></td>
                <td>
                  <input type="hidden" name="color" value="1" id="color-new" form="slide-form-new">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="color-check-new" onchange="document.getElementById('color-new').value = this.checked ? 2 : 1;">
                    <label class="form-check-label" for="color-check-new">Texto blanco</label>
                  </div>
                </td>
                <td>
                  <input type="hidden" name="estado" value="1" id="estado-new" form="slide-form-new">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="switch-new" checked onchange="document.getElementById('estado-new').value = this.checked ? 1 : 2;">
                    <label class="form-check-label" for="switch-new">Activo</label>
                  </div>
                </td>
                <td><button class="btn btn-primary btn-sm" name="action" value="create" form="slide-form-new">Crear</button></td>
              </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Slide Modal End -->
<!-- Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Banners</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php foreach ($banners as $banner): ?>
        <form id="banner-form-<?= $banner['id'] ?>" method="post" action="banners.php" enctype="multipart/form-data"></form>
        <?php endforeach; ?>
        <table class="table">
          <thead>
            <tr>
              <th>Imagen</th>
              <th>Subtítulo</th>
              <th>Título</th>
              <th>Link</th>
              <th>Color</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($banners as $banner): ?>
            <tr>
              <td>
                <img src="<?= htmlspecialchars($banner['image'], ENT_QUOTES, 'UTF-8') ?>" alt="" class="img-thumbnail mb-1" style="max-width:80px;" id="banner-preview-<?= $banner['id'] ?>">
                <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'banner-preview-<?= $banner['id'] ?>')" form="banner-form-<?= $banner['id'] ?>">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($banner['image'], ENT_QUOTES, 'UTF-8') ?>" form="banner-form-<?= $banner['id'] ?>">
              </td>
              <td><input type="text" name="subtitle" value="<?= htmlspecialchars($banner['subtitle'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="banner-form-<?= $banner['id'] ?>"></td>
              <td><input type="text" name="title" value="<?= htmlspecialchars($banner['title'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="banner-form-<?= $banner['id'] ?>"></td>
              <td><input type="text" name="link" value="<?= htmlspecialchars($banner['link'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="banner-form-<?= $banner['id'] ?>"></td>
              <td>
                <input type="hidden" name="color" value="<?= $banner['color'] ?>" id="banner-color-<?= $banner['id'] ?>" form="banner-form-<?= $banner['id'] ?>">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="banner-color-check-<?= $banner['id'] ?>" <?= $banner['color']==2?'checked':'' ?> onchange="toggleBannerColor(<?= $banner['id'] ?>, this.checked)">
                  <label class="form-check-label" for="banner-color-check-<?= $banner['id'] ?>">Texto blanco</label>
                </div>
              </td>
              <td>
                <input type="hidden" name="id" value="<?= $banner['id'] ?>" form="banner-form-<?= $banner['id'] ?>">
                <button class="btn btn-success btn-sm" name="action" value="update" form="banner-form-<?= $banner['id'] ?>">Actualizar</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Banner Modal End -->
<!-- Feature Modal -->
<div class="modal fade" id="featureModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Opciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php foreach ($features as $feature): ?>
        <form id="feature-form-<?= $feature['id'] ?>" method="post" action="features.php" enctype="multipart/form-data"></form>
        <?php endforeach; ?>
        <table class="table">
          <thead>
            <tr>
              <th>Icono</th>
              <th>Título</th>
              <th>Texto</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($features as $feature): ?>
            <tr>
              <td>
              <img src="<?= htmlspecialchars($feature['icon'], ENT_QUOTES, 'UTF-8') ?>" alt="" class="img-thumbnail mb-1" style="max-width:80px;" id="feature-preview-<?= $feature['id'] ?>">  
              <input type="file" name="icon" class="form-control form-control-sm" onchange="previewImage(this,'feature-preview-<?= $feature['id'] ?>')" form="feature-form-<?= $feature['id'] ?>">
              <input type="hidden" name="current_icon" value="<?= htmlspecialchars($feature['icon'], ENT_QUOTES, 'UTF-8') ?>" form="feature-form-<?= $feature['id'] ?>">
              </td>
              <td><input type="text" name="title" value="<?= htmlspecialchars($feature['title'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="feature-form-<?= $feature['id'] ?>"></td>
              <td><input type="text" name="description" value="<?= htmlspecialchars($feature['description'], ENT_QUOTES, 'UTF-8') ?>" class="form-control" form="feature-form-<?= $feature['id'] ?>"></td>
              <td>
                <input type="hidden" name="id" value="<?= $feature['id'] ?>" form="feature-form-<?= $feature['id'] ?>">
                <button class="btn btn-success btn-sm" name="action" value="update" form="feature-form-<?= $feature['id'] ?>">Actualizar</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Feature Modal End -->
<?php endif; ?>

<?php if (isset($_SESSION['username'])): ?>
<script>
function toggleEstado(id, checked) {
  document.getElementById('estado-toggle-' + id).value = checked ? 1 : 2;
  const updateField = document.getElementById('estado-update-' + id);
  if (updateField) {
    updateField.value = checked ? 1 : 2;
  }
  document.getElementById('slide-toggle-' + id).submit();
}
function toggleColor(id, checked) {
  document.getElementById('color-' + id).value = checked ? 2 : 1;
}
function toggleBannerColor(id, checked) {
  document.getElementById('banner-color-' + id).value = checked ? 2 : 1;
}
function previewImage(input, previewId) {
  const preview = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.classList.remove('d-none');
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
<?php endif; ?>

<?php include __DIR__ . '/layout/footer.php'; ?>
