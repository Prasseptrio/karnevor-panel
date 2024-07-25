<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0"> <?= $title; ?> Detail
			<?php if ($Reservation['status'] == 0) : ?>
				<a class="btn rounded btn-dark float-end" href="<?= base_url('reservation/cancel?id=' . $Reservation['reservation_id']); ?>"> <i class="align-middle" data-feather="x-square"></i> Cancel</a>
				<button class="btn rounded btn-secondary float-end" data-bs-toggle="modal" data-bs-target="#reschedule"> <i class="align-middle" data-feather="shuffle"></i> Reschedule</button>
				<a class="btn rounded btn-dark float-end" href="<?= base_url('reservation/Approved?id=' . $Reservation['reservation_id']); ?>"> <i class="align-middle" data-feather="clipboard"></i> Approve</a>
				<a class="btn rounded btn-secondary float-end" href="<?= base_url('reservation/followUp?id=' . $Reservation['reservation_id']); ?>"> <i class="align-middle" data-feather="phone-outgoing"></i> Follow-up</a>
			<?php else : ?>
				<?php
				$reservStatus = $Reservation['status'];
				switch ($reservStatus) {
					case '1':
						$status = "Approved";
						break;
					case '3':
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
						<h6 class="fw-bold">Grooming Space Indonesia </h6>
						<p>
							Jl. Tajem Maguwoharjo, Sleman Yogyakarta
							<br> halo@groomingspace.id | www.groomingspace.id
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
						<th class="fw-bold"><?= $Reservation['customer_address'] ?></th>
					</tr>
					<tr>
						<th>Customer Telephone</th>
						<th>:</th>
						<th class="fw-bold"><?= $Reservation['customer_telephone'] ?></th>
					</tr>
					<tr>
						<th>Customer Email</th>
						<th>:</th>
						<th class="fw-bold"><?= $Reservation['customer_email'] ?></th>
					</tr>
					<tr>
						<th>Reservation Date</th>
						<th>:</th>
						<th class="fw-bold"><?= date('d F Y', strtotime($Reservation['reservation_date'])) ?></th>
					</tr>
				</table>
			</div>
			<?php if ($Reservation['status'] == 1) : ?>
				<div class="row my-4">
					<a class="btn btn-secondary" href="<?= base_url('poservice?id=' . $Reservation['reservation_id']); ?>"> Create Service Order</a>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-sm-7">
			<div class="row">
				<h4 class="text-center fw-bold mb-2">Pet Details</h4>
			</div>
			<div class="table-responsive">
				<table class="table table-hover my-0 ">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Age</th>
							<th>Ras</th>
							<th>Color</th>
							<th>Service</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($ReservationDetail as $reservDetail) : ?>
							<tr>
								<td><?= $no++ ?> </td>
								<td><?= $reservDetail['pet_name'] ?> </td>
								<td><?= $reservDetail['pet_age'] ?> </td>
								<td><?= $reservDetail['pet_ras'] ?> </td>
								<td><?= $reservDetail['pet_color'] ?> </td>
								<td><?= $reservDetail['service_package_name'] ?> </td>
							</tr>
						<?php endforeach; ?>
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
				<input type="hidden" name="id" value="<?= $Reservation['reservation_id']; ?>">
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