<?php

namespace App\Controller;

use App\Entity\Sneaker;
use App\Entity\Showroom;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SneakerRepository;
use App\Repository\ShowroomRepository;


/**
 * Controleur Showroom
 * @Route("/showroom")
 */

class ShowroomController extends AbstractController
{
    
    /**
    *[Route('/showroom', name: 'app_showroom')]
    */
    
    public function indexShowroom(): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
  <body>    Liste des Showrooms :
    <ul>
      <li>...La caverne d\'Abdel Aziz...</li>
      <li>...L\'antre de Saad...</li>
      <li>...Le repère de Soumaya...</li>
    </ul>
  </body>
</html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
        #return $this->render('showroom/index.html.twig', [
        #    'controller_name' => 'ShowroomController',
        #]);
    }
    
    /**
     * Lists all shworoom entities.
     *
     * @Route("/list", name="showroom_list")
     */
    
    
    public function listShowroom(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Showroom lists</title>
    </head>
    <body>
        <h1>Showroom list</h1>
        <p>Voici les la liste des showrooms:</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $showrooms = $entityManager->getRepository(Showroom::class)->findAll();
        
       /*  #Méthode de URL 'à la main'
        foreach($showrooms as $showroom) {
            $htmlpage .= '<li>
            <a href="/showroom/'.$showroom->getid().'">'.$showroom->getName().'</a></li>';
        }        
        */
        
        #Méthode de URL via le générateur
        foreach($showrooms as $showroom) {
        $htmlpage .= '<li><a href='.$this->generateUrl( 'showroom_show',    ['id' => $showroom->getId() ] ).'>'.$showroom->getName().'</a></li>';
        }
        $htmlpage .= '</ul>';
        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }
    
    /**
     * Show a showroom
     *
     * @Route("/{id}", name="showroom_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function showShowroom(ManagerRegistry $doctrine, $id): Response
    {
        
        $showroomrepo = $doctrine->getRepository(Showroom::class);
        $showroom = $showroomrepo->find($id);
        
        if (!$showroom) {
            throw $this->createNotFoundException('The showroom does not exist');
        }
        
        $res ='<!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>'.$showroom->getName().' details</title>
            </head>
        <body>
            <h2>Sneakers Details :</h2>
            <ul>
            <dl>Sneaker';
        $sneakers = $showroom->getRelation();
        foreach ($sneakers as $sneaker)
            {
                $res .= '<dt><dd>' . $sneaker->getModel() .' '. $sneaker->getColor() .' <a href="/sneaker/'.$sneaker->getid().'">'.$sneaker->getId().'</a></dd></dt>';
            }
            $res .= '</dl>';
            $res .= '</ul></body></html>';
        return new Response('<html><body>'. $res . '</body></html>');
    }
    
}
