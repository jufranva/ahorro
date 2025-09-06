<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <?php if (empty($items)): ?>
      <p>Tu carrito está vacío.</p>
    <?php else: ?>
      <div class="row">
        <div class="col-12">
          <div class="cart-table table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="pro-thumbnail">Imagen</th>
                  <th class="pro-title">Producto</th>
                  <th class="pro-price">Precio</th>
                  <th class="pro-quantity">Cantidad</th>
                  <th class="pro-subtotal">Sub Total</th>
                  <th class="pro-remove">Eliminar</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                  <tr>
                    <td class="pro-thumbnail">
                      <?php
                        $basePath = __DIR__ . '/../../';
                        $img = $item['image_primary'] ?? '';
                        $imgSrc = '';
                        if ($img && (filter_var($img, FILTER_VALIDATE_URL) || is_file($basePath . $img))) {
                          $imgSrc = asset($img);
                        }
                      ?>
                      <?php if ($imgSrc): ?>
                        <a href="<?= htmlspecialchars(asset('prenda.php?id=' . (int)$item['garment_id']), ENT_QUOTES, 'UTF-8'); ?>">
                          <img class="img-fluid" src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                        </a>
                      <?php endif; ?>
                    </td>
                    <td class="pro-title">
                      <a href="<?= htmlspecialchars(asset('prenda.php?id=' . (int)$item['garment_id']), ENT_QUOTES, 'UTF-8'); ?>">
                        <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                      </a>
                    </td>
                    <td class="pro-price"><span>$<?= number_format((float)$item['sale_value'], 2); ?></span></td>
                    <td class="pro-quantity"><span><?= (int)$item['quantity']; ?></span></td>
                    <td class="pro-subtotal"><span>$<?= number_format((float)$item['sale_value'] * $item['quantity'], 2); ?></span></td>
                    <td class="pro-remove">
                      <form method="post" action="<?= htmlspecialchars(asset('cart.php'), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="id" value="<?= (int)$item['id']; ?>">
                        <button type="submit" class="btn btn-link p-0"><i class="pe-7s-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php
        $total = array_reduce(
          $items,
          function ($carry, $i) {
            return $carry + $i['sale_value'] * $i['quantity'];
          },
          0
        );
      ?>
      <div class="row">
        <div class="col-lg-5 ms-auto col-custom">
          <div class="cart-calculator-wrapper">
            <div class="cart-calculate-items">
              <h3 class="title">Valor total</h3>
              <div class="table-responsive">
                <table class="table">
                  <tr class="total">
                    <td>Total</td>
                    <td class="total-amount">$<?= number_format($total, 2); ?></td>
                  </tr>
                </table>
              </div>
            </div>
            <a href="#" class="btn btn-dark btn-hover-primary rounded-0 w-100">Confirmar pedido</a>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
