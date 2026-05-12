<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<section id="page-login" style="background:var(--surface);">
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">Fit<span>Space</span></div>
            <div class="auth-subtitle">Bienvenue ! Connectez-vous à votre espace.</div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash-message flash-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="flash-message flash-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($validation)): ?>
                <div class="flash-message flash-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        <?= $validation->listErrors() ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="/connexion" method="post">
                <div class="form-group mb-3">
                    <label class="form-label">Adresse email</label>
                    <input type="email" name="email" class="form-control" placeholder="votre@email.com"
                        value="<?= set_value('email') ?>" required />
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required />
                </div>
                <button type="submit" class="btn-primary-custom">Se connecter</button>
            </form>

            <hr class="auth-divider" />
            <div class="auth-footer">Pas encore de compte ? <a href="/inscription">Créer un compte</a></div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>