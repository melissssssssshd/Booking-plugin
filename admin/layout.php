<?php
$company_name = get_option('ib_company_name', 'Institut Booking');
?>
<div id="ib-app" class="ib-app">
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
    padding: 1rem 2rem;
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
}

.ib-menu-toggle {
    display: none;
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: var(--radius);
    transition: all 0.2s ease;
}

.ib-menu-toggle:hover {
    background: var(--bg-light);
    color: var(--text);
}

.ib-page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}

.ib-header-right {
    display: flex;
    align-items: center;
    gap: 1rem;
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
}

body {
    overflow-x: hidden !important;
}

.ib-main-content {
    margin-left: 240px;
    padding: 0;
    background: transparent;
    min-height: 100vh;
    box-sizing: border-box;
    width: auto;
    display: block;
}
</style>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.ib-sidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}

// Fermer la sidebar en cliquant à l'extérieur sur mobile
document.addEventListener('click', function(e) {
    if (window.innerWidth <= 1024) {
        const sidebar = document.querySelector('.ib-sidebar');
        const menuToggle = document.querySelector('.ib-menu-toggle');
        
        if (sidebar && menuToggle && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    }
});
</script> 