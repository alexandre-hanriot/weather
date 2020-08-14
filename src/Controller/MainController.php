<?php

namespace App\Controller;

use App\Model\WeatherModel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home()
    {
        // Les données
        $data = WeatherModel::getWeatherData();

        return $this->render('main/home.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/city/{id}", name="city_select")
     */
    public function citySelect($id, SessionInterface $session)
    {
        // Données de la ville
        $cityData = WeatherModel::getWeatherByCityIndex($id);

        // Non trouvée ?
        if ($cityData === null) {
            throw $this->createNotFoundException('Ville non trouvée.');
        }

        // Mise en session de la donnée
        $session->set('widget', $cityData);

        // Redirect
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mountain", name="mountain")
     */
    public function mountain()
    {
        return $this->render('main/mountain.html.twig');
    }

    /**
     * @Route("/beaches", name="beaches")
     */
    public function beaches()
    {
        return $this->render('main/beaches.html.twig');
    }
}