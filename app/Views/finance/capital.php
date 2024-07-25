<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0"> <?= $title; ?> <button type="button" class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#capitalForm">
				Add New Capital
			</button></h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover my-0">
				<thead>
					<tr>
						<th>#</th>
						<th>Investor</th>
						<th>Capital Amount</th>
						<th>Capital Date</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($FinanceCapital as $financecapital) : ?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $financecapital['investor_name'] ?> </td>
							<td><?= number_format($financecapital['capital_amount']) ?> </td>
							<td>
								<?php
								$capitalDate = new DateTime($financecapital['capital_date']);
								echo $capitalDate->format('d F Y');
								?>
							</td>

						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="capitalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="capitalForm" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="capitalFormLabel">Add New Capital</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('capital/create'); ?>" method="post">
				<div class="modal-body">
					<div class="form-group my-3">
						<label class="mb-2" for="inputInvestor">Investor</label>
						<select name="inputInvestor" id="inputInvestor" class="form-select">
							<option value="">-- Choose Investor --</option>
							<?php foreach ($Investor as $investor) : ?>
								<option value="<?= $investor['investor_id']; ?>"><?= $investor['investor_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group my-3">
						<label class="mb-2" for="inputCapitalAmount">Capital Amount</label>
						<input type="number" class="form-control" name="inputCapitalAmount" id="inputCapitalAmount" required>
					</div>
					<div class="form-group my-3">
						<label class="mb-2" for="inputCapitalDate">Capital Date</label>
						<input type="date" class="form-control" name="inputCapitalDate" id="inputCapitalDate" required>
					</div>
					<div class="form-group my-3">
						<label for="inputPettyCash">Bank Transfer</label>
						<select name="inputPettyCash" id="inputPettyCash" class="form-select">
							<option value="">-- Choose Petty Cash --</option>
							<?php foreach ($PettyCash as $pettycash) : ?>
								<option value="<?= $pettycash['petty_cash_id']; ?>"><?= $pettycash['alias']; ?> <?= $pettycash['bank_name']; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
					<!-- <div class="form-group my-3">
						<label class="mb-2" for="inputCapitalProof">Capital Proof</label>
						<input type="file" class="form-control" name="inputCapitalProof" id="inputCapitalProof" required>
					</div> -->
				</div>
				<div class="modal-footer">
					<div class="d-grid gap-2 mt-3">
						<button class="btn btn-dark" type="submit">Save Data</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>