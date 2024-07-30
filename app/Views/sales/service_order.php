<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<form action="<?= base_url('poservice/create'); ?>" method="post">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-5">
					<div class="row">
						<div class="col-sm-3">
							<img src="<?= base_url('assets/images/logo.png'); ?>" alt="Bonty Logo" class="img-fluid">
						</div>
						<div class="col-sm-9">
							<div class="mt-3">
								<h6 class="fw-bold">Karnevor Indonesia </h6>
								<p>
									<?php if (session()->get('role') == 1) : ?>
										Jl. Tajem Maguwoharjo, Sleman Yogyakarta
									<?php else : ?>
										Jl. Monumen Perjuangan, RT 05, Wirokerten, Grojogan, Banguntapan, Bantul
									<?php endif; ?>
									<br> halo@karnevorindonesia.id | www.karnevorindonesia.id
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h3 class="card-title">Cashier : <?= $user['fullname']; ?></h3>
						</div>
						<div class="col-sm-6">
							<h3 id="CloCk" class="card-title text-end"></h3>
						</div>
					</div>
					<hr>
					<div>
						<input type="hidden" name="branch" value="<?= session()->get('branch'); ?>">
						<div class="input-group mb-3">
							<select class="form-control select2" name="inputCustomer" id="inputCustomer" required>
								<?php if ($reservation != '') : ?>
									<option value="<?= $reservation['customer_id']; ?>"><?= $reservation['customer_fullname']; ?></option>
									<input type="hidden" name="reservationID" value="<?= $reservation['reservation_id']; ?>">
								<?php else : ?>
									<option value="">-- Choose Customer --</option>
									<?php foreach ($Customers as $customer) : ?>
										<option value="<?= $customer['customer_id']; ?>"><?= $customer['customer_fullname']; ?></option>
									<?php endforeach; ?>
									<input type="hidden" name="reservationID" value="">
								<?php endif ?>
							</select>
							<button type="button" class="btn btn-secondary" id="button-addon2" data-bs-toggle="modal" data-bs-target="#customerForm"><i data-feather="plus-circle"></i> Customer</button>
						</div>
						<div id="petServiceForm"></div>
						<div class="text-end">
							<button type="button" class="btn btn-outline-light text-secondary btn-sm" id="btnAddPet"><i data-feather="plus-circle"></i> Customer Pet</button>
							<button type="button" class="btn btn-outline-light text-dark btn-sm" id="btnAddPetService"><i data-feather="plus-circle"></i> Pet Service</button>
						</div>
					</div>
				</div>
				<div class="col-sm-7 mt-5">
					<div class="input-group mb-3 ">
						<div class="input-group-prepend">
							<span class="input-group-text fw-bold" id="basic-addon1">ORDER ID</span>
						</div>
						<input type="text" class="form-control " value="GS-<?= $invoice; ?>" aria-describedby="button-addon2" readonly>
						<input type="date" name="inputServiceDate" id="inputServiceDate" class="form-control" required>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tbody id="additionalForm">
								<tr>
									<td>
										Pick Up Fee
									</td>
									<td>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp.</span>
											</div>
											<input type="text" class="form-control" id="input-pickup-fee" name="inputPickupFee">
										</div>
									</td>
								</tr>
								<tr>
									<td>Total</td>
									<td>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp.</span>
											</div>
											<input type="text" name="inputTotal" class="form-control" id="inputTotal" readonly>
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
											<input type="number" class="form-control" name="inputDiscount" id="discount" value="" required>
										</div>
									</td>
								</tr>
								<tr>
									<td><b>GRAND TOTAL</b></td>
									<td>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp.</span>
											</div>
											<input type="text" class="form-control" name="grandTotal" id="grandTotal" readonly>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="form-group mb-3">
						<label for="inputPaymentMethod">Payment Method</label>
						<select name="inputPaymentMethod" id="inputPaymentMethod" class="form-select">
							<option value="">-- Choose Petty Cash --</option>
							<?php foreach ($PettyCash as $pettycash) : ?>
								<option value="<?= $pettycash['petty_cash_id']; ?>"><?= $pettycash['alias']; ?> <?= $pettycash['bank_name']; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="text-end">
						<button type="submit" class="btn btn-lg btn-dark">Checkout</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- Modal -->
<div class="modal fade" id="customerPetForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Customer Pet</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('customers/addPet'); ?>" method="post">
				<div class="modal-body">
					<input type="hidden" class="form-control" name="inputCustomer" id="inputCustomerID">
					<div class="form-group">
						<label for="inputPetName">Pet Name</label>
						<input type="text" class="form-control" name="inputPetName" id="inputPetName" required>
					</div>
					<div class="form-group">
						<label for="inputPetAge">Pet Age</label>
						<div class="input-group">
							<input type="number" min="0" class="form-control" name="inputPetAge" id="inputPetAge" required>
							<span class="input-group-text">Month</span>
						</div>
					</div>
					<div class="form-group my-3">
						<label for="inputPetType">Pet Type</label>
						<select name="inputPetType" id="inputPetType" class="form-select" required>
							<option value="">-- Choose Pet Type --</option>
							<option value="1">Cat</option>
							<option value="2">Dog</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="customerForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('customers/create'); ?>" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Create New Customer</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="source" id="source" value="poservice">
					<div class="form-group my-2">
						<label for="inputCustomerFullname">Customer Name</label>
						<input type="text" class="form-control" name="inputCustomerFullname" id="inputCustomerFullname" required>
					</div>

					<div class="form-group my-2">
						<label for="inputCustomerAddress">Customer Address</label>
						<input type="text" class="form-control" name="inputCustomerAddress" id="inputCustomerAddress" required>
					</div>
					<div class="form-group my-2">
						<label for="inputCustomerTelephone">Customer Telephone</label>
						<input type="text" class="form-control" name="inputCustomerTelephone" id="inputCustomerTelephone" required>
					</div>
					<div class="form-group my-2">
						<label for="inputCustomerEmail">Customer Email</label>
						<input type="text" class="form-control" name="inputCustomerEmail" id="inputCustomerEmail">
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary">Add new customer</button>
				</div>
		</form>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascript'); ?>

<script>
	$(document).ready(function() {
		startTime();
		let total = 0;
		let inputPetServiceID = 0;
		let inputServiceID = 0;
		let inputCustomerPetID = 0;
		let buttonPetServiceID = 0;


		function startTime() {
			var today = new Date();
			var h = today.getHours();
			var m = today.getMinutes();
			var s = today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('CloCk').innerHTML = "<?= date_indo(date('Y-m-d')) ?> " +
				h + ":" + m + ":" + s;
			var t = setTimeout(startTime, 500);
		}

		function checkTime(i) {
			if (i < 10) {
				i = "0" + i
			}; // add zero in front of numbers < 10
			return i;
		}

		function updateTotal() {
			let total = $('#total').val();
			$('#totalView').val(total);
		}
		$(document).on('keyup', '#discount', function() {
			let pickupFee = $('#input-pickup-fee').val();
			if (pickupFee == '') {
				alert("Pickup Fee must have value !")
			}
			let total = parseInt($('#inputTotal').val());
			let discount = parseInt($('#discount').val());
			let grandTotal = parseInt(pickupFee) + (total - discount);
			$('#grandTotal').val(grandTotal);
		});
		$('#btnAddPet').click(function() {
			let customerID = $('#inputCustomerID').val();
			if (customerID == '') {
				alert("Please select customer !");
			} else {
				var customerPetForm = new bootstrap.Modal(document.getElementById('customerPetForm'), {
					keyboard: false
				});
				customerPetForm.show();
			}
		});
		$('#inputCustomer').change(function() {
			let customerID = $(this).val();
			$('#inputCustomerID').val(customerID);
			$.get("<?= base_url('customers/pet?customer=') ?>" + customerID, function(result) {
				let data = JSON.parse(result);
				let option = '<option value="">-- Choose Customer Pet --</option>';
				data.forEach(pet => {
					option += `<option value="${pet.pet_id}">${pet.pet_name}</option>`;
				});
				$('.inputCustomerPet').html(option);
			});
		});
		let customerID = $('#inputCustomer').val();
		if (customerID) {
			$('#inputCustomerID').val(customerID);
			$.get("<?= base_url('customers/pet?customer=') ?>" + customerID, function(result) {
				let data = JSON.parse(result);
				let option = '<option value="">-- Choose Customer Pet --</option>';
				data.forEach(pet => {
					option += `<option value="${pet.pet_id}">${pet.pet_name}</option>`;
				});
				$('.inputCustomerPet').html(option);
			});
		}

		$(document).on('change', '.inputService', function() {
			let serviceID = $(this).data('id');
			let se = $('#inputService' + serviceID).val();
			if (se == '') {
				$.get("<?= base_url('services/package?id=') ?>" + se, function(result) {
					let data = JSON.parse(result);
					let btnid = buttonPetServiceID - 1;
					total -= parseInt(data.service_package_price);
					$('#inputTotal').val(total);
					$('#grandTotal').val('');
					$('#discount').val('');
				});
			}

			let servicePackageID = $(this).val();
			$.get("<?= base_url('services/package?id=') ?>" + servicePackageID, function(result) {
				let data = JSON.parse(result);
				let btnid = buttonPetServiceID - 1;
				total += parseInt(data.service_package_price);
				$('#inputTotal').val(total);
				$('#grandTotal').val('');
				$('#discount').val('');
				$('#btnRemovePetService' + btnid).attr('data-package', servicePackageID);
			});
		});
		$('#btnAddPetService').click(function() {
			let customerID = $('#inputCustomerID').val();
			if (customerID == '') {
				alert("Please select customer !");
			} else {
				let html = `<div class="input-group mb-3" id="inputPetService${inputPetServiceID}">
							<select name="inputCustomerPet[]" id="inputCustomerPet${inputCustomerPetID}" class="form-select inputCustomerPet" required>
								<option value="">-- Choose Customer Pet --</option>
							</select>
							<select name="inputService[]" id="inputService${inputServiceID}" class="form-select inputService" data-id="${inputServiceID}" required>
								<option value="">-- Choose Service --</option>
								<?php foreach ($Services as $service) : ?>
									<option value="<?= $service['service_package_id']; ?>"><?= $service['service_name']; ?> - <?= $service['service_package_name']; ?></option>
								<?php endforeach; ?>
							</select>
							<button type="button" class="btn btn-secondary btn-sm btnRemovePetService" id="btnRemovePetService${buttonPetServiceID}" data-id="${buttonPetServiceID}">X</button>
						</div>
						`;
				$('#petServiceForm').append(html);
				$.get("<?= base_url('customers/pet?customer=') ?>" + customerID, function(result) {
					let data = JSON.parse(result);
					let option = '<option value="">-- Choose Customer Pet --</option>';
					data.forEach(pet => {
						option += `<option value="${pet.pet_id}">${pet.pet_name}</option>`;
					});
					let CPID = inputCustomerPetID - 1;
					$('#inputCustomerPet' + CPID).html(option);
				});
				inputPetServiceID++;
				inputServiceID++;
				inputCustomerPetID++;
				buttonPetServiceID++;
			}
		});
		$(document).on('click', '.btnRemovePetService', function() {
			let btnID = $(this).data('id');
			let servicePackageID = $('#btnRemovePetService' + btnID).data('package');
			$.get("<?= base_url('services/package?id=') ?>" + servicePackageID, function(result) {
				let data = JSON.parse(result);
				total -= parseInt(data.service_package_price);
				$('#inputPetService' + btnID).remove();
				$('#inputTotal').val(total);
				$('#grandTotal').val('');
				$('#discount').val('');
			});
		});
	});
</script>
<?= $this->endSection(); ?>