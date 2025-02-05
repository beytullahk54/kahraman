<?php

namespace App\Service\Payments;

class FinansbankPos
{
    public function form($credentials, $card, $order){
        $MbrId="5";
        $MerchantID=$credentials['client_id'];
        $MerchantPass=$credentials['store_key'];
        $UserCode=$credentials['username'];
        $UserPass=$credentials['password'];
        $SecureType="3DModel";
        $TxnType="Auth";
        $InstallmentCount=in_array($order['installment'], ['0', '1']) ? '0' : $order['installment'];
        $Currency="949";
        $OkUrl=$order['success_url'];
        $FailUrl=$order['fail_url'];
        $OrderId = $order['code'];
        $OrgOrderId="";
        $PurchAmount= floatval(number_format($order['amount'], 2, '.', ''));
        $Lang="TR";
        $rnd = microtime();
        $hashstr = $MbrId . $OrderId . $PurchAmount . $OkUrl . $FailUrl . $TxnType . $InstallmentCount . $rnd . $MerchantPass;
        $hash = base64_encode(pack('H*',sha1($hashstr)));

        $inputs = [
            'Pan' => $card['number'],
            'Cvv2' => $card['cvv'],
            'Expiry' => $card['month'] . $card['year'],
            'MbrId' => $MbrId,
            'MerchantID' => $MerchantID,
            'UserCode' => $UserCode,
            'UserPass' => $UserPass,
            'SecureType' => $SecureType,
            'TxnType' => $TxnType,
            'InstallmentCount' => $InstallmentCount,
            'Currency' => $Currency,
            'OkUrl' => $OkUrl,
            'FailUrl' => $FailUrl,
            'OrderId' => $OrderId,
            'OrgOrderId' => $OrgOrderId,
            'PurchAmount' => $PurchAmount,
            'Lang' => $Lang,
            'Rnd' => $rnd,
            'Hash' => $hash
        ];

        return [
            'gateway' => 'https://vpos.qnbfinansbank.com/Gateway/Default.aspx',
            'inputs' => $inputs
        ];
    }

    public function verify($credentials){
        $request = request()->all();

        if($request['3DStatus'] != '1'){
            $response = [
                'status' => 'failed',
                'message' => '3d işlemi doğrulanmadı:' . @$request['ErrMsg']
            ];
        }else{
            $userCode = $credentials['username'];
            $userPass = $credentials['password'];

            $requestGuid = $request["RequestGuid"];
            $orderidval = $request["OrderId"];
            $payersecuritylevelval = $request["Eci"];
            $payertxnidval = $request["PayerTxnId"];
            $payerauthenticationcodeval = $request["PayerAuthenticationCode"];

            $data = "RequestGuid=".$requestGuid."&".
                    "OrderId=".$orderidval."&".
                    "UserCode=".$userCode."&".
                    "UserPass=".$userPass."&".
                    "SecureType=3DModelPayment";

            $url = "https://vpos.qnbfinansbank.com/Gateway/Default.aspx";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
            curl_setopt($ch, CURLOPT_SSLVERSION, 4);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 90);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                $response = [
                    'status' => 'failed',
                    'message' => 'İşlem başarısız'
                ];
            } else {
                curl_close($ch);

                $resultValues = explode(";;", $result);
                $resultArr = [];
                foreach($resultValues as $resultt)
                {
                    list($key,$value)= explode("=", $resultt);
                    $resultArr[$key] = $value;
                }

                request()->merge([
                    'FINANSBANK_CURL_RESPONSE' => $resultArr
                ]);

                if($resultArr['ProcReturnCode'] == "00")
                {
                    $response = [
                        'status' => 'receive',
                        'message' => 'Ödeme başarılı.'
                    ];
                }else{
                    $response = [
                        'status' => 'failed',
                        'message' => "İşlem başarısız, Hata Sebebi : ".$resultArr['ErrMsg']
                    ];
                }
            }
        }

        return array_merge($response, [
            'terminal_id' => isset($resultArr['TerminalID']) ? $resultArr['TerminalID'] : ($resultArr['ClientId'] ?? null),
            'authcode' => $resultArr['AuthCode'] ?? null,
            'refno' => $resultArr['ReqId'] ?? null,
            'version' => $resultArr['Version'] ?? null,
            'payment_type' => $resultArr['SecureType'] ?? null
        ]);
    }
}