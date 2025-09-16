<?php include __DIR__ . '/layout/header.php'; ?>
<div class="section section-margin">
  <div class="container">
    <h3>Cuentas</h3>
    <form method="get" class="mb-3">
      <div class="row g-2">
        <div class="col-auto">
          <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($selectedFrom, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Desde">
        </div>
        <div class="col-auto">
          <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($selectedTo, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Hasta">
        </div>
        <div class="col-auto">
          <select name="provider_id" class="form-select">
            <option value="">Todos</option>
            <?php foreach ($providers as $prov): ?>
            <option value="<?= $prov['id']; ?>" <?= $selectedProvider == $prov['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($prov['name'], ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
      </div>
    </form>
    <?php if (empty($garments)): ?>
      <p>No hay prendas vendidas.</p>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Código Único</th>
            <th>Nombre</th>
            <th>Valor</th>
            <th>Fecha de Pago</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($garments as $g): ?>
          <tr>
            <td>
              <?php $imgSrc = asset($g['image_primary']); ?>
              <img class="img-thumbnail" style="width:60px;" src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($g['name'], ENT_QUOTES, 'UTF-8'); ?>">
            </td>
            <td><?= htmlspecialchars($g['unique_code'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($g['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>$<?= number_format((float)$g['sale_value'], 2); ?></td>

            <td>
    <?php
    $fecha = new DateTime($g['sale_date']);

    // Arreglo de nombres de meses en español
    $meses = [
        1 => 'enero',
        2 => 'febrero',
        3 => 'marzo',
        4 => 'abril',
        5 => 'mayo',
        6 => 'junio',
        7 => 'julio',
        8 => 'agosto',
        9 => 'septiembre',
        10 => 'octubre',
        11 => 'noviembre',
        12 => 'diciembre'
    ];

    $dia = $fecha->format('d');
    $mes = $meses[(int)$fecha->format('m')];
    $anio = $fecha->format('Y');

    echo htmlspecialchars("$dia de $mes de $anio", ENT_QUOTES, 'UTF-8');
    ?>
</td>
     <!--
       <td>< ?= htmlspecialchars($g['sale_date'], ENT_QUOTES, 'UTF-8'); ?></td>
  -->
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="text-end"><strong>Total</strong></td>
            <td><strong>$<?= number_format((float)$total, 2); ?></strong></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
