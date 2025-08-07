<?php
/**
 * Script de réparation de la base de données
 * À exécuter après suppression accidentelle des données
 */

// Charger WordPress
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Vérifier les permissions
if (!current_user_can('manage_options')) {
    die('Accès refusé');
}

echo "<h1>🔧 Réparation de la base de données Institut Booking</h1>";

global $wpdb;

// 1. Vérifier l'état des tables
echo "<h2>📊 Vérification des tables</h2>";
$tables_to_check = [
    'ib_services' => 'Services',
    'ib_employees' => 'Praticiennes',
    'ib_clients' => 'Clients',
    'ib_bookings' => 'Réservations',
    'ib_notifications' => 'Notifications',
    'ib_categories' => 'Catégories'
];

$table_status = [];
foreach ($tables_to_check as $table => $name) {
    $full_table = $wpdb->prefix . $table;
    $exists = $wpdb->get_var("SHOW TABLES LIKE '$full_table'") === $full_table;
    $count = $exists ? $wpdb->get_var("SELECT COUNT(*) FROM $full_table") : 0;
    
    $table_status[$table] = [
        'exists' => $exists,
        'count' => $count,
        'name' => $name
    ];
    
    $status_icon = $exists ? ($count > 0 ? '✅' : '⚠️') : '❌';
    echo "<p>$status_icon <strong>$name</strong>: " . ($exists ? "$count enregistrements" : "Table manquante") . "</p>";
}

// 2. Recréer les tables manquantes
echo "<h2>🔨 Recréation des tables manquantes</h2>";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$charset_collate = $wpdb->get_charset_collate();

// Table des catégories
if (!$table_status['ib_categories']['exists']) {
    $sql = "CREATE TABLE {$wpdb->prefix}ib_categories (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        color varchar(7) DEFAULT NULL,
        icon varchar(255) DEFAULT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta($sql);
    echo "<p>✅ Table ib_categories créée</p>";
}

// Table des services
if (!$table_status['ib_services']['exists']) {
    $sql = "CREATE TABLE {$wpdb->prefix}ib_services (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        description text,
        duration int NOT NULL,
        price decimal(10,2) NOT NULL,
        color varchar(7) NOT NULL,
        image varchar(255) DEFAULT NULL,
        category_id bigint(20) DEFAULT NULL,
        variable_price tinyint(1) DEFAULT 0,
        min_price decimal(10,2) DEFAULT NULL,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta($sql);
    echo "<p>✅ Table ib_services créée</p>";
}

// Table des clients
if (!$table_status['ib_clients']['exists']) {
    $sql = "CREATE TABLE {$wpdb->prefix}ib_clients (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(20) NOT NULL,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";
    dbDelta($sql);
    echo "<p>✅ Table ib_clients créée</p>";
}

// Table des praticiennes
if (!$table_status['ib_employees']['exists']) {
    $sql = "CREATE TABLE {$wpdb->prefix}ib_employees (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(20) NOT NULL,
        services text NOT NULL,
        working_hours text NOT NULL,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta($sql);
    echo "<p>✅ Table ib_employees créée</p>";
}

// Table des réservations
if (!$table_status['ib_bookings']['exists']) {
    $sql = "CREATE TABLE {$wpdb->prefix}ib_bookings (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        client_id bigint(20) NOT NULL,
        employee_id bigint(20) NOT NULL,
        service_id bigint(20) NOT NULL,
        client_name varchar(255) DEFAULT NULL,
        client_email varchar(255) DEFAULT NULL,
        date date NOT NULL,
        start_time datetime NOT NULL,
        end_time datetime NOT NULL,
        status varchar(20) NOT NULL,
        price decimal(10,2) NOT NULL,
        notes text,
        extras text,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY  (id),
        KEY client_id (client_id),
        KEY employee_id (employee_id),
        KEY service_id (service_id),
        KEY date (date),
        KEY status (status)
    ) $charset_collate;";
    dbDelta($sql);
    echo "<p>✅ Table ib_bookings créée</p>";
}

// Table des notifications
if (!$table_status['ib_notifications']['exists']) {
    $sql = "CREATE TABLE {$wpdb->prefix}ib_notifications (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(32) NOT NULL,
        message TEXT NOT NULL,
        target VARCHAR(32) DEFAULT 'admin',
        status VARCHAR(16) DEFAULT 'unread',
        link VARCHAR(255) DEFAULT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";
    dbDelta($sql);
    echo "<p>✅ Table ib_notifications créée</p>";
}

// 3. Ajouter des données de base
echo "<h2>📝 Ajout des données de base</h2>";

// Catégories de base
if ($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ib_categories") == 0) {
    $categories = [
        ['name' => 'Soins du visage', 'color' => '#FF6B6B', 'icon' => '✨'],
        ['name' => 'Soins du corps', 'color' => '#4ECDC4', 'icon' => '💆'],
        ['name' => 'Coiffure', 'color' => '#45B7D1', 'icon' => '💇'],
        ['name' => 'Esthétique', 'color' => '#96CEB4', 'icon' => '💅']
    ];
    
    foreach ($categories as $cat) {
        $wpdb->insert("{$wpdb->prefix}ib_categories", $cat);
    }
    echo "<p>✅ " . count($categories) . " catégories ajoutées</p>";
}

// Services de base
if ($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ib_services") == 0) {
    $services = [
        [
            'name' => 'Soin du visage classique',
            'description' => 'Nettoyage, gommage et hydratation',
            'duration' => 60,
            'price' => 45.00,
            'color' => '#FF6B6B',
            'category_id' => 1,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ],
        [
            'name' => 'Massage relaxant',
            'description' => 'Massage complet du corps',
            'duration' => 90,
            'price' => 65.00,
            'color' => '#4ECDC4',
            'category_id' => 2,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ],
        [
            'name' => 'Coupe et brushing',
            'description' => 'Coupe personnalisée et mise en forme',
            'duration' => 75,
            'price' => 35.00,
            'color' => '#45B7D1',
            'category_id' => 3,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ],
        [
            'name' => 'Manucure',
            'description' => 'Soin des mains et pose de vernis',
            'duration' => 45,
            'price' => 25.00,
            'color' => '#96CEB4',
            'category_id' => 4,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ]
    ];
    
    foreach ($services as $service) {
        $wpdb->insert("{$wpdb->prefix}ib_services", $service);
    }
    echo "<p>✅ " . count($services) . " services ajoutés</p>";
}

// Praticienne de base
if ($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ib_employees") == 0) {
    $current_user = wp_get_current_user();
    $wpdb->insert("{$wpdb->prefix}ib_employees", [
        'user_id' => $current_user->ID,
        'name' => $current_user->display_name ?: 'Administrateur',
        'email' => $current_user->user_email,
        'phone' => '0123456789',
        'services' => json_encode([1, 2, 3, 4]),
        'working_hours' => json_encode([
            'monday' => ['09:00', '18:00'],
            'tuesday' => ['09:00', '18:00'],
            'wednesday' => ['09:00', '18:00'],
            'thursday' => ['09:00', '18:00'],
            'friday' => ['09:00', '18:00']
        ]),
        'created_at' => current_time('mysql'),
        'updated_at' => current_time('mysql')
    ]);
    echo "<p>✅ Praticienne administrateur ajoutée</p>";
}

echo "<h2>🎉 Réparation terminée !</h2>";
echo "<p><strong>Votre base de données a été réparée avec succès.</strong></p>";
echo "<p>Vous pouvez maintenant retourner au dashboard et ajouter vos propres données.</p>";
echo "<p><a href='" . admin_url('admin.php?page=institut-booking') . "' style='background: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Retour au Dashboard</a></p>";
?>
