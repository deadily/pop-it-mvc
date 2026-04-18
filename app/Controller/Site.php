<?php

namespace Controller;

use Model\Post;
use Model\User;
use Src\View;
use Src\Request;
use Src\Auth\Auth;


class Site
{
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            unset($_SESSION['message']);

            if (Auth::user()->isAdmin()) {
                app()->route->redirect('/signup');
            } else {
                app()->route->redirect('/staff');
            }
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    public function signup(): string
    {
        $users = User::all();
        return new View('site.signup', ['users' => $users]);
    }

    public function staff(): string
        {
            $user = app()->auth::user();
            return new View('site.staff', ['user' => $user]);
        }

    public function deleteUser(Request $request): void
        {
            if ($request->method === 'POST') {
                $id = $request->get('id');
                $user = User::find($id);
                if ($user) {
                    $user->delete();
                }
            }

            app()->route->redirect('/signup'); 
        }
}