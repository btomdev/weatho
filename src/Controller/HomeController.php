<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( HttpClientInterface $client ): Response
    {
        $response = $client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?lat=48.90508212632233&lon=2.440328488068335&appid=7fe1d2f8a7734f614cd5de324b33a93c&units=metric'
        );

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        $weather = [
            'temperature' => $content['main']['temp'],
            'feels_like' => $content['main']['feels_like'],
            'humidity' => $content['main']['humidity'],
        ];

        return $this->render('home.html.twig', [
            'weather' => $weather
        ]);
    }
}
