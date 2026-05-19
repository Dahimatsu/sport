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

    public function creneaux()
    {
        $creneauModel = new CreneauModel();

        // On récupère les créneaux actifs avec les infos de la ressource
        $allCreneaux = $creneauModel->select('creneaux.*, ressources.nom as ressource_nom, ressources.type as ressource_type, ressources.capacite as total_places')
            ->join('ressources', 'ressources.id = creneaux.ressource_id')
            ->where('creneaux.actif', 1)
            ->where('creneaux.date_debut >', date('Y-m-d H:i:s'))
            ->orderBy('creneaux.date_debut', 'ASC')
            ->findAll();

        return view('client/creneaux', ['creneaux' => $allCreneaux]);
    }

    public function reserver($id)
    {
        $session = session();
        $creneauModel = new CreneauModel();
        $reservationModel = new ReservationModel();

        $creneau = $creneauModel->find($id);

        if (!$creneau || $creneau['places_dispo'] <= 0) {
            $session->setFlashdata('error', 'Désolé, ce créneau n\'est plus disponible.');
            return redirect()->back();
        }

        // Début d'une transaction pour garantir la cohérence des données
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Créer la réservation
        $reservationModel->save([
            'user_id' => $session->get('id'),
            'creneau_id' => $id,
            'statut' => 'en attente',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Décrémenter les places disponibles
        $creneauModel->update($id, [
            'places_dispo' => $creneau['places_dispo'] - 1
        ]);

        $db->transComplete();

        $session->setFlashdata('success', 'Votre demande de réservation a été envoyée.');
        return redirect()->to('/client/dashboard');
    }

    public function annuler($id)
    {
        $session = session();
        $reservationModel = new ReservationModel();
        $creneauModel = new CreneauModel();

        $res = $reservationModel->find($id);

        // Sécurité : on vérifie que la réservation appartient bien à l'utilisateur
        if (!$res || $res['user_id'] != $session->get('id')) {
            return redirect()->to('/client/dashboard');
        }

        if ($res['statut'] == 'en attente') {
            $db = \Config\Database::connect();
            $db->transStart();

            // 1. Changer le statut
            $reservationModel->update($id, ['statut' => 'annulée']);

            // 2. Rendre la place au créneau
            $creneau = $creneauModel->find($res['creneau_id']);
            $creneauModel->update($res['creneau_id'], [
                'places_dispo' => $creneau['places_dispo'] + 1
            ]);

            $db->transComplete();
            $session->setFlashdata('success', 'Réservation annulée.');
        }

        return redirect()->to('/client/dashboard');
    }
}