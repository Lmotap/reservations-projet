<?php

class User
{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $motdepasse;
    private string $role;

    public function getId(): int
    {
        return $this->id;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPwd(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;
        return $this;
    }
    public function getPwd(): string
    {
        return $this->motdepasse;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
    public function getNom(): string
    {
        return $this->nom;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
    public function getRole(): string
    {
        return $this->role;
    }
}
