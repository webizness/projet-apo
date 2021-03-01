<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Bar;
use App\Entity\Barman;
use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Entity\Produit;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("dashboard", name="dashboard")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('A ton Apéro');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-tachometer');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        yield MenuItem::section('Ajouter des admins');
        yield MenuItem::linkToCrud('Admin(s)', 'fa fa-user-circle', Admin::class);
        
        yield MenuItem::section('Ajouter des bars');
        yield MenuItem::linkToCrud('Bar', 'fa fa-beer', Bar::class);
    
        yield MenuItem::section('Ajouter des barmans');
        yield MenuItem::linkToCrud('Barman', 'fa fa-id-card', Barman::class);
    
        yield MenuItem::section('Ajouter des Categories');
        yield MenuItem::linkToCrud('categorie(s)', 'fa fa-folder-open', Categorie::class);

        yield MenuItem::section('Ajouter des Clients');
        yield MenuItem::linkToCrud('client(s)', 'fa fa-users', Client::class);

        yield MenuItem::section('Ajouter des Commandes');
        yield MenuItem::linkToCrud('commande(s)', 'fa fa-shopping-cart', Commande::class);

        yield MenuItem::section('Ajouter des lignes de commande');
        yield MenuItem::linkToCrud('ligne de commande(s)', 'fa fa-credit-card', LigneDeCommande::class);

        yield MenuItem::section('Ajouter des produits');
        yield MenuItem::linkToCrud('produit(s)', 'fa fa-clipboard', Produit::class);

        yield MenuItem::section('Ajouter des User(s)');
        yield MenuItem::linkToCrud('user(s)', 'fa fa-address-book', User::class);
    }
}
