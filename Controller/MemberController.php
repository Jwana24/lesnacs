<?php
// For the "lostPassword" function, I installed a package : "PHPMailer" on "Composer" and I followed the instructions on GitHub
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MemberController extends Controller
{
    public function logout()
    {
        unset($_SESSION['member']);
        header('Location: http://lesnacs.fr/accueil/');
    }

    public function login()
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
                        // Create the member in the session
                        $_SESSION['member'] = serialize($member);
                        // Return our js messages in an json object
                        echo json_encode(['statut' => 'success']);
                        $this->addMessages($this->translation('Vous êtes connecté !'), 'success');
                    }
                    else
                    {
                        echo json_encode(['statut' => 'error']);
                        $this->addMessages($this->translation('Erreur d\'authentification'), 'error');
                    }
                }
                else
                {
                    echo json_encode(['statut' => 'error']);
                    $this->addMessages($this->translation('Une erreur s\'est produite'), 'error');
                }

            }
            else
            {
                echo json_encode(['statut' => 'error']);
                $this->addMessages($this->translation('Une erreur s\'est produite'), 'error');
            }
        }
        else
        {
            header('Location:'.$this->router->generate('accueil'));
        }
    }

    // If the member forgot his password, we send him a mail with a confirmation for changed the password
    public function lostPassword()
    {
        $titlePage = $this->translation('Mot de passe oublié');
        $memberManager = new MemberManager();
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['mail']) || !preg_match('#^[A-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $post['mail']))
            {
                $errors[] = 'Votre email n\'est pas valide';
            }

            if(count($errors) == 0)
            {
                $member = $memberManager->getByMail($post['mail']);
                
                if($member)
                {
                    $memberManager->tokenPassEdit($member);

                    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                    try
                    {
                        //Server settings
                        // $mail->SMTPDebug = 2;                              // Enable verbose debug output
                        $mail->isSMTP();                                      // Set mailer to use SMTP
                        $mail->Host = 'smtp.office365.com';                   // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                        $mail->Username = '';                                 // SMTP username
                        $mail->Password = '';                                 // SMTP password
                        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = 587;                                    // TCP port to connect to

                        //Recipients
                        $mail->setFrom('johanna-24@hotmail.fr', 'Mailer');
                        $mail->addAddress($member->get_mail(), $member->get_username());     // Add a recipient

                        //Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Demande de changement de votre mot de passe';
                        $mail->Body    = 'Pour modifier votre mot de passe, cliquez <a href="'.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/reinitialisermotdepasse/'.$member->get_id().'/'.$member->get_token_password().'/">ici</a>';
                        $mail->AltBody = 'Pour modifier votre mot de passe, cliquez ici '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/reinitialisermotdepasse/'.$member->get_id().'/'.$member->get_token_password().'/';

                        $mail->send();
                        $this->addMessages('Votre demande a bien été envoyé, vous recevrez bientôt un mail à l\'adresse '.$member->get_mail(), 'success');
                    }
                    catch (Exception $e)
                    {
                        $this->addMessages('Il y a eu une erreur lors de l\'envoi du mail', 'error');
                    }
                }
                else
                {
                    $this->addMessages('Une erreur s\'est produite', 'error');
                }
            }
            else
            {
                foreach($errors as $error)
                {
                    $this->addMessages($error, 'error');
                }
            }
        }
        ob_start(); // execute the php script and stock it in the cache
        require '../View/member/lostpassword.php';
        echo ob_get_clean(); // get the elements in the cache and displays
    }

    // If the member forgot is password, we reset it
    public function resetPassword($params)
    {
        extract($params);
        $titlePage = $this->translation('Nouveau mot de passe');
        $memberManager = new MemberManager();

        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(isset($token) && isset($id) && isset($post['password']) && isset($post['password2']))
            {
                if(!isset($post['password']) || !preg_match('#^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@\#\$\%]).{8,})$#', $post['password']))
                {
                    $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que @, #, $, %';
                }

                if(!isset($post['password2']) || $post['password'] != $post['password2'])
                {
                    $errors[] = 'Le mot de passe n\'a pas pu être confirmé';
                }

                if(count($errors) == 0)
                {
                    
                    if($post['password'] == $post['password2'])
                    {
                        $member = $memberManager->get($id);

                        if($member)
                        {
                            if($token == $member->get_token_password())
                            {
                                $mp_hashed = password_hash($post['password'], PASSWORD_BCRYPT);
                                $member->set_password($mp_hashed);
                                $member->set_token_password('');

                                if($memberManager->edit($member))
                                {
                                    $this->addMessages('Votre mot de passe a bien été réinitialisé', 'success');
                                }
                                else
                                {
                                    $this->addMessages('Votre mot de passe n\'a pas pu être réinitialisé', 'error');
                                }
                            }
                        }
                    }
                    else
                    {
                        $this->addMessages('Le mot de passe n\'a pas pu être confirmé', 'error');
                    }
                }
                else
                {
                    foreach($errors as $error)
                    {
                        $this->addMessages($error, 'error');
                    }
                }
            }
            else
            {
                foreach($errors as $error)
                {
                    $this->addMessages($error, 'error');
                }
            }
        }
        ob_start();
        require '../View/member/resetpassword.php';
        echo ob_get_clean();
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
                if($_FILES['avatar']['name'] != '')
                {
                    // Verify if 'avatar' exist, if there are errors in the upload and if the size is greather than 5mo
                    if(!isset($_FILES['avatar']) || $_FILES['avatar']['error'] != UPLOAD_ERR_OK || $_FILES['avatar']['size'] > 5000000)
                    {
                        $errors[] = 'L\'avatar n\'a pas pu être téléchargé '.$_FILES['avatar']['error'];
                    }
    
                    if(count($errors) == 0)
                    {
                        // We cut the string after the '.' in the name of the file where we selected the extension
                        $fileExtension = explode('.', $_FILES['avatar']['name'])[1];
    
                        // We verify the file's extensions
                        if(in_array($fileExtension ,['jpg', 'jpeg', 'gif', 'svg', 'png']))
                        {
                            // We construct the path of and the name of the file
                            $username = str_replace( 
                                ['À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ',' '],
                                ['A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y',''],
                                $post['username']);
                            $fileName = 'avatars/'. $username. '.'. $fileExtension;
    
                            // Move the temporary file to the final folder ('avatar')
                            if(move_uploaded_file($_FILES['avatar']['tmp_name'], $fileName))
                            {
                                $avatar = $fileName;
                            }
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
                    else
                    {
                        echo json_encode(['statut' => 'error', 'error' => $errors]);
                    }
                }
                else
                {
                    $errors[] = 'Pseudo ou email déjà utilisé';
                    echo json_encode(['statut' => 'error', 'error' => $errors]);
                }
            }
            else
            {
                echo json_encode(['statut' => 'error', 'error' => $errors]);
            }
        }
    }

    public function show($params)
    {
        extract($params);
        $memberManager = new MemberManager();
        $member = $memberManager->show($id);
        $titlePage = $this->translation('Profil de ').$this->member->get_username();

        ob_start();
        require '../View/member/show.php';
        echo ob_get_clean();
    }

    public function edit($params)
    {
        extract($params);
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
                if($_FILES['avatar']['name'] != '')
                {
                    if(!isset($_FILES['avatar']) || $_FILES['avatar']['error'] != UPLOAD_ERR_OK || $_FILES['avatar']['size'] > 5000000)
                    {
                        $errors[] = 'L\'avatar n\'a pas pu être téléchargé '.$_FILES['avatar']['error'];
                    }
    
                    if(count($errors) == 0)
                    {
                        $fileExtension = explode('.', $_FILES['avatar']['name'])[1];
    
                        if(in_array($fileExtension ,['jpg', 'jpeg', 'gif', 'svg', 'png']))
                        {
                            $username = str_replace( 
                                ['À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ',' '],
                                ['A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y',''],
                                $post['username']);
                            $fileName = 'avatars/'. $username. '.'. $fileExtension;
    
                            if(move_uploaded_file($_FILES['avatar']['tmp_name'], $fileName))
                            {
                                if($this->member->get_username() != $username)
                                {
                                    if(file_exists($this->member->get_avatar()))
                                    {
                                        unlink($this->member->get_avatar());
                                    }
                                }
                                $avatar = $fileName;
                            }
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

            if(!isset($post['password']))
            {
                $errors[] = 'Oups ! Il y a eu une erreur !';
            }

            if(!isset($post['password2']) || $post['password'] != $post['password2'])
            {
                $errors[] = 'Le mot de passe n\'a pas pu être confirmé';
            }

            if(!isset($post['mail']) || !preg_match('#^[A-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $post['mail']))
            {
                $errors[] = 'Votre email n\'est pas valide';
            }

            if($this->member->get_token_session() != $post['token_session'])
            {
                $errors[] = 'Oups ! Il y a eu une erreur !';
            }
            
            if(!empty($post['password']))
            {
                if(preg_match('#^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@\#\$\%]).{8,})$#', $post['password']))
                {
                    $this->member->set_password(password_hash($post['password'], PASSWORD_BCRYPT));
                }
                else
                {
                    $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que @, #, $, %';
                }
            }

            if(count($errors) == 0)
            {
                $this->member->set_last_name($post['last_name']);
                $this->member->set_first_name($post['first_name']);
                $this->member->set_username($post['username']);
                $this->member->set_mail($post['mail']);
                $this->member->set_description($post['description']);
                $this->member->set_avatar($avatar ?? $this->member->get_avatar());

                $memberManager->edit($this->member);

                $_SESSION['member'] = serialize($this->member);
                
                echo json_encode(['content' => [
                    'first_name' => $this->member->get_first_name(),
                    'last_name' => $this->member->get_last_name(),
                    'username' => $this->member->get_username(),
                    'mail' => $this->member->get_mail(),
                    'description' => $this->member->get_description(),
                    'avatar' => $this->member->get_avatar()
                ],
                'statut' => 'success']);

                $this->addMessages($this->translation('Le profil a bien été édité'), 'success');
            }
            else
            {
                echo json_encode(['statut' => 'error', 'error' => $errors]);
            }
        }
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
                    $errors[] = 'Une erreur s\'est produite';
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

    public function delete($params)
    {
        extract($params);
        $memberManager = new MemberManager();
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['token_session']) || $post['token_session'] != $this->member->get_token_session())
            {
                $errors[] = 'Une erreur s\'est produite';
            }

            if(!isset($post['id']) || !is_numeric($post['id']))
            {
                $errors[] = 'Une erreur s\'est produite';
            }

            if(count($errors) == 0)
            {
                if($memberManager->delete($post['id']))
                {
                    $postManager = new PostManager();
                    $postManager->setNullById($post['id']);
                    $this->addMessages($this->translation('Le compte a été supprimé'), 'success');
                }
                else
                {
                    $this->addMessages($this->translation('Erreur lors de la suppression du compte'), 'error');
                }
            }
            else
            {
                $this->addMessages($this->translation('Une erreur s\'est produite'), 'error');
            }
            unset($_SESSION['member']);
            header('Location: http://lesnacs.fr/accueil/');
        }
    }
}
