<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Suppliers List <a href="<?= base_url('suppliers/form'); ?>" class="btn btn-dark btn-sm float-end">Create New Supplier</a></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0 datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Whatsapp</th>
                        <th>Address</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($Suppliers as $suppliers) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $suppliers['company'] ?> </td>
                            <td><?= $suppliers['name'] ?> </td>
                            <td><?= $suppliers['email'] ?> </td>
                            <td><?= $suppliers['whatsapp'] ?> </td>
                            <td><?= $suppliers['address'] ?> </td>
                            <td><?= $suppliers['notes'] ?> </td>
                            <td>
                                <a href="<?= base_url('suppliers/form?id=' . $suppliers['supplier_id']); ?>" class="btn btn-secondary btn-sm">Update</a>
                                <form action="<?= base_url('suppliers/delete/' . $suppliers['supplier_id']); ?> " method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>