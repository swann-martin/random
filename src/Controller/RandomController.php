<?php

namespace App\Controller;

use App\Entity\Snowflake;
use App\Form\SnowflakeType;
use App\Repository\SnowflakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RandomController extends AbstractController
{

    public $number;



    /**
     * @Route("/random", name="app_random_max")
     * 
     */
    public function random(): Response
    {
        if (isset($_GET['max'])) {
            $max = htmlspecialchars($_GET["max"]);
        } else {
            $max = 100;
        }

        $number = random_int(0, $max);
        // dd($number); // methode dump and die, fais un dumping de mon instruction et tue le reste du script
        return $this->render('snowstorm/random.html.twig', [
            'controller_name' => 'RandomController',
            'number' => $number
        ]);
    }

    /**
     * @Route("/snowflake", name="app_snowstorm")
     */
    public function snowtime(SnowflakeRepository $snowflakeRepository): Response
    {
        $snowflakes = $snowflakeRepository->findAll();

        return $this->render('snowstorm/index.html.twig', [
            'snowflakes' => $snowflakes
        ]);
    }

    /**
     * @Route("/snowflake/{id}", name="app_snowstorm_id")
     */
    public function snowtimeById(SnowflakeRepository $snowflakeRepository, $id): Response
    {
        $snowflakeById = $snowflakeRepository->findOneById($id);

        return $this->render('snowstorm/details.html.twig', [
            'snowflakeById' => $snowflakeById
        ]);
    }

    /**
     * @Route("/new", name="aap_new")
     */
    public function add()
    {
        $snow = new Snowflake();
        ($form = $this->createForm(SnowflakeType::class, $snow));

        return $this->render(
            'snowstorm/add.html.twig',
            ['form' => $form->createView()]
        );
    }
}
