<?php

namespace App\Controllers;


use App\Models\UserModel;
use App\Models\GenderModel;

class UserController extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }


    public function addUser()
     {

        $data = array();
        helper('form');

        if ($this->request == 'post') {
            $post = $this->request->getPost (['first_name','middle_name','last_name', 'age' , 'gender_id' , 'email' , 'password'  ]);
            
            $rules = [
            
                'first_name' => ['label' => 'first name', 'rules'  => 'required' ],
                'middle_name'=> ['label' => 'middle name', 'rules'  => 'permit_empty' ],
                'last_name' => ['label' => 'last name', 'rules'  => 'required' ],
                'age' => ['label' => 'age', 'rules'  => 'required|numeric' ],
                'email' => ['label' => 'email', 'rules'  => 'required|is_unique[users.email]' ],
                'password' =>  ['label' => 'password', 'rules'  => 'required' ],
                'confirm_password' => ['label ' => 'confirm password', 'rules' => 'required_with[password]|matches[password]']
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);

                $userModel = new UserModel();
                $userModel->save($post);
    
                return 'User Succesfully saved!';
            }
        }


            $genderModel = new GenderModel();
            $genderModel = $genderModel->findAll();

            return view ('/user/add' , $data);
     }
    }