<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> List Menu </h1>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Purchase Order List <a href="<?= base_url('purchase-order/form'); ?>" class="btn btn-dark btn-sm float-end">Create New Purchase Order</a></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0 datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction Date</th>
                        <th>Invoice</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Notes</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($PurchaseOrder as $purchaseorder) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php
                                $PODate = new DateTime($purchaseorder['transaction_date']);
                                echo $PODate->format('d F Y');
                                ?>
                            </td>
                            <td><?= $purchaseorder['invoice_no'] ?> </td>
                            <td><?= $purchaseorder['company'] ?> </td>
                            <td><?= $purchaseorder['total'] ?> </td>
                            <td><?= $purchaseorder['notes'] ?> </td>
                            <td><?= ($purchaseorder['payment_status'] == 0) ? 'Unpaid' : 'Paid' ?> </td>
                            <td>
                                <a href="<?= base_url('purchase-order?id=' . $purchaseorder['purchase_order_id']); ?>" class="btn btn-secondary btn-sm">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>