<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<style>
    .bullet-line-list {
        padding-left: 30px;
        margin-bottom: 0;
        position: relative;
        list-style-type: none;
    }

    .rtl .bullet-line-list {
        padding-right: 0px;
    }

    .bullet-line-list li {
        position: relative;
        line-height: 1;
        padding-bottom: 10px;
    }

    .bullet-line-list li:before {
        content: "";
        position: absolute;
        border-radius: 100%;
        width: 12px;
        height: 12px;
        left: -28px;
        top: 6px;
        border: 3px solid black;
        margin-right: 15px;
        z-index: 2;
        background: #ffffff;
    }

    .bullet-line-list li:after {
        content: "";
        border: 1px solid #f2f2f2;
        position: absolute;
        bottom: 0;
        left: -23px;
        height: 100%;
    }

    .bullet-line-list li:first-child:after {
        content: "";
        height: 80%;
    }

    .bullet-line-list li:last-child {
        padding-bottom: 0;
    }

    .bullet-line-list li:last-child:after {
        content: "";
        top: 0;
        height: 30%;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <h5 class="card-title mb-0">Detail Loan</h5>
                <table class="table">
                    <tr>
                        <th>Loan To</th>
                        <td>: <?= $loan['loan_to'] ?></td>
                    </tr>
                    <tr>
                        <th>Loan Date</th>
                        <td>:
                            <?php
                            $loanDate = new DateTime($loan['loan_date']);
                            echo $loanDate->format('d F Y');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Loan Amount</th>
                        <td>: Rp. <?= number_format($loan['loan_amount']) ?></td>
                    </tr>
                    <tr>
                        <th>Rest Loan</th>
                        <td>: Rp. <?= number_format($loan['rest_loan']) ?></td>
                    </tr>
                    <tr>
                        <th>Loan Due Date</th>
                        <td>:
                            <?php
                            $loanDate = new DateTime($loan['loan_due_date']);
                            echo $loanDate->format('d F Y');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td class="fw-bold">: <?= ($loan['loan_status'] == 0) ? 'UNPAID' : 'PAID' ?></td>
                    </tr>
                </table>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modelId">
                        Pay Loan
                    </button>
                </div>
            </div>
            <div class="col-sm-8">
                <h5 class="card-title mb-3">Loan History</h5>
                <?php if ($LoansDetail) : ?>
                    <ul class="bullet-line-list pb-3">
                        <?php foreach ($LoansDetail as $loan_detail) :
                        ?>
                            <li>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex">
                                        <div class="ml-3">
                                            <h6 class="mb-0"><?= $loan_detail['description_loan_payment'] ?></h6>
                                            <small class="d-block mb-0">
                                                &emsp;<?php
                                                        $date = new DateTime($loan_detail['payment_date']);
                                                        echo $date->format('d F Y');
                                                        ?></small>
                                        </div>
                                    </div>
                                    <div>
                                        Rp. <?= number_format($loan_detail['amount_loan_payment']); ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <h3 class="text-center"> History is empty</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modelId" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('loan/payment'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Loan Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="inputLoanID" id="inputLoanId" value="<?= $loanID; ?>">
                    <div class="form-group my-3">
                        <label for="inputDescriptionLoanPayment" class="mb-2">Description Loan Payment</label>
                        <input type="text" class="form-control" name="inputDescriptionLoanPayment" id="inputDescriptionLoanPayment" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputAmountLoanPayment" class="mb-2">Amount Loan Payment</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="text" class="form-control" name="inputAmountLoanPayment" id="inputAmountLoanPayment" required>
                        </div>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputPettyCash">Bank Transfer</label>
                        <select name="inputPettyCash" id="inputPettyCash" class="form-select" required>
                            <option value="">-- Choose Petty Cash --</option>
                            <?php foreach ($PettyCash as $pettycash) : ?>
                                <option value="<?= $pettycash['petty_cash_id']; ?>"><?= $pettycash['alias']; ?> <?= $pettycash['bank_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputPaymentDate" class="mb-2">Payment Date</label>
                        <input type="date" class="form-control" name="inputPaymentDate" id="inputPaymentDate" required>
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