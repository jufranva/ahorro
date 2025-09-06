<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <h1>Carrito</h1>
    <?php if (empty($items)): ?>
      <p>Tu carrito está vacío.</p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?= (int)$item['quantity']; ?></td>
              <td>$<?= number_format((float)$item['sale_value'] * $item['quantity'], 2); ?></td>
              <td>
                <form method="post" action="<?= htmlspecialchars(asset('cart.php'), ENT_QUOTES, 'UTF-8'); ?>">
                  <input type="hidden" name="action" value="remove">
                  <input type="hidden" name="id" value="<?= (int)$item['id']; ?>">
                  <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p class="text-end">
        Total: $<?= number_format(array_reduce($items, fn($carry, $i) => $carry + $i['sale_value'] * $i['quantity'], 0), 2); ?>
      </p>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
