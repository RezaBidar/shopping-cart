<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class BaseController extends AbstractController
{
    protected function toJsonResponse($entity, SerializerInterface $serializer)
    {
        $response = new Response();
        $json = $serializer->serialize($entity, 'json', ['groups' => 'index']);
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}