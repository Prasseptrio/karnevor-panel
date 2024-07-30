<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> Menu </h1>
<div class="card">
	<div class="card-header">
		<form action="<?= base_url('stock-card'); ?>" method="get">
			<div class="input-group">
				<select class="form-select" id="inputProduct" name="product" aria-label="Example select with button addon">
					<option value="" selected>-- Choose Product --</option>
					<?php foreach ($Products as $product) : ?>
						<option value="<?= $product['product_id'] ?>" <?= ($inputProduct == $product['product_id']) ? 'selected' : '' ?>><?= $product['product_name']; ?></option>
					<?php endforeach; ?>
				</select>
				<button class="btn btn-dark" type="submit">Look up</button>
			</div>
		</form>
	</div>
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<thead>
				<tr class="text-center">
					<th rowspan="2">Date</th>
					<th colspan="2">Stock In</th>
					<th colspan="2">Stock Out</th>
					<th>Saldo</th>
				</tr>
				<tr class="text-center">
					<th>No. Income</th>
					<th width="15%">Quantity</th>
					<th>No. SO</th>
					<th width="15%">Quantity</th>
					<th>Quantity</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($inputProduct && $ProductStock) :
					$initStock     = $ProductStock['quantity'];
					$initNominal   = $ProductStock['nominal'];
					$COGS          = $initNominal / $initStock;
				else :
					$initStock     = 0;
					$initNominal   = 0;
					$COGS          = 0;
				endif;
				?>
				<tr class="text-center">
					<td colspan="5" class="text-center"><b>Early Stock In <?= date('Y'); ?></b></td>
					<td><?= $initStock  ?></td>
				</tr>
				<?php
				$qty_in         = 0;
				$nominal_in     = 0;
				$qty_out         = 0;
				$nominal_out     = 0;
				$nominal_saldo         = 0;
				foreach ($StockCard as $stockCard) :
					$qty_in         += $stockCard['income'];
					$qty_out        += $stockCard['outcome'];
					$qtyin          = $stockCard['income'];
					$qtyout         = $stockCard['outcome'];
					$qty_saldo      =  $initStock + $qty_in - $qty_out;
				?>
					<tr class="text-center">
						<td width="15%"><?= date('d F Y', $stockCard['created_at']) ?></td>
						<td><?= ($stockCard['income_id']) ? $stockCard['income_id'] : '' ?></td>
						<td><?= ($stockCard['income'] != 0) ? $stockCard['income'] : '' ?></td>
						<td><?= ($stockCard['sales_id']) ? $stockCard['sales_id'] : '' ?></td>
						<td><?= ($stockCard['outcome'] != 0) ? $stockCard['outcome'] : '' ?></td>
						<td><?= $qty_saldo ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?= $this->endSection(); ?>