<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller {

    public function login() {
        if(session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function authenticate() {
        $username = $this->request->getPost('username');
        $password = 
        $this->request->getPost('password');
        
        $db = db_connect();
        $user = $db->table('users')->where('username', $username)->get()->getRow();

        if($user && password_verify($password, $user->password)) {
            session()->set([
                'user_id' => $user->id_user,
                'username' => $username,
                'role' => $user->role,
                'nama_lengkap' => $user->nama_lengkap,
                'isLoggedIn' => true
            ]);

            return redirect()->to('/');
        }
        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}

?>
