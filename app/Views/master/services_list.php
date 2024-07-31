<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Sales Order List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Invoice</th>
                        <th>Nama Customer</th>
                        <th>Tipe Pembayaran</th>
                        <th>Tipe Pembelian</th>
                        <th>Tanggal Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $no = 1;
                    foreach ($Services as $service) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $service['invoice_no']; ?></td>
                            <td><?= $service['customer_fullname']; ?></td>
                            <td><?php if ($service['payment_method'] == 1) : echo "Cash";
                                elseif ($service['payment_method'] == 2) : echo "Qris BCA";
                                else : echo "Transfer BCA";
                                endif ?></td>
                            <td><?= ($service['type'] == 1) ? "Dine-in/Take-away" : "Website"; ?></td>
                            <td class="fw-bold"><?= date('d F Y', strtotime($service['transaction_date'])) ?></td>
                            <td>
                                <a href="<?= base_url('salesorder-list?inv=' . $service['invoice_no']); ?> " class="btn btn-outline-secondary btn-sm">Detail</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('services/create'); ?>" method="post">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" name="inputServiceName" class="form-control" placeholder="Service Name" aria-label="Services" aria-describedby="button-addon2">
                        <button class="btn btn-dark" type="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>