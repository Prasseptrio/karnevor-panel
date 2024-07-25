<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"><strong>Initial Stock <?= date('Y'); ?> </strong>
            <button type="button" class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modelId">
                Add Initial Stock
            </button>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Period</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Nominal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($InitialStock as $initialStock) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $initialStock['period']; ?></td>
                            <td><?= $initialStock['product']; ?></td>
                            <td><?= $initialStock['quantity']; ?></td>
                            <td><?= number_format($initialStock['nominal']); ?></td>
                            <td>
                                <form action="<?= base_url('initial-stock/delete'); ?>" method="post">
                                    <input type="hidden" name="inputPeriod" value="<?= $initialStock['period']; ?>">
                                    <input type="hidden" name="inputProduct" value="<?= $initialStock['product']; ?>">
                                    <button type="submit" class="btn btn-outline-dark btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('initial-stock/create'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group my-3">
                        <label for="inputPeriod" class="mb-2">Period</label>
                        <input type="text" class="form-control" name="inputPeriod" id="inputPeriod" value="<?= date('Y'); ?>" readonly>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputProduct" class="mb-2">Product </label>
                        <select name="inputProduct" id="inputProduct" class="form-select">
                            <option value="">-- Choose Product --</option>
                            <?php foreach ($Products  as $product) : ?>
                                <option value="<?= $product['product_id']; ?>"><?= $product['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputQuantity" class="mb-2">Quantity</label>
                        <input type="number" min="0" class="form-control" name="inputQuantity" id="inputQuantity" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputNominal" class="mb-2">Nominal</label>
                        <input type="number" min="0" class="form-control" name="inputNominal" id="inputNominal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>