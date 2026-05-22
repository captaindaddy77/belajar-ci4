<?php
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS db_praktikum");
    $pdo->exec("USE db_praktikum");
    
    // Drop table if exists
    $pdo->exec("DROP TABLE IF EXISTS users");
    
    // Create users table
    $sqlCreate = "CREATE TABLE users ( 
        id           INT AUTO_INCREMENT PRIMARY KEY, 
        username     VARCHAR(50) UNIQUE NOT NULL, 
        email        VARCHAR(100) UNIQUE NOT NULL, 
        password     VARCHAR(255) NOT NULL, 
        nama_lengkap VARCHAR(100) NOT NULL, 
        role         ENUM('admin', 'petugas', 'anggota') DEFAULT 'anggota', 
        aktif        TINYINT(1) DEFAULT 1 COMMENT '1=aktif, 0=dinonaktifkan', 
        last_login   DATETIME NULL, 
        created_at   DATETIME DEFAULT CURRENT_TIMESTAMP, 
        updated_at   DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
    )";
    $pdo->exec($sqlCreate); 
    echo "Table 'users' created successfully.\n";
    
    // Password hashes
    $adminHash = password_hash('Admin@perpus.id', PASSWORD_DEFAULT);
    $petugasHash = password_hash('Petugas@perpus.id', PASSWORD_DEFAULT);
    $anggotaHash = password_hash('Anggota@perpus.id', PASSWORD_DEFAULT);
    
    // Insert initial users
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, nama_lengkap, role) VALUES 
        ('admin', 'admin@perpus.id', ?, 'Administrator', 'admin'), 
        ('petugas1', 'petugas@perpus.id', ?, 'Petugas', 'petugas'), 
        ('anggota1', 'anggota@perpus.id', ?, 'Anggota', 'anggota')");
    $stmt->execute([$adminHash, $petugasHash, $anggotaHash]);
    echo "Initial users seeded successfully.\n";
} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage() . "\n";
}
