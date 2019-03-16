<?php

class MemberController
{
    public function inscription()
    {
        $memberManager = new MemberManager($bdd);

        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('htmlspecialchars', $_POST);

            if(isset($post['last_name']) && isset($post['first_name']) && isset($post['username']) && isset($post['password']) && isset($post['password2']) && isset($post['mail']) && isset($post['roles']) && isset($post['captcha']))
            {
                if($post['captcha'] != $_SESSION['captcha'])
                {
                    $errors[] = 'Captcha invalide';
                }

                if(!preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['last_name']))
                {
                    $errors[] = 'Votre pseudo doit faire entre 4 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
                }

                if(!preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['first_name']))
                {
                    $errors[] = 'Votre pseudo doit faire entre 4 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
                }

                if(!preg_match('#^[A-z0-9-_ ]{2,50}$#', $post['username']))
                {
                    $errors[] = 'Votre pseudo doit faire entre 2 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
                }

                if(!preg_match('#^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@\#\$\%]).{8,})$#', $post['password']))
                {
                    $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que @, #, $, %';
                }

                if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $post['mail']))
                {
                    $errors[] = 'Votre email n\'est pas valide';
                }

                if(count($errors) == 0)
                {
                    if(!empty($post['last_name']) && isset($post['first_name']) && isset($post['username']) && isset($post['password']) && isset($post['password2']) && isset($post['mail']) && isset($post['roles']))
                    {                
                        // We verify to the "confirmation password" : password2, is the same of the "password" : password
                        if($post['password'] == $post['password2'])
                        {
                            if($memberManager->verif($post['mail'], $post['username']))
                            {
                                // Password hashed
                                $mp_hashed = password_hash($post['password'], PASSWORD_BCRYPT);
                                $member = new Member();
                                $member->set_username($post['username']);
                                $member->set_password($mp_hashed);
                                $member->set_mail($post['mail']);

                                // we keep the informations "username", "password(hashed)" and "mail" in the database
                                if($memberManager->add($member, 'ROLE_USER'))
                                {
                                    $_SESSION['success'] = 'Vous êtes à présent inscrit !';
                                    header('Location:../index.php');
                                }
                            }
                            else
                            {
                                $errors[] = 'Email ou pseudo déjà utilisé';
                            }
                        }
                        else
                        {
                            $errors[] = 'Le mot de passe n\'a pas pu être confirmé';
                        }
                    }
                    else
                    {
                        $errors[] = 'Veuillez remplir tous les champs';
                    }
                }
            }
        }
    }

    public function captcha()
    {
        // Generate the captcha
        $md5_hash = md5(rand(0,999));
        $captcha = substr($md5_hash, 14, 5);

        // Add the captcha in the session
        $_SESSION['captcha'] = $captcha;

        $image = ImageCreate(200,50); // create an image : width = 200 and height = 50

        // Create colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Add background for the image
        imagefill($image, 0, 0, $black);

        // Add text to the image
        imagestring($image, 4, 75, 15, $captcha, $white);

        // Indicates that we are sending a jpeg image
        header('content-type:image/jpeg');

        // Converted the image to jpeg
        imagejpeg($image);

        // Empty the cache
        imagedestroy($image);
    }

    public function editProfile()
    {
        $errors = [];

        $memberManager = new MemberManager($bdd);

        $member = $memberManager->show($_SESSION['id']);
        // $token = new token($bdd, $_SESSION['id']);

        // if(empty($_POST))
        // {
        //     $token->tokenEdit();
        // }

        if(!empty($_POST))
        {
            $post = array_map('htmlspecialchars', $_POST);

            if(isset($post['last_name']) && isset($post['first_name']) && isset($post['password']) && isset($post['password2']) && isset($post['username']) && isset($post['mail']) && isset($post['description']) && isset($post['token_session']))
            {
                if($membre->get_token_session() != $post['token_session'])
                {
                    $errors[] = 'Oups ! Il y a eu une erreur !';
                }

                // $token->tokenEdit();

                if(!preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['last_name']))
                {
                    $errors[] = 'Votre pseudo doit faire entre 4 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
                }

                if(!preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['first_name']))
                {
                    $errors[] = 'Votre pseudo doit faire entre 4 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
                }

                if(!preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['username']))
                {
                    $errors[] = 'Votre pseudo doit faire entre 4 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
                }

                if(!preg_match('#^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@\#\$\%]).{8,})$#', $post['password']))
                {
                    $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que @, #, $, %';
                }

                if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $post['mail']))
                {
                    $errors[] = 'Votre email n\'est pas valide';
                }

                if(count($errors) == 0)
                {
                    if($post['password'] == $post['password2'])
                    {
                        $mp_hashed = password_hash($post['password'], PASSWORD_BCRYPT);
                        $member->set_last_name($post['last_name']);
                        $member->set_first_name($post['first_name']);
                        $member->set_username($post['username']);
                        $member->set_mail($post['mail']);
                        $member->set_description($post['description']);
                        $memberManager->edit($member);
                        $success = 'Le profil a bien été édité';
                    }
                }
            }
        }

        $member = $memberManager->show($_SESSION['id']);
    }

    public function editAvatar()
    {
        $memberManager = new MemberManager($bdd);

        // $token = new token($bdd, $_SESSION['id']);

        $errors = [];

        // if(empty($_POST))
        // {
        //     $token->tokenEdit();
        // }

        if(!empty($_POST))
        {
            $post = array_map('htmlspecialchars', $_POST);

            if(isset($_FILES['avatar']) && isset($post['token_session']))
            {
                $memberCo = $memberManager->show($_SESSION['id']);

                if($memberCo->get_token_session() != $post['token_session'])
                {
                    $errors[] = 'Oups ! Il y a eu une erreur !';
                }

                // $token->tokenEdit();

                if(count($errors) == 0) // We verify there are no errors
                {   
                    // We put the name of the folderin a variable
                    $folder= '../avatars/';

                    $file = basename($_FILES['avatar']['name']);
                    // We replace the accented letters for the unaccented and we take the result on the "file"
                    $file = strtr($file,
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    // We create a regex for transform specials characters on indents (tirets) and place the result in "file"
                    $file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
                    
                    //  We create a variable for change the title of the file (pseudo of the member + name of the file)
                    $modif_title = $_SESSION['username'].time().$file;

                    // We put the autorized extensions in an array (for an image here)
                    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
                    // We take the part of the string of characters after the last point (.jpg, .gif etc.) for know the extension
                    $extension = strrchr($_FILES['avatar']['name'],'.');
                    
                    // Maximum size (octets)
                    $max_size = 500000;
                    // Size of the file
                    $size = filesize($_FILES['avatar']['tmp_name']);

                    if($size>$max_size)
                    {
                        $error = 'L\'image est trop grande';
                    }
                    else
                    {
                        if(!in_array($extension, $extensions)) // if the extention is not in our array
                        {
                            $error = 'Vous devez télécharger un fichier de type ".png", ".gif", ".jpg" ou ".jpeg"';
                        }
                        else
                        {
                            if(move_uploaded_file($_FILES['avatar']['tmp_name'], $folder .$modif_title))
                            {
                                $_SESSION['success'] = 'Le téléchargement a été effectué avec succès';

                                $memberCo->set_avatar($folder .$modif_title);
                                $memberManager->edit($memberCo);

                                header('Location:profile_page.php');
                            }
                            else
                            {
                                $error = 'Echec du téléchargement de l\'image';
                            }
                        }
                    }
                }
            }
        }
    }

    public function connection()
    {
        $memberManager = new MemberManager($bdd);

        if(!empty($_POST))
        {
            $post = array_map('htmlspecialchars', $_POST);

            if(isset($post['username']) && isset($post['password']))
            {   
                $result = $memberManager->getByUsername($post['username']);
                
                // We create a variable for verify if the password in "post" and the password in the "result" (hashed password) is the same
                $isPasswordOk = password_verify($post['password'], $result->get_password());

                if(!$result)
                {
                    $error = 'Mauvais identifiant ou mot de passe';
                }
                else
                {
                    // If the password is correct we offered to the member to connect automatically by storing his informations in cookies
                    if ($isPasswordOk)
                    {
                        if(isset($post['autoCo']) && isset($post['username']) && isset($post['password']))
                        {
                            if($post['autoCo'] == 'ok')
                            {
                                // we keep the cookie 24H
                                setcookie('username', $post['username'], time() + 3600*24, null, null, false, true);
                                // the password is hashed
                                $mp_hashed = password_hash($post['password'], PASSWORD_BCRYPT);
                                setcookie('password', $mp_hashed, time() + 3600*24, null, null, false, true);
                            }
                        }

                        // We keep the informations on the session of the member
                        $_SESSION['id'] = $result->get_id();
                        $_SESSION['username'] = $result->get_username();
                        $_SESSION['success'] = 'Vous êtes connecté';

                        // if the member who connect is an admin, he can access to the "admin.php" page
                        if($result->get_roles() === 'ROLE_ADMIN')
                        {
                            header('Location:../admin/admin.php');
                        }
                        else
                        {
                            header('Location:../index.php');
                        }
                    }
                    else
                    {
                        $error = 'Mauvais identifiant ou mot de passe';
                    }
                }
            }
        }
    }

    public function deconnection()
    {
        // Suppression of the session
        $_SESSION = array();

        // Suppression of the cookies
        setcookie('username', '');
        setcookie('password', '');

        $_SESSION['success'] = 'Vous êtes déconnecté';

        header('Location:../index.php');
    }
}
