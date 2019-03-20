<?php require '../View/header.php' ?>

<main class="container">
    
    <div class="table-responsive">
        <table class="table table-dark table-list-members">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($members as $member): ?>
                    <tr>
                        <th scope="row"><?= $member->get_id() ?></th>
                        <td><?= $member->get_last_name() ?></td>
                        <td><?= $member->get_first_name() ?></td>
                        <td><?= $member->get_mail() ?></td>
                        <td><?= $member->get_description() ?></td>
                        <td><a class="btn btn-light" href="<?= $this->router->generate('member_show', ['id' => $member->get_id()]) ?>">Voir</a></td>
                    </tr>
                <?php endforeach ?>
                
            </tbody>
        </table>
    </div>
    
</main>

<?php require '../View/footer.php' ?>