<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Comment;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tag = null;
        
        if ($request->get('tag')) {
            $tag = $entityManager->getRepository(Tag::class)->findOneBy(['name' => $request->get('tag')]);
        }

        return $this->render('page/index.html.twig', [
            'products' => $entityManager->getRepository(Product::class)->findLatest($tag),
        ]);
    }

    #[Route('/tag/{id}', name: 'app_tag')]
    public function tag(Tag $tag, EntityManagerInterface $entityManager): Response
    {
        return $this->render('page/tag.html.twig', [
            'tag' => $tag,
            'products' => $entityManager->getRepository(Product::class)->findByTag($tag)
        ]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function product(Product $product): Response
    {
        return $this->render('page/product.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/comments', name: 'app_comments')]
    public function comments(EntityManagerInterface $entityManager): Response
    {
        return $this->render('page/comments.html.twig', [
            'comments' => $entityManager->getRepository(Comment::class)->findAllComments()
        ]);
    }
}
