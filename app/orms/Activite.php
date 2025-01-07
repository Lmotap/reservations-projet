<?php

class Activite
{
    private int $id;
    private ?string $nom;
    private ?int $type_id;
    private ?int $places_disponibles;
    private ?string $description;
    private ?string $image_url;
    private ?string $datetime_debut;
    private ?int $duree;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): self
    {
        $this->type_id = $type_id;
        return $this;
    }

    public function getPlacesDisponibles(): int
    {
        return $this->places_disponibles;
    }

    public function setPlacesDisponibles(int $places_disponibles): self
    {
        $this->places_disponibles = $places_disponibles;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDatetimeDebut(): string
    {
        return $this->datetime_debut;
    }

    public function setDatetimeDebut(string $datetime_debut): self
    {
        $this->datetime_debut = $datetime_debut;
        return $this;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;
        return $this;
    }
}
