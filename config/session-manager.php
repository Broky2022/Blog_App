<?php
/**
 * Quản lý session với thời hạn
 */
class SessionManager {
    /**
     * Khởi tạo session với thời hạn
     * 
     * @param int $lifetime Thời gian sống của session tính bằng giây (mặc định 30 phút)
     */
    public static function start($lifetime = 1800) {
        // Bắt đầu session nếu chưa được bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            // Thiết lập lifetime cho cookie session
            session_set_cookie_params($lifetime);
            session_start();
        }
        
        // Kiểm tra xem session đã có thời hạn chưa
        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > $lifetime) {
            // Session đã hết hạn, tạo mới
            session_regenerate_id(true);
            $_SESSION['CREATED'] = time();
            
            // Xóa dữ liệu cũ của session (trừ thông tin tạo mới)
            $created = $_SESSION['CREATED'];
            session_unset();
            $_SESSION['CREATED'] = $created;
        }
        
        // Cập nhật thời gian truy cập gần nhất
        $_SESSION['LAST_ACTIVITY'] = time();
    }
    
    /**
     * Thiết lập thời gian session sẽ hết hạn
     * 
     * @param int $lifetime Thời gian tính bằng giây
     */
    public static function setTimeout($lifetime) {
        $_SESSION['EXPIRES'] = time() + $lifetime;
    }
    
    /**
     * Kiểm tra xem session có hết hạn không
     * 
     * @return bool True nếu session hết hạn, ngược lại là false
     */
    public static function isExpired() {
        if (isset($_SESSION['EXPIRES']) && time() > $_SESSION['EXPIRES']) {
            return true;
        }
        
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            // Nếu không có hoạt động trong 30 phút
            return true;
        }
        
        return false;
    }
    
    /**
     * Xóa hết dữ liệu session
     */
    public static function clear() {
        session_unset();
    }
    
    /**
     * Hủy session
     */
    public static function destroy() {
        self::clear();
        session_destroy();
        
        // Xóa cookie session
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
} 