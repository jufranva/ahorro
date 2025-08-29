<?php include __DIR__ . '/layout/header.php'; ?>
<h1>Productos destacados</h1>
<ul>
<?php foreach ($products as $product): ?>
    <li>
        <strong><?= htmlspecialchars($product['title']) ?></strong>
        - $<?= number_format($product['price'], 2) ?>
    </li>
<?php endforeach; ?>
</ul>
<?php include __DIR__ . '/layout/footer.php'; ?>
