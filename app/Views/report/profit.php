<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="row">
	<div class="card">
		<div class="card-body">
			<div class="card-header">
				<h1 class="h3"><strong>Total Report</strong> <?= date('F Y'); ?></h1>
			</div>
			<div class="card-body">
				<table class="table">
					<tr>
						<th width="50%">Income</th>
						<td>: Rp. <?= number_format($income); ?></td>
					</tr>
					<tr>
						<th>Total Discount</th>
						<td>: Rp. <?= number_format($discount); ?></td>
					</tr>
					<tr>
						<th>Pick Up Fee</th>
						<td>: Rp. <?= number_format($pickupfee); ?></td>
					</tr>
					<tr>
						<th>Profit</th>
						<td>: Rp. <?= number_format($profit); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>