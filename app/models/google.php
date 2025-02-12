<?php
require_once __DIR__ . '/../../google/vendor/autoload.php';
include_once __DIR__ . '/../../includes/database.php';
include_once __DIR__ . '/../../config/config.php';

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

class Google
{
    private $client;
    private $db;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(CLIENT_ID);
        $this->client->setClientSecret(CLIENT_SECRET);
        $this->client->setRedirectUri(REDIRECT_URI);
        $this->client->addScope('email');
        $this->client->addScope('profile');

        try {
            $this->db = db_connect();
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function googleLogin()
    {
        $authUrl = $this->client->createAuthUrl();
        var_dump($authUrl);
        header('Location: ' . $authUrl);
        exit();
    }

    public function googleCallback()
    {
        if (isset($_GET['code'])) {
            try {
                $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
                $this->client->setAccessToken($token);

                $google_oauth = new Google_Service_Oauth2($this->client);
                $google_account_info = $google_oauth->userinfo->get();
                $email = $google_account_info->email;
                $name = $google_account_info->name;
                $google_id = $google_account_info->id;

                $user = $this->getUserByEmail($email);

                if ($user) {
                    $_SESSION['user'] = $user;
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                        echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        title: 'Đăng nhập thành công',
                                        text: 'Thành công',
                                        icon: 'success'
                                    }).then(function() {
                                        window.location.href = '/';
                                    });
                                });
                            </script>";
                    // header('Location: /');
                    exit();
                } else {
                    $radomUs = rand(1000, 9999);
                    $usergg = 'GoogleUser' . $radomUs;
                    $data = [
                        'username' => $usergg,
                        'email' => $email,
                        'full_name' => $name,
                        'google_id' => $google_id,
                    ];
                    $result = $this->registerFromGoogle($data);

                    if ($result['success']) {
                        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                        echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        title: 'Đăng nhập thành công',
                                        text: 'Thành công',
                                        icon: 'success'
                                    }).then(function() {
                                        window.location.href = '/';
                                    });
                                });
                            </script>";
                        $_SESSION['user'] = $result['user'];
                        // header('Location: /');
                        exit();
                    } else {
                        error_log(print_r($result['errors'], true));
                        header('Location: /register');
                        exit();
                    }
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                header('Location: /login');
                exit();
            }
        } else {
            header('Location: /login');
            exit();
        }
    }

    private function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function registerFromGoogle($data)
    {
        $errors = [];

        try {
            $sql = "INSERT INTO users (username, email, full_name, google_id) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['username'],
                $data['email'],
                $data['full_name'],
                $data['google_id'],
            ]);
            $user = $this->getUserByEmail($data['email']);
            return ['success' => true, 'user' => $user];
        } catch (PDOException $e) {
            $errors['db'] = "Lỗi khi thêm người dùng: " . $e->getMessage();
            return ['success' => false, 'errors' => $errors];
        }
    }
}
