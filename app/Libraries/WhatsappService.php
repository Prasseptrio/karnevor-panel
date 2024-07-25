<?php


namespace App\Libraries;

use App\Models\SalesModel;

class WhatsappService
{
    protected $SalesModel;

    function __construct()
    {
        $this->SalesModel = new SalesModel();
    }

    public function followup($reservation)
    {
        $curl = curl_init();
        try {
            if (substr($reservation['customer_telephone'], 0, 1) == '+') {
                $string = str_replace('-', '', $reservation['customer_telephone']);
                $replace = str_replace(' ', '', $string);
                $nomor = str_replace('+', '', $replace);
            } else {
                $string = ltrim($reservation['customer_telephone'], '0');
                $nomor = '62' . $string;
            }

            $text = 'Halo kak ' . $reservation['customer_fullname'] . ', terima kasih telah melakukan reservasi di Grooming Space Jogja. Konfirmasi selanjutnya jika menggunakan metode Antar Jemput maka mohon menyertakan Share Location untuk titik penjemputan. 
Jika ada catatan tambahan bisa dikonfirmasi kembali melalui Whatsapp.

Terima kasih ☺✨';

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'appkey' => '2c2fde63-7015-4e38-aa91-f59b3c211dc2',
                    'authkey' => 'peoiOfnjtaS74PSlYyYh4IGACTbeaQ1rZIn3jbB3VON6K3FLFg',
                    'to' => $nomor,
                    'message' => $text,
                    'sandbox' => 'false'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return json_decode($response, true)['message_status'];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
