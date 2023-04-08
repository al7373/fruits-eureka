<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\FruitRepository;
use App\Entity\Fruit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class FruitController extends AbstractController
{
    /**
     * @Route("/api/fruits", name="index", methods={"GET"})
     */
    public function index(FruitRepository $fruitRepository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $name = $request->query->get('name', '');
        $family = $request->query->get('family', '');

        $fruits = $fruitRepository->findFruits($page, $name, $family);

        return $this->json($fruits, 200, [], ['groups' => 'fruit:list']);
    }

    /**
     * @Route("/api/fruits/{fruit_id}/favorite", name="toggle_favorite", methods={"POST"})
     * @ParamConverter("fruit", class="App\Entity\Fruit")
     */
    public function toggleFavorite(Fruit $fruit): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $fruit->setIsFavorite(!$fruit->getIsFavorite());
        $entityManager->flush();

        return $this->json([
            'message' => 'Fruit favorite status updated successfully',
            'isFavorite' => $fruit->getIsFavorite()
        ]);
    }


    /**
     * @Route("/api/fruits/favorites", name="get_favorites", methods={"GET"})
     */
    public function getFavorites(FruitRepository $fruitRepository): JsonResponse
    {
        $favoriteFruits = $fruitRepository->findFavoriteFruits();

        $totalNutritionFacts = [
            'carbohydrates' => 0,
            'protein'       => 0,
            'fat'           => 0,
            'calories'      => 0,
            'sugar'         => 0,
        ];

        foreach ($favoriteFruits as $fruit) {
            $totalNutritionFacts['carbohydrates'] += $fruit->getCarbohydrates();
            $totalNutritionFacts['protein']       += $fruit->getProtein();
            $totalNutritionFacts['fat']           += $fruit->getFat();
            $totalNutritionFacts['calories']      += $fruit->getCalories();
            $totalNutritionFacts['sugar']         += $fruit->getSugar();
        }

        return $this->json([
            'favoriteFruits'     => $favoriteFruits,
            'totalNutritionFacts' => $totalNutritionFacts,
        ], 200, [], ['groups' => 'fruit:list']);
    }

    /**
     * @Route("/", name="fruit_home")
     */
    public function home(): Response
    {
        return $this->render('fruit/index.html.twig');
    }

}
