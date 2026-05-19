<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="page-section">
    <div class="section-head">
        <h2>Créneaux disponibles</h2>
        <span class="count"><?= count($creneaux) ?> créneaux trouvés</span>
    </div>

    <div class="filter-bar">
        <button class="filter-pill active" data-filter="tous">Tous</button>
        <button class="filter-pill" data-filter="cours"><i class="bi bi-people-fill"></i> Cours collectifs</button>
        <button class="filter-pill" data-filter="salle"><i class="bi bi-door-open-fill"></i> Salles</button>
        <button class="filter-pill" data-filter="terrain"><i class="bi bi-dribbble"></i> Terrains</button>
    </div>

    <div class="creneaux-grid">
        <?php foreach ($creneaux as $c): ?>
            <?php
            $isFull = $c['places_dispo'] <= 0;
            $percent = ($c['total_places'] - $c['places_dispo']) / $c['total_places'] * 100;

            // Normalisation du type pour le filtre et l'affichage
            $typeRaw = strtolower($c['ressource_type']);
            $typeClass = 'type-cours';
            $iconClass = 'bi-people-fill';

            if ($typeRaw == 'salle') {
                $typeClass = 'type-salle';
                $iconClass = 'bi-door-open-fill';
            } elseif ($typeRaw == 'terrain') {
                $typeClass = 'type-terrain';
                $iconClass = 'bi-dribbble';
            }
            ?>

            <div class="creneau-card <?= $isFull ? 'full' : '' ?>" data-type="<?= $typeRaw ?>">
                <div class="creneau-header">
                    <span class="creneau-type <?= $typeClass ?>">
                        <i class="bi <?= $iconClass ?>"></i>
                        <?= ucfirst($c['ressource_type']) ?>
                    </span>
                    <span
                        style="font-size:0.75rem;color:var(--muted);"><?= date('d/m/Y', strtotime($c['date_debut'])) ?></span>
                </div>
                <p class="creneau-title"><?= $c['ressource_nom'] ?></p>
                <div class="creneau-meta">
                    <div class="meta-row"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($c['date_debut'])) ?> —
                        <?= date('H:i', strtotime($c['date_fin'])) ?></div>
                </div>
                <div>
                    <div class="places-bar">
                        <div class="places-fill" style="width:<?= $percent ?>%"></div>
                    </div>
                    <div class="places-label"><?= $c['places_dispo'] ?> places restantes sur <?= $c['total_places'] ?></div>
                </div>

                <?php if ($isFull): ?>
                    <button class="btn-reserver disabled" disabled>Complet</button>
                <?php else: ?>
                    <a href="/client/reserver/<?= $c['id'] ?>" class="btn-reserver">Réserver ce créneau</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterPills = document.querySelectorAll('.filter-pill');
        const cards = document.querySelectorAll('.creneau-card');

        filterPills.forEach(pill => {
            pill.addEventListener('click', () => {
                // 1. Retirer la classe active de tous les boutons
                filterPills.forEach(p => p.classList.remove('active'));

                // 2. Ajouter la classe active au bouton cliqué
                pill.classList.add('active');

                // 3. Récupérer la valeur du filtre choisi
                const filterValue = pill.getAttribute('data-filter');

                // 4. Afficher ou masquer les cartes
                let visibleCount = 0;
                cards.forEach(card => {
                    const cardType = card.getAttribute('data-type');

                    if (filterValue === 'tous' || cardType === filterValue) {
                        card.style.display = 'flex'; // Le template utilise flexbox pour les cartes
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // 5. Mettre à jour le compteur en haut de la page
                document.querySelector('.count').textContent = visibleCount + (visibleCount > 1 ? ' créneaux trouvés' : ' créneau trouvé');
            });
        });
    });
</script>
<?= $this->endSection() ?>