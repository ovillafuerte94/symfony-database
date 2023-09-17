<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Comment;
use App\Entity\Product;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, TagRepository $tagRepository, ProductRepository $productRepository): Response
    {
        $tag = null;
        
        if ($request->get('tag')) {
            $tag = $tagRepository->findOneBy(['name' => $request->get('tag')]);
        }

        return $this->render('page/index.html.twig', [
            'products' => $productRepository->findLatest($tag),
        ]);
    }

    #[Route('/tag/{id}', name: 'app_tag')]
    public function tag(Tag $tag, ProductRepository $productRepository): Response
    {
        return $this->render('page/tag.html.twig', [
            'tag' => $tag,
            'products' => $productRepository->findByTag($tag)
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
    public function comments(CommentRepository $commentRepository): Response
    {
        return $this->render('page/comments.html.twig', [
            'comments' => $commentRepository->findAllComments()
        ]);
    }
}
