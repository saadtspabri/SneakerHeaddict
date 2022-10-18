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
 * @Route("/sneaker")
 */

class SneakerController extends AbstractController
{
    /**
    *[Route('/sneaker', name: 'app_sneaker')]
    */
    
    public function indexSneaker(): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
  <body>    Liste des Showrooms :
    <ul>
      <li>...AirForce 1 Noir...</li>
      <li>...AirForce 1 Blanc...</li>
      <li>...StanSmith Blanc...</li>
      <li>...DunkLow Green Lemon...</li>
      <li>...DunkLow University Blue...</li>
    </ul>
  </body>
</html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }
    
    /**
     * Lists all shworoom entities.
     *
     * @Route("/list", name="sneaker_list")
     */
    
    public function listSneaker(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sneaker lists</title>
    </head>
    <body>
        <h1>Sneaker list</h1>
        <p>Voici les la liste des sneakers disponible:</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $sneakers = $entityManager->getRepository(Sneaker::class)->findAll();
        foreach($sneakers as $sneaker) {
            $htmlpage .= '<li>
            <a href="/sneaker/'.$sneaker->getid().'">'.$sneaker->getModel().' '.$sneaker->getColor().'</a></li>';
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
     * Show a sneaker
     *
     * @Route("/{id}", name="sneaker_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    
    public function showSneaker(ManagerRegistry $doctrine, $id): Response
    {
        
        $sneakerrepo = $doctrine->getRepository(Sneaker::class);
        $sneaker = $sneakerrepo->find($id);
        
        if (!$sneaker) {
            throw $this->createNotFoundException('The sneaker does not exist');
        }
        
        $res ='<!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Sneaker :'.$sneaker->getModel().' details</title>
            </head>
        <body>
            <h1>Caractéristique technique</h1>
            <ul>
            <dl>
        <dt>Modèle : '.$sneaker->getModel().'</dt>
        <dt>Couleur : '.$sneaker->getColor().'</dt>
        </dl>
        </ul></body></html>';
        return new Response('<html><body>'. $res . '</body></html>');
    }
    
}
