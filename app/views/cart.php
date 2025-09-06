<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <?php if (empty($items)): ?>
      <p>Tu carrito está vacío.</p>
    <?php else: ?>
      <div class="row">
        <div class="col-12">
          <div class="cart-table">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="pro-thumbnail">Imagen</th>
                    <th class="pro-title">Producto</th>
                    <th class="pro-price">Precio</th>
                    <th class="pro-quantity">Cantidad</th>
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
                          <img class="img-thumbnail" style="width: 60px;" src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php endif; ?>
                      </td>
                      <td class="pro-title">
                        <a href="<?= htmlspecialchars(asset('prenda.php?id=' . (int)$item['garment_id']), ENT_QUOTES, 'UTF-8'); ?>">
                          <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                      </td>
                      <td class="pro-price"><span>$<?= number_format((float)$item['sale_value'], 2); ?></span></td>
                      <td class="pro-quantity"><span><?= (int)$item['quantity']; ?></span></td>
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
            <button type="button" class="btn btn-dark btn-hover-primary rounded-0 w-100" data-bs-toggle="modal" data-bs-target="#checkoutModal">Confirmar pedido</button>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php if (!empty($items)): ?>
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= htmlspecialchars(asset('cart.php'), ENT_QUOTES, 'UTF-8'); ?>">
      <input type="hidden" name="action" value="checkout">
      <div class="modal-header">
        <h5 class="modal-title">Resumen de compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3">
          <?php foreach ($items as $item): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?> x<?= (int)$item['quantity']; ?>
            <span>$<?= number_format($item['sale_value'] * $item['quantity'], 2); ?></span>
          </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between">
            <strong>Total</strong>
            <strong>$<?= number_format($total, 2); ?></strong>
          </li>
        </ul>
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Método de pago</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payCard" value="Tarjeta" required>
            <label class="form-check-label" for="payCard">Tarjeta de crédito</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payTransfer" value="Transferencia" required>
            <label class="form-check-label" for="payTransfer">Transferencia</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payCash" value="Efectivo" required>
            <label class="form-check-label" for="payCash">Efectivo</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/layout/footer.php'; ?>
