<?php

class AuthController
{
    public function login()
    {
        redirectIfLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf_token();

            $identifier = cleanInput($_POST['identifier']);
            $password = cleanInput($_POST['password']);

            try {
                checkEmpty($identifier, $password);
                $user = User::connect($identifier, $password);
                $_SESSION['user'] = ['id' => $user->id];
                redirect('articles');
            } catch (Exception $e) {
                setResponseMessage('error', $e->getMessage());
            }
        }

        render('auth/login', $_POST);
    }

    public function signup()
    {
        redirectIfLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf_token();

            $username = cleanInput($_POST['username']);
            $email = cleanInput($_POST['email']);
            $password = cleanInput($_POST['password']);
            $confirmPassword = cleanInput($_POST['confirm_password']);

            try {
                checkEmpty($username, $email, $password, $confirmPassword);
                User::validatePasswords($password, $confirmPassword);
                User::create($username, $email, $password);
                setResponseMessage('success', "Compte créé avec succès. Vous pouvez vous connecter maintenant.");
                redirect('login');
            } catch (Exception $e) {
                setResponseMessage('error', $e->getMessage());
            }
        }

        render('auth/signup', $_POST);
    }

    public function logout()
    {
        requireLogin();
        destroySession();
        redirect('');
    }
}
