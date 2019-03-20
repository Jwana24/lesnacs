<?php

class MemberController extends Controller
{
    public function connection()
    {
        $memberManager = new MemberManager();
        $errors = [];

        if(!empty($_POST))
        {   // 'Trim' : delete whitespace from the beginning and end of a string ; 'strip_tags' : delete HTML and PHP tags
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['username']) || empty($post['username']))
            {
                $errors[] = 'Pseudo ou mot de passe invalide';
            }

            if(!isset($post['password']) || empty($post['password']))
            {
                $errors[] = 'Pseudo ou mot de passe invalide';
            }

            if(count($errors) == 0)
            {
                $member = $memberManager->getByUsername($post['username']);

                if($member)
                {
                    // We verify if the password in "post" and the password in the "member" (hashed password) is the same
                    if(password_verify($post['password'], $member->get_password()))
                    {
                        $_SESSION['member'] = $member;
                        // Return our js messages in an json object
                        echo json_encode(['statut' => 'success']);
                    }
                }
                else
                {
                    echo json_encode(['statut' => 'error', 'error' => 'L\'utilisateur n\'existe pas']);
                }

            }
            else
            {
                echo json_encode(['statut' => 'error']);
            }
        }
    }

    public function add()
    {
        $memberManager = new MemberManager();

        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['username']) || !preg_match('#^[A-z0-9-_ ]{2,50}$#', $post['username']))
            {
                $errors[] = 'Votre pseudo doit faire entre 2 et 50 caractères et ne doit pas contenir de caractères spéciaux (sauf espace, "_" et "-")';
            }

            if(!empty($_FILES))
            {
                // Verify if 'avatar' exist, if there are errors in the upload and if the size is greather than 50mo
                if(!isset($_FILES['avatar']) || $_FILES['avatar']['error'] != UPLOAD_ERR_OK || $_FILES['avatar']['size'] > 50000)
                {
                    $errors[] = 'L\'avatar n\'a pas pu être télécharger '.$_FILES['avatar']['error'];
                }

                if(count($errors) == 0)
                {
                    // We cut the string after the '.' in the name of the file where we selected the extension
                    $fileExtension = explode('.', $_FILES['avatar']['name'])[1];

                    // We verify the file's extensions
                    if(in_array($fileExtension ,['jpg', 'jpeg', 'gif', 'svg', 'png']))
                    {
                        // We construct the path of and the name of the file
                        $fileName = 'avatars/'. $post['username']. time(). '.'. $fileExtension;

                        // Move the temporary file to the final folder ('avatar')
                        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $fileName))
                        {
                            $avatar = $fileName;
                        }
                    }
                }
            }

            if(!isset($post['last_name']) || !preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['last_name']))
            {
                $errors[] = 'Votre nom n\'est pas valide, il ne doit contenir aucun accent';
            }

            if(!isset($post['first_name']) || !preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['first_name']))
            {
                $errors[] = 'Votre prénom n\'est pas valide';
            }

            if(!isset($post['password']) || !preg_match('#^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@\#\$\%]).{8,})$#', $post['password']))
            {
                $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que @, #, $, %';
            }

            // We verify to the "confirmation password" : password2, is the same of the "password" : password
            if(!isset($post['password2']) || $post['password'] != $post['password2'])
            {
                $errors[] = 'Le mot de passe n\'a pas pu être confirmé';
            }

            if(!isset($post['mail']) || !preg_match('#^[A-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $post['mail']))
            {
                $errors[] = 'Votre email n\'est pas valide';
            }

            if(count($errors) == 0)
            {
                if($memberManager->verif($post['mail'], $post['username']))
                {
                    // Password hashed
                    $mp_hashed = password_hash($post['password'], PASSWORD_BCRYPT);
                    $member = new Member();
                    $member->set_last_name($post['last_name']);
                    $member->set_first_name($post['first_name']);
                    $member->set_username($post['username']);
                    $member->set_password($mp_hashed);
                    $member->set_mail($post['mail']);
                    $member->set_avatar($avatar ?? 'avatars/default-avatar.jpg');
                    $member->set_token_session(password_hash(uniqid(), PASSWORD_BCRYPT));

                    // We keep the informations "username", "password(hashed)" and "mail" in the database
                    if($memberManager->add($member))
                    {
                        echo json_encode(['statut' => 'success']);
                    }
                }
                else
                {
                    echo json_encode(['statut' => 'error', 'error' => 'Pseudo ou email déjà utilisé']);
                }
            }
            else
            {
                echo json_encode(['statut' => 'error']);
            }
        }
    }

    public function editProfile()
    {
        $errors = [];

        $memberManager = new MemberManager();

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
        $memberManager = new MemberManager();

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
