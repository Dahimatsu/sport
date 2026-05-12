<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="app-wrapper">

  <aside class="sidebar">
    <div class="sidebar-section">Menu</div>
    <ul class="sidebar-nav">
      <li><a href="/client/dashboard" class="active"><i class="bi bi-grid-1x2-fill"></i> Tableau de bord</a></li>
      <li><a href="/creneaux"><i class="bi bi-calendar3"></i> Voir les créneaux</a></li>
      <li><a href="/client/reservations"><i class="bi bi-bookmark-check-fill"></i> Mes réservations</a></li>
      <li><a href="/profil"><i class="bi bi-person-fill"></i> Mon profil</a></li>
    </ul>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="avatar"><?= substr($nom_utilisateur, 0, 2) ?></div>
        <div class="user-info">
          <div class="name"><?= $nom_utilisateur ?></div>
          <div class="role">Client</div>
        </div>
        <a href="/deconnexion" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;"><i
            class="bi bi-box-arrow-right"></i></a>
      </div>
    </div>
  </aside>

  <div class="main-content">
    <div class="topbar">
      <span class="topbar-title">Tableau de bord</span>
    </div>

    <div class="page-content">
      <div class="metrics-row">
        <div class="metric-card">
          <div class="metric-icon yellow"><i class="bi bi-hourglass-split"></i></div>
          <div class="metric-value"><?= $stats['attente'] ?></div>
          <div class="metric-label">En attente</div>
        </div>
        <div class="metric-card">
          <div class="metric-icon green"><i class="bi bi-check-circle-fill"></i></div>
          <div class="metric-value"><?= $stats['confirmee'] ?></div>
          <div class="metric-label">Confirmées</div>
        </div>
        <div class="metric-card">
          <div class="metric-icon red"><i class="bi bi-x-circle-fill"></i></div>
          <div class="metric-value"><?= $stats['annulee'] ?></div>
          <div class="metric-label">Annulées</div>
        </div>
      </div>

      <div class="data-card">
        <div class="data-card-header">
          <h3>Mes prochaines réservations</h3>
        </div>
        <table class="table-custom">
          <thead>
            <tr>
              <th>Créneau</th>
              <th>Date</th>
              <th>Statut</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($reservations)): ?>
              <tr>
                <td colspan="4" class="text-center p-4 text-muted">Vous n'avez pas encore de réservations.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($reservations as $res): ?>
                <tr>
                  <td class="td-name"><?= $res['ressource_nom'] ?></td>
                  <td class="td-muted">
                    <?= date('d/m/Y', strtotime($res['date_debut'])) ?>
                    <small>(<?= date('H:i', strtotime($res['date_debut'])) ?> –
                      <?= date('H:i', strtotime($res['date_fin'])) ?>)</small>
                  </td>
                  <td>
                    <?php
                    $statusClass = [
                      'en attente' => 's-attente',
                      'confirmée' => 's-confirmee',
                      'annulée' => 's-annulee',
                      'refusée' => 's-refusee'
                    ];
                    ?>
                    <span class="badge-statut <?= $statusClass[$res['statut']] ?>"><?= $res['statut'] ?></span>
                  </td>
                  <td>
                    <?php if ($res['statut'] == 'en attente'): ?>
                      <a href="/client/annuler/<?= $res['id'] ?>" class="btn-sm-custom btn-cancel"><i class="bi bi-x"></i>
                        Annuler</a>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>