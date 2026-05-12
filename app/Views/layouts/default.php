<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitSpace — Gestionnaire de réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap"
        rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet" />

<body>

    <nav class="nav-public">
        <a href="/" class="brand">Fit<span>Space</span></a>
        <?php if (!url_is('connexion') && !url_is('inscription')): ?>
            <div class="nav-links">
                <a href="/#creneaux">Nos créneaux</a>
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= session()->get('role') == 'admin' ? '/admin/dashboard' : '/client/dashboard' ?>"
                        class="btn-nav-primary">Mon Espace</a>
                    <a href="/deconnexion">Déconnexion</a>
                <?php else: ?>
                    <a href="/connexion">Connexion</a>
                    <a href="/inscription" class="btn-nav-primary">S'inscrire</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </nav>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="footer-public">
        FitSpace &copy; <?= date('Y') ?> — Projet CodeIgniter 4 · Tous droits <span>réservés</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>