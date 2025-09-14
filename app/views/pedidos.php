<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <h3>Pedidos</h3>
    <form method="get" class="mb-3">
      <div class="row g-2">
        <div class="col-auto">
          <select name="status" class="form-select">
            <option value="" <?= $currentStatus === '' ? 'selected' : ''; ?>>Todos</option>
            <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : ''; ?>>Pendientes</option>
            <option value="confirmed" <?= $currentStatus === 'confirmed' ? 'selected' : ''; ?>>Confirmados</option>
            <option value="paid" <?= $currentStatus === 'paid' ? 'selected' : ''; ?>>Pagados</option>
            <option value="delivered" <?= $currentStatus === 'delivered' ? 'selected' : ''; ?>>Entregados</option>
            <option value="rejected" <?= $currentStatus === 'rejected' ? 'selected' : ''; ?>>Rechazados</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
      </div>
    </form>
    <?php if (empty($orders)): ?>
      <p>No hay pedidos.</p>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Método</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
          <tbody>
          <?php $orderModals = []; foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['buyer_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($order['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($order['payment_method'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="text-center">
              <?php
                $iconClass = 'pe-7s-clock text-warning';
                $orden= 'Pedido Pendiente';
                if ($order['status'] === 'confirmed') {
                    $iconClass = 'pe-7s-check text-success';
                    $orden= 'Pedido Confirmado';
                } elseif ($order['status'] === 'paid') {
                    $iconClass = 'pe-7s-cash text-primary';
                    $orden= 'Pedido Pagado';
                } elseif ($order['status'] === 'delivered') {
                    $iconClass = 'pe-7s-gift text-info';
                    $orden= 'Pedido Entregado';
                } elseif ($order['status'] === 'rejected') {
                    $iconClass = 'pe-7s-close-circle text-danger';
                    $orden= 'Pedido Rechazado';
                }
              ?>
              <i class="<?= $iconClass; ?>" title="<?= htmlspecialchars($orden, ENT_QUOTES, 'UTF-8'); ?>"></i>
            </td>
            <td>
              <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#order-<?= (int)$order['id']; ?>">Ver prendas</button>
              <?php if ($order['status'] === 'pending'): ?>
              <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline">
                <input type="hidden" name="action" value="confirm">
                <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
              </form>
              <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline">
                <input type="hidden" name="action" value="reject">
                <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                <button type="submit" class="btn btn-sm btn-danger">Rechazar</button>
              </form>
              <?php elseif ($order['status'] === 'confirmed'): ?>
              <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline">
                <input type="hidden" name="action" value="pay">
                <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                <button type="submit" class="btn btn-sm btn-primary">Pagado</button>
              </form>
              <?php elseif ($order['status'] === 'paid'): ?>
              <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline">
                <input type="hidden" name="action" value="deliver">
                <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                <button type="submit" class="btn btn-sm btn-success">Entregado</button>
              </form>
              <?php endif; ?>
              <?php if ($order['status'] === 'rejected' || (isset($_SESSION['role']) && (int)$_SESSION['role'] === 1)): ?>
              <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este pedido?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
              <?php endif; ?>
            </td>
            </tr>
            <?php ob_start(); ?>
            <div class="modal fade" id="order-<?= (int)$order['id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Prendas del pedido #<?= (int)$order['id']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Código Único</th>
                            <th>Precio</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $total = 0; foreach ($order['items'] as $item): $total += $item['sale_value'] * $item['quantity']; ?>
                          <tr>
                            <td>
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
                            <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($item['unique_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>$<?= number_format((float)$item['sale_value'], 2); ?></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td><strong>$<?= number_format($total, 2); ?></strong></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
            <?php $orderModals[] = ob_get_clean(); ?>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php foreach ($orderModals as $modal) echo $modal; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include __DIR__ . '/layout/footer.php'; ?>
