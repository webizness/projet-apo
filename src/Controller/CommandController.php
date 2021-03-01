<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{
    /**
     * Liste des commandes
     * 
     * @Route("/barman/commandes", name="commands_list", methods={"GET"})
     */
    public function commandList()
    {
        $commandes = CommandeRepository::findAll();
        return $this->render('barman/commandlist.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * Affichage d'une commmande
     *
     * @Route("barman/commande/{id}", name="command_show", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function commandShow(int $id)
    {
        $command = CommandeRepository::find($id);
        
        if ($command === false) {
            throw $this->createNotFoundException();
        }
        return $this->render('barman/singlecommand.html.twig', [
            'commande' => $command,
        ]);
    }

    /**
     * Changement de statut
     *
     * @Route(
     *      "barman/commande/{id}/{status}",
     *      name="command_set_status",
     *      requirements={"id": "\d+", "status": "(done|undone)"},
     *      methods={"POST"}
     * )
     */
    public function commandSetStatus(int $id, $status)
    {
        // On récupére la valeur de retour de setStatus()
        $result=Commande::setStatus($id, $status);

        // Si $result vaut true on ajoute un message flash de succès
        // Sinon, un message flash d'erreur
        if ($result) {
            $this->addFlash('success', 'La commande a été marqué comme ' . $status);
        } else {
            $this->addFlash('danger', 'La commande n\'a pas été modifiée car elle n\'existe pas!');
        }
       
        return $this->redirectToRoute('commands_list');
    }

    /**
     * Annulation d'une commande
     * 
     * @Route("/commande/annulation/{id}", name="command_delete", requirements={"id": "\d+"}, methods={"POST"})
     */
    public function commandDelete(int $id)
    {
        // On supprime la commande de la session
        $result = Commande::delete($id);

        if ($result) {
            $this->addFlash('success', 'La commande a bien été annulée');
        } else {
            $this->addFlash('danger', 'Vous essayez d\'annuler une commande qui n\'existe pas !');
        }

        // On redirige l'utilisateur en GET sur la liste des commandes
        return $this->redirectToRoute('command_list');
    }
}
