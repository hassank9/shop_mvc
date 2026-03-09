public static function file(string $path = ''): string
{
    $path = trim(str_replace('\\', '/', $path));

    if ($path === '') {
        return '';
    }

    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }

    $base = rtrim(self::basePath(), '/');

    if (strpos($path, $base . '/') === 0) {
        return $path;
    }

    // تنظيف المسارات القديمة الثابتة
    $knownOldBases = [
        '/shop_mvc/public',
        '/firstclass_shop_mvc/public',
    ];

    foreach ($knownOldBases as $oldBase) {
        if (strpos($path, $oldBase . '/') === 0) {
            $path = substr($path, strlen($oldBase));
            break;
        }
    }

    // إذا كان المسار يحتوي uploads في أي مكان، نأخذها منه
    $uploadsPos = strpos($path, '/uploads/');
    if ($uploadsPos !== false) {
        $path = substr($path, $uploadsPos);
    } elseif (strpos($path, 'uploads/') === 0) {
        $path = '/' . $path;
    } else {
        $path = '/' . ltrim($path, '/');
    }

    return $base . $path;
}