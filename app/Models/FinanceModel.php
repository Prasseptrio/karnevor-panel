<?php

namespace App\Models;

use CodeIgniter\Model;

class FinanceModel extends Model
{
    public function getPettyCash($PettyCashID = false)
    {
        if ($PettyCashID) {
            return $this->db->table('finance_petty_cash')
                ->where(['finance_petty_cash.petty_cash_id' => $PettyCashID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('finance_petty_cash')
                ->get()->getResultArray();
        }
    }

    public function createPettyCash($dataPettyCash)
    {
        return $this->db->table('finance_petty_cash')->insert([
            'alias'             => $dataPettyCash['inputAlias'],
            'name'              => $dataPettyCash['inputName'],
            'bank_name'         => $dataPettyCash['inputBankName'],
            'branch_office'     => $dataPettyCash['inputBranchOffice'],
            'account'           => $dataPettyCash['inputAccount'],
            'balance'           => 0,
        ]);
    }
    public function updatePettyCash($dataPettyCash)
    {
        return $this->db->table('finance_petty_cash')->update([
            'alias'             => $dataPettyCash['inputAlias'],
            'name'              => $dataPettyCash['inputName'],
            'bank_name'         => $dataPettyCash['inputBankName'],
            'branch_office'     => $dataPettyCash['inputBranchOffice'],
            'account'           => $dataPettyCash['inputAccount']
        ], ['petty_cash_id'     => $dataPettyCash['inputPettyCashID']]);
    }
    public function updatePettyCashBalance($incoming, $pettycashID, $status)
    {
        $pettycash  =  $this->getPettyCash($pettycashID);
        if ($status == 1) {
            $balance = $pettycash['balance'] + $incoming;
        } else {
            $balance = $pettycash['balance'] - $incoming;
        }

        return $this->db->table('finance_petty_cash')->update(['balance' => $balance], ['petty_cash_id' => $pettycashID]);
    }

    public function transferPettyCash($dataPettyCash)
    {
        $this->db->transBegin();
        $this->db->table('finance_transfer')->insert([
            'sender_account'    => $dataPettyCash['inputSender'],
            'recipient_account' => $dataPettyCash['inputRecipient'],
            'transfer_date'     => $dataPettyCash['inputTransferDate'],
            'amount'            => $dataPettyCash['inputAmount'],
            'created_at'        => time(),
        ]);
        $this->updatePettyCashBalance(incoming: $dataPettyCash['inputAmount'], pettycashID: $dataPettyCash['inputSender'], status: 0);
        $this->updatePettyCashBalance(incoming: $dataPettyCash['inputAmount'], pettycashID: $dataPettyCash['inputRecipient'], status: 1);
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }


    public function getFinanceLoans($FinanceLoansID = false)
    {
        if ($FinanceLoansID) {
            return $this->db->table('finance_loans')
                ->where(['finance_loans.loan_id' => $FinanceLoansID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('finance_loans')
                ->get()->getResultArray();
        }
    }

    public function getFinanceDetail($loanID)
    {
        return $this->db->table('finance_loans_detail')
            ->where(['finance_loans_detail.loan_id' => $loanID])
            ->get()->getResultArray();
    }

    public function createFinanceLoans($dataFinanceLoans)
    {
        $this->db->transBegin();
        $this->db->table('finance_loans')->insert([
            'loan_date'       => date('Y-m-d'),
            'loan_to'         => $dataFinanceLoans['inputLoanTo'],
            'loan_amount'     => $dataFinanceLoans['inputLoanAmount'],
            'rest_loan'       => $dataFinanceLoans['inputLoanAmount'],
            'loan_interest'   => $dataFinanceLoans['inputLoanInterest'],
            'loan_due_date'   => $dataFinanceLoans['inputLoanDueDate'],
            'loan_term'       => $dataFinanceLoans['inputLoanTerm'],
            'loan_description' => $dataFinanceLoans['inputLoanDescription'],
            'loan_status'     => 0,
            'loan_category'   => $dataFinanceLoans['inputLoanCategory'],
            'created_at'      => time(),
        ]);
        $this->updatePettyCashBalance($dataFinanceLoans['inputLoanAmount'], $dataFinanceLoans['inputPettyCash'],  $dataFinanceLoans['inputLoanCategory']);
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
    public function paymentLoan($data)
    {
        $this->db->transBegin();
        $loan = $this->getFinanceLoans($data['inputLoanID']);
        $restLoan = $loan['rest_loan'] - $data['inputAmountLoanPayment'];
        if ($restLoan == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        $this->db->table('finance_loans')->update([
            'rest_loan'         => $restLoan,
            'loan_status'       => $status,
        ], ['loan_id' => $data['inputLoanID']]);

        $this->db->table('finance_loans_detail')->insert([
            'loan_id'                   => $data['inputLoanID'],
            'description_loan_payment'  => $data['inputDescriptionLoanPayment'],
            'amount_loan_payment'       => $data['inputAmountLoanPayment'],
            'payment_date'              => $data['inputPaymentDate'],
            'created_at'                => time(),
        ]);
        $loanType = ($loan['loan_category'] == 0) ? 1 : 0;
        $this->updatePettyCashBalance($data['inputAmountLoanPayment'], $data['inputPettyCash'], $loanType);
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
    public function getCapital($FinanceCapitalID = false)
    {
        if ($FinanceCapitalID) {
            return $this->db->table('finance_capital')
                ->where(['finance_capital.id' => $FinanceCapitalID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('finance_capital')
                ->join('investor', 'finance_capital.investor = investor.investor_id')
                ->get()->getResultArray();
        }
    }

    public function getInvestor($InvestorID = false)
    {
        if ($InvestorID) {
            return $this->db->table('investor')
                ->where(['investor.investor_id' => $InvestorID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('investor')
                ->get()->getResultArray();
        }
    }

    public function createFinanceCapital($dataCapital, $capitalProof)
    {
        $this->db->transBegin();
        $this->db->table('finance_capital')->insert([
            'investor'         => $dataCapital['inputInvestor'],
            'capital_amount'   => $dataCapital['inputCapitalAmount'],
            'capital_date'     => $dataCapital['inputCapitalDate'],
            'capital_proof'    => $capitalProof,
            'created_at'       => time()
        ]);
        $investor = $this->getInvestor($dataCapital['inputInvestor']);
        $investorCapital =  $investor['capital'] +  $dataCapital['inputCapitalAmount'];
        $this->db->table('investor')->update([
            'capital'         => $investorCapital,
        ], ['investor_id' => $dataCapital['inputInvestor']]);
        $this->updatePettyCashBalance($dataCapital['inputCapitalAmount'], $dataCapital['inputPettyCash'],  1);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function updateFinanceCapital($dataFinanceCapital)
    {
        return $this->db->table('finance_capital')->update([
            'investor'         => $dataFinanceCapital['inputInvestor'],
            'capital_amount'   => $dataFinanceCapital['inputCapitalAmount'],
            'capital_date'     => $dataFinanceCapital['inputCapitalDate'],
            'capital_proof'    => $dataFinanceCapital['inputCapitalProof'],
        ], ['id' => $dataFinanceCapital['inputFinanceCapitalID']]);
    }

    public function getOperationalCost($OperationalCostID = false)
    {
        if ($OperationalCostID) {
            return $this->db->table('finance_operational_cost')
                ->where(['finance_operational_cost.id' => $OperationalCostID])
                ->get()->getRowArray();
        } else {
            $month  = date('m');
            $year   = date('Y');
            return $this->db->table('finance_operational_cost')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
                ->getResultArray();
        }
    }

    public function getCostCategories()
    {
        return $this->db->table('finance_cost_category')->get()->getResultArray();
    }

    public function createOperationalCost($dataOperationalCost, $billAttachment)
    {
        $this->db->transBegin();
        $this->db->table('finance_operational_cost')->insert([
            'cost_invoice'          => $dataOperationalCost['inputCostInvoice'],
            'description'           => $dataOperationalCost['inputDescription'],
            'cost_category'         => $dataOperationalCost['inputCostCategory'],
            'bill'                  => $dataOperationalCost['inputBill'],
            'bill_attachment'       => $billAttachment,
            'transaction_date'      => $dataOperationalCost['inputTransactionDate'],
            'branch_id'             => $dataOperationalCost['inputBranch'],
            'created_at'            => time(),
        ]);
        $this->updatePettyCashBalance($dataOperationalCost['inputBill'], $dataOperationalCost['inputPettyCash'],  0);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function getTotalCostThisMonth()
    {
        $month  = date('m');
        $year   = date('Y');
        return $this->db->table('finance_operational_cost')
            ->selectSum('bill')
            ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
            ->getRowArray();
    }
    public function getTotalCostThisMonthByBranch($branch = false)
    {
        $month  = date('m');
        $year   = date('Y');
        if ($branch) {
            return $this->db->table('finance_operational_cost')
                ->selectSum('bill')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year, 'branch_id' => $branch])
                ->getRowArray();
        } else {
            return $this->db->table('finance_operational_cost')
                ->selectSum('bill')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
                ->getRowArray();
        }
    }
}
