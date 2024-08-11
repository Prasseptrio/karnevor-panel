<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0"> <?= $title; ?> Detail
			<?php if ($Reservation['status'] == 1) :
				if (substr($Reservation['customer_whatsapp'], 0, 1) == '+') {
					$string = str_replace('-', '', $Reservation['customer_whatsapp']);
					$replace = str_replace(' ', '', $string);
					$nomor = str_replace('+', '', $replace);
				} else {
					$string = ltrim($Reservation['customer_whatsapp'], '0');
					$nomor = '62' . $string;
				}
			?>
				<a class="btn rounded btn-dark float-end" href="<?= base_url('reservation/cancel?id=' . $Reservation['order_id']); ?>"> <i class="align-middle" data-feather="x-square"></i> Cancel</a>
				<button class="btn rounded btn-secondary float-end" data-bs-toggle="modal" data-bs-target="#reschedule"> <i class="align-middle" data-feather="shuffle"></i> Reschedule</button>
				<a class="btn rounded btn-dark float-end" href="<?= base_url('posale?id=' . $Reservation['order_id']); ?>"> <i class="align-middle" data-feather="clipboard"></i> Approve</a>
				<a class="btn rounded btn-secondary float-end" href="https://wa.me/<?= $nomor; ?>"> <i class="align-middle" data-feather="phone-outgoing"></i> Follow-up</a>
			<?php else : ?>
				<?php
				$reservStatus = $Reservation['status'];
				switch ($reservStatus) {
					case '2':
						$status = "Approved";
						break;
					case '4':
						$status = "Success";
						break;
					default:
						$status = "Cancel";
						break;
				} ?>
				<span class="text-5 fw-bold float-end">Status : <span class="<?= ($Reservation['status'] == 1 || $Reservation['status'] == 3) ? 'text-dark' : 'text-secondary'; ?>"><?= $status  ?></span></span>
			<?php endif; ?>
		</h5>
		<hr class="mt-4">
	</div>
	<div class="card-body row">
		<div class="col-sm-5">
			<div class="row">
				<div class="col-sm-3">
					<img src="<?= base_url('assets/images/logo.png'); ?>" alt="Bonty Logo" class="img-fluid">
				</div>
				<div class="col-sm-9">
					<div class="mt-3">
						<h6 class="fw-bold">Karnevor Indonesia </h6>
						<p>
							Jl. Emplak No.183, Pendrikan Kidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50131
							<br> halo@karnevorindonesia.id | www.karnevorindonesia.id
						</p>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<h4 class="text-center fw-bold mb-2">Customer Detail</h4>
			</div>
			<div class="table-responsive">
				<table class="table table-hover my-0">
					<tr>
						<th>Customer Fullname </th>
						<th>:</th>
						<th class="fw-bold"><?= $Reservation['customer_fullname'] ?></th>
					</tr>
					<tr>
						<th>Customer Address</th>
						<th>:</th>
						<th class="fw-bold"><?= $Reservation['address'] ?></th>
					</tr>
					<tr>
						<th>Customer Telephone</th>
						<th>:</th>
						<th class="fw-bold"><?= $Reservation['customer_whatsapp'] ?></th>
					</tr>
					<tr>
						<th>Customer Email</th>
						<th>:</th>
						<th class="fw-bold"><?= $Reservation['customer_email'] ?></th>
					</tr>
					<tr>
						<th>Reservation Date</th>
						<th>:</th>
						<th class="fw-bold"><?= date('d F Y', strtotime($Reservation['transaction_date'])) ?></th>
					</tr>
					<tr>
						<th>Payment Proof</th>
						<th>:</th>
						<th class="fw-bold"><img src="<?= base_url() . 'assets/images/customers/' . $Reservation['customer_id'] . '/paymentProof/' . $Reservation['payment_proof']; ?>" alt=""></th>
					</tr>
				</table>
			</div>
			<?php if ($Reservation['status'] == 1) : ?>
				<div class="row my-4">
					<!-- <a class="btn btn-secondary" href="<?= base_url('poservice?id=' . $Reservation['order_id']); ?>"> Create Service Order</a> -->
				</div>
			<?php endif; ?>
		</div>
		<div class="col-sm-7">
			<div class="row">
				<h4 class="text-center fw-bold mb-2">Order Details</h4>
			</div>
			<div class="table-responsive">
				<table class="table table-hover my-0 ">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($ReservationProduct as $product) : ?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $product['order_product_name']; ?></td>
								<td><?= $product['price']; ?></td>
								<td><?= $product['quantity']; ?></td>
								<td><?= number_format($product['total']); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<table class="table">
					<tbody id="additionalForm">
						<tr>
							<td>Total</td>
							<td>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp.</span>
									</div>
									<input type="text" name="inputTotal" class="form-control" id="totalView" value="<?= number_format($Reservation['total']); ?>" readonly>
								</div>
							</td>
						</tr>
						<tr>
							<td>Discount</td>
							<td>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp.</span>
									</div>
									<input type="number" class="form-control" name="inputDiscount" id="discount" value="<?= number_format($Reservation['sales_order_discount']); ?>" readonly>
								</div>
							</td>
						</tr>
						<tr>
							<td>Tax Rate 10%</td>
							<td>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp.</span>
									</div>
									<input type="text" class="form-control" name="inputTax" id="tax" value="<?= number_format($Reservation['sales_order_tax']); ?>" readonly>
								</div>
							</td>
						</tr>
						<tr>
							<td>Payment Method</td>
							<td>
								<?php if ($Reservation['payment_method'] == 1) : echo "Cash";
								elseif ($Reservation['payment_method'] == 2) : echo "Qris BCA";
								else : echo "Transfer BCA";
								endif ?>
							</td>
						</tr>
						<tr>
							<td><b>GRAND TOTAL</b></td>
							<td>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp.</span>
									</div>
									<input type="text" class="form-control" name="grandTotal" id="grandTotal" value="<?= number_format($Reservation['total'] - $Reservation['sales_order_discount'] + $Reservation['sales_order_tax']); ?>" readonly>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="reschedule" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="card-title mb-0"> Reschadule Reservation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('reservation/reschadule'); ?>" method="post">
				<input type="hidden" name="id" value="<?= $Reservation['order_id']; ?>">
				<div class="modal-body">
					<div class="form-group">
						<input type="date" class="form-control" name="reservation_date" id="reservationDate" placeholder="Nama Hooman" required>
					</div>
					<div class="modal-footer">
						<button class="btn btn-dark" type="submit">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('javascript'); ?>
<?= $this->endSection(); ?>