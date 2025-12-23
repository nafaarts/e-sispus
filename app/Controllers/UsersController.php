<?php
namespace App\Controllers;

use Core\Controller;
use Core\Middleware;
use Core\Validator;
use Core\Csrf;
use App\Models\User;

class UsersController extends Controller
{
    public function index(): void
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_users');
        $this->view('users/index', ['users' => User::all()]);
    }

    public function create(): void
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_users');
        $this->view('users/create', ['csrf' => Csrf::token(), 'errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_users');
        $token = $_POST['_csrf'] ?? null;
        if (!Csrf::check($token)) {
            http_response_code(400);
            echo 'Invalid CSRF';
            return;
        }
        $data = [
            'username' => trim((string)($_POST['username'] ?? '')),
            'name' => trim((string)($_POST['name'] ?? '')),
            'email' => trim((string)($_POST['email'] ?? '')),
            'password' => (string)($_POST['password'] ?? ''),
            'role' => trim((string)($_POST['role'] ?? ''))
        ];
        $validator = new Validator($data);
        $validator->required('username')->min('username', 3)
                  ->required('name')->min('name', 3)
                  ->required('email')->email('email')
                  ->required('password')->min('password', 6)
                  ->required('role')->in('role', ['ADMIN', 'OPERATOR']);
        if ($validator->fails()) {
            $this->view('users/create', ['csrf' => Csrf::token(), 'errors' => $validator->errors(), 'old' => $data]);
            return;
        }
        if (User::findByEmail($data['email'])) {
            $errors = $validator->errors();
            $errors['email'] = ['exists'];
            $this->view('users/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $data]);
            return;
        }
        if (User::findByUsername($data['username'])) {
            $errors = $validator->errors();
            $errors['username'] = ['exists'];
            $this->view('users/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $data]);
            return;
        }
        User::create($data['username'], $data['name'], $data['email'], $data['password'], $data['role']);
        $this->redirect('/index.php?url=users/index');
    }

    public function edit($id): void
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_users');
        $user = User::find((int)$id);
        if (!$user) {
            http_response_code(404);
            echo 'Not Found';
            return;
        }
        $this->view('users/edit', ['user' => $user, 'csrf' => Csrf::token(), 'errors' => []]);
    }
 

    public function update($id): void
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_users');
        $token = $_POST['_csrf'] ?? null;
        if (!Csrf::check($token)) {
            http_response_code(400);
            echo 'Invalid CSRF';
            return;
        }
        $data = [
            'username' => trim((string)($_POST['username'] ?? '')),
            'name' => trim((string)($_POST['name'] ?? '')),
            'email' => trim((string)($_POST['email'] ?? '')),
            'password' => (string)($_POST['password'] ?? ''),
            'role' => trim((string)($_POST['role'] ?? ''))
        ];
        $validator = new Validator($data);
        $validator->required('username')->min('username', 3)
                  ->required('name')->min('name', 3)
                  ->required('email')->email('email')
                  ->required('role')->in('role', ['ADMIN', 'OPERATOR']);
        if ($validator->fails()) {
            $user = User::find((int)$id);
            $this->view('users/edit', ['user' => $user, 'csrf' => Csrf::token(), 'errors' => $validator->errors()]);
            return;
        }
        $existingEmail = User::findByEmail($data['email']);
        if ($existingEmail && (int)$existingEmail['id'] !== (int)$id) {
            $errors = $validator->errors();
            $errors['email'] = ['exists'];
            $user = User::find((int)$id);
            $this->view('users/edit', ['user' => $user, 'csrf' => Csrf::token(), 'errors' => $errors]);
            return;
        }
        $existingUsername = User::findByUsername($data['username']);
        if ($existingUsername && (int)$existingUsername['id'] !== (int)$id) {
            $errors = $validator->errors();
            $errors['username'] = ['exists'];
            $user = User::find((int)$id);
            $this->view('users/edit', ['user' => $user, 'csrf' => Csrf::token(), 'errors' => $errors]);
            return;
        }
        User::update((int)$id, $data['username'], $data['name'], $data['email'], $data['password'] ?: null, $data['role']);
        $this->redirect('/index.php?url=users/index');
    }

    public function destroy($id): void
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_users');
        $token = $_POST['_csrf'] ?? null;
        if (!Csrf::check($token)) {
            http_response_code(400);
            echo 'Invalid CSRF';
            return;
        }
        User::delete((int)$id);
        $this->redirect('/index.php?url=users/index');
    }
}
