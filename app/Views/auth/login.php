<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#64748b'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/auth/authenticate') ?>" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Username</label>
                <input type="text" name="username" placeholder="Username..." class="w-full px-4 py-2 border rounded required">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" placeholder="******" class="w-full px-4 py-2 border rounded required">
            </div>
            <button id="login" type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('login').addEventListener('click', function() {
            document.getElementById('login').classList.add('animate-pulse');
            setTimeout(function() {
                document.getElementById('login').classList.remove('animate-pulse');
            }, 1000);
        });
    });
</script>