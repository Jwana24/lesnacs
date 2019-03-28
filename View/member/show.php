<?php require '../View/header.php' ?>

<main class="main-profile">

    <section class="container-profile">
        <article class="profile-show">

            <img class="rounded avatar" alt="Votre avatar" src="<?= $this->asset($this->member->get_avatar()) ?>"/>
            <div class="info-profile">
                <h3 class="username-profile"><?= $this->member->get_username() ?></h3>
                <p class="member-lastName">Nom : <?= $this->member->get_last_name() ?></p>
                <p class="member-firstName">Prénom : <?= $this->member->get_first_name() ?></p>
                <p class="member-mail">Email : <?= $this->member->get_mail() ?></p>
                <p class="member-description">Description : <?= $this->member->get_description() ?></p>
            </div>

            <form class="form-edit-member" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">

                <div class="form-group">
                    <input type="text" class="form-control" name="username" value="<?= $this->member->get_username() ?>">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="last_name" value="<?= $this->member->get_last_name() ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="first_name" value="<?= $this->member->get_first_name() ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="password" class="form-control" name="password_verify" placeholder="Confirmation mot de passe">
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="mail" value="<?= $this->member->get_mail() ?>">
                </div>

                <div class="form-group">
                    <textarea class="form-control content-edit-member" name="description"><?= $this->member->get_description() ?></textarea>
                </div>

                <div class="form-group">
                    <input type="file" name="avatar">
                </div>
            </form>
        
        </article>
    </section>

    <div class="link-article-page">
        <a class="btn-site btn-edit-member" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="<?= $this->member->get_id() ?>" href="<?= $this->router->generate('edit_member', ['id' => $this->member->get_id()]) ?>">Editer mon profil</a>

        <a class="btn-site cancel-member" href="#">Annuler</a>

        <a class="btn-site link-return-homepage" href="<?= $this->router->generate('accueil') ?>">Revenir à l'accueil</a>

        <form action="<?= $this->router->generate('delete_member') ?>" method="post">
            <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
            <input type="hidden" name="id" value="<?= $this->member->get_id() ?>">
            <input class="btn-site" type="submit" value="<?= $this->translation('Supprimer le compte') ?>">
        </form>
    </div>

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

</main>

<script src="<?= asset('js/editMember.js') ?>"></script>

<?php require '../View/footer.php' ?>