<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('page/index.html.twig', [
            'products' => $entityManager->getRepository(Product::class)->findAll(),
        ]);
    }

    #[Route('/tag/{id}', name: 'app_tag')]
    public function tag(Tag $tag): Response
    {
        return $this->render('page/tag.html.twig', [
            'tag' => $tag,
            // 'products' => $tag->getProducts()
        ]);
    }
}
