<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong></h1>

<div class="row">
	<div class="col-sm-5">
		<div class="card">
			<div class="card-body">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="maguro-tab" data-bs-toggle="tab" data-bs-target="#maguro-tab-pane" type="button" role="tab" aria-controls="maguro-tab-pane" aria-selected="true">Maguwoharjo</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="giwangan-tab" data-bs-toggle="tab" data-bs-target="#giwangan-tab-pane" type="button" role="tab" aria-controls="giwangan-tab-pane" aria-selected="false">Giwangan</button>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="maguro-tab-pane" role="tabpanel" aria-labelledby="maguro-tab" tabindex="0">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>Transaction Date</th>
									<th>Total Income</th>
									<th>Total Pickup</th>
								</thead>
								<tbody>
									<?php if ($ServiceIncomeMaguwo) : ?>
										<?php foreach ($ServiceIncomeMaguwo as $ServiceIncmgw) : ?>
											<tr>
												<td>
													<a href="<?= base_url('service-report?day=' . $ServiceIncmgw['transaction_date']); ?>"><?= $ServiceIncmgw['transaction_date']; ?> </a>
												</td>
												<td>Rp. <?= number_format($ServiceIncmgw['service_order_discount']); ?></td>
												<td>Rp. <?= number_format($ServiceIncmgw['service_order_total']); ?></td>
												<td>Rp. <?= number_format($ServiceIncmgw['pickup_fee']); ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td colspan="3" class="text-center text-danger"><i> <b>You don't have transaction!</b> <br> Wake up and make money !!!</i></td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="giwangan-tab-pane" role="tabpanel" aria-labelledby="giwangan-tab" tabindex="0">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>Transaction Date</th>
									<th>Total Income</th>
									<th>Total Pickup</th>
								</thead>
								<tbody>
									<?php if ($ServiceIncomeGiwangan) : ?>
										<?php foreach ($ServiceIncomeGiwangan as $ServiceIncgwg) : ?>
											<tr>
												<td>
													<a href="<?= base_url('service-report?day=' . $ServiceIncgwg['transaction_date']); ?>"><?= $ServiceIncgwg['transaction_date']; ?> </a>
												</td>
												<td>Rp. <?= number_format($ServiceIncgwg['service_order_discount']); ?></td>
												<td>Rp. <?= number_format($ServiceIncgwg['service_order_total']); ?></td>
												<td>Rp. <?= number_format($ServiceIncgwg['pickup_fee']); ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td colspan="3" class="text-center text-danger"><i> <b>You don't have transaction!</b> <br> Wake up and make money !!!</i></td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<div class="card" <?= ($ServicesToday) ? '' : 'hidden'; ?>>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<th>Branch</th>
								<th>Customer Name</th>
								<th class="d-none d-xl-table-cell">Total</th>
								<th class="d-none d-xl-table-cell">Discount</th>
								<th class="d-none d-xl-table-cell">Pickup Fee</th>
								<th class="d-none d-md-table-cell">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($ServicesToday as $service) : ?>
								<tr>
									<td><?= ($service['branch_id'] == 1) ? "Maguwoharjo" : "Giwangan"; ?></td>
									<td><?= $service['customer_fullname']; ?></td>
									<td>Rp. <?= number_format($service['service_order_discount']); ?></td>
									<td>Rp. <?= number_format($service['service_order_total']); ?></td>
									<td>Rp. <?= number_format($service['pickup_fee']); ?></td>
									<td class="d-none d-md-table-cell">
										<a href="<?= base_url('poservice/print?inv=' . $service['service_order_invoices']); ?>" class="btn btn-sm btn-primary"> Detail</a>
									</td>
								</tr>
							<?php endforeach; ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>