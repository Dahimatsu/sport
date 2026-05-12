<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<section id="page-inscription" style="background:var(--surface);">
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">Fit<span>Space</span></div>
            <div class="auth-subtitle">Créez votre compte client gratuitement.</div>

            <?php if (isset($validation)): ?>
                <div class="flash-message flash-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        <?= $validation->listErrors() ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="/inscription" method="post">
                <div class="form-group mb-3">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="nom" class="form-control" placeholder="Jean Dupont"
                        value="<?= set_value('nom') ?>" required />
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Adresse email</label>
                    <input type="email" name="email" class="form-control" placeholder="jean.dupont@email.com"
                        value="<?= set_value('email') ?>" required />
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="6 caractères minimum"
                        required />
                </div>

                <button type="submit" class="btn-primary-custom">Créer mon compte</button>
            </form>

            <hr class="auth-divider" />
            <div class="auth-footer">Déjà inscrit ? <a href="/connexion">Se connecter</a></div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>