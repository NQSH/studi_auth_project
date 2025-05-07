<?php

class AuthController
{
    public function login()
    {
        redirectIfLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf_token();

            $identifier = cleanInput($_POST['identifier']);
            $password = $_POST['password'];

            $user = User::findByUsername($identifier) ?? User::findByEmail($identifier);

            if ($user && $user->verifyPassword($password)) {
                $_SESSION['user'] = [
                    'id' => $user->id
                ];
                redirect('articles');
            } else {
                setResponseMessage('error', "Nom d'utilisateur ou mot de passe incorrect.");
                render('auth/login');
            }
        } else {
            render('auth/login');
        }
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

            if ($password !== $confirmPassword) {
                setResponseMessage('error', "Les mots de passe ne correspondent pas.");
                render('auth/signup');
                return;
            }

            if (User::exists($username) || User::exists($email)) {
                setResponseMessage('error', "Nom d'utilisateur ou e-mail déjà utilisé.");
                render('auth/signup');
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $created = User::create($username, $email, $hashedPassword);

            if ($created) {
                setResponseMessage('success', "Compte créé avec succès. Vous pouvez vous connecter maintenant.");
                render('auth/login');
            } else {
                setResponseMessage('error', "Erreur lors de la création du compte.");
                render('auth/signup');
            }
        } else {
            render('auth/signup');
        }
    }

    public function logout()
    {
        requireLogin();
        destroySession();
        redirect('/');
    }
}
