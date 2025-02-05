<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Service\Payments\FinansbankPos;

class TestController extends Controller
{
    /**
     * Test için index fonksiyonu
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    private $finansbankPos;

    public function __construct(FinansbankPos $finansbankPos)
    {
        $this->finansbankPos = $finansbankPos;
    }
    public function index()
    {
        $credentials = [
            'client_id' => '085300000009597',
            'store_key' => '12345678',
            'username' => 'QNB_API_KULLANICI',
            'password' => 'FwCX2'
        ];
        $card = [
            'number' => '9792091234123455',
            'cvv' => '123',
            'month' => '12',
            'year' => '20'
        ];
        $order = [
            'code' => 'order12324',
            'amount' => '100',
            'installment' => '0',
            'success_url' => 'http://laravel_11.test/api/test/qnbReturn',
            'fail_url' => 'http://laravel_11.test/api/test/qnbReturn2'
        ];
        $form = $this->finansbankPos->form($credentials, $card, $order);

        Log::info("test");
        return response()->json([
            'form' => $form,
            'message' => 'test'
        ], 200);
    }

    public function qnbReturn(Request $request)
    {
        Log::info("qnbReturn");
        return response()->json([
            'message' => 'qnbReturn',
            'request' => $request->all()
        ], 200);
    }

    public function qnbReturn2(Request $request)
    {
        Log::info("qnbReturn2");
        return response()->json([
            'message' => 'qnbReturn2',
            'request' => $request->all()
        ], 200);
    }

}

