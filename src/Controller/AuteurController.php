<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/auteur', name: 'app.auteur')]
class AuteurController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private AuteurRepository $repo,
    )
    {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render("auteur/index.html.twig",[
            'auteurs' => $this->repo->findAll(),
        ]);
    }

    #[Route('/create',name: '.create',methods: ['GET','POST'])]
    public function create(Request $request): Response | RedirectResponse {
        $auteur = new Auteur();

        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($auteur);
            $this->em->flush();

            $this->addFlash('success',"L'auteur à été crée avec succès");
            return $this->redirectToRoute('app.auteur.index');
        }

        return $this->render('auteur/create.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name:'.update',methods:['GET','POST'])]
    public function update(?Auteur $auteur, Request $request): Response | RedirectResponse{
        if(!$auteur instanceof Auteur){
            $this->addFlash('error',"L'auteur est introuvable");
            return $this->redirectToRoute('app.auteur.index');
        }

        $form = $this->createForm(AuteurType::class,$auteur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($auteur);
            $this->em->flush();

            $this->addFlash('success',"L'auteur à été modifié avec succès");
            return $this->redirectToRoute('app.auteur.index');
        }

        return $this->render('auteur/update.html.twig', [
            'form' => $form,
            'auteur' => $auteur,
        ]);
    }

    #[Route('/{id}/delete', name:'.delete',methods: ['POST'])]
    public function delete(?Auteur $auteur, Request $request): RedirectResponse {
        if(!$auteur instanceof Auteur){
            $this->addFlash('error','Auteur introuvable');
            return $this->redirectToRoute('app.auteur.index');
        }

        if($this->isCsrfTokenValid('delete'. $auteur->getId(), $request->request->get('token'))){
            $this->em->remove($auteur);
            $this->em->flush();

            $this->addFlash('success',"L'auteur à été supprimé");
            return $this->redirectToRoute('app.auteur.index');
        }

        $this->addFlash('error',"token CSRF invalide, l'auteur n'a pas été supprimé");
        return $this->redirectToRoute('app.auteur.index');
    }
}
