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
                            <h1 class="mt-1 mb-3"><?= $Sales; ?></h1>
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
                                    <h5 class="card-title">Total Income</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp. <?= number_format($erning['total']); ?>
                                <div class="mb-0">
                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> -->
                                    <span class="text-muted"><?= date('F Y'); ?></span>
                                </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Total Pick Up Fee</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp. <?= number_format($erning['cost_delivery']); ?>
                                <div class="mb-0">
                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> -->
                                    <span class="text-muted"><?= date('F Y'); ?></span>
                                </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Total Tax</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp. <?= number_format($erning['sales_order_tax']); ?>
                                <div class="mb-0">
                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> -->
                                    <span class="text-muted"><?= date('F Y'); ?></span>
                                </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Total Discont</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp. <?= number_format($erning['sales_order_discount']); ?>
                                <div class="mb-0">
                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> -->
                                    <span class="text-muted"><?= date('F Y'); ?></span>
                                </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Earnings Total</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp. <?= number_format($SalesErning); ?>
                            </h1>
                            <div class="mb-0">
                                <!-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span> -->
                                <span class="text-muted"><?= date('F Y'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>

<?= $this->section('javascript'); ?>
<script src="<?= base_url('assets/js/pages/dashboard.js'); ?>"></script>
<?= $this->endSection(); ?>