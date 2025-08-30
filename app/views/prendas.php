<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Prendas</h2>
        <div>
            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createGarmentModal">Crear Prenda</button>
            <button class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#categoryModal">Categorías</button>
            <button class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#tagModal">Etiquetas</button>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#stateModal">Estados</button>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Compra</th>
                <th>Venta</th>
                <th>Tipo</th>
                <th>Categoría</th>
                <th>Etiqueta</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($garments as $garment): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($garment['image_primary'], ENT_QUOTES) ?>" alt="Imagen" class="img-thumbnail" style="width:60px;"></td>
                <td><?= htmlspecialchars($garment['name']) ?></td>
                <td><?= htmlspecialchars($garment['purchase_value']) ?></td>
                <td><?= htmlspecialchars($garment['sale_value']) ?></td>
                <td><?= htmlspecialchars($garment['type']) ?></td>
                <td><?= htmlspecialchars($garment['category_name']) ?></td>
                <td>
                    <?php if (!empty($garment['tag_id'])): ?>
                    <span class="badge" style="background-color: <?= htmlspecialchars($garment['tag_bg_color']) ?>; color: <?= htmlspecialchars($garment['tag_text_color']) ?>;">
                        <?= htmlspecialchars($garment['tag_text']) ?>
                    </span>
                    <?php else: ?>
                    Ninguna
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($garment['state_name']) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editGarmentModal"
                        data-id="<?= $garment['id'] ?>"
                        data-name="<?= htmlspecialchars($garment['name'], ENT_QUOTES) ?>"
                        data-image_primary="<?= htmlspecialchars($garment['image_primary'], ENT_QUOTES) ?>"
                        data-image_secondary="<?= htmlspecialchars($garment['image_secondary'], ENT_QUOTES) ?>"
                        data-purchase="<?= $garment['purchase_value'] ?>"
                        data-sale="<?= $garment['sale_value'] ?>"
                        data-code="<?= htmlspecialchars($garment['unique_code'], ENT_QUOTES) ?>"
                        data-condition="<?= $garment['condition'] ?>"
                        data-size="<?= htmlspecialchars($garment['size'], ENT_QUOTES) ?>"
                        data-comment="<?= htmlspecialchars($garment['comment'], ENT_QUOTES) ?>"
                        data-type="<?= htmlspecialchars($garment['type'], ENT_QUOTES) ?>"
                        data-category="<?= $garment['category_id'] ?>"
                        data-tag="<?= $garment['tag_id'] ?>"
                        data-state="<?= $garment['state_id'] ?>"
                        data-pdate="<?= $garment['purchase_date'] ?>"
                        data-sdate="<?= $garment['sale_date'] ?>"
                    >Editar</button>
                    <form method="post" action="" class="d-inline" onsubmit="return confirm('¿Eliminar prenda?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $garment['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Create Garment Modal -->
<div class="modal fade" id="createGarmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="post" action="" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Crear Prenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="create">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Código único</label>
            <input type="text" class="form-control" name="unique_code" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Imagen principal</label>
            <input type="file" class="form-control" name="image_primary" accept="image/png, image/jpeg" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Imagen secundaria</label>
            <input type="file" class="form-control" name="image_secondary" accept="image/png, image/jpeg" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Valor de compra</label>
            <input type="number" step="0.01" class="form-control" name="purchase_value" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Valor de venta</label>
            <input type="number" step="0.01" class="form-control" name="sale_value" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Condición (0-100)</label>
            <input type="number" class="form-control" name="condition" min="0" max="100" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Talla</label>
            <input type="text" class="form-control" name="size" required>
          </div>
          <div class="col-12">
            <label class="form-label">Comentario</label>
            <input type="text" class="form-control" name="comment" maxlength="200">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tipo</label>
            <select class="form-select" name="type">
              <option value="nueva">Nueva</option>
              <option value="usada">Usada</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Categoría</label>
            <select class="form-select" name="category_id">
              <option value="">Seleccione</option>
              <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Etiqueta</label>
              <select class="form-select" name="tag_id">
                <option value="">Ninguna</option>
                <?php foreach ($tags as $tag): ?>
                <option value="<?= $tag['id'] ?>"><?= htmlspecialchars($tag['text']) ?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Estado</label>
            <select class="form-select" name="state_id">
              <option value="">Seleccione</option>
              <?php foreach ($states as $st): ?>
              <option value="<?= $st['id'] ?>"><?= htmlspecialchars($st['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Fecha de compra</label>
            <input type="date" class="form-control" name="purchase_date">
          </div>
          <div class="col-md-6">
            <label class="form-label">Fecha de venta</label>
            <input type="date" class="form-control" name="sale_date">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Garment Modal -->
<div class="modal fade" id="editGarmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="post" action="" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Editar Prenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" id="edit-id">
        <input type="hidden" name="current_image_primary" id="edit-current-image-primary">
        <input type="hidden" name="current_image_secondary" id="edit-current-image-secondary">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name" id="edit-name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Código único</label>
            <input type="text" class="form-control" name="unique_code" id="edit-code" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Imagen principal</label>
            <input type="file" class="form-control" name="image_primary" accept="image/png, image/jpeg">
            <img id="edit-image-primary-preview" src="" class="img-thumbnail mt-2" style="width:100px;">
          </div>
          <div class="col-md-6">
            <label class="form-label">Imagen secundaria</label>
            <input type="file" class="form-control" name="image_secondary" accept="image/png, image/jpeg">
            <img id="edit-image-secondary-preview" src="" class="img-thumbnail mt-2" style="width:100px;">
          </div>
          <div class="col-md-6">
            <label class="form-label">Valor de compra</label>
            <input type="number" step="0.01" class="form-control" name="purchase_value" id="edit-purchase" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Valor de venta</label>
            <input type="number" step="0.01" class="form-control" name="sale_value" id="edit-sale" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Condición (0-100)</label>
            <input type="number" class="form-control" name="condition" id="edit-condition" min="0" max="100" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Talla</label>
            <input type="text" class="form-control" name="size" id="edit-size" required>
          </div>
          <div class="col-12">
            <label class="form-label">Comentario</label>
            <input type="text" class="form-control" name="comment" id="edit-comment" maxlength="200">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tipo</label>
            <select class="form-select" name="type" id="edit-type">
              <option value="nueva">Nueva</option>
              <option value="usada">Usada</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Categoría</label>
            <select class="form-select" name="category_id" id="edit-category">
              <option value="">Seleccione</option>
              <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Etiqueta</label>
              <select class="form-select" name="tag_id" id="edit-tag">
                <option value="">Ninguna</option>
                <?php foreach ($tags as $tag): ?>
                <option value="<?= $tag['id'] ?>"><?= htmlspecialchars($tag['text']) ?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Estado</label>
            <select class="form-select" name="state_id" id="edit-state">
              <option value="">Seleccione</option>
              <?php foreach ($states as $st): ?>
              <option value="<?= $st['id'] ?>"><?= htmlspecialchars($st['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Fecha de compra</label>
            <input type="date" class="form-control" name="purchase_date" id="edit-pdate">
          </div>
          <div class="col-md-6">
            <label class="form-label">Fecha de venta</label>
            <input type="date" class="form-control" name="sale_date" id="edit-sdate">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Categorías</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="mb-3" method="post" action="">
          <input type="hidden" name="action" value="create_category">
          <label class="form-label">Nombre</label>
          <div class="input-group">
            <input type="text" class="form-control" name="name" required>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        <ul class="list-group">
          <?php foreach ($categories as $cat): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <form class="d-flex flex-grow-1 me-2" method="post" action="">
              <input type="hidden" name="action" value="update_category">
              <input type="hidden" name="id" value="<?= $cat['id'] ?>">
              <input type="text" name="name" class="form-control me-2" value="<?= htmlspecialchars($cat['name']) ?>">
              <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
            </form>
            <?php if ($cat['usage_count'] == 0): ?>
            <form method="post" action="" onsubmit="return confirm('¿Eliminar categoría?');">
              <input type="hidden" name="action" value="delete_category">
              <input type="hidden" name="id" value="<?= $cat['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
            <?php endif; ?>
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

<!-- Tag Modal -->
<div class="modal fade" id="tagModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Etiquetas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="mb-3" method="post" action="">
          <input type="hidden" name="action" value="create_tag">
          <div class="row g-2">
            <div class="col">
              <label class="form-label">Texto</label>
              <input type="text" class="form-control" name="text" required>
            </div>
              <div class="col-auto">
                <label class="form-label">Color</label>
                <select class="form-select" name="color" required>
                <option value="amarillo">Amarillo</option>
                <option value="azul">Azul</option>
                <option value="rojo">Rojo</option>
                <option value="verde">Verde</option>
                </select>
              </div>
            <div class="col-auto align-self-end">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
        <ul class="list-group">
          <?php foreach ($tags as $tag): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <form class="d-flex flex-grow-1 me-2" method="post" action="">
              <input type="hidden" name="action" value="update_tag">
              <input type="hidden" name="id" value="<?= $tag['id'] ?>">
              <input type="text" name="text" class="form-control me-2" value="<?= htmlspecialchars($tag['text']) ?>">
                <select name="color" class="form-select me-2">
                  <option value="amarillo" <?= $tag['color'] === 'amarillo' ? 'selected' : '' ?>>Amarillo</option>
                  <option value="azul" <?= $tag['color'] === 'azul' ? 'selected' : '' ?>>Azul</option>
                  <option value="rojo" <?= $tag['color'] === 'rojo' ? 'selected' : '' ?>>Rojo</option>
                  <option value="verde" <?= $tag['color'] === 'verde' ? 'selected' : '' ?>>Verde</option>
                </select>
              <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
            </form>
            <?php if ($tag['usage_count'] == 0): ?>
            <form method="post" action="" onsubmit="return confirm('¿Eliminar etiqueta?');">
              <input type="hidden" name="action" value="delete_tag">
              <input type="hidden" name="id" value="<?= $tag['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
            <?php endif; ?>
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

<!-- State Modal -->
<div class="modal fade" id="stateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Estados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="mb-3" method="post" action="">
          <input type="hidden" name="action" value="create_state">
          <label class="form-label">Nombre</label>
          <div class="input-group">
            <input type="text" class="form-control" name="name" required>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        <ul class="list-group">
          <?php foreach ($states as $st): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <form class="d-flex flex-grow-1 me-2" method="post" action="">
              <input type="hidden" name="action" value="update_state">
              <input type="hidden" name="id" value="<?= $st['id'] ?>">
              <input type="text" name="name" class="form-control me-2" value="<?= htmlspecialchars($st['name']) ?>">
              <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
            </form>
            <?php if ($st['usage_count'] == 0): ?>
            <form method="post" action="" onsubmit="return confirm('¿Eliminar estado?');">
              <input type="hidden" name="action" value="delete_state">
              <input type="hidden" name="id" value="<?= $st['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
            <?php endif; ?>
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

<script>
var editModal = document.getElementById('editGarmentModal');
editModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  document.getElementById('edit-id').value = button.getAttribute('data-id');
  document.getElementById('edit-name').value = button.getAttribute('data-name');
  document.getElementById('edit-code').value = button.getAttribute('data-code');
  document.getElementById('edit-current-image-primary').value = button.getAttribute('data-image_primary');
  document.getElementById('edit-current-image-secondary').value = button.getAttribute('data-image_secondary');
  document.getElementById('edit-image-primary-preview').src = button.getAttribute('data-image_primary');
  document.getElementById('edit-image-secondary-preview').src = button.getAttribute('data-image_secondary');
  document.getElementById('edit-purchase').value = button.getAttribute('data-purchase');
  document.getElementById('edit-sale').value = button.getAttribute('data-sale');
  document.getElementById('edit-condition').value = button.getAttribute('data-condition');
  document.getElementById('edit-size').value = button.getAttribute('data-size');
  document.getElementById('edit-comment').value = button.getAttribute('data-comment');
  document.getElementById('edit-type').value = button.getAttribute('data-type');
  document.getElementById('edit-category').value = button.getAttribute('data-category');
  document.getElementById('edit-tag').value = button.getAttribute('data-tag');
  document.getElementById('edit-state').value = button.getAttribute('data-state');
  document.getElementById('edit-pdate').value = button.getAttribute('data-pdate');
  document.getElementById('edit-sdate').value = button.getAttribute('data-sdate');
});
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
