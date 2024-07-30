<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card" id="printableArea">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-3">
                        <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Bonty Logo" class="img-fluid">
                    </div>
                    <div class="col-sm-9">
                        <div class="mt-3">
                            <h6 class="fw-bold">Novapos - Karnevor Indonesia </h6>
                            <p>
                                Jl. Tajem Maguwoharjo, Sleman Yogyakarta
                                <br> halo@groomingspace.id | www.groomingspace.id
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <br>
                <br>
                <h2><u>Purchase Order</u></h2>
                <p class="card-description">
                    <?= $purchaseOrder['invoice_no']; ?> -
                    <?= date('d F Y', $purchaseOrder['created_at']) ?>
                </p>
            </div>
            <div class="col-sm-4">
                <br>
                <strong> Diterbitkan Untuk :</strong>
                <p> <strong><?= ucwords($purchaseOrder['company']); ?> </strong><br>
                    <?= $purchaseOrder['address']; ?>
                </p>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($PurchaseOrderProduct as $purchaseOrderProduct) { ?>
                        <tr>
                            <td><?= $purchaseOrderProduct['name'] ?></td>
                            <td><?= $purchaseOrderProduct['quantity'] ?></td>
                            <td>Rp.<?= number_format($purchaseOrderProduct['price']); ?></td>
                            <td>Rp.<?= number_format($purchaseOrderProduct['subtotal']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="fw-bold">
                        <td colspan="3">Total </td>
                        <td>Rp.<?= number_format($purchaseOrder['total']); ?></td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3">Discount </td>
                        <td>Rp.<?= number_format($purchaseOrder['discount']); ?></td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3">Tax </td>
                        <td>Rp.<?= number_format($purchaseOrder['tax']); ?></td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3">Shipping Cost </td>
                        <td>Rp.<?= number_format($purchaseOrder['shipping_cost']); ?></td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3">Insurance Cost </td>
                        <td>Rp.<?= number_format($purchaseOrder['insurance_cost']); ?></td>
                    </tr>
                    <tr>
                        <?php $grand_total = ($purchaseOrder['total'] - $purchaseOrder['discount']) + ($purchaseOrder['shipping_cost'] + $purchaseOrder['insurance_cost']) + $purchaseOrder['tax']; ?>
                        <td colspan="3">
                            <h5 class="fw-bold"> GRAND TOTAL </h5>
                        </td>
                        <td>
                            <h5 class="fw-bold"> Rp.<?= number_format($grand_total); ?></h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row ">
            <div class="col-sm-10">
                <p class="text-justify">
                    <strong>Catatan :</strong>
                    <br>
                    <?= $purchaseOrder['notes']; ?>
                </p>
            </div>
            <div class="col-sm-2">
                <h3>Status : <b><?= ($purchaseOrder['payment_status'] == 0) ? 'UNPAID' : 'PAID'; ?></b></h3>
                <?php if ($purchaseOrder['payment_status'] == 0) : ?>
                    <form action="<?= base_url('purchase-order/pay'); ?>" method="post">
                        <input type="hidden" name="inputPurchaseOrderID" value="<?= $purchaseOrder['purchase_order_id']; ?>">
                        <div class="d-grid gap-2">
                            <button class="btn btn-dark">Paid</button>
                        </div>
                    </form>
                <?php else : ?>
                    <?php if ($StockCardPurchaseOrder == 0) : ?>
                        <form action="<?= base_url('stock-card/insert'); ?>" method="post">
                            <input type="hidden" name="inputPurchaseOrderID" value="<?= $purchaseOrder['purchase_order_id']; ?>">
                            <div class="d-grid gap-2">
                                <button class="btn btn-dark">Move to Stock</button>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>