<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/database.php';

function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function redirect(string $path): never { header('Location: ' . BASE_URL . $path); exit; }
function slugify(string $text): string {
    $text = strtolower(trim((string) preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    return $text ?: bin2hex(random_bytes(4));
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Invalid CSRF token. Please refresh and try again.');
    }
}
function setting(string $key, string $default = ''): string {
    $stmt = db()->prepare('SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1');
    $stmt->execute([$key]);
    return (string)($stmt->fetchColumn() ?: $default);
}
function is_admin(): bool { return isset($_SESSION['admin_id']); }
function require_admin(): void { if (!is_admin()) redirect('/admin/login.php'); }
function require_role(array $roles): void {
    require_admin();
    if (!in_array($_SESSION['admin_role'] ?? '', $roles, true)) { http_response_code(403); exit('Forbidden'); }
}
function flash(string $key, ?string $value = null): ?string {
    if ($value !== null) { $_SESSION['flash'][$key] = $value; return null; }
    $message = $_SESSION['flash'][$key] ?? null; unset($_SESSION['flash'][$key]); return $message;
}
function upload_image(string $field): ?string {
    if (empty($_FILES[$field]['name'])) return null;
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK || $_FILES[$field]['size'] > 5 * 1024 * 1024) throw new RuntimeException('Image must be under 5 MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES[$field]['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) throw new RuntimeException('Only JPG, PNG and WebP images are allowed.');
    if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
    $name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], UPLOAD_DIR . $name)) throw new RuntimeException('Upload failed.');
    return $name;
}

