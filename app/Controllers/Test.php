<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class Test extends Controller
{
    public function searchTest()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Test JSON response',
            'html' => '<div class="p-4 bg-green-100">Test HTML Content</div>'
        ]);
    }
}

?>