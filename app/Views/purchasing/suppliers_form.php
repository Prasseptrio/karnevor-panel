<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> Form</h1>
<div class="card">
    <div class="card-body ">
        <div class="d-flex justify-content-center">
            <div class="col-sm-8">
                <form action="<?= ($supplier) ? base_url('suppliers/update') : base_url('suppliers/create'); ?>" method="post">
                    <input type="hidden" name="inputSuppliersID" value="<?= ($supplier) ? $supplier['supplier_id'] : ''; ?>">
                    <div class="mb-3 row">
                        <label class="col-sm-2" for="inputCompany">Company</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputCompany" id="inputCompany" value="<?= ($supplier) ? $supplier['company'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2" for="inputName">Contact Person</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputName" id="inputName" value="<?= ($supplier) ? $supplier['name'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2" for="inputEmail">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputEmail" id="inputEmail" value="<?= ($supplier) ? $supplier['email'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2" for="inputWhatsapp">Whatsapp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputWhatsapp" id="inputWhatsapp" value="<?= ($supplier) ? $supplier['whatsapp'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2" for="inputAddress">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputAddress" id="inputAddress" value="<?= ($supplier) ? $supplier['address'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2" for="inputNotes">Notes</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputNotes" id="inputNotes" value="<?= ($supplier) ? $supplier['notes'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-dark" type="submit">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>