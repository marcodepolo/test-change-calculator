<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Registry\CalculatorRegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * Use of Symfony's dependency injection to get the service
     *
     * @Route("/automaton/{model}/change/{amount}", methods="GET", name="change")
     */
    public function change(CalculatorRegistryInterface $calculatorRegistry, string $model, int $amount): Response
    {
        $calculator = $calculatorRegistry->getCalculatorFor($model);
        if (null === $calculator) {
            throw $this->createNotFoundException();
        }

        $change = $calculator->getChange($amount);
        if (null === $change) {
            return new Response('impossible to make change for this amount!', 204);
        }

        return new JsonResponse($change);
    }
}
