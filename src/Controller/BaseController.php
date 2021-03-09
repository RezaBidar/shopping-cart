<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

abstract class BaseController extends AbstractController
{
    protected function toJsonResponse($entity)
    {
        $response = new Response();
        $json = $this->get('serializer')->serialize($entity, 'json', ['groups' => 'index']);
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}