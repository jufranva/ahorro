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
            <option value="credit" <?= $currentStatus === 'credit' ? 'selected' : ''; ?>>A Crédito</option>
            <option value="paid" <?= $currentStatus === 'paid' ? 'selected' : ''; ?>>Pagados</option>
            <option value="rejected" <?= $currentStatus === 'rejected' ? 'selected' : ''; ?>>Rechazados</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
        <div class="col-auto">
          <!-- Link to cuentas.php page -->
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
            <th>Entregado</th>
            <th>Acciones</th>
          </tr>
        </thead>
          <tbody>
          <?php $orderModals = []; $creditModals = []; $contributionModals = []; foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['buyer_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($order['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($order['payment_method'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="text-center">
              <?php
                $iconClass = 'fa fa-clock-o text-warning';
                $orden= 'Pedido Pendiente';
                if ($order['status'] === 'confirmed') {
                    $iconClass = 'fa fa-check text-success';
                    $orden= 'Pedido Confirmado';
                } elseif ($order['status'] === 'credit') {
                    $iconClass = 'fa fa-credit-card text-info';
                    $orden= 'Pedido a crédito';
                } elseif ($order['status'] === 'paid') {
                    $iconClass = 'fa fa-money text-primary';
                    $orden= 'Pedido Pagado';
                } elseif ($order['status'] === 'rejected') {
                    $iconClass = 'fa fa-times-circle text-danger';
                    $orden= 'Pedido Rechazado';
                }
              ?>
              <i class="<?= $iconClass; ?>" title="<?= htmlspecialchars($orden, ENT_QUOTES, 'UTF-8'); ?>"></i>
              <?php if (!empty($order['credit_name'])): ?>
                <div>
                  <small class="text-muted">
                    Crédito: <?= htmlspecialchars($order['credit_name'], ENT_QUOTES, 'UTF-8'); ?>
                    <?php if ($order['status'] === 'credit' && isset($order['credit_value'])): ?>
                      (Saldo general $<?= number_format((float)$order['credit_value'], 2); ?>)
                    <?php endif; ?>
                  </small>
                </div>
                <?php if (isset($order['contributed_total'])): ?>
                <div>
                  <small class="text-muted">
                    Abonado: $<?= number_format((float)($order['contributed_total'] ?? 0), 2); ?>
                    <?php if ($order['status'] === 'credit'): ?>
                      | Saldo del pedido: $<?= number_format((float)max($order['outstanding'] ?? 0, 0), 2); ?>
                    <?php endif; ?>
                  </small>
                </div>
                <?php endif; ?>
              <?php endif; ?>
            </td>
            <td>$<?= number_format((float)$order['total'], 2); ?></td>
            <td class="text-center">
              <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="action" value="toggle_entregado">
                <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                <input type="hidden" name="entregado" value="<?= (int)($order['entregado'] ? 0 : 1); ?>">
                <?php $entregadoActivo = !empty($order['entregado']); ?>
                <button type="submit" class="btn btn-sm <?= $entregadoActivo ? 'btn-success' : 'btn-danger'; ?>">
                  <?= $entregadoActivo ? 'SI' : 'NO'; ?>
                </button>
              </form>
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
              <button type="button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#credit-order-<?= (int)$order['id']; ?>">Crédito</button>
              <?php elseif ($order['status'] === 'credit'): ?>
              <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#credit-contributions-<?= (int)$order['id']; ?>">Abonar pago</button>
              <?php elseif ($order['status'] === 'paid'): ?>
              <?php if (!empty($order['credit_id'])): ?>
              <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#credit-contributions-<?= (int)$order['id']; ?>">Ver abonos</button>
              <?php endif; ?>
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
            <?php if (!empty($order['credit_id'])): ?>
            <?php ob_start(); ?>
            <div class="modal fade" id="credit-contributions-<?= (int)$order['id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="action" value="contribute">
                    <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                    <div class="modal-header">
                      <h5 class="modal-title">Abonos del pedido #<?= (int)$order['id']; ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <?php
                        $orderTotal = isset($order['total']) ? (float)$order['total'] : 0.0;
                        $contributedTotal = isset($order['contributed_total']) ? (float)$order['contributed_total'] : 0.0;
                        $outstandingAmount = isset($order['outstanding']) ? (float)$order['outstanding'] : max($orderTotal - $contributedTotal, 0.0);
                        $pendingAmount = max($outstandingAmount, 0.0);
                      ?>
                      <div class="mb-3">
                        <p class="mb-1"><strong>Valor del pedido:</strong> $<?= number_format($orderTotal, 2); ?></p>
                        <p class="mb-1"><strong>Abonado:</strong> $<?= number_format($contributedTotal, 2); ?></p>
                        <p class="mb-0"><strong>Saldo pendiente:</strong> $<?= number_format($pendingAmount, 2); ?></p>
                      </div>
                      <?php if (!empty($order['contributions'])): ?>
                      <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Valor</th>
                              <th>Fecha</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($order['contributions'] as $indexContribution => $contribution): ?>
                            <?php
                              $formattedDate = '';
                              if (!empty($contribution['contributed_at'])) {
                                  $timestamp = strtotime($contribution['contributed_at']);
                                  if ($timestamp !== false) {
                                      $formattedDate = date('d/m/Y H:i', $timestamp);
                                  }
                              }
                            ?>
                            <tr>
                              <td><?= (int)$indexContribution + 1; ?></td>
                              <td>$<?= number_format((float)$contribution['amount'], 2); ?></td>
                              <td><?= htmlspecialchars($formattedDate, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                      <?php else: ?>
                      <p class="text-muted">Aún no hay abonos registrados para este pedido.</p>
                      <?php endif; ?>
                      <?php if ($order['status'] === 'credit' && $pendingAmount > 0): ?>
                      <div class="mb-3">
                        <label for="contribution-amount-<?= (int)$order['id']; ?>" class="form-label">Valor del abono</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" id="contribution-amount-<?= (int)$order['id']; ?>" name="amount" placeholder="Ej. 50000" max="<?= number_format($pendingAmount, 2, '.', ''); ?>" required>
                        <div class="form-text">Ingrese un valor menor o igual al saldo pendiente.</div>
                      </div>
                      <div class="mb-0">
                        <label for="contribution-date-<?= (int)$order['id']; ?>" class="form-label">Fecha del abono</label>
                        <input type="date" class="form-control" id="contribution-date-<?= (int)$order['id']; ?>" name="contributed_at">
                        <div class="form-text">Si no selecciona una fecha se usará la actual.</div>
                      </div>
                      <?php else: ?>
                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        <p class="text-success mb-0">Este pedido no tiene saldo pendiente.</p>
                        <?php if ($order['status'] === 'credit'): ?>
                        <form method="post" action="<?= htmlspecialchars(asset('pedidos.php'), ENT_QUOTES, 'UTF-8'); ?>" class="mb-0">
                          <input type="hidden" name="action" value="pay">
                          <input type="hidden" name="id" value="<?= (int)$order['id']; ?>">
                          <button type="submit" class="btn btn-sm btn-primary">Pagado</button>
                        </form>
                        <?php endif; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <?php if ($order['status'] === 'credit' && $pendingAmount > 0): ?>
                      <button type="submit" class="btn btn-primary">Guardar abono</button>
                      <?php endif; ?>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php $contributionModals[] = ob_get_clean(); ?>
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
        <?php foreach ($contributionModals as $modal) echo $modal; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include __DIR__ . '/layout/footer.php'; ?>
