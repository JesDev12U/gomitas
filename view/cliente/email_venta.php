<h2>¡Gracias por su compra!</h2>
<p>¡Su venta <?= $id_venta ?> se ha creado exitosamente!</p>
<p>Puede ir al establecimiento indicando su número de venta para poder recoger los productos.</p>
<h3>Ticket de compra</h3>
<table class="ticket-table">
  <thead>
    <tr>
      <th>Imagen</th>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    foreach ($ticket as $item):
      $total += $item['importe'];
    ?>
      <tr>
        <td>
          <img src="cid:<?= htmlspecialchars($item['cid']) ?>" alt="Imagen producto" class="ticket-img">
        </td>
        <td><?= htmlspecialchars($item['nombre']) ?></td>
        <td><?= (int)$item['cantidad'] ?></td>
        <td>$<?= number_format($item['importe'], 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="ticket-total">
  Total: $<?= number_format($total, 2) ?>
</div>