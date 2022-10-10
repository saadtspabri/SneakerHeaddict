<?php

namespace App\Controller;

use App\Entity\Showroom;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Sneaker;

class ShowroomController extends AbstractController
{
    #[Route('/showroom', name: 'app_showroom')]
    public function indexSneakers(): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
  <body>Liste des Showrooms :
    <ul>
      <li>...La caverne d\'Abdel Aziz...</li>
      <li>...L\'antre de Saad...</li>
      <li>...Le repère de Soumaya...</li>

      ....

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
     * Show a showroom
     *
     * @Route("/showroom/{id}", name="showroom_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function showInventaire(ManagerRegistry $doctrine, $id)
    {
        $showroomRepo = $doctrine->getRepository(Showroom::class);
        $showroom = $showroomRepo->find($id);
        $sneakerRepo = $doctrine->getRepository(Sneaker::class);
        $sneaker = $sneakerRepo->find($id);
        
        
        if (!$showroom) {
            throw $this->createNotFoundException('The showroom does not exist');
        }
        
        $res = '1';
        $res ='<!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Showroom :'.$showroom->getName().' details</title>
            </head>
        <body>';
        
        $res .= '<dt>Sneaker</dt><dd>' . $sneaker->getModel() . '</dd>';
        $res .= '<dt></dt> <dd> ' . $sneaker->getColor() . '</dd>';
        
        $res .= '</dl>';
        $res .= '</ul></body></html>';
        
        $res .= '<p/><a href="' . $this->generateUrl('showroom_index') . '">Back</a>';
        
        return new Response('<html><body>'. $res . '</body></html>');
    }
    
}
