<?php include __DIR__ . '/layout/header.php'; ?>

<?php if (isset($_SESSION['username'])): ?>
<div class="container my-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideModal">Slide</button>
</div>
<?php endif; ?>

<!-- Hero/Intro Slider Start -->
<div class="section">
    <div class="hero-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($slides as $slide): ?>
                <div class="hero-slide-item swiper-slide">
                    <div class="hero-slide-bg">
                        <img src="<?= htmlspecialchars($slide['image']) ?>" alt="Slider Image" />
                    </div>
                    <div class="container">
                        <div class="hero-slide-content">
                            <h2 class="title"><?= nl2br(htmlspecialchars($slide['title'])) ?></h2>
                            <p><?= htmlspecialchars($slide['description']) ?></p>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Slides</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php foreach ($slides as $slide): ?>
        <form id="slide-form-<?= $slide['id'] ?>" method="post" action="slides.php" enctype="multipart/form-data"></form>
        <?php endforeach; ?>
        <form id="slide-form-new" method="post" action="slides.php" enctype="multipart/form-data"></form>
        <table class="table">
          <thead>
            <tr>
              <th>Título</th>
              <th>Texto</th>
              <th>Imagen</th>
              <th>Link</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($slides as $slide): ?>
            <tr>
              <td><input type="text" name="title" value="<?= htmlspecialchars($slide['title']) ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
              <td><input type="text" name="description" value="<?= htmlspecialchars($slide['description']) ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
              <td>
                <img src="<?= htmlspecialchars($slide['image']) ?>" alt="" class="img-thumbnail mb-1" style="max-width:80px;" id="preview-<?= $slide['id'] ?>">
                <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'preview-<?= $slide['id'] ?>')" form="slide-form-<?= $slide['id'] ?>">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($slide['image']) ?>" form="slide-form-<?= $slide['id'] ?>">
              </td>
              <td><input type="text" name="link" value="<?= htmlspecialchars($slide['link']) ?>" class="form-control" form="slide-form-<?= $slide['id'] ?>"></td>
              <td>
                <input type="hidden" name="id" value="<?= $slide['id'] ?>" form="slide-form-<?= $slide['id'] ?>">
                <button class="btn btn-success btn-sm" name="action" value="update" form="slide-form-<?= $slide['id'] ?>">Guardar</button>
                <button class="btn btn-danger btn-sm" name="action" value="delete" onclick="return confirm('¿Eliminar?')" form="slide-form-<?= $slide['id'] ?>">Eliminar</button>
              </td>
            </tr>
            <?php endforeach; ?>
            <tr>
              <td><input type="text" name="title" class="form-control" placeholder="Título" form="slide-form-new"></td>
              <td><input type="text" name="description" class="form-control" placeholder="Texto" form="slide-form-new"></td>
              <td>
                <img src="" alt="" class="img-thumbnail mb-1 d-none" style="max-width:80px;" id="preview-new">
                <input type="file" name="image" class="form-control form-control-sm" onchange="previewImage(this,'preview-new')" form="slide-form-new">
              </td>
              <td><input type="text" name="link" class="form-control" placeholder="Link" form="slide-form-new"></td>
              <td><button class="btn btn-primary btn-sm" name="action" value="create" form="slide-form-new">Crear</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Slide Modal End -->
<?php endif; ?>

<?php if (isset($_SESSION['username'])): ?>
<script>
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
