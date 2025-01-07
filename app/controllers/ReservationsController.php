<?php

// Inclusion des fichiers nécessaires
require_once './app/models/ReservationModel.php';
require_once './app/models/ActiviteModel.php';
require_once './app/utils/AuthMiddleware.php';
require_once './app/utils/Render.php';

class ReservationsController
{
    use Render;
    private ReservationModel $reservationModel;
    private ActiviteModel $activiteModel;

    // Constructeur : initialisation des modèles
    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
        $this->activiteModel = new ActiviteModel();
    }

    /**
     * Affiche les réservations de l'utilisateur connecté
     */
    public function index()
    {
        AuthMiddleware::isAuthenticated();
        $userId = $_SESSION['user']['id'];
        $reservations = $this->reservationModel->getReservationsByUserId($userId);
        $this->renderView('reservations/index', [
            'title' => 'Mes Réservations',
            'reservations' => $reservations
        ], 'reservations');
    }

    /**
     * Crée une nouvelle réservation
     */
    public function create()
    {
        AuthMiddleware::isAuthenticated();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['activity_id'])) {
            header('Location: /activities');
            exit();
        }

        $activityId = (int) $_POST['activity_id'];
        $userId = $_SESSION['user']['id'];

        if ($this->reservationModel->createReservation($userId, $activityId)) {
            header('Location: /reservations');
        } else {
            $_SESSION['error'] = 'Impossible de créer la réservation.';
            header('Location: /activities/show/' . $activityId);
        }
        exit();
    }

    /**
     * Affiche les détails d'une réservation spécifique
     * @param int $id
     */
    public function show(int $id)
    {
        AuthMiddleware::isAuthenticated();
        $userId = $_SESSION['user']['id'];

        $reservation = $this->reservationModel->getReservationById($id);

        if (!$reservation || $reservation->getUserId() !== $userId) {
            require_once './app/views/errors/404.php';
            exit();
        }
        $this->renderView('reservations/show', [
            'title' => 'Détails de la réservation',
            'reservation' => $reservation
        ], 'reservations');
    }

    /**
     * Annule une réservation
     * @param int $id
     */
    public function cancel(int $id)
    {
        AuthMiddleware::isAuthenticated();
        $userId = $_SESSION['user']['id'];

        $reservation = $this->reservationModel->getReservationById($id);

        if (!$reservation || $reservation->getUserId() !== $userId) {
            header('Location: /reservations');
            exit();
        }

        if ($this->reservationModel->cancelReservation($id)) {
            $_SESSION['success'] = 'La réservation a été annulée avec succès.';
        } else {
            $_SESSION['error'] = "Impossible d'annuler la réservation.";
        }

        header('Location: /reservations');
        exit();
    }

    /**
     * Liste toutes les réservations (admin uniquement)
     */
    public function list()
    {
        AuthMiddleware::isAdmin();
        $reservations = $this->reservationModel->getAllReservations();
        $this->renderView('reservations/list', [
            'title' => 'Toutes les réservations',
            'reservations' => $reservations
        ], 'reservations');
    }
}
