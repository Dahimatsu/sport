<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<section id="page-accueil">
    <div class="hero">
        <div class="hero-eyebrow"><i class="bi bi-lightning-charge-fill"></i> Réservation en ligne</div>
        <h1>Votre espace bien-être,<br><em>réservé en 30 secondes.</em></h1>
        <p>Cours collectifs, salles et terrains disponibles 7j/7. Créez un compte gratuit et réservez votre prochain
            créneau.</p>
        <div class="hero-ctas">
            <a href="/connexion" class="btn-hero btn-hero-primary">Voir les créneaux disponibles</a>
            <a href="/inscription" class="btn-hero btn-hero-outline">Créer mon compte</a>
        </div>
    </div>

    <div class="stats-band">
        <div class="stat-item">
            <div class="num">12</div>
            <div class="lbl">Créneaux / semaine</div>
        </div>
        <div class="stat-item">
            <div class="num">3</div>
            <div class="lbl">Types de ressources</div>
        </div>
        <div class="stat-item">
            <div class="num">48h</div>
            <div class="lbl">Délai d'annulation</div>
        </div>
        <div class="stat-item">
            <div class="num">100%</div>
            <div class="lbl">Gratuit à l'inscription</div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>