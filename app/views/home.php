<?php include __DIR__ . '/layout/header.php'; ?>

<?php if (isset($_SESSION['username'])): ?>
<div class="container my-3">
    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#slideModal">Slide</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bannerModal">Banner</button>
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
                          <img src="<?= htmlspecialchars($slide['image']) ?>" alt="Slider Image" />
                      </div>
                      <div class="container">
                          <div class="hero-slide-content">
                              <h2 class="title <?= $textClass ?>"><?= nl2br(htmlspecialchars($slide['title'])) ?></h2>
                              <p class="<?= $textClass ?>"><?= htmlspecialchars($slide['description']) ?></p>
                              <a href="<?= htmlspecialchars($slide['link'] ?: 'index.php') ?>" class="btn btn-lg btn-primary btn-hover-dark">Ver más</a>
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
    <div class="container">
        <div class="row mb-n6 overflow-hidden">
            <?php foreach ($banners as $index => $banner): ?>
            <div class="col-md-6 col-12 mb-6" data-aos="<?= $index % 2 === 0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="300">
                <div class="banner">
                    <div class="banner-image">
                        <a href="<?= htmlspecialchars($banner['link']) ?>"><img src="<?= htmlspecialchars($banner['image']) ?>" alt="Banner Image"></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title"><?= htmlspecialchars($banner['subtitle']) ?></h4>
                            <h3 class="title"><?= htmlspecialchars($banner['title']) ?></h3>
                            <a href="<?= htmlspecialchars($banner['link']) ?>" class="btn btn-primary btn-hover-dark btn-sm">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Banner Section End -->

<h1>Productos destacados</h1>
<ul>
<?php foreach ($products as $product): ?>
    <li>
        <strong><?= htmlspecialchars($product['title']) ?></strong>
        - $<?= number_format($product['price'], 2) ?>
    </li>
<?php endforeach; ?>
</ul>

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
                  <img src="<?= htmlspecialchars($slide['image']) ?>" alt="" class="img-thumbnail mb-1" style="max-width:80px;" id="preview-<?= $slide['id'] ?>">
                  <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'preview-<?= $slide['id'] ?>')" form="slide-form-<?= $slide['id'] ?>">
                  <input type="hidden" name="current_image" value="<?= htmlspecialchars($slide['image']) ?>" form="slide-form-<?= $slide['id'] ?>">
                </td>
                <td><input type="text" name="title" value="<?= htmlspecialchars($slide['title']) ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
                <td><input type="text" name="description" value="<?= htmlspecialchars($slide['description']) ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
                <td><input type="text" name="link" value="<?= htmlspecialchars($slide['link']) ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
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
                    <img src="" alt="" class="img-thumbnail mb-1 d-none" style="max-width:80px;" id="preview-new">
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
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($banners as $banner): ?>
            <tr>
              <td>
                <img src="<?= htmlspecialchars($banner['image']) ?>" alt="" class="img-thumbnail mb-1" style="max-width:80px;" id="banner-preview-<?= $banner['id'] ?>">
                <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'banner-preview-<?= $banner['id'] ?>')" form="banner-form-<?= $banner['id'] ?>">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($banner['image']) ?>" form="banner-form-<?= $banner['id'] ?>">
              </td>
              <td><input type="text" name="subtitle" value="<?= htmlspecialchars($banner['subtitle']) ?>" class="form-control" form="banner-form-<?= $banner['id'] ?>"></td>
              <td><input type="text" name="title" value="<?= htmlspecialchars($banner['title']) ?>" class="form-control" form="banner-form-<?= $banner['id'] ?>"></td>
              <td><input type="text" name="link" value="<?= htmlspecialchars($banner['link']) ?>" class="form-control" form="banner-form-<?= $banner['id'] ?>"></td>
              <td>
                <input type="hidden" name="id" value="<?= $banner['id'] ?>" form="banner-form-<?= $banner['id'] ?>">
                <button class="btn btn-success btn-sm" name="action" value="update" form="banner-form-<?= $banner['id'] ?>">Guardar</button>
                <button class="btn btn-danger btn-sm" name="action" value="delete" onclick="return confirm('¿Eliminar?')" form="banner-form-<?= $banner['id'] ?>">Eliminar</button>
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
