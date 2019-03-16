<?php

class MemberManager extends Manager
{
    // Add members into the database
    public function add(Member $member, $role)
    {
        $request = $this->_bdd->prepare('INSERT INTO member(last_name, first_name, username, password, mail, roles, avatar, date_inscription, description, locale) VALUES (:last_name, :first_name, :username, :password, :mail, :roles, :avatar, NOW(), :description, :locale)');

        if($request->execute([
            'last_name' => $member->get_last_name(),
            'first_name' => $member->get_first_name(),
            'username' => $member->get_username(),
            'password' => $member->get_password(),
            'mail' => $member->get_mail(),
            'roles' => $role,
            'avatar' => $member->get_avatar(),
            'description' => $member->get_description(),
            'locale' => $member->get_locale(),
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
        $request = $this->_bdd->prepare('SELECT *, DATE_FORMAT(date_inscription, \'%d/%m/%Y\') AS dateInsc FROM member');
        if($request->execute())
        {
            $results = $request->fetchAll(\PDO::FETCH_ASSOC);
            $tableMembers = [];
            foreach($results as $value)
            {
                $member = new member();
                $member->set_id($value['id']);
                $member->set_last_name($value['lname']);
                $member->set_first_name($value['fname']);
                $member->set_username($value['username']);
                $member->set_password($value['password']);
                $member->set_mail($value['mail']);
                $member->set_roles($value['roles']);
                $member->set_avatar($value['avatar']);
                $member->set_token_session($value['token_session']);
                $member->set_token_password($value['token_password']);
                $member->set_date_inscription($value['dateInsc']);
                $member->set_description($value['description']);
                $member->set_locale($value['locale']);

                $tableMembers[] = $member;
            }
            return $tableMembers;
        }
        else
        {
            return false;
        }
    }

    public function show($id)
    {
        $request = $this->_bdd->prepare('SELECT *, DATE_FORMAT(date_inscription, \'%d/%m/%Y\') AS dateInsc FROM member WHERE member.id = :id');
        if($request->execute(['id' => $id]) && $request->rowCount() == 1)
        {
            $results = $request->fetch(\PDO::FETCH_ASSOC);
            $member = new member();
            $member->set_id($results['id']);
            $member->set_last_name($results['lname']);
            $member->set_first_name($results['fname']);
            $member->set_username($results['username']);
            $member->set_password($results['password']);
            $member->set_mail($results['mail']);
            $member->set_roles($results['roles']);
            $member->set_avatar($results['avatar']);
            $member->set_token_session($results['token_session']);
            $member->set_token_password($results['token_password']);
            $member->set_date_inscription($results['dateInsc']);
            $member->set_description($results['description']);
            $member->set_locale($results['locale']);

            return $member;
        }
        else
        {
            return false;
        }
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
        $request = $this->_bdd->prepare('SELECT *, DATE_FORMAT(date_inscription, \'%d/%m/%Y\') AS dateInsc FROM member WHERE username = :username');
        if($request->execute(['username' => $username]))
        {
            $results = $request->fetch(\PDO::FETCH_ASSOC);
            $member = new Member();
            $member->set_id($results['id']);
            $member->set_last_name($results['lname']);
            $member->set_first_name($results['fname']);
            $member->set_username($results['username']);
            $member->set_password($results['password']);
            $member->set_mail($results['mail']);
            $member->set_roles($results['roles']);
            $member->set_avatar($results['avatar']);
            $member->set_token_session($results['token_session']);
            $member->set_token_password($results['token_password']);
            $member->set_date_inscription($results['dateInsc']);
            $member->set_description($results['description']);
            $member->set_locale($results['locale']);

            return $member;
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