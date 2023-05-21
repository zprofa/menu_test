<?php

namespace App\Http\Controllers;

use App\Services\Order\OrderSaver;
use App\Services\Order\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController
{
    public function __construct(
        private readonly OrderSaver $orderSaver,
        private readonly Validator $validator,
    ) {
    }

    public function create(): JsonResponse
    {
        $this->validator->validate(request());
        $orderData = request()->get('orderData');

        $order = $this->orderSaver->save($orderData);

        return response()->json([
            'orderData' => $orderData,
            'orderId' => $order->id,
        ]);
    }
}
