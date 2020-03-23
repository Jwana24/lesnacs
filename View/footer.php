<?php if(!$this->cookie_exist('cookie-bandeauCookie')): ?>
    <div class="container">
        <div class="toast message-cookie" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img widht="10px" height="20px" src="<?= $this->asset('images/gingerman.png') ?>" class="rounded mr-2" alt="Image du cookie">
                <strong class="mr-auto">Cookies</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <p>
                <?= $this->translation('Les cookies vous permettent de bénéficier de nombreuses fonctionnalités afin d\'améliorer votre navigation sur le site. En utilisant ce site, vous acceptez de recevoir des cookies. Pour en savoir plus et accepter les cookies, ') ?><a href="<?= $this->router->generate('mentionslegales') ?>#cookies"><?= $this->translation('cliquez ici') ?></a>.
                </p>
            </div>
        </div>
    </div>
<?php endif ?>

<footer>
    <div class="footer-elements">
        <div class="elements-center">
            <a href="<?= $this->router->generate('accueil') ?>#contacts">Contacts</a>
            <a href="<?= $this->router->generate('mentionslegales') ?>"><?= $this->translation('Mentions légales') ?></a>
            <a href="<?= $this->router->generate('article_list') ?>">Articles</a>
            <a href="<?= $this->router->generate('post_list') ?>">Forum</a>
            <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>
                <a href="<?= $this->router->generate('member_show', ['id' => $this->member->get_id()]) ?>"><?= $this->translation('Mon profil') ?></a>
            <?php endif ?>
            <p class="recommand-sites">
            <?= $this->translation('Les sites que l\'on vous recommande') ?> :
                <div class="logos">
                    <div class="logo-30MA">
                        <a href="https://www.30millionsdamis.fr/"><img class="logo-30MAmis" src="<?= $this->asset('images/logo-30MAmis.png') ?>" alt="Logo de la Fondation 30 Millions d'Amis"></a>
                    </div>
                    <div class="logo-spa">
                        <a href="https://www.la-spa.fr/"><img class="logo-spa" src="<?= $this->asset('images/logo-LaSPA.png') ?>" alt="Logo de la SPA (Société Protectrice des Animaux)"></a>
                    </div>
                </div>
            </p>
        </div>
        <p class="copyright">© <?= $this->translation('Site LesNac créé par ') ?>Johanna DETRIEUX</p>
    </div>
</footer>

<!-- My js for connection and inscription modals -->
<?php if($this->member == NULL): ?>
    <script src="<?= $this->asset('js/registration.js') ?>"></script>
<?php endif ?>

<!-- Ionicons links -->
<script src="https://unpkg.com/ionicons@4.5.5/dist/ionicons.js"></script>

<!-- Bootstrap links, content JS to Bootstrap -->
<script src="<?= $this->asset('js/jquery.js') ?>"></script>
<script src="<?= $this->asset('js/popper.js') ?>"></script>
<script src="<?= $this->asset('js/bootstrap.min.js') ?>"></script>

<!-- My js (translate language in en) -->
<script src="<?= $this->asset('js/languages.js') ?>"></script>

<!-- Success and errors messages appearance (with Bootstrap) -->
<script>$('.toast').toast('show')</script>
<script src="<?= $this->asset('js/useQuill.js') ?>"></script>

</body>
</html>