<?php

namespace App\Controller;

use App\Entity\Snowflake;
use App\Form\SnowflakeType;
use App\Repository\SnowflakeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomController extends AbstractController
{

    public $number;



    /**
     * @Route("/random", name="app_random")
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
     * @Route("/snowflake", name="app_snowflake")
     */
    public function snowtime(SnowflakeRepository $snowflakeRepository): Response
    {
        $snowflakes = $snowflakeRepository->findAll();

        return $this->render(
            'snowstorm/index.html.twig',
            compact('snowflakes')
        );
    }

    /**
     * @Route("/snowflake/{id}", name="app_snowflake_show", requirements={"id"="\d+"})
     */
    public function snowtimeById(SnowflakeRepository $snowflakeRepository, $id): Response
    {
        $snowflake = $snowflakeRepository->findOneById($id);

        return $this->render('snowstorm/details.html.twig', [
            'snowflake' => $snowflake
        ]);
    }

    /**
     * @Route("/new", name="app_new", methods="GET|POST")
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $snowflake = new Snowflake();
        $form = $this->createForm(SnowflakeType::class, $snowflake);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $snowflake->setCreatedAt(new \DateTime('now'));
            $snowflake->setCreatedAtValue();
            $manager->persist($snowflake);
            $manager->flush();

            return $this->redirectToRoute('app_snowflake');
        }

        return $this->render(
            'snowstorm/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/snowflake/edit/{id<\d+>}", name ="app_snowflake_edit")
     */
    public function edit(Request $request, EntityManagerInterface $manager, Snowflake $snowflake): Response
    {

        $form = $this->createForm(SnowflakeType::class, $snowflake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($snowflake);
            $manager->flush();

            return $this->redirectToRoute('app_snowflake');
        }

        return $this->render(
            'snowstorm/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/snowflake/delete/{id<\d+>}", name ="app_snowflake_delete")
     */
    public function delete(Request $request, EntityManagerInterface $manager, Snowflake $snowflake): Response
    {
        if ($this->isCsrfTokenValid(
            'snowflake_deletion_' . $snowflake->getId(),
            $request->request->get('csrf_token')
        )) {
            $manager->remove($snowflake);
            $manager->flush();

            $this->addFlash('success', 'Your snowflake has been deleted successfully');
        }
        return $this->redirectToRoute('app_snowflake');
    }
}
