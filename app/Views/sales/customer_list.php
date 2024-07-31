<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> List Menu </h1>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Customers List <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#customerForm">Create New Customers</button></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0 datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Fullname</th>
                        <th>Customer Address</th>
                        <th>Customer Telephone</th>
                        <th>Customer Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($Customers as $customer) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $customer['customer_fullname'] ?> </td>
                            <td><?= $customer['address'] ?> </td>
                            <td><?= $customer['customer_whatsapp'] ?> </td>
                            <td><?= $customer['customer_email'] ?> </td>
                            <td>
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#customerForm">Update</button>
                                <form action="<?= base_url('customers/delete/' . $customer['customer_id']); ?>" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-outline-dark btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="customerForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Customer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('customers/update'); ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" class="form-control" name="inputCustomerID" id="inputCustomerID" value="<?= ($customer) ? $customer['customer_id'] : ''; ?>">
                                            <div class="form-group my-2">
                                                <label for="inputCustomerFullname">Customer Fullname</label>
                                                <input type="text" class="form-control" name="inputCustomerFullname" id="inputCustomerFullname" value="<?= ($customer) ? $customer['customer_fullname'] : ''; ?>" required>
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="inputCustomerAddress">Customer Address</label>
                                                <input type="text" class="form-control" name="inputCustomerAddress" id="inputCustomerAddress" value="<?= ($customer) ? $customer['address'] : ''; ?>" required>
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="inputCustomerTelephone">Customer Telephone</label>
                                                <input type="text" class="form-control" name="inputCustomerTelephone" id="inputCustomerTelephone" value="<?= ($customer) ? $customer['customer_whatsapp'] : ''; ?>" required>
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="inputCustomerEmail">Customer Email</label>
                                                <input type="text" class="form-control" name="inputCustomerEmail" id="inputCustomerEmail" value="<?= ($customer) ? $customer['customer_email'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-dark">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="customerForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('customers/create'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="source" id="source" value="customers">
                    <div class="form-group my-2">
                        <label for="inputCustomerFullname">Customer Fullname</label>
                        <input type="text" class="form-control" name="inputCustomerFullname" id="inputCustomerFullname" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="inputCustomerAddress">Customer Address</label>
                        <input type="text" class="form-control" name="inputCustomerAddress" id="inputCustomerAddress" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="inputCustomerTelephone">Customer Telephone</label>
                        <input type="text" class="form-control" name="inputCustomerTelephone" id="inputCustomerTelephone" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="inputCustomerEmail">Customer Email</label>
                        <input type="text" class="form-control" name="inputCustomerEmail" id="inputCustomerEmail">
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