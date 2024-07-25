<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

<div class="row">
    <div class="col-xl-6 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Sales</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="truck"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">0</h1>
                            <div class="mb-0">
                                <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                                <span class="text-muted"><?= date('F Y'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Customers</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3"><?= $countCustomer; ?></h1>
                            <div class="mb-0">
                                <!-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span> -->
                                <span class="text-muted">Since 2022</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Earnings</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp. <?= number_format($ServiceEarning['service_order_total']); ?></h1>
                            <div class="mb-0">
                                <!-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span> -->
                                <span class="text-muted"><?= date('F Y'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Orders</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3"><?= number_format($countService); ?></h1>
                            <div class="mb-0">
                                <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> -->
                                <span class="text-muted"><?= date('F Y'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-4 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Income Statment</h5>
            </div>
            <div class="card-body py-3">
                <div class="align-self-center w-100">
                    <div class="py-2">
                        <div class="chart chart-xs">
                            <canvas id="chartjs-dashboard-pie"></canvas>
                        </div>
                    </div>
                    <ul>
                        <li>Service &emsp;&emsp;: Rp. <?= number_format($ServiceEarning['service_order_total']); ?></li>
                        <li>Pickup Fee &nbsp;: Rp. <?= number_format($ServiceEarning['pickup_fee']); ?></li>
                        <li>Cost &emsp;&emsp;&emsp; : Rp. <?= number_format($cost['bill']); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Movement</h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-sm">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">

                <h5 class="card-title mb-0">Latest Services</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th class="d-none d-xl-table-cell">Pet Name</th>
                        <th class="d-none d-xl-table-cell">Service Date</th>
                        <th>Status</th>
                        <th class="d-none d-md-table-cell">Assignee</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($LastService as $lastServe) : ?>
                        <tr>
                            <td><?= $lastServe['customer_fullname']; ?></td>
                            <td class="d-none d-xl-table-cell"><?= $lastServe['pet_name']; ?></td>
                            <td class="d-none d-xl-table-cell"><?= $lastServe['transaction_date']; ?></td>
                            <td><span class="badge bg-success">Done</span></td>
                            <td class="d-none d-md-table-cell">Mas Deva</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('javascript'); ?>
<script src="<?= base_url('assets/js/pages/dashboard.js'); ?>"></script>
<?= $this->endSection(); ?>