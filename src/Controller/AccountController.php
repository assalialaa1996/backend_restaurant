<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Client;
use App\Entity\RestaurantOwner;
use App\Entity\Restaurant;
use App\Entity\Speciality;
use App\Entity\RestaurantService;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

class AccountController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //$page = $this->render('dashboard/index.html.twig');
       // return parent::index();
        //return $this->render('dashboard/index.html.twig');
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(RestaurantCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Congo food');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
        return [
            MenuItem::linkToRoute('DASHBOARD', 'fa fa-home', 'accueil'),
            //MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            
            MenuItem::subMenu('RESTAURANTS')->setSubItems([
                MenuItem::linkToCrud('Restaurant', 'fa fa-file-text', Restaurant::class),
                MenuItem::linkToCrud('Specialité', 'fa fa-file-text', Speciality::class),
                MenuItem::linkToCrud('Service', 'fa fa-file-text', RestaurantService::class),
            ]),

            MenuItem::subMenu('UTILISATEURS')->setSubItems([
                MenuItem::linkToCrud('Client', 'fa fa-user', Client::class),
                MenuItem::linkToCrud('Restaurateur', 'fa fa-users', RestaurantOwner::class),
            ]),
        ];
    }
}
