<?php

namespace Vep\ReservationBundle\Service;

class Theater {
    private $map;
    
    public function getMap() {
        if ($this->map === null) {
            $this->map = json_decode(file_get_contents(__DIR__ . '/../Resources/config/theater.json'), true);
        }
        return $this->map;
    }
    
    public function getMapWithReservations($session) {
        $result = array();
        foreach($this->getMap() as $seat) {
            $data = $seat;
            $data['taken'] = false;
            foreach ($session->getReservations() as $reservation) {
                foreach($reservation->getSeats() as $takenSeat) {
                    if ($data['name'] == $takenSeat) {
                        $data['taken'] = true;
                    }
                }
            }
            $result[] = $data;
        }
        return $result;
    }
    
    public function getFreeSeatList($session) {
        $seats = array();
        foreach($this->getMapWithReservations($session) as $seat) {
            if (!$seat['taken']) {
                $seats[$seat['name']] = $seat['name'];
            }
        }
        return $seats;
    }
}