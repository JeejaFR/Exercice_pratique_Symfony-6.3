<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPUnit\Framework\isEmpty;

#[Route('/livre', name: 'app.livre')]
class LivreController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private LivreRepository $repo,
        private AuteurRepository $auteurRepo,
    )
    {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render("livre/index.html.twig",[
            'livres' => $this->repo->findAll(),
        ]);
    }

    #[Route('/create',name: '.create',methods: ['GET','POST'])]
    public function create(Request $request): Response | RedirectResponse {
        $auteurs = $this->auteurRepo->findAll();
        if(count($auteurs)==0){
            $this->addFlash('warning',"Veuillez ajouter un auteur avant d'ajouter un livre");
            return $this->redirectToRoute('app.livre.index');
        }

        $livre = new Livre();

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($livre);
            $this->em->flush();

            $this->addFlash('success',"Le livre à été crée avec succès");
            return $this->redirectToRoute('app.livre.index');
        }

        return $this->render('livre/create.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name:'.update',methods:['GET','POST'])]
    public function update(?Livre $livre, Request $request): Response | RedirectResponse{
        if(!$livre instanceof Livre){
            $this->addFlash('error',"Le livre est introuvable");
            return $this->redirectToRoute('app.livre.index');
        }

        $form = $this->createForm(LivreType::class,$livre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($livre);
            $this->em->flush();

            $this->addFlash('success',"Le livre à été modifié avec succès");
            return $this->redirectToRoute('app.livre.index');
        }

        return $this->render('livre/update.html.twig', [
            'form' => $form,
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/delete', name:'.delete',methods: ['POST'])]
    public function delete(?Livre $livre, Request $request): RedirectResponse {
        if(!$livre instanceof Livre){
            $this->addFlash('error','Le livre est introuvable');
            return $this->redirectToRoute('app.livre.index');
        }

        if($this->isCsrfTokenValid('delete'. $livre->getId(), $request->request->get('token'))){
            $this->em->remove($livre);
            $this->em->flush();

            $this->addFlash('success',"Le livre à été supprimé");
            return $this->redirectToRoute('app.livre.index');
        }

        $this->addFlash('error',"token CSRF invalide, le livre n'a pas été supprimé");
        return $this->redirectToRoute('app.livre.index');
    }
}

