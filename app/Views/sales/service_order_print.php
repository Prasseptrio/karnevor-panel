<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Point of Sale Karnevor Indonesia">
    <meta name="author" content="Karnevor Indonesia">
    <title>Invoice | Karnevor Indonesia</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: 0.25em;
            margin-right: 0.25em;
            border-style: inset;
            border-width: 1px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .text-center {
            margin-left: 7.5%;
            margin-top: 1%;
        }
    </style>
</head>

<body>
    <div style="width:8cm ;" id="section-to-print">
        <div style="text-align: center ;margin-left: 0.25cm; margin-right: 0.25cm; ">
            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Bonty Logo" width="50%">
            <p style="font-size:10pt; margin-top:-5%">
                Karnevor Indonesia
                <br>
                Jl. Tajem Maguwoharjo, Sleman Yogyakarta
                <br>
                <?= $ServiceOrder['service_order_invoices'] . ' - ' . date_indo(date('Y-m-d', $ServiceOrder['service_order_created_at'])); ?>
            </p>
        </div>
        <hr>

        <?php foreach ($ServiceOrderDetail as $order) : ?>
            <table cellspacing='0' cellpadding='0.5' style="font-size:10pt; margin-left: 0.25cm; margin-right: 0.25cm;text-align: left" width="95%">
                <tr>
                    <td><?= $order['service_name']; ?> - <?= $order['service_package_name']; ?></td>
                    <td style='text-align:right; padding-right:'>Rp. <?= number_format($order['service_price']); ?></td>
                </tr>
                <tr>
                    <td style='text-align:left; padding-right:' colspan="2">(<?= $order['pet_name']; ?>)</td>
                </tr>
            </table>
        <?php endforeach; ?>
        <table cellspacing='0' cellpadding='0.5' style="font-size:10pt; margin-left: 0.25cm; margin-right: 0.25cm;text-align: left; margin-top:0.25cm;" width="95%">
            <tr>
                <td>Pickup Fee</td>
                <td style='text-align:right; padding-right:'>Rp. <?= number_format($ServiceOrder['pickup_fee']); ?></td>
            </tr>
        </table>
        <hr>
        <table cellspacing='0' cellpadding='0.5' style=" font-size:10pt; margin-left: 0.25cm; margin-right: 0.25cm;" width="95%">

            <tr>
                <td width='35%' style='font-size:12pt;'>Total Belanja</td>
                <td width='65%' style='text-align:right;font-size:12pt; '>Rp.<?= number_format(($ServiceOrder['service_order_total'] + $ServiceOrder['pickup_fee'])); ?></td>
            </tr>
            <tr>
                <td width='50%' style='text-align:left;font-size:12pt;'>Total Diskon</td>
                <td width='50%' style='text-align:right;font-size:12pt;'>Rp. <?= number_format($ServiceOrder['service_order_discount']); ?></td>
            </tr>

            <tr>
                <td width='35%' style='font-size:12pt;'>Total Bayar</td>
                <td width='65%' style='text-align:right;font-size:12pt; '>Rp.<?= number_format(($ServiceOrder['service_order_total'] + $ServiceOrder['pickup_fee']) - $ServiceOrder['service_order_discount']); ?></td>
            </tr>
        </table>
        <hr>
        <table cellspacing='0' cellpadding='0.5' style="font-size:12pt; margin-left: 0.25cm; margin-right: 0.25cm; " width="95%">
            <td>
                <p style='text-align:center; font-size:12pt;'>Terima Kasih</p>
            </td>
        </table>
    </div>
    <div class="text-center">
        <button id="printButton">Cetak Nota</button>
        <button onclick="window.location.href='<?= base_url('poservice'); ?>'">Kembali</button>
    </div>
    <script>
        $('#printButton').click(function() {
            window.print()
        });
    </script>
</body>