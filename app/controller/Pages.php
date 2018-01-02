<?php
/**
 * Created by PhpStorm.
 * User: hikmetis
 * Date: 12/30/17
 * Time: 5:43 AM
 */

class Pages extends Controller
{
    public function __construct()
    {

    }

    //Load homepage
    public function index(){
        if (isLoggedIn())
        {
            redirect('posts');
        }

        $data = [
            'title' => 'Shareboard',
            'description' => 'MVC PHP Framework',
        ];

        $this->view('pages/index', $data);
    }

    public function about(){
        $data = [
            'title' => 'About Us',
            'description' => 'MVC PHP Framework',
        ];

        $this->view('pages/about', $data);
    }

}