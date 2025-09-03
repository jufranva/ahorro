<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php
        $basePath = __DIR__ . '/../../';
        $primary = $garment['image_primary'] ?? '';
        if ($primary && (filter_var($primary, FILTER_VALIDATE_URL) || is_file($basePath . $primary))): ?>
            <img class="img-fluid mb-3" src="<?= htmlspecialchars(asset($primary), ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?>">
        <?php endif; ?>
        <?php
        $secondary = $garment['image_secondary'] ?? '';
        if ($secondary && (filter_var($secondary, FILTER_VALIDATE_URL) || is_file($basePath . $secondary))): ?>
            <img class="img-fluid" src="<?= htmlspecialchars(asset($secondary), ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?>">
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <h1><?= htmlspecialchars($garment['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php if (!empty($garment['unique_code'])): ?>
        <p>Código: <?= htmlspecialchars($garment['unique_code'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if (!empty($garment['comment'])): ?>
        <p><?= htmlspecialchars($garment['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <p>Precio: $<?= number_format((float)$garment['sale_value'], 2); ?></p>
        <?php
          $waMessage = 'Por favor enviar información de la prenda ' . $garment['name'] . ' de código:' . $garment['unique_code'];
          $waLink = 'https://wa.me/593999591820?text=' . urlencode($waMessage);
        ?>
        <a href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Preguntar</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
