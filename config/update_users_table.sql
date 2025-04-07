-- Thêm cột cho xác thực 2 bước
ALTER TABLE users
ADD COLUMN two_factor_enabled BOOLEAN DEFAULT FALSE,
ADD COLUMN two_factor_secret VARCHAR(32) DEFAULT NULL;

-- Thêm cột cho đặt lại mật khẩu
ALTER TABLE users
ADD COLUMN reset_token VARCHAR(64) DEFAULT NULL,
ADD COLUMN reset_token_expires DATETIME DEFAULT NULL; 