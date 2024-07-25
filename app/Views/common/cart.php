<?php
$no = 1;
foreach ($Carts as $item) :
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $item['name']; ?></td>
        <td><?= $item['qty'] ?></td>
        <td>Rp. <?= number_format($item['price']) ?></td>
        <td>Rp. <?= number_format($item['subtotal']) ?></td>
        <td>
            <input type="hidden" name="inputTotal" id="total" value="<?= $Total; ?>">
            <button type="button" id="<?= $item['rowid'] ?>" class="removeItemCart btn btn-outline-dark btn-sm">Delete</button>
        </td>
    </tr>
<?php endforeach; ?>