<?php

class MemberManager extends Manager
{
    // Add members into the database
    public function add(Member $member)
    {
        $request = $this->_bdd->prepare('INSERT INTO member (last_name, first_name, username, password, mail, avatar, date_inscription, description, token_session) VALUES (:last_name, :first_name, :username, :password, :mail, :avatar, NOW(), :description, :tokenSess)');

        if($request->execute([
            'last_name' => $member->get_last_name(),
            'first_name' => $member->get_first_name(),
            'username' => $member->get_username(),
            'password' => $member->get_password(),
            'mail' => $member->get_mail(),
            'avatar' => $member->get_avatar(),
            'description' => $member->get_description(),
            'tokenSess' => $member->get_token_session()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // We recuperate all the members and we transform the result on "member" object
    public function list()
    {
        return $this->_bdd->query('SELECT * FROM member', PDO::FETCH_CLASS, 'Member')->fetchAll();
    }

    public function show($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM member WHERE member.id = :id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS);
    }

    public function edit(Member $member)
    {
        $request = $this->_bdd->prepare('UPDATE member SET last_name = :lName, first_name = :fName, username = :username, password = :password, mail = :mail, roles = :roles, avatar = :avatar, token_password = :tokenPass, token_session = :tokenSess, description = :description, locale = :locale WHERE id = :id');

        if($request->execute([
            'id' => $member->get_id(),
            'lName' => $member->get_last_name(),
            'fName' => $member->get_first_name(),
            'username' => $member->get_username(),
            'password' => $member->get_password(),
            'mail' => $member->get_mail(),
            'roles' => $member->get_roles(),
            'avatar' => $member->get_avatar(),
            'tokenPass' => $member->get_token_password(),
            'tokenSess' => $member->get_token_session(),
            'description' => $member->get_description(),
            'locale' => $member->get_locale()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getByUsername($username)
    {
        $request = $this->_bdd->prepare('SELECT * FROM member WHERE username = :username');
        $request->bindValue(':username', (string)$username);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Member')[0];
    }

    // We verify if the usdername or the mail already exist in the database
    public function verif($mail, $username)
    {
        $request = $this->_bdd->prepare('SELECT * FROM member WHERE mail = :mail || username = :username');
        if($request->execute(['mail' => $mail, 'username' => $username]))
        {
            if($request->rowCount() == 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function delete($id)
    {
        $request = $this->_bdd->prepare('DELETE FROM member WHERE id = :id');
        if($request->execute(['id' => $id]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}