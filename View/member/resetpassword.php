<?php require '../View/header.php' ?>

<main class="reset_password">

    <div class="container">
        <form method="post">
            <h2>Réinitialisation de votre mot de passe</h2>
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input class="form-control" id ="password" type="password" name="password" onkeypress="capsLockMp(event)" required>
                <span id="aidePassword"></span>
                <span id="cLockMp"></span><br/>

                <label for="password2">Confirmez le nouveau mot de passe</label>
                <input class="form-control" id="password2" type="password" name="password2" onkeypress="capsLockPassword2(event)" required>
                <span id="aidePassword2"></span>
                <span id="cLockPassword2"></span><br/>
            </div>

            <input class="btn btn-primary" type="submit" value="Valider">
        </form>

        <a class="btn-site reset_password_link" href="<?= $this->router->generate('accueil') ?>"><i class="fas fa-arrow-circle-left"></i>Retour à la page d'accueil</a>
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
