<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller {
    public function index() {
        // Serve the view
        return view ('/login', []);
    }

    public function login() {
        $alerts = [];
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';

        $accountExists = DB::table('people')
            ->where('medicare_id', '=', $user)
            ->where('date_of_birth', '=', $pass)
            ->exists();

        if ($accountExists) {
            setcookie('user', $user);
            setcookie('pass', $pass);

            header("Location: /");
            exit;
        } else {
            array_push($alerts, [
                'type' => 'warning',
                'text' => "Username and password combination not found"
            ]);

            return view ('/login', [
                'alerts' => $alerts
            ]);
        }
    }

    public function logout() {
        setcookie('user', '', time() - 100);
        setcookie('pass', '', time() - 100);

        header("Location: /");
        exit;
    }
}
