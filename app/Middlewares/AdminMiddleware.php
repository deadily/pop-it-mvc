<?php

namespace Middlewares;

use Src\Request;


class AdminMiddleware
{
    public function handle(Request $request, ?string $arg = null): ?Request
    {
        
        if (!app()->auth->check() || !app()->auth->user()->isAdmin()) {
            
            $_SESSION['message'] = 'Доступ запрещен. Требуются права администратора.';
            
            app()->route->redirect('/hello'); 

            return null; 
        }

        return $request;
    }
}