<?php

class UserController
{
    public function show()
    {
        requireLogin();

        $user = User::findById($_SESSION['user']['id']);
        if (!$user) {
            renderNotFound();
            return;
        }

        render('user/show', ['user' => $user]);
    }

    public function edit()
    {
        requireLogin();

        $user = User::findById($_SESSION['user']['id']);
        if (!$user) {
            renderNotFound();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf_token();

            $username = cleanInput($_POST['username']);
            $email = cleanInput($_POST['email']);
            $password = cleanInput($_POST['password']);
            $confirmPassword = cleanInput($_POST['confirm_password']);

            if ($password !== $confirmPassword) {
                setResponseMessage('error', "Les mots de passe ne correspondent pas.");
                render('user/edit', ['user' => $user]);
                return;
            }

            if (($username !== $user->username && User::exists($username)) || ($email !== $user->email && User::exists($email))) {
                setResponseMessage('error', "Nom d'utilisateur ou e-mail déjà utilisé.");
                render('user/edit', ['user' => $user]);
                return;
            }

            $user->username = $username;
            $user->email = $email;
            if (!empty($password)) {
                $user->setPassword($password);
            }

            if ($user->save()) {
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['email'] = $email;

                setResponseMessage('success', "Profil mis à jour avec succès.");
                render('user/show', ['user' => $user]);
            } else {
                setResponseMessage('error', "Erreur lors de la mise à jour du profil.");
                render('user/edit', ['user' => $user]);
            }
        } else {
            render('user/edit', ['user' => $user]);
        }
    }

    public function delete()
    {
        requireLogin();

        $user = User::findById($_SESSION['user']['id']);
        if (!$user) {
            renderNotFound();
            return;
        }

        $user->delete();
        Article::deleteByAuthor($user->id);
        destroySession();
        redirect('/');
    }
}
