<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\CreneauModel;

class ClientController extends BaseController
{
    public function dashboard()
    {
        $session = session();
        $userId = $session->get('id');
        $reservationModel = new ReservationModel();

        // Récupération des statistiques pour les blocs colorés
        $stats = [
            'attente' => $reservationModel->where(['user_id' => $userId, 'statut' => 'en attente'])->countAllResults(),
            'confirmee' => $reservationModel->where(['user_id' => $userId, 'statut' => 'confirmée'])->countAllResults(),
            'annulee' => $reservationModel->where(['user_id' => $userId, 'statut' => 'annulée'])->countAllResults(),
        ];

        // Récupération des réservations à venir avec jointures
        // On récupère les infos du créneau et de la ressource associée
        $prochainesReservations = $reservationModel->select('reservations.*, creneaux.date_debut, creneaux.date_fin, ressources.nom as ressource_nom')
            ->join('creneaux', 'creneaux.id = reservations.creneau_id')
            ->join('ressources', 'ressources.id = creneaux.ressource_id')
            ->where('reservations.user_id', $userId)
            ->orderBy('creneaux.date_debut', 'ASC')
            ->findAll(5); // On limite aux 5 prochaines

        $data = [
            'stats' => $stats,
            'reservations' => $prochainesReservations,
            'nom_utilisateur' => $session->get('nom')
        ];

        return view('client/dashboard', $data);
    }
}