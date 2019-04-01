<?php require '../View/header.php' ?>

<main class="main-profile container-fluid">

    <section class="container-profile">
        <article class="profile-show">

            <img class="rounded-circle avatar" alt="Votre avatar" src="<?= $this->asset($this->member->get_avatar()) ?>"/>
            <div class="info-profile">
                <div class="row">
                    <h3 class="username-profile col-12"><?= $this->member->get_username() ?></h3>
                    <p class="member-lastName col-md-6 col-12">Nom : <?= $this->member->get_last_name() ?></p>
                    <p class="member-firstName col-md-6 col-12">Prénom : <?= $this->member->get_first_name() ?></p>
                    <p class="member-mail col-12">Email : <?= $this->member->get_mail() ?></p>
                    <p class="member-description col-12">Description : <?= $this->member->get_description() ?></p>
                </div>
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
                        <input type="password" class="form-control" name="password2" placeholder="Confirmation mot de passe">
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

        <div class="link-article-page d-flex flex-row bd-highlight mb-3">
            <a href="<?= $this->router->generate('edit_member', ['id' => $this->member->get_id()]) ?>"><i class="btn-edit-member fas fa-pencil-alt" data-locale="<?= $this->lang ?>" data-tokencsrf="<?= $this->member->get_token_session() ?>" data-toggle="false" data-id="<?= $this->member->get_id() ?>"></i></a>
    
            <a href="#"><i class="cancel-member fas fa-times"></i></a>
    
            <form action="<?= $this->router->generate('delete_member') ?>" method="post">
                <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                <input type="hidden" name="id" value="<?= $this->member->get_id() ?>">

                <div class="container-delete-account">
                    <i class="icone-delete-account far fa-trash-alt"></i>
                    <input class="btn-delete-account" type="submit" onclick="return confirm('Etes-vous sûr de vouloir supprimer votre profil ?');" value="<?= $this->translation('Supprimer le compte') ?>">
                </div>
            </form>
        </div>
    
    </section>


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

<script src="<?= $this->asset('js/editMember.js') ?>"></script>
<script src="<?= $this->asset('js/avatar.js') ?>"defer></script>

<?php require '../View/footer.php' ?>