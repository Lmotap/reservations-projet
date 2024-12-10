<?php

class Reservation {
    private int $id;
    private int $user_id;
    private int $activity_id;
    private string $date_reservation;
    private string $statut;

    public function getId(): int 
    {
        return $this->id;
    }

    public function getUserId(): int 
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self 
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getActivityId(): int 
    {
        return $this->activity_id;
    }

    public function setActivityId(int $activity_id): self 
    {
        $this->activity_id = $activity_id;
        return $this;
    }

    public function getDateReservation(): string 
    {
        return $this->date_reservation;
    }

    public function setDateReservation(string $date_reservation): self 
    {
        $this->date_reservation = $date_reservation;
        return $this;
    }

    public function getStatut(): string 
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self 
    {
        $this->statut = $statut;
        return $this;
    }
}