<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<?= $this->include('common/alerts'); ?>
<div class="card">
	<div class="card-header">
		<div class="row col-sm-12">
			<div class="row mb-4">
				<div class="col-sm-4">
					<h5 class="card-title mb-0"> <?= $title; ?> List</h5>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" name="date" id="lookDate">
				</div>
				<div class="col-sm-4 float-end">
					<button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#reservationForm">Create New Reservation</button>
				</div>
			</div>
			<hr>
		</div>

		<div class="card-body ">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="payable-tab" data-bs-toggle="tab" data-bs-target="#payable-tab-pane" type="button" role="tab" aria-controls="payable-tab-pane" aria-selected="true">Waiting</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="approve-tab" data-bs-toggle="tab" data-bs-target="#approve-tab-pane" type="button" role="tab" aria-controls="approve-tab-pane" aria-selected="false">Approve</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="cancel-tab" data-bs-toggle="tab" data-bs-target="#cancel-tab-pane" type="button" role="tab" aria-controls="cancel-tab-pane" aria-selected="false">Cancel</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="success-tab" data-bs-toggle="tab" data-bs-target="#success-tab-pane" type="button" role="tab" aria-controls="success-tab-pane" aria-selected="false">Success</button>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="payable-tab-pane" role="tabpanel" aria-labelledby="payable-tab" tabindex="0">
					<div class="table-responsive">
						<table class="table table-hover my-0 ">
							<thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">Reservation Date</th>
									<th rowspan="2">Customer Telephone</th>
									<th rowspan="2">Customer Name</th>
									<th rowspan="2" class="text-center">Notes</th>
									<th rowspan="2">Booking At</th>
									<th rowspan="2">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($ReservationWait as $wait) : ?>
									<tr>
										<td><?= $no++ ?> </td>
										<td><?= date('d-m-Y', strtotime($wait['reservation_date'])) ?> </td>
										<td><?= $wait['customer_telephone'] ?> </td>
										<td><?= $wait['customer_name'] ?> </td>

										<td><?= $wait['notes'] ?> </td>
										<td><?= date('d-m-Y', $wait['created_at']) ?> </td>
										<td>
											<a class="btn btn-info btn-sm" href="<?= base_url('reservation?id=' . $wait['reservation_id']); ?>"> <i class="align-middle" data-feather="eye"></i> Detail</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="approve-tab-pane" role="tabpanel" aria-labelledby="approve-tab" tabindex="0">
					<div class="table-responsive">
						<table class="table table-hover my-0 ">
							<thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">Reservation Date</th>
									<th rowspan="2">Customer Telephone</th>
									<th rowspan="2">Customer Name</th>
									<th rowspan="2" class="text-center">Notes</th>
									<th rowspan="2">Booking At</th>
									<th rowspan="2">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($ReservationApprove as $approve) : ?>
									<tr>
										<td><?= $no++ ?> </td>
										<td><?= date('d-m-Y', strtotime($approve['reservation_date'])) ?> </td>
										<td><?= $approve['customer_telephone'] ?> </td>
										<td><?= $approve['customer_name'] ?> </td>
										<td><?= $approve['notes'] ?> </td>
										<td><?= date('d-m-Y', $approve['created_at']) ?> </td>
										<td>
											<a class="btn btn-info btn-sm" href="<?= base_url('reservation?id=' . $approve['reservation_id']); ?>"> <i class="align-middle" data-feather="eye"></i> Detail</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="cancel-tab-pane" role="tabpanel" aria-labelledby="cancel-tab" tabindex="0">
					<div class="table-responsive">
						<table class="table table-hover my-0 ">
							<thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">Reservation Date</th>
									<th rowspan="2">Customer Telephone</th>
									<th rowspan="2">Customer Name</th>
									<th rowspan="2" class="text-center">Notes</th>
									<th rowspan="2">Booking At</th>
									<th rowspan="2">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($ReservationCancel as $cancel) : ?>
									<tr>
										<td><?= $no++ ?> </td>
										<td><?= date('d-m-Y', strtotime($cancel['reservation_date'])) ?> </td>
										<td><?= $cancel['customer_telephone'] ?> </td>
										<td><?= $cancel['customer_name'] ?> </td>

										<td><?= $cancel['notes'] ?> </td>
										<td><?= date('d-m-Y', $cancel['created_at']) ?> </td>
										<td>
											<a class="btn btn-info btn-sm" href="<?= base_url('reservation?id=' . $cancel['reservation_id']); ?>"> <i class="align-middle" data-feather="eye"></i> Detail</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="success-tab-pane" role="tabpanel" aria-labelledby="success-tab" tabindex="0">
					<div class="table-responsive">
						<table class="table table-hover my-0">
							<thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">Reservation Date</th>
									<th rowspan="2">Customer Telephone</th>
									<th rowspan="2">Customer Name</th>
									<th rowspan="2" class="text-center">Notes</th>
									<th rowspan="2">Booking At</th>
									<th rowspan="2">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($ReservationSuccess as $success) : ?>
									<tr>
										<td><?= $no++ ?> </td>
										<td><?= date('d-m-Y', strtotime($success['reservation_date'])) ?> </td>
										<td><?= $success['customer_telephone'] ?> </td>
										<td><?= $success['customer_name'] ?> </td>

										<td><?= $success['notes'] ?> </td>
										<td><?= date('d-m-Y', $success['created_at']) ?> </td>
										<td>
											<a class="btn btn-info btn-sm" href="<?= base_url('reservation?id=' . $success['reservation_id']); ?>"> <i class="align-middle" data-feather="eye"></i> Detail</a>
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
</div>

<div class="modal fade" id="reservationForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="card-title mb-0"> Create Reservation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('reservation'); ?>" method="post">
					<div class="form-row">
						<div class="form-group mb-2">
							<label for="inputCustomer">Customer</label>
							<select name="inputCustomer" id="inputCustomer" class="form-control" required>
								<option value="">-- Choose Customer --</option>
								<?php foreach ($Customers as $customer) : ?>
									<option value="<?= $customer['customer_id']; ?>"><?= $customer['customer_fullname']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-row">
						<label for="inputCustomerPet">Customer Pet</label>
						<div class="form-group">
							<div class="input-group mb-3" id="inputPetService0">
								<select name="inputCustomerPet[]" id="anabul0" class="form-control" required>
									<option value="">-- Choose Customer Pet --</option>
								</select>
								<select name="service[]" id="service0" class="form-control service" data-id="0" required aria-describedby="btnAddPet">
									<option value="">-- Choose Service --</option>
									<?php foreach ($Services as $service) : ?>
										<option value="<?= $service['service_package_id']; ?>"><?= $service['service_name']; ?> - <?= $service['service_package_name']; ?></option>
									<?php endforeach; ?>
								</select>
								<div class="input-group-append">
									<button type="button" class="btn text-dark btn-sm input-group-text" id="btnAddPet"><i class="align-middle" data-feather="plus-circle" style="font-size:35px;"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div id="petForm"></div>
					<div class="row mb-2">
						<div class="form-group col-6">
							<label for="inputReservationDate">Reservation Date</label>
							<input type="date" class="form-control" name="inputReservationDate" id="reservationDate" required>
						</div>
						<div class="form-group col-6">
							<div class="d-flex justify-content-center">
								<div class="spinner-border text-center" role="status" id="SpinnerWait2" hidden></div>
							</div>
							<div class="form-group" id="ArrivalTime" hidden>
								<label for="inputReservationDate">Arrival Time</label>
								<select name="input_arival_time" id="input_arival_time" class="form-control " required>
									<option value="">--Choose Arrival Time --</option>
									<option value="09:00:00" id="status1">Pukul 09.00</option>
									<option value="11:00:00" id="status2">Pukul 11.00</option>
									<option value="13:00:00" id="status3">Pukul 13.00</option>
									<option value="15:00:00" id="status4">Pukul 15.00</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-6">

						</div>
						<div class=" col-6">

						</div>
					</div>
					<div class="row mb-2">
						<div class="form-group col-6">
							<label for="inputService">Branch</label>
							<select name="branch" id="branch" class="form-control" required>
								<option value="">-- Branch --</option>
								<option value="1" <?= (session()->get('branch') == 1) ? 'selected' : 'disabled' ?>>GS MAGUWOHARJO</option>
								<option value="2" <?= (session()->get('branch') == 2) ? 'selected' : 'disabled' ?>>GS GIWANGAN</option>
							</select>
						</div>
						<div class="form-group col-6">
							<label for="inputService">Pet Carrier</label>
							<select name="pet_carrier" id="pet_carrier" class="form-control" required>
								<option value="">--- Pet Carrier ---</option>
								<option value="Tidak Ada">Tidak Ada</option>
								<option value="Tas">Tas</option>
								<option value="Pet Cargo">Pet Cargo</option>
								<option value="Keranjang">Keranjang</option>
							</select>
						</div>
					</div>
					<div class="form-group mb-2">
						<label for="inputService">Pickup Method</label>
						<select name="pickup_method" id="pickup_method" class="form-control" required>
							<option value="">-- Pickup Method --</option>
							<option value="Antar Jemput">Antar Jemput</option>
							<option value="Ditunggu">Ditunggu</option>
							<option value="Datang Langsung">Datang Langsung</option>
						</select>
					</div>
					<div class="form-row">

					</div>
					<div class="form-group mb-2">
						<label for="inputNotes">Notes</label>
						<textarea name="inputNotes" id="inputNotes" class="form-control" cols="30" rows="8" required></textarea>
					</div>
					<div class="d-grid gap-2 mt-3">
						<button class="btn btn-dark" type="submit">Save Reservation</button>
					</div>
			</div>
			</form>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('javascript'); ?>
<script>
	$(document).ready(function() {
		$('#lookDate').change(function() {
			let date = $(this).val();
			window.location.href = 'reservation?date=' + date;
		});
		$('#inputCustomer').change(function() {
			let customer = $(this).val();
			if (customer == null) {
				alert('Choose Customer First!');
			} else {
				$.get("<?= base_url('customers/pet?customer=') ?>" + customer, function(result) {
					if (result == null) {
						option = `<option value="">Customer Pet Not Found </option>`;
						$('#anabul0').html(option);
					}
					let data = JSON.parse(result);
					let option = '<option value="">-- Choose Customer Pet --</option>';
					data.forEach(pet => {
						option += `<option value="${pet.pet_id}">${pet.pet_name}</option>`;
					});
					$('#anabul0').html(option);
				});
			}
		})
		let inputPetServiceID = 1;
		let inputServiceID = 1;
		let inputCustomerPetID = 1;
		let buttonPetServiceID = 1;
		$('#btnAddPet').click(function() {
			let anabul = $('#anabul0').val();
			let service = $('#service0').val();
			if (anabul == "" && service == "") {
				alert("Choose Anabul First !");
			} else if (service == "") {
				alert("Choose Service First !");
			} else {
				let html = `<div class="input-group mb-3" id="inputPetService${inputPetServiceID}">
							<select name="inputCustomerPet[]" id="anabul${inputCustomerPetID}" class="form-control anabul" required>
								<option value="">-- Choose Customer Pet --</option>
							</select>
							<select name="service[]" id="service${inputServiceID}" class="form-control service" data-id="${inputServiceID}" required>
								<option value="">-- Choose Service --</option>
								<?php foreach ($Services as $service) : ?>
									<option value="<?= $service['service_package_id']; ?>"><?= $service['service_name']; ?> - <?= $service['service_package_name']; ?></option>
								<?php endforeach; ?>
							</select>
							<button type="button" class="btn btn-dark btn-sm btnRemovePetService" id="btnRemovePetService${buttonPetServiceID}" data-id="${buttonPetServiceID}">X</button>
						</div>
						`;
				$('#petForm').append(html);
				if (inputCustomerPetID % '2' == 0) {
					$('#btnAddPet').attr("hidden", true);
				} else {
					$('#btnAddPet').attr("hidden", false);
				}
				let customer = $('#inputCustomer').val();
				$.get("<?= base_url('customers/pet?customer=') ?>" + customer, function(result) {
					let data = JSON.parse(result);
					let option = '<option value="">-- Choose Customer Pet --</option>';
					data.forEach(pet => {
						if (pet.pet_id == anabul) {
							status = "disabled"
						} else {
							status = ""
						}
						option += `<option value="${pet.pet_id}" ${status}>${pet.pet_name}</option>`;
					});
					let CPID = inputCustomerPetID - 1;
					$('#anabul' + CPID).html(option);
				});
				inputPetServiceID++;
				inputServiceID++;
				inputCustomerPetID++;
				buttonPetServiceID++;
			}
		});
		$(document).on('click', '.btnRemovePetService', function() {
			let btnID = $(this).data('id');
			$('#inputPetService' + btnID).remove();
			$('#btnAddPet').attr("hidden", false);
		});
		$('#reservationDate').click(function() {
			let option = '<option value="">-- Pilih Jam Kedatangan--</option>';
			option += ` <option value="09:00:00" id="status1">Pukul 09.00</option>
                   <option value="11:00:00" id="status2">Pukul 11.00</option>
                   <option value="13:00:00" id="status3">Pukul 13.00</option>
                   <option value="15:00:00" id="status4">Pukul 15.00</option>`;
			$("#input_arival_time").html(option);
			$("#ArrivalTime").attr("hidden", true);
		});
		$(document).on('change', '#reservationDate', function() {
			$("#SpinnerWait2").attr("hidden", false);
			$("#ArrivalTime").attr("hidden", true);
			let date = $(this).val();
			$.get("<?= base_url("reservation/getArrivalTime?date") ?>" + date, function(result) {
				let data = JSON.parse(result);
				let option = '<option value="">-- Pilih Jam Kedatangan--</option>';
				if (data.length === 0) {
					option += `<option value="09:00:00" >Pukul 09.00</option>
                            <option value="11:00:00" >Pukul 11.00</option>
                            <option value="13:00:00" >Pukul 13.00</option>
                            <option value="15:00:00" >Pukul 15.00</option>
                            `;
					$("#input_arival_time").html(option);
				} else {
					data.forEach(cek => {
						let arrival = cek.arrival_time;
						if (arrival == "09:00:00") {
							$("#status1").attr("disabled", true);
							$("#status1").text("Pukul 09.00 RESERVED");
						} else if (arrival == "11:00:00") {
							$("#status2").attr("disabled", true);
							$("#status2").text("Pukul 11.00 RESERVED");
						} else if (arrival == "13:00:00") {
							$("#status3").attr("disabled", true);
							$("#status3").text("Pukul 13.00 RESERVED");
						} else if (arrival == "15:00:00") {
							$("#status4").attr("disabled", true);
							$("#status4").text("Pukul 15.00 RESERVED");
						} else {
							$("#status1").attr("disabled", false);
						}
					});
				}
				$("#SpinnerWait2").attr("hidden", true);
				$("#ArrivalTime").attr("hidden", false);

			});
		});
	});
</script>
<?= $this->endSection(); ?>