<?php

class Reservation
{
    private int $id;
    private int $user_id;
    private int $activite_id;
    private string $date_reservation;
    private int $etat;
    private ?string $activite_nom;
    private ?string $description;
    private ?string $datetime_debut;
    private ?int $duree;
    private ?string $user_nom;
    private ?string $user_prenom;

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getActiviteId(): int
    {
        return $this->activite_id;
    }

    public function getDateReservation(): string
    {
        return $this->date_reservation;
    }

    public function getEtat(): bool
    {
        return (bool) $this->etat;
    }

    public function getActiviteNom(): ?string
    {
        return $this->activite_nom;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDatetimeDebut(): ?string
    {
        return $this->datetime_debut;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function getUserNom(): ?string
    {
        return $this->user_nom;
    }

    public function getUserPrenom(): ?string
    {
        return $this->user_prenom;
    }
}
