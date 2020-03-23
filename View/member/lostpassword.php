<?php require '../View/header.php' ?>

<main class="lost_password">
    <div class="container">
        <form method="post">
            <h2>Mot de passe oublié ?</h2>
            <div class="form-group">
                <label for="email">Veuillez renseigner votre adresse e-mail dans le champs ci-dessous :</label>
                <input class="form-control" type="email" name="mail" placeholder="exemple@mail.fr" id="email">
            </div>
            <input class="btn btn-primary" type="submit" value="Continuer">
        </form>
        <a class="btn-site lost_password_link" href="<?= $this->router->generate('accueil') ?>"><i class="fas fa-arrow-circle-left"></i>Retour à la page d'accueil</a>
    </div>
</main>

<div class="showMessage"></div>

<script>
    <?php $errorsMessage = $this->getMessage('error'); ?>
    <?php if(!empty($errorsMessage)): ?>
        showMessage('error', <?= json_encode($errorsMessage) ?>);
    <?php endif ?>

    <?php $successMessage = $this->getMessage('success'); ?>
    <?php if(!empty($successMessage)): ?>
        showMessage('success', [<?= json_encode($successMessage) ?>]);
    <?php endif ?>
</script>

<?php require '../View/footer.php' ?>