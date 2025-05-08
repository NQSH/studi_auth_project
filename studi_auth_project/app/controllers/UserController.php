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

            try {
                checkEmpty($username, $email);
                User::isAvailable($username, $email, $user);
                User::validatePasswords($password, $confirmPassword);
                $user->update($username, $email, $password);
                setResponseMessage('success', "Modifications enregistrées avec succès.");
            } catch (Exception $e) {
                setResponseMessage('error', $e->getMessage());
            }
        }

        render('user/edit', ['user' => $user]);
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

        destroySession();
        redirect('');
    }
}
