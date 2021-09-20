<?php

namespace App\Http\Controllers;

use App\Models\PaymentDetail;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class PaymentDetailController extends Controller
{
    //
    public function all()
    {
        return PaymentDetail::all();
    }

    public function testAdd()
    {
        return PaymentDetail::updateOrCreate(['id' => null], (array) json_decode(json_encode(new PaymentDetail)));
    }

    public function saveBatch(Request $request)
    {
        $paymentDetails = json_decode($request->getContent());

        return $paymentDetails;
    }

    public function save(Request $request)
    {
        $bod =  json_decode($request->getContent(), true);

        $paymentDetails = $bod['data'];

        $paymentDetailsMapped = [];

        foreach ($paymentDetails as $paymentDetail) {
            $paymentDetailObj = new PaymentDetail((array) json_decode(json_encode($paymentDetail['paymentDetail']), true));

            // array_push($paymentDetailsMapped, (array) json_decode(json_encode($paymentDetail), true));

            $savedPaymentDetail = PaymentDetail::updateOrCreate(['id' => $paymentDetailObj->id], (array) json_decode(json_encode($paymentDetailObj), true));

            // var_dump($savedPaymentDetail->id);

            if ($paymentDetail['base64Image'] && $paymentDetail['base64Image'] != "====" && $paymentDetail['base64Image'] != "") {
                file_put_contents("images/img_" . (string) $savedPaymentDetail->id, base64_decode($paymentDetail['base64Image']));
            }
        }

        // return json_encode($paymentDetailsMapped);
    }
}
