<?php
$company_name = get_option('ib_company_name', 'Institut Booking');
?>
<div id="ib-app" class="ib-app">
    <!-- Header principal avec bouton hamburger et notifications -->
    <div class="ib-header">
        <div class="ib-header-left">
            <button class="ib-menu-toggle" onclick="toggleSidebar()">
                <span class="dashicons dashicons-menu"></span>
            </button>
            <h1 class="ib-page-title"><?php echo esc_html($company_name); ?></h1>
        </div>
        <div class="ib-header-right">
            <div id="ib-notif-bell" class="ib-notif-bell">
                <button class="ib-notif-bell-btn" aria-label="Notifications">
                    <span class="dashicons dashicons-bell"></span>
                    <span class="ib-notif-badge" style="display:none;">0</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Overlay pour mobile -->
    <div class="ib-sidebar-overlay" onclick="closeSidebar()"></div>
    
    <!-- Sidebar -->
    <?php require_once(IB_PLUGIN_DIR . 'admin/sidebar.php'); ?>
    
    <!-- Contenu principal -->
    <div class="ib-main-content">
        <div class="ib-main-inner">
            <main class="ib-content">
                <?php if (isset($GLOBALS['ib_page_content'])) echo $GLOBALS['ib_page_content']; ?>
            </main>
        </div>
    </div>
</div>

<style>
/* Layout moderne */
#ib-app, .ib-app,
.ib-main-content, .ib-main-inner, .ib-content {
    display: block !important;
    min-height: unset !important;
    height: auto !important;
    flex: unset !important;
    align-items: unset !important;
    justify-content: unset !important;
    background: var(--bg-light);
}

.ib-header, .ib-content {
    width: 100%;
}

.ib-header {
    background: var(--bg);
    border-bottom: 1px solid var(--border);
    padding: 1rem 0 1rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow);
    position: sticky;
    top: 0;
    z-index: 100;
}

.ib-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 0;
}

.ib-menu-toggle {
    display: none;
    background: none;
    border: none;
    color: #e9aebc;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.8rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    margin-right: 1rem;
}

.ib-menu-toggle:hover {
    background: #fbeff3;
    color: #b95c8a;
    transform: scale(1.05);
}

.ib-page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.ib-header-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-right: 0;
}

.ib-user-menu {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--bg-light);
    border-radius: var(--radius);
    color: var(--text);
    font-weight: 500;
    font-size: 0.9rem;
}

.ib-content {
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    padding: 0 !important;
    flex: 1;
    overflow-y: auto;
}

.ib-notif-bell {
    margin-right: 4rem;
    margin-left: 0;
    align-items: center;
    display: flex;
}

/* Responsive */
@media (max-width: 1024px) {
    .ib-main-content {
        margin-left: 0;
    }
    .ib-main-inner {
        max-width: 100%;
    }
    
    .ib-menu-toggle {
        display: block;
    }
    
    .ib-content {
        padding: 1rem;
    }
    
    .ib-header {
        padding: 1rem;
    }
    
    /* Sidebar mobile */
    .ib-sidebar {
        transform: translateX(-100%);
    }
    
    .ib-sidebar.open {
        transform: translateX(0);
    }
    
    /* Overlay pour fermer la sidebar */
    .ib-sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    
    .ib-sidebar-overlay.active {
        display: block;
    }
}

@media (max-width: 768px) {
    .ib-content {
        padding: 0.5rem;
    }
    
    .ib-page-title {
        font-size: 1.25rem;
    }
}

@media (max-width: 900px) {
    .ib-main-content, .ib-content {
        margin-left: 0 !important;
        padding-left: 0.5rem !important;
        padding-right: 1rem !important;
    }
}

/* Animation pour la sidebar */
@keyframes slideIn {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(0);
    }
}

.ib-sidebar.open {
    animation: slideIn 0.3s ease;
}

.ib-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 240px;
    height: 100vh;
    background: #fff;
    border-right: 1px solid #f1f5f9;
    z-index: 1000;
    overflow-y: auto;
    transition: transform 0.3s ease;
}

.ib-sidebar, .custom-sidebar {
    width: 270px !important;
    min-width: 270px !important;
}

.ib-main-content {
    margin-left: 270px;
    padding: 0;
    background: transparent;
    min-height: 100vh;
    box-sizing: border-box;
    width: auto;
    display: block;
}

body {
    overflow-x: hidden !important;
}
</style>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.ib-sidebar');
    const overlay = document.querySelector('.ib-sidebar-overlay');
    
    if (sidebar) {
        sidebar.classList.toggle('open');
        if (overlay) {
            overlay.classList.toggle('active');
        }
    }
}

function closeSidebar() {
    const sidebar = document.querySelector('.ib-sidebar');
    const overlay = document.querySelector('.ib-sidebar-overlay');
    
    if (sidebar) {
        sidebar.classList.remove('open');
    }
    if (overlay) {
        overlay.classList.remove('active');
    }
}

// Fermer la sidebar en cliquant à l'extérieur sur mobile
document.addEventListener('click', function(e) {
    if (window.innerWidth <= 1024) {
        const sidebar = document.querySelector('.ib-sidebar');
        const menuToggle = document.querySelector('.ib-menu-toggle');
        
        if (sidebar && menuToggle && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            closeSidebar();
        }
    }
});

// Fermer la sidebar quand on redimensionne l'écran
window.addEventListener('resize', function() {
    if (window.innerWidth > 1024) {
        const sidebar = document.querySelector('.ib-sidebar');
        const overlay = document.querySelector('.ib-sidebar-overlay');
        
        if (sidebar) {
            sidebar.classList.remove('open');
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
    }
});
</script>

<!-- Modal notifications premium -->
<div id="ib-notif-modal-overlay" class="ib-notif-modal-overlay" style="display:none;">
    <div class="ib-notif-modal">
        <button class="ib-notif-modal-close" aria-label="Fermer">&times;</button>
        <div class="ib-notif-modal-header">
            Notifications
            <button class="ib-notif-mark-all" title="Tout marquer comme lu">✔️</button>
        </div>
        <div class="ib-notif-modal-search">
            <input type="text" class="ib-notif-search-input" placeholder="Rechercher une notification..." />
        </div>
        <div class="ib-notif-modal-spinner" style="display:none;"><span class="ib-spinner"></span></div>
        <div class="ib-notif-modal-list"></div>
        <div class="ib-notif-empty" style="display:none;">Aucune notification</div>
        <button class="ib-notif-load-more" style="display:none;">Charger plus</button>
    </div>
</div>
<!-- Toast notification -->
<div id="ib-notif-toast" class="ib-notif-toast" style="display:none;"></div> 