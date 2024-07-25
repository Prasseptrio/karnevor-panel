<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h5 class="card-title mb-0"> Petty Cash List </h5>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#transferForm">Transfer</button>
                <button type="button" class="btn btn-dark btn-sm btn-add" data-bs-toggle="modal" data-bs-target="#pettyCashForm">Add New Petty Cash</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Bank Name</th>
                        <th>Account Holder</th>
                        <th>Account</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($PettyCash as $pettycash) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $pettycash['alias'] ?> </td>
                            <td><?= $pettycash['bank_name'] ?> </td>
                            <td><?= $pettycash['name'] ?> </td>
                            <td><?= $pettycash['account'] ?> </td>
                            <td>Rp. <?= number_format($pettycash['balance']) ?> </td>
                            <td>
                                <button type="submit" class="btn btn-secondary btn-sm btn-update" data-bs-toggle="modal" data-bs-target="#pettyCashForm" data-id="<?= $pettycash['petty_cash_id']; ?>" <?= ($pettycash['petty_cash_id'] < 1) ? 'disabled' : '' ?>>Update</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pettyCashForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('petty-cash/create'); ?>" method="post" id="petty-cash-form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="petty-cash-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="inputPettyCashID" id="inputPettyCashID">
                    <div class="form-group">
                        <label for="inputAlias">Alias</label>
                        <input type="text" class="form-control" name="inputAlias" id="inputAlias" required>
                    </div>
                    <div class="form-group mb-2 mt-3">
                        <label for="inputName">Account Holder</label>
                        <input type="text" class="form-control" name="inputName" id="inputName" required>
                    </div>
                    <div class="form-group mb-2 mt-3">
                        <label for="inputAccount">Account</label>
                        <input type="text" class="form-control" name="inputAccount" id="inputAccount" required>
                    </div>
                    <div class="form-group mb-2 mt-3">
                        <label for="inputBankName">Bank Name</label>
                        <input type="text" class="form-control" name="inputBankName" id="inputBankName" required>
                    </div>
                    <div class="form-group mb-2 mt-3">
                        <label for="inputBranchOffice">Branch Office</label>
                        <input type="text" class="form-control" name="inputBranchOffice" id="inputBranchOffice" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="transferForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('petty-cash/transfer'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Petty Cash Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group my-1">
                                <label for="inputTransferDate" class="my-1">Transaction Date</label>
                                <input type="date" class="form-control" name="inputTransferDate" id="inputTransferDate" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="inputSender" class="my-1">Sender Account</label>
                                <select name="inputSender" id="inputSender" class="form-select">
                                    <option value="">-- Choose Petty Cash --</option>
                                    <?php foreach ($PettyCash as $pettycash) : ?>
                                        <option value="<?= $pettycash['petty_cash_id']; ?>"><?= $pettycash['alias']; ?> <?= $pettycash['bank_name']; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group my-3">
                                <label for="inputRecipient" class="my-1">Recipient Account</label>
                                <select name="inputRecipient" id="inputRecipient" class="form-select">
                                    <option value="">-- Choose Petty Cash --</option>
                                    <?php foreach ($PettyCash as $pettycash) : ?>
                                        <option value="<?= $pettycash['petty_cash_id']; ?>"><?= $pettycash['alias']; ?> <?= $pettycash['bank_name']; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group my-1">
                                <label for="inputAmount" class="my-1">Amount</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fw-bold" id="basic-addon1">Rp. </span>
                                    </div>
                                    <input type="number" class="form-control" name="inputAmount" id="inputAmount" required>
                                </div>
                            </div>
                            <div class="form-group my-3">
                                <label for="inputDescription" class="my-1">Description</label>
                                <textarea name="inputDescription" id="inputDescription" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('javascript'); ?>
<script>
    $(document).ready(function() {
        $('.btn-add').click(function() {
            $('#petty-cash-title').html('Add New Petty Cash');
            $('#petty-cash-form').attr('action', '<?= base_url('petty-cash/create') ?>');
            $('#inputPettyCashID').val('');
            $('#inputAlias').val('');
            $('#inputName').val('');
            $('#inputAccount').val('');
            $('#inputBankName').val('');
            $('#inputBranchOffice').val('');
        });
        $('.btn-update').click(function() {
            let id = $(this).data('id');
            $('#petty-cash-title').html('Update Petty Cash');
            $('#petty-cash-form').attr('action', '<?= base_url('petty-cash/update') ?>');
            $.get("<?= base_url('petty-cash/get?id=') ?>" + id, function(data) {
                let pettyCash = JSON.parse(data);
                $('#inputPettyCashID').val(pettyCash.petty_cash_id);
                $('#inputAlias').val(pettyCash.alias);
                $('#inputName').val(pettyCash.name);
                $('#inputAccount').val(pettyCash.account);
                $('#inputBankName').val(pettyCash.bank_name);
                $('#inputBranchOffice').val(pettyCash.branch_office);
            });
        });
    });
</script>
<?= $this->endSection(); ?>