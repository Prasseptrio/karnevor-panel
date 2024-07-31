<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <h3 class="card-title mb-0"> Customers Detail </h3>
                <table class="table">
                    <tr>
                        <th>Customer Fullname</th>
                        <td>: <?= $customer['customer_fullname']; ?></td>
                    </tr>
                    <tr>
                        <th>Customer Address</th>
                        <td>: <?= $customer['customer_address']; ?></td>
                    </tr>
                    <tr>
                        <th>Customer Telephone</th>
                        <td>: <?= $customer['customer_telephone']; ?></td>
                    </tr>
                    <tr>
                        <th>Customer Email</th>
                        <td>: <?= $customer['customer_email']; ?></td>
                    </tr>
                </table>
                <div class="text-end">
                    <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#customerPetForm">Add Customer Pet</button>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#customerForm">Update</button>
                    <form action="<?= base_url('customers/delete/' . $customer['customer_id']); ?>" method="post" class="d-inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-dark btn-sm">Delete</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-8">
                <h3 class="card-title mb-0">Customer Pets</h3>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Pet Name</th>
                        <th>Pet Type</th>
                        <th>Pet Age</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($CustomerPet as $customerPet) :
                        ?> <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $customerPet['pet_name']; ?></td>
                                <td><?= ($customerPet['pet_type'] == 1) ? 'Cat' : 'Dog'; ?></td>
                                <td><?= $customerPet['pet_age']; ?> Month</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



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
                    <input type="hidden" class="form-control" name="inputCustomer" id="inputCustomer" value="<?= $customer['customer_id']; ?>">
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
<?= $this->endSection(); ?>