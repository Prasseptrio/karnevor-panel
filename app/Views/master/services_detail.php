<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <form action="<?= base_url('services'); ?>" method="get">
            <div class="modal-body">
                <div class="input-group">
                    <select name="id" id="serviceID" class="form-select">
                        <option value="">-- Choose Service --</option>
                        <?php foreach ($Services as $serv) : ?>
                            <option value="<?= $serv['service_id']; ?>"><?= $serv['service_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-secondary" type="submit">Look up</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body row">
        <div class="col-sm-6">
            <h5 class="card-title mb-4"> Detail Service <?= $service['service_name']; ?>
                <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#servicePackageForm">Create New Package</button>
            </h5>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Service Package Name</th>
                    <th>Service Package Price</th>
                    <th>Feature</th>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($ServicePackage as $servicepackage) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $servicepackage['service_package_name'] ?> </td>
                            <td>Rp. <?= number_format($servicepackage['service_package_price']); ?> </td>
                            <td>
                                <a href="<?= base_url('services?id=' . $servicepackage['service_id'] . '&pack=' . $servicepackage['service_package_id']); ?>" class="btn btn-outline-dark btn-sm">Feature</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <?php if ($package) : ?>
                <h5 class="card-title mb-4">Feature of <?= $package['service_package_name']; ?>
                    <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#serviceFeatureForm">Create New Feature</button>
                </h5>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Service Feature Name</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($ServiceFeature as $servicefeature) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $servicefeature['service_feature_name'] ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="servicePackageForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Service Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('services/create-package'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="inputService" value="<?= $service['service_id']; ?>">
                    <div class="form-group mb-3 row">
                        <label for="inputServicePackageName" class="col-sm-3">Package Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="inputServicePackageName" class="form-control" placeholder="Service Package Name" aria-label="Services" aria-describedby="button-addon2">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="inputServicePackageName" class="col-sm-3">Package Price</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" min="1" class="form-control" name="inputServicePackagePrice" id="shippingCost" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceFeatureForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Package Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('services/create-feature'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="inputService" value="<?= $service['service_id']; ?>">
                    <input type="hidden" name="inputServicePackage" value="<?= ($package) ? $package['service_package_id'] : ''; ?>">
                    <div class="form-group row">
                        <label for="inputServiceFeatureName" class="col-sm-3">Feature</label>
                        <div class="col-sm-9">
                            <input type="text" name="inputServiceFeatureName" class="form-control" aria-label="Services" aria-describedby="button-addon2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>