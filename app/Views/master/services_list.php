<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Services List <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#serviceForm">Create New Service</button></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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