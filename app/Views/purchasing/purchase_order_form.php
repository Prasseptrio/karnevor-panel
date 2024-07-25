<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <form action="<?= base_url('purchase-order/create'); ?>" method="post">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="h3 mb-3"><strong><?= $title; ?></strong> Form | <span id="CloCk"></span></h1>
                    <div class="form-group mt-1  row">
                        <label for="exampleFormControlInput1" class="form-label col-sm-2">Date</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= date('d-m-Y'); ?>" readonly>
                            <input type="hidden" name="inputTransactionDate" value="<?= date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="form-group  mt-3 row">
                        <label for="exampleFormControlInput1" class="form-label col-sm-2">Invoice</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputInvoice" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="inputSupplier" class="form-label col-sm-2">Suppliers</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="inputSupplier" aria-label="Default select" required>
                                <option value="">-- Choose Supplier --</option>
                                <?php foreach ($Suppliers as $supplier) : ?>
                                    <option value="<?= $supplier['supplier_id']; ?>"><?= $supplier['company'] . ' (' . $supplier['name'] . ')'; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mt-2 row">
                        <label for="inputNotes" class="form-label col-sm-2">Notes</label>
                        <textarea name="inputNotes" id="inputNotes" cols="30" rows="6" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="detailCart">
                    </tbody>
                </table>
            </div>
            <hr>
            <table class="table">
                <tbody id="additionalForm">
                    <tr>
                        <td>Total</td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" id="totalView" readonly>
                                <!-- <input type="hidden" class="form-control" id="total" value="0" readonly> -->
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
                        <td>Shipping Cost</td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" name="inputShippingCost" id="shippingCost" value="0" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Insurance Cost</td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" name="inputInsuranceCost" id="insuranceCost" value="0" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>PAYMENT TOTAL</b></td>
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
            <div class="text-end">
                <button type="button" class="btn btn-secondary " data-bs-toggle="modal" data-bs-target="#modelId"> Add Product </button>
                <button type="submit" class="btn btn-dark">Save Purchase Order</button>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modelId" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                <th>Product SKU</th>
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
                                    <td><?= $product['product_sku'] ?> </td>
                                    <td><?= $product['product_name'] ?> </td>
                                    <td><input type="number" min="1" id="inputPrice<?= $product['product_id'] ?>" class="form-control"></td>
                                    <td><input type="number" min="1" id="inputQuantity<?= $product['product_id'] ?>" class="form-control"></td>
                                    <td>
                                        <button type="submit" class="btn btn-secondary btn-sm add-to-cart" data-id="<?= $product['product_id']; ?>" data-name="<?= $product['product_name']; ?>" data-price="<?= $product['product_price']; ?>" data-bs-dismiss="modal">Add to cart</button>
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
            document.getElementById('CloCk').innerHTML = "<?= date_indo(date('Y-m-d')) ?>, " +
                h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }

        //insertCart
        $('.tableProduct').on('click', '.add-to-cart', function() {
            let product_id = $(this).data("id");
            let name = $(this).data("name");
            let price = $('#inputPrice' + product_id).val();
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

        // Load shopping cart
        $('#detailCart').load("<?= base_url('cart'); ?>");

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
                    updateTotal();
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
            const shippingCost = parseInt($('#shippingCost').val());
            const insuranceCost = parseInt($('#insuranceCost').val());
            const totalTax = (total - discount) * 0.1;
            const grandTotal = (total - discount) + (shippingCost + insuranceCost) + totalTax;
            $('#tax').val(totalTax);
            $('#grandTotal').val(grandTotal);
        });

        $(document).on('keyup', '#shippingCost', function() {
            const shippingCost = parseInt($(this).val());
            if (shippingCost == '') {
                shipcost = 0;
            } else {
                shipcost = shippingCost;
            }
            const insuranceCost = parseInt($('#insuranceCost').val());
            const total = parseInt($('#total').val());
            const discount = parseInt($('#discount').val());
            const tax = parseInt($('#tax').val());
            const grandTotal = (total - discount) + (shipcost + insuranceCost) + tax;
            $('#grandTotal').val(grandTotal);
        });

        $(document).on('keyup', '#insuranceCost', function() {
            const insuranceCost = parseInt($(this).val());
            if (insuranceCost == '') {
                insurancecost = 0;
            } else {
                insurancecost = insuranceCost;
            }
            const total = parseInt($('#total').val());
            const discount = parseInt($('#discount').val());
            const tax = parseInt($('#tax').val());
            const shippingCost = parseInt($('#shippingCost').val());
            const grandTotal = (total - discount) + (shippingCost + insurancecost) + tax;
            $('#grandTotal').val(grandTotal);
        });
    });
</script>
<?= $this->endSection(); ?>