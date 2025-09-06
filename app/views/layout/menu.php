<?php
$menuItems = [
    ['href' => 'index.php', 'label' => 'INICIO'],
    ['href' => 'nueva.php', 'label' => 'NUEVOS'],
    ['href' => 'usada.php', 'label' => '2DA MANO'],
];

require_once __DIR__ . '/../../models/Cart.php';
$cartCount = Cart::count();
$menuItems[] = ['href' => 'cart.php', 'label' => $cartCount > 0 ? 'CARRITO (' . $cartCount . ')' : 'CARRITO'];

if (isset($_SESSION['username'])) {
    $menuItems[] = ['href' => 'prendas.php', 'label' => 'PRENDAS'];
    $menuItems[] = ['href' => 'logout.php', 'label' => 'CERRAR SESION'];
} else {
    $menuItems[] = ['href' => 'inicio.php', 'label' => 'INICIAR SESION'];
}

foreach ($menuItems as $item) {
    $href = htmlspecialchars(asset($item['href']), ENT_QUOTES, 'UTF-8');
    $label = htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8');
    echo "    <li class=\"has-children\"><a href=\"$href\">$label </a></li>\n";
}
?>
