<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0"> Operational Cost List <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#operationalCostForm">Add New Operational Cost</button></h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover my-0 datatable">
				<thead>
					<tr>
						<th>#</th>
						<th>Transaction Date</th>
						<th>Cost Invoice</th>
						<th>Branch</th>
						<th>Description</th>
						<th>Bill</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($OperationalCost as $operationalCost) : ?>
						<tr>
							<td><?= $no++; ?></td>
							<td> <?php
									$transactionDate = new DateTime($operationalCost['transaction_date']);
									echo $transactionDate->format('d F Y');
									?>
							</td>
							<td><?= $operationalCost['cost_invoice'] ?> </td>
							<td><?= ($operationalCost['branch_id'] <= 2) ? 'GS Maguwoharjo' : 'GS Giwangan' ?> </td>
							<td><?= $operationalCost['description'] ?> </td>
							<td>Rp. <?= number_format($operationalCost['bill']) ?> </td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="operationalCostForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

			</div>
			<form action="<?= base_url('operational-cost/create'); ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group my-1">
								<label for="inputCostCategory" class="my-1">Cost Category</label>
								<select name="inputCostCategory" id="inputCostCategory" class="form-select" required>
									<option value="">-- Choose Category --</option>
									<?php foreach ($CostCategories as $category) : ?>
										<option value="<?= $category['cost_category_id']; ?>"><?= $category['cost_category_name']; ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group my-1">
								<label for="inputTransactionDate" class="my-1">Transaction Date</label>
								<input type="date" class="form-control" name="inputTransactionDate" id="inputTransactionDate" required>
							</div>
						</div>
					</div>

					<div class="form-group my-1">
						<label for="inputCostInvoice" class="my-1">Cost Invoice</label>
						<input type="text" class="form-control" name="inputCostInvoice" id="inputCostInvoice" required>
					</div>
					<div class="form-group my-1">
						<label for="inputBill" class="my-1">Amount</label>
						<div class="input-group">
							<span class="input-group-text">Rp.</span>
							<input type="number" class="form-control" name="inputBill" id="inputBill" required>
							<input class="form-control" type="file" id="bill-attachment" name="inputBillAttachment" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group my-3">
								<label for="inputPettyCash" class="my-1">Payment Account</label>
								<select name="inputPettyCash" id="inputPettyCash" class="form-select">
									<option value="">-- Choose Petty Cash --</option>
									<?php foreach ($PettyCash as $pettycash) : ?>
										<option value="<?= $pettycash['petty_cash_id']; ?>"><?= $pettycash['alias']; ?> <?= $pettycash['bank_name']; ?> </option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						<div class="col-sm-6">
							<div class="form-group my-3">
								<label for="inputBranch" class="my-1">Branch</label>
								<select name="inputBranch" id="inputBranch" class="form-select">
									<option value="">-- Choose Branch --</option>
									<option value="1">GS Maguwoharjo </option>
									<option value="2">GS Giwangan</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group my-1">
						<label for="inputDescription" class="my-1">Description</label>
						<textarea name="inputDescription" id="inputDescription" cols="30" rows="2" class="form-control" required></textarea>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>