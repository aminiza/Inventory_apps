<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['username', 'password', 'role'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'username' => 'required|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,petugas]'
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan.'
        ],
        'password' => [
            'min_length' => 'Password minimal 6 karakter.'
        ],
        'role' => [
            'in_list' => 'Role harus admin atau petugas'
        ]
    ];

    public function getUsername($username) {
        return $this->where('username', $username)->first();
    }
}


