<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{

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
     * @Route ("/room/{id<\d+>}", name="app_room_showOneRoom")
     */
    public function showOneRoom(RoomRepository $roomRepository, $id) : Response
    {
        $room = $roomRepository->find($id);
        
        return $this->render('blog/rooms.html.twig', [
            'room' => $room,
        ]);
    }
}
