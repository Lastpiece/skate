<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomFormType;
use Doctrine\ORM\EntityManager;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

     /**
     * @Route ("/rooms", name="app_room_showRooms")
     */
    public function showRooms(RoomRepository $roomRepository) : Response
    {
        $rooms = $roomRepository->findAll();
        
        return $this->render('room/showRooms.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * @Route ("/rooms/{id<\d+>}", name="app_room_showOneRoom")
     */
    public function showOneRoom(RoomRepository $roomRepository, $id) : Response
    {
        $room = $roomRepository->find($id);
        
        return $this->render('blog/rooms.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route ("/room_create", name="app_room_create", methods="GET|POST")
     */
    public function create(EntityManagerInterface $em, Security $security, Room $room = null, Request $request){
        if(!$room){
            $room = new Room();
        }
        
        $form = $this->createForm(RoomFormType::class, $room);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->security->getUser();
            $room->setAuthor($user);

            
            $em->persist($room);
            $em->flush();
            $this->addFlash('sucess', 'Votre forum a bien été créer !');
            
            return $this->redirectToRoute('app_room_showRooms');
        }
        
        return $this->render('room/room_create.html.twig',[
            'room' => $room,
            'form' => $form->createView(),
            ]);
        }
        
    /**
     * @Route ("/room_edit/{id<\d+>}", name="app_room_edit", methods="GET|POST")
     */
    public function edit(Request $request, Room $room) : Response
    {
        $user = $this->security->getUser();
        if($user === $room->getAuthor()){
            $form = $this->createForm(RoomFormType::class, $room);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                
                return $this->redirectToRoute('app_room_showRooms');
            }

            return $this->render('room_edit.html.twig', [
                'room' => $room,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('common/error.html.twig', [
            'error' => 401,
            'message' => 'acces non autorisé'
        ]);
    }
        
    /**
     * @Route ("/room_delete/{id<\d+>}", name="app_room_delete", methods="POST")
     */
    public function delete(Request $request, Room $room) : Response
    {
        $user = $this->security->getUser();
        if($user === $room->getAuthor()){
            if($this->isCsrfTokenValid('delete'.$room->getId(),$request->request->get('_token'))){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($room);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_room_showRooms');
        }
        return $this->render('common/error.html.twig',[
            'error' => 401,
            'message' => 'acces non autorisé',
        ]);
    }
}
