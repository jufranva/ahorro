<?php
require_once __DIR__ . '/../models/Banner.php';

class BannerController
{
    private function cropImage(string $file, int $width, int $height): void
    {
        [$origWidth, $origHeight, $type] = getimagesize($file);
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($file);
                break;
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($file);
                break;
            default:
                return;
        }

        $srcRatio = $origWidth / $origHeight;
        $dstRatio = $width / $height;

        if ($srcRatio > $dstRatio) {
            $newHeight = $origHeight;
            $newWidth = $origHeight * $dstRatio;
            $srcX = ($origWidth - $newWidth) / 2;
            $srcY = 0;
        } else {
            $newWidth = $origWidth;
            $newHeight = $origWidth / $dstRatio;
            $srcX = 0;
            $srcY = ($origHeight - $newHeight) / 2;
        }

        $dst = imagecreatetruecolor($width, $height);
        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $width, $height, $newWidth, $newHeight);

        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($dst, $file, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($dst, $file);
                break;
            case IMAGETYPE_GIF:
                imagegif($dst, $file);
                break;
        }
        imagedestroy($src);
        imagedestroy($dst);
    }

    public function handle(): void
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: inicio.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            switch ($action) {
                case 'create':
                    $title = $_POST['title'] ?? '';
                    $subtitle = $_POST['subtitle'] ?? '';
                    $link = $_POST['link'] ?? '';
                    $link = $link ?: 'shop-grid.html';
                    $color = isset($_POST['color']) ? (int)$_POST['color'] : 1;
                    $image = '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/banner/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $this->cropImage($destination, 570, 300);
                            $image = 'assets/images/banner/' . $filename;
                        }
                    }
                    if ($title && $subtitle && $image) {
                        Banner::create($title, $subtitle, $image, $link, $color);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $title = $_POST['title'] ?? '';
                    $subtitle = $_POST['subtitle'] ?? '';
                    $link = $_POST['link'] ?? '';
                    $link = $link ?: 'shop-grid.html';
                    $color = isset($_POST['color']) ? (int)$_POST['color'] : 1;
                    $image = $_POST['current_image'] ?? '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/banner/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $this->cropImage($destination, 570, 300);
                            $image = 'assets/images/banner/' . $filename;
                        }
                    }
                    if ($id && $title && $subtitle && $image) {
                        Banner::update($id, $title, $subtitle, $image, $link, $color);
                    }
                    break;
                case 'delete':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        Banner::delete($id);
                    }
                    break;
            }
        }

        header('Location: index.php');
        exit;
    }
}
