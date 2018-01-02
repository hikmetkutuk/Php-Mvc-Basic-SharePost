<?php
/**
 * Created by PhpStorm.
 * User: hikmetis
 * Date: 12/31/17
 * Time: 7:20 AM
 */

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this -> Model('User');
    }

    public function register()
    {
        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //Process form

            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //Validate email
            if (empty($data['email']))
            {
                $data['email_err'] = 'Please enter email !';
            }

            else
            {
                //check email
                if ($this->userModel->findUserByEmail($data['email']))
                {
                    $data['email_err'] = 'Email is already taken !';
                }
            }

            //Validate name
            if (empty($data['name']))
            {
                $data['name_err'] = 'Please enter name !';
            }

            //Validate password
            if (empty($data['password']))
            {
                $data['password_err'] = 'Please enter password !';
            }

            elseif(strlen($data['password']) < 6)
            {
                $data['password_err'] = 'Password must be at least 6 characters !';
            }

            //Validate confirm password
            if (empty($data['confirm_password']))
            {
                $data['confirm_password_err'] = 'Please enter confirm password !';
            }

            else
            {
                if($data['password'] != $data['confirm_password'])
                {
                    $data['confirm_password_err'] = 'Passwords do not match !';
                }
            }

            //Make sure errors empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
            {
                //validated

                //Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register user
                if ($this->userModel->register($data))
                {
                    flash('register_success', 'You are registered can login');
                    redirect('users/login');
                }

                else
                {
                    die('Error');
                }
            }

            else
            {
                //Load view with errors
                $this->view('users/register', $data);
            }

        }
        else
        {
            //Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //Load view
            $this -> view('users/register', $data);
        }
    }

    public function login()
    {
        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //Process form

            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            //Validate email
            if (empty($data['email']))
            {
                $data['email_err'] = 'Please enter email !';
            }

            //Validate password
            if (empty($data['password']))
            {
                $data['password_err'] = 'Please enter password !';
            }

            //Check for user/email
            if ($this->userModel->findUserByEmail($data['email']))
            {
                //User found
            }

            else
            {
                //User not found
                $data['email_err'] = 'No user found !';
            }

            //Make sure errors empty
            if (empty($data['email_err']) && empty($data['password_err']))
            {
                //check and set logged user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser)
                {
                    //Create user
                    $this->createUserSession($loggedInUser);
                }

                else
                {
                    $data['password_err'] = 'Password incorrect !';
                    $this->view('users/login', $data);
                }
            }

            else
            {
                //Load view with errors
                $this->view('users/login', $data);
            }

        }
        else
        {
            //Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            //Load view
            $this -> view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('posts');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id']))
        {
            return true;
        }

        else
        {
            return false;
        }
    }
}