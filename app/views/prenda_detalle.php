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
          $tag = strtolower($garment['tag_text'] ?? '');
          $showCart = $tag !== 'reservado' && $tag !== 'vendido';
          $showAsk  = $tag !== 'vendido';
        ?>
        <?php if ($showAsk): ?>
        <a href="<?= htmlspecialchars($waLink, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-info"><i class="pe-7s-help1"></i></a>
        <?php endif; ?>
        <?php if ($showCart): ?>
        <form method="post" action="<?= htmlspecialchars(asset('cart.php'), ENT_QUOTES, 'UTF-8'); ?>" class="mt-3">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="id" value="<?= (int)$garment['id']; ?>">
          <input type="hidden" name="quantity" value="1">
          <button type="submit" class="btn btn-success"><i class="pe-7s-shopbag"></i></button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
