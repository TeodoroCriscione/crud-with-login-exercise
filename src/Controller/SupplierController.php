<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Form\SupplierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/supplier')]
final class SupplierController extends AbstractController
{
    #[Route('/', name: 'app_supplier')]
    public function index(): Response
    {
        return $this->render('supplier/index.html.twig', [
            'controller_name' => 'SupplierController',
        ]);
    }

    #[Route('/new', name: 'app_supplier_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supplier);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index'); // Or wherever you want to redirect
        }

        return $this->render('supplier/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
