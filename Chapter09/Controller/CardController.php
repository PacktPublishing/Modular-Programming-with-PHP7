<?php

namespace Foggyline\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CardController extends Controller
{
    public function authorizeAction(Request $request)
    {
        // Incoming request should/might contain the CardType form
        // Imagine we are calling the real payment processor API here, and getting some transaction id back
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any

        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }

        return new JsonResponse(array(
            'error' => 'Error occurred while processing Card payment.'
        ));
    }

    public function captureAction(Request $request)
    {
        // Incoming request should/might contain the CardType form
        // Imagine we are calling the real payment processor API here, and getting some transaction id back
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any

        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }

        return new JsonResponse(array(
            'error' => 'Error occurred while processing Card payment.'
        ));
    }

    public function cancelAction(Request $request)
    {
        // Imagine we are calling the real payment processor API here, and getting some transaction id back
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any

        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }

        return new JsonResponse(array(
            'error' => 'Error occurred while processing Card payment.'
        ));
    }
}
