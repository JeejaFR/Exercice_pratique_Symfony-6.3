<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categorie', name: 'app.categorie')]
class CategorieController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private CategorieRepository $repo,
    )
    {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render("categorie/index.html.twig",[
            'categories' => $this->repo->findAll(),
        ]);
    }

    #[Route('/create',name: '.create',methods: ['GET','POST'])]
    public function create(Request $request): Response | RedirectResponse {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categorie);
            $this->em->flush();

            $this->addFlash('success',"La catégorie à été crée avec succès");
            return $this->redirectToRoute('app.categorie.index');
        }

        return $this->render('categorie/create.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name:'.update',methods:['GET','POST'])]
    public function update(?Categorie $categorie, Request $request): Response | RedirectResponse{
        if(!$categorie instanceof Categorie){
            $this->addFlash('error',"La catégorie est introuvable");
            return $this->redirectToRoute('app.categorie.index');
        }

        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categorie);
            $this->em->flush();

            $this->addFlash('success',"La catégorie à été modifié avec succès");
            return $this->redirectToRoute('app.categorie.index');
        }

        return $this->render('categorie/update.html.twig', [
            'form' => $form,
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/delete', name:'.delete',methods: ['POST'])]
    public function delete(?Categorie $categorie, Request $request): RedirectResponse {
        if(!$categorie instanceof Categorie){
            $this->addFlash('error','La catégorie est introuvable');
            return $this->redirectToRoute('app.categorie.index');
        }

        if($this->isCsrfTokenValid('delete'. $categorie->getId(), $request->request->get('token'))){
            $this->em->remove($categorie);
            $this->em->flush();

            $this->addFlash('success',"La catégorie à été supprimé");
            return $this->redirectToRoute('app.categorie.index');
        }

        $this->addFlash('error',"token CSRF invalide, la catégorie n'a pas été supprimé");
        return $this->redirectToRoute('app.catégorie.index');
    }
}

