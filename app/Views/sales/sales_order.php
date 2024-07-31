<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-4">
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
				<div class="row">
					<div class="col-sm-6">
						<h3 class="card-title">Cashier : <?= $user['fullname']; ?></h3>
					</div>
					<div class="col-sm-6">
						<h3 id="CloCk" class="card-title text-end"></h3>
					</div>
				</div>
				<hr>
				<form action="<?= base_url('customers/create'); ?>" method="post">
					<input type="hidden" class="form-control" name="source" id="source" value="posale">
					<div class="form-group">
						<label for="exampleDataList" class="form-label">Customer Name</label>
						<input class="form-control" name="inputCustomerFullname" id="inputCustomerFullname" list="datalistCustomer" id="exampleDataList" placeholder="Type to search..." required>
						<datalist id="datalistCustomer">
							<?php foreach ($Customers as $customer) : ?>
								<option value="<?= $customer['customer_id']; ?>"><?= $customer['customer_fullname']; ?></option>
							<?php endforeach; ?>
							</select>
					</div>
					<div class="form-group my-2">
						<label for="inputCustomerEmail">Customer Email</label>
						<input type="text" class="form-control" name="inputCustomerEmail" id="inputCustomerEmail">
					</div>
					<div class="mt-4 text-end">
						<button type="submit" class="btn btn-secondary">Add as new customer</button>
					</div>
				</form>
			</div>
			<div class="col-sm-8">
				<form action="<?= base_url('posale/create'); ?>" method="post">
					<div class=" mt-4">
						<div class="input-group mb-3">
							<span class="input-group-text fw-bold">ORDER ID</span>
							<input type="text" class="form-control" value="<?= $invoice; ?>" aria-describedby="button-addon2" readonly>
							<input type="text" class="form-control" placeholder="Search SKU Product" aria-describedby="button-addon2">
							<button class="btn btn-secondary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#productList">Product List</button>
						</div>
					</div>
					<input type="hidden" class="form-control" name="inputCustomerID" id="inputCustomerID">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="">#</th>
									<th>Product</th>
									<th class="">Quantity</th>
									<th class="text-center">Price</th>
									<th class="text-right">Subtotal</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="detailCart">
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
											<input type="text" name="inputTotal" class="form-control" id="totalView" readonly>
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
									<td>Tax Rate 10%</td>
									<td>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp.</span>
											</div>
											<input type="text" class="form-control" name="inputTax" id="tax" value="" required>
										</div>
									</td>
								</tr>
								<tr>
									<td>Payment Method</td>
									<td>
										<select class="form-control" name="paymentMethod" id="paymentMethod" required>
											<option value="1" selected>Cash</option>
											<option value="2">Qris BCA</option>
											<option value="3">Transfer</option>
										</select>
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
					<div class="text-end">
						<button type="button" class="btn btn-lg btn-outline-dark resetData" id="reset">Reset</button>
						<button type="submit" class="btn btn-lg btn-dark">Process Order</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="productList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-hover my-0 tableProduct dataTable">
						<thead>
							<tr>
								<th>#</th>
								<th>Product Name</th>
								<th>Product Price</th>
								<th width="5%">Quantity</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($Products as $product) : ?>
								<tr>
									<td><?= $no++; ?></td>
									<td><?= $product['product_name'] ?> </td>
									<td>Rp. <?= number_format($product['price']); ?></td>
									<td><input type="number" min="1" id="inputQuantity<?= $product['product_id'] ?>" class="form-control"></td>
									<td>
										<button type="submit" class="btn btn-secondary btn-sm add-to-cart" data-id="<?= $product['product_id']; ?>" data-name="<?= $product['product_name']; ?>" data-price="<?= $product['price']; ?>" data-bs-dismiss="modal">Add to cart</button>
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
<?= $this->section('javascript'); ?>
<script>
	$(document).ready(function() {
		startTime();

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
		// Load shopping cart
		$('#detailCart').load("<?= base_url('cart'); ?>");

		//insertCart
		$('.tableProduct').on('click', '.add-to-cart', function() {
			let product_id = $(this).data("id");
			let name = $(this).data("name");
			let price = $(this).data("price");
			let quantity = $('#inputQuantity' + product_id).val();
			$.ajax({
				url: "<?= base_url('cart/insert'); ?>",
				method: "POST",
				type: 'JSON',
				data: {
					id: product_id,
					name: name,
					qty: quantity,
					price: price,
				},
				success: function(result) {
					$('#detailCart').html(result);
					updateTotal();
				}
			});
		});
		//DestroyCart
		$(document).on('click', '.resetData', function() {
			const row_id = $(this).attr("id");
			$.ajax({
				url: "<?= base_url('cart/destroy'); ?>",
				method: "POST",
				type: 'JSON',
				data: {
					rowid: row_id,
				},
				success: function(result) {
					$('#detailCart').html(result);
					$('#inputCustomerAddress').val('');
					$('#inputCustomerTelephone').val('');
					$('#inputCustomerEmail').val('');
					$('#inputCustomerFullname').val('');
					$('#inputCustomerID').val('');
					$('#total').val('');
					$('#totalView').val('');
					$('#discount').val('');
					$('#tax').val('');
					$('#grandTotal').val('');
				}
			});
		});
		//Remove Cart By Product
		$(document).on('click', '.removeItemCart', function() {
			const row_id = $(this).attr("id");
			$.ajax({
				url: "<?= base_url('cart/remove'); ?>",
				method: "POST",
				type: 'JSON',
				data: {
					rowid: row_id,
				},
				success: function(result) {
					$('#detailCart').html(result);
				}
			});
		});

		function updateTotal() {
			let total = $('#total').val();
			$('#totalView').val(total);
		}
		$(document).on('keyup', '#discount', function() {
			const total = parseInt($('#total').val());
			const discount = parseInt($('#discount').val());
			const totalTax = (total - discount) * 0.1;
			const grandTotal = (total - discount) + totalTax;
			$('#tax').val(totalTax);
			$('#grandTotal').val(grandTotal);
		});

		$('#inputCustomerFullname').change(function() {
			let customerID = $(this).val();
			$.get("<?= base_url('customers?id=') ?>" + customerID, function(result) {
				let data = JSON.parse(result);
				$('#inputCustomerAddress').val(data.customer_address);
				$('#inputCustomerTelephone').val(data.customer_telephone);
				$('#inputCustomerEmail').val(data.customer_email);
				$('#inputCustomerFullname').val(data.customer_fullname);
				$('#inputCustomerID').val(data.customer_id);
			});
		});
	})
</script>
<?= $this->endSection(); ?>