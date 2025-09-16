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
            <option value="credit" <?= $currentStatus === 'credit' ? 'selected' : ''; ?>>Crédito</option>
            <option value="paid" <?= $currentStatus === 'paid' ? 'selected' : ''; ?>>Pagados</option>
            <option value="delivered" <?= $currentStatus === 'delivered' ? 'selected' : ''; ?>>Entregados</option>
            <option value="rejected" <?= $currentStatus === 'rejected' ? 'selected' : ''; ?>>Rechazados</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
        <div class="col-auto">
          <a href="<?= htmlspecialchars(asset('cuentas.php'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary">Cuentas</a>
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
            <th>Valor Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
          <tbody>
          <?php $orderModals = []; $creditModals = []; foreach ($orders as $order): ?>
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
                } elseif ($order['status'] === 'credit') {
                    $iconClass = 'pe-7s-wallet text-info';
                    $orden= 'Pedido a crédito';
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
              <?php if (!empty($order['credit_name']) && in_array($order['status'], ['credit', 'paid'], true)): ?>
                <div><small class="text-muted">Crédito: <?= htmlspecialchars($order['credit_name'], ENT_QUOTES, 'UTF-8'); ?><?php if ($order['status'] === 'credit' && isset($order['credit_value'])): ?> (Saldo $<?= number_format((float)$order['credit_value'], 2); ?>)<?php endif; ?></small></div>
              <?php endif; ?>
            </td>
            <td>$<?= number_format((float)$order['total'], 2); ?></td>
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
              <button type="button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#credit-order-<?= (int)$order['id']; ?>">Crédito</button>
              <?php elseif ($order['status'] === 'credit'): ?>
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
            <?php if ($order['status'] === 'confirmed'): ?>
            <?php ob_start(); ?>
            <div class="modal fade" id="credit-order-<?= (int)$order['id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="action" value="credit">
                    <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                    <div class="modal-header">
                      <h5 class="modal-title">Asignar crédito al pedido #<?= (int)$order['id']; ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p>El pedido tiene un valor de <strong>$<?= number_format((float)$order['total'], 2); ?></strong> que se sumará al saldo del crédito seleccionado.</p>
                      <div class="mb-3">
                        <label for="credit-select-<?= (int)$order['id']; ?>" class="form-label">Crédito existente</label>
                        <select class="form-select" id="credit-select-<?= (int)$order['id']; ?>" name="credit_id">
                          <option value="">Seleccione una persona</option>
                          <?php foreach ($credits as $credit): ?>
                          <option value="<?= (int)$credit['id']; ?>">
                            <?= htmlspecialchars($credit['name'], ENT_QUOTES, 'UTF-8'); ?> (Saldo $<?= number_format((float)$credit['value'], 2); ?>)
                          </option>
                          <?php endforeach; ?>
                        </select>
                        <div class="form-text">Puede elegir un crédito existente o crear uno nuevo a continuación.</div>
                      </div>
                      <div class="mb-3">
                        <label for="credit-name-<?= (int)$order['id']; ?>" class="form-label">Crear nuevo crédito</label>
                        <input type="text" class="form-control" id="credit-name-<?= (int)$order['id']; ?>" name="credit_name" placeholder="Nombre de la persona">
                        <div class="form-text">Complete este campo para crear un nuevo crédito.</div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Guardar crédito</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php $creditModals[] = ob_get_clean(); ?>
            <?php endif; ?>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-end"><strong>Total</strong></td>
              <td><strong>$<?= number_format((float)$ordersTotal, 2); ?></strong></td>
              <td></td>
            </tr>
          </tfoot>
        </table>
        <?php foreach ($orderModals as $modal) echo $modal; ?>
        <?php foreach ($creditModals as $modal) echo $modal; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include __DIR__ . '/layout/footer.php'; ?>
