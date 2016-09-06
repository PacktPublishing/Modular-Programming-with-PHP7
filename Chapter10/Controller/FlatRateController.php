<?php

namespace Foggyline\ShipmentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FlatRateController extends Controller
{
    public function processAction(Request $request)
    {
        // Imagine we are calling the real shipment processor API here, and getting some transaction id back
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any

        return new JsonResponse(array(
            'success' => $transaction
        ));
    }
}
