<?php

namespace App\Controller;

use App\Form\Product\Step\Data\ProductFlowDto;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\Product\ProductFlowType;
use App\Repository\ProductRepository;
use App\Service\CsvExporter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Flow\FormFlowInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/product')]
final class ProductController extends AbstractController
{
    #[Route(name: 'app_product_index')]
    #[IsGranted('PRODUCT_VIEW')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAllOrderedByPrice(),
        ]);
    }

    #[Route('/export', name: 'app_product_export', methods: ['GET'])]
    #[IsGranted('PRODUCT_VIEW')]
    public function export(ProductRepository $productRepository, CsvExporter $csvExporter): Response
    {
        $products = $productRepository->findAllOrderedByPrice();
        $data = [];

        foreach ($products as $product) {
            $data[] = [
                $product->getName(),
                $product->getDescription(),
                $product->getPrice(),
            ];
        }

        $csvContent = $csvExporter->export($data, ['name', 'description', 'price']);

        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv');

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'products.csv'
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    #[Route('/formflow', name: 'app_product_formflow')]
    #[IsGranted('PRODUCT_CREATE')]
    public function form(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();

        /** @var FormFlowInterface $flow */
        $flow = $this->createForm(ProductFlowType::class, new ProductFlowDto())
            ->handleRequest($request);

        if ($flow->isSubmitted() && $flow->isValid() && $flow->isFinished()) {
            $entityManager->persist($product);

            $this->addFlash('success', 'Formulaire correctement complété !');

            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/flow_new.html.twig', [
            'form'=> $flow->getStepForm(),
        ]);

    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    #[IsGranted('PRODUCT_CREATE')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    #[IsGranted('PRODUCT_VIEW')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    #[IsGranted('PRODUCT_EDIT')]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    #[IsGranted('PRODUCT_DELETE')]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

}
