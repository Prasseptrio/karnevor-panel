<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0"> <?= $title; ?> <a href="<?= base_url('Bank/form'); ?>" class="btn btn-dark btn-sm btn-add float-end " data-bs-toggle="modal" data-bs-target="#pettyCashForm">Create New Loan</a></h5>
	</div>
	<div class="card-body">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="payable-tab" data-bs-toggle="tab" data-bs-target="#payable-tab-pane" type="button" role="tab" aria-controls="payable-tab-pane" aria-selected="true">Payable</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="receivable-tab" data-bs-toggle="tab" data-bs-target="#receivable-tab-pane" type="button" role="tab" aria-controls="receivable-tab-pane" aria-selected="false">Receivable</button>
			</li>

		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="payable-tab-pane" role="tabpanel" aria-labelledby="payable-tab" tabindex="0">
				<div class="table-responsive">
					<table class="table table-hover ">
						<thead>
							<tr>
								<th>#</th>
								<th>Loan Date</th>
								<th>Loan To</th>
								<th>Loan Amount</th>
								<th>Rest Loan</th>
								<th>Loan Due Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($FinanceLoans as $financeloan) : if ($financeloan['loan_category'] == 1) : ?>
									<tr>
										<td><?= $no++; ?></td>
										<td>
											<?php
											$loanDate = new DateTime($financeloan['loan_date']);
											echo $loanDate->format('d F Y');
											?>
										</td>
										<td><?= $financeloan['loan_to'] ?> </td>
										<td>Rp. <?= number_format($financeloan['loan_amount']) ?> </td>
										<td>Rp. <?= number_format($financeloan['rest_loan']) ?> </td>
										<td>
											<?php
											$loanDate = new DateTime($financeloan['loan_due_date']);
											echo $loanDate->format('d F Y');
											?>
										</td>
										<td><?= ($financeloan['loan_status'] == 0) ? 'UNPAID' : 'PAID' ?> </td>
										<td>
											<a href="<?= base_url('loan?id=' . $financeloan['loan_id']); ?> " class="btn btn-outline-dark ">
												Details
											</a>
										</td>
									</tr>
							<?php endif;
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane fade" id="receivable-tab-pane" role="tabpanel" aria-labelledby="receivable-tab" tabindex="0">
				<div class="table-responsive">
					<table class="table table-hover ">
						<thead>
							<tr>
								<th>#</th>
								<th>Loan Date</th>
								<th>Loan To</th>
								<th>Loan Amount</th>
								<th>Rest Loan</th>
								<th>Loan Due Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($FinanceLoans as $financeloan) : if ($financeloan['loan_category'] == 0) : ?>
									<tr>
										<td><?= $no++; ?></td>
										<td>
											<?php
											$loanDate = new DateTime($financeloan['loan_date']);
											echo $loanDate->format('d F Y');
											?>
										</td>
										<td><?= $financeloan['loan_to'] ?> </td>
										<td>Rp. <?= number_format($financeloan['loan_amount']) ?> </td>
										<td>Rp. <?= number_format($financeloan['rest_loan']) ?> </td>
										<td>
											<?php
											$loanDate = new DateTime($financeloan['loan_due_date']);
											echo $loanDate->format('d F Y');
											?>
										</td>
										<td><?= ($financeloan['loan_status'] == 0) ? 'UNPAID' : 'PAID' ?> </td>
										<td>
											<a href="<?= base_url('loan?id=' . $financeloan['loan_id']); ?> " class="btn btn-outline-dark ">
												Details
											</a>
										</td>
									</tr>
							<?php endif;
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="pettyCashForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form action="<?= base_url('loan/create'); ?>" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Create New Loan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="inputLoansID" id="inputLoansID">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group my-3">
								<label for="inputLoanTo">Loan To</label>
								<input type="text" class="form-control" name="inputLoanTo" id="inputLoanTo" required>
							</div>
							<div class="form-group my-3">
								<label for="inputLoanAmount">Loan Amount</label>
								<input type="number" min="0" class="form-control" name="inputLoanAmount" id="inputLoanAmount" required>
							</div>
							<div class="form-group my-3">
								<label for="inputLoanInterest">Loan Interest</label>
								<div class="input-group">
									<input type="text" class="form-control" name="inputLoanInterest" id="inputLoanInterest">
									<span class="input-group-text">%</span>
								</div>
							</div>
							<div class="form-group my-3">
								<label for="inputLoanTerm">Loan Term</label>
								<div class="input-group">
									<input type="number" min="0" class="form-control" name="inputLoanTerm" id="inputLoanTerm" required>
									<span class="input-group-text">Month</span>
								</div>
							</div>
							<div class="form-group my-3">
								<label for="inputLoanDueDate">Loan Due Date</label>
								<input type="date" class="form-control" name="inputLoanDueDate" id="inputLoanDueDate" required>
							</div>

						</div>
						<div class="col-sm-6">
							<div class="form-group my-3">
								<label for="inputLoanCategory">Loan Category</label>
								<select name="inputLoanCategory" id="inputLoanCategory" class="form-select" required>
									<option value="">-- Choose Loan Type --</option>
									<option value="0">Receivable</option>
									<option value="1">Payable</option>
								</select>
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
							<div class="form-group my-3">
								<label for="inputLoanDescription">Loan Description</label>
								<textarea name="inputLoanDescription" id="inputLoanDescription" class="form-control" cols="30" rows="8"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
		</form>
	</div>
</div>


<?= $this->endSection(); ?>