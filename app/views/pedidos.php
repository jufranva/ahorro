<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <h3>Pedidos</h3>
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
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['buyer_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($order['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($order['payment_method'], ENT_QUOTES, 'UTF-8'); ?></td>
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
              <?php endif; ?>
            </td>
          </tr>
          <div class="modal fade" id="order-<?= (int)$order['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Prendas del pedido #<?= (int)$order['id']; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <ul class="list-group">
                  <?php foreach ($order['items'] as $item): ?>
                    <li class="list-group-item">
                      <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?> x<?= (int)$item['quantity']; ?>
                    </li>
                  <?php endforeach; ?>
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
