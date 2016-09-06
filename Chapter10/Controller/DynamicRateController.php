<?php

namespace Foggyline\ShipmentBundle\Controller;

use Foggyline\ShipmentBundle\Entity\DynamicRate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DynamicRateController extends Controller
{
    public function processAction(Request $request)
    {
        /**
         * Incoming request should contain the same info as getInfo($street, $city, $country, $postcode, $amount, $qty)
         * plus the info about the selected delivery option
         * since we are doing (almost) the same API request here... whereas we would now "insert" shipment in API and return some transaction id or something
         *
         * Meaning, we would send the address details, amount, qty and desired delivery option to API now
         */

        // Imagine we are calling the real shipment processor API here, and getting some transaction id back
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any

        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }

        return new JsonResponse(array(
            'error' => 'Error occurred while processing DynamicRate shipment.'
        ));
    }


}
