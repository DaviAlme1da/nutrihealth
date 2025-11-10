<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>nutrihealth</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root {
      color-scheme: dark light;
      --bg:#0f172a; --fg:#e5e7eb; --muted:#9ca3af;
      --surface:#0b1020; --surface-elev:#111827; --on-surface:var(--fg);
      --primary:#22c55e; --on-primary:#052e16;
      --danger:#dc2626; --on-danger:#ffffff;
      --hover:#1f2937; --border:#1f2937;
      --sidebar-w:260px; --sidebar-w-collapsed:76px; --topbar-h:56px;
    }
    @media (prefers-color-scheme: light) {
      :root:not(.theme-dark):not(.theme-light) {
        --bg:#f9fafb; --fg:#111827; --muted:#6b7280;
        --surface:#ffffff; --surface-elev:#ffffff; --on-surface:#111827;
        --primary:#16a34a; --on-primary:#052e16;
        --danger:#dc2626; --on-danger:#ffffff;
        --hover:#e5e7eb; --border:#d1d5db;
      }
    }
    .theme-light {
      --bg:#f9fafb; --fg:#111827; --muted:#6b7280;
      --surface:#ffffff; --surface-elev:#ffffff; --on-surface:#111827;
      --primary:#16a34a; --on-primary:#052e16;
      --danger:#dc2626; --on-danger:#ffffff;
      --hover:#e5e7eb; --border:#d1d5db;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;height:100%;background:linear-gradient(180deg,var(--surface) 0%, var(--bg) 100%);color:var(--fg);font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif}
    a{color:inherit;text-decoration:none}
    i[data-lucide]{width:18px;height:18px;display:inline-block;vertical-align:middle}
    .layout{display:flex;min-height:100dvh}
    aside.sidebar{position:fixed;inset:0 auto 0 0;width:var(--sidebar-w);background:var(--surface-elev);border-right:1px solid var(--border);padding:14px 12px;display:flex;flex-direction:column;gap:8px;transform:translateX(-100%);transition:transform .25s ease,width .25s ease;z-index:60;}
    .sidebar.open{ transform:translateX(0) }
    .sidebar .brand{display:flex;align-items:center;gap:10px;margin-bottom:6px;font-weight:700}
    .sidebar .badge{font-size:12px;background:rgba(34,197,94,.12);color:#065f46;padding:2px 8px;border-radius:999px;border:1px solid rgba(34,197,94,.25)}
    .nav-group{margin-top:8px;display:flex;flex-direction:column;gap:6px}
    .nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;background:transparent;border:1px solid transparent;color:var(--on-surface);}
    .nav-item:hover{background:var(--hover);border-color:var(--border)}
    .nav-item.active{background:rgba(34,197,94,.12);border-color:rgba(34,197,94,.25);color:#065f46}
    .nav-item .label{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    header.topbar{position:fixed;top:0;left:0;right:0;height:var(--topbar-h);display:flex;align-items:center;gap:10px;background:var(--surface-elev);border-bottom:1px solid var(--border);padding:0 12px;z-index:50;}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;height:36px;padding:0 12px;border-radius:10px;border:1px solid var(--border);background:var(--surface-elev);color:var(--on-surface);cursor:pointer}
    .btn:hover{background:var(--hover)}
    .btn-primary{background:var(--primary);border-color:transparent;color:var(--on-primary);font-weight:600}
    .btn-primary:hover{filter:brightness(0.95)}
    .btn-danger{background:var(--danger);border-color:transparent;color:var(--on-danger);font-weight:600}
    .btn-danger:hover{filter:brightness(0.95)}
    main.content{flex:1;width:100%;padding:calc(var(--topbar-h) + 16px) 16px 24px}
    .page-head{margin:6px 0 12px;display:flex;align-items:center;gap:12px}
    .page-title{font-size:22px;font-weight:700}
    .page-sub{font-size:14px;color:var(--muted)}
    .overlay{position:fixed;inset:0;background:rgba(0,0,0,.35);opacity:0;pointer-events:none;transition:opacity .2s ease;z-index:55;}
    .overlay.show{opacity:1;pointer-events:auto}
    @media (min-width: 1024px){
      aside.sidebar{transform:none;}
      .overlay{display:none}
      .layout{padding-left:var(--sidebar-w)}
      body.sidebar-collapsed .layout{padding-left:var(--sidebar-w-collapsed)}
      body.sidebar-collapsed aside.sidebar{width:var(--sidebar-w-collapsed)}
      body.sidebar-collapsed .nav-item .label{display:none}
    }

    /* === MODAL DE PERMISSÕES === */
    .modal-permissions {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.7);
      z-index: 100;
      align-items: center;
      justify-content: center;
      padding: 20px;
      overflow-y: auto;
    }
    .modal-permissions.show {
      display: flex;
    }
    .modal-content-perm {
      background: var(--surface);
      border-radius: 15px;
      width: 100%;
      max-width: 1200px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    .modal-header-perm {
      background: var(--primary);
      color: var(--on-primary);
      padding: 20px 30px;
      border-radius: 15px 15px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .modal-header-perm h2 {
      margin: 0;
      font-size: 1.5em;
    }
    .btn-close-modal {
      background: transparent;
      border: none;
      color: var(--on-primary);
      cursor: pointer;
      padding: 8px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-close-modal:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    .modal-body-perm {
      padding: 30px;
    }
    .profile-selector-modal {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 30px;
    }
    .profile-btn-modal {
      padding: 15px;
      border: 2px solid var(--border);
      border-radius: 10px;
      background: var(--surface-elev);
      cursor: pointer;
      transition: all 0.3s ease;
      text-align: center;
    }
    .profile-btn-modal:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .profile-btn-modal.active {
      border-color: var(--primary);
      background: rgba(34, 197, 94, 0.1);
    }
    .profile-btn-modal h3 {
      margin: 0 0 5px 0;
      font-size: 1.1em;
    }
    .profile-btn-modal .count {
      font-size: 0.85em;
      color: var(--muted);
    }
    .permissions-table-modal {
      background: var(--surface-elev);
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid var(--border);
    }
    .permissions-table-modal table {
      width: 100%;
      border-collapse: collapse;
    }
    .permissions-table-modal thead {
      background: var(--hover);
    }
    .permissions-table-modal th {
      padding: 12px;
      text-align: left;
      font-weight: 600;
      border-bottom: 2px solid var(--border);
    }
    .permissions-table-modal th:first-child {
      padding-left: 20px;
    }
    .permissions-table-modal th.action-col {
      text-align: center;
      width: 100px;
    }
    .permissions-table-modal tbody tr:hover {
      background: var(--hover);
    }
    .permissions-table-modal td {
      padding: 12px;
      border-bottom: 1px solid var(--border);
    }
    .permissions-table-modal td:first-child {
      padding-left: 20px;
      font-weight: 500;
    }
    .permissions-table-modal td.action-cell {
      text-align: center;
    }
    .permission-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      font-weight: bold;
      font-size: 16px;
    }
    .permission-icon.granted {
      background: var(--primary);
      color: var(--on-primary);
    }
    .permission-icon.denied {
      background: var(--border);
      color: var(--muted);
    }
    .legend-modal {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
    }
    .legend-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9em;
    }
    .legend-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.85em;
    }
    .legend-badge.create { background: #22c55e; color: white; }
    .legend-badge.read { background: #3b82f6; color: white; }
    .legend-badge.update { background: #f59e0b; color: white; }
    .legend-badge.delete { background: #ef4444; color: white; }
  </style>
</head>
<body>
  <div class="layout">
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <i data-lucide="leaf"></i>
        <span class="label">nutrihealth</span>
        <span class="badge label">v1</span>
      </div>
      <nav class="nav-group">
        <a class="nav-item <?= ($_GET['action']??'index')==='index'?'active':'' ?>" href="/nutrihealth/public/?action=index"><i data-lucide="users"></i><span class="label">Usuários</span></a>        
        <a class="nav-item" href="#" onclick="Swal.fire('Em breve','Módulo de relatórios','info')"><i data-lucide="bar-chart-2"></i><span class="label">Relatórios</span></a>
      </nav>
    </aside>
    <div class="overlay" id="overlay"></div>
    <header class="topbar">
      <button class="btn" id="btnSidebar" aria-label="Alternar menu"><i data-lucide="menu"></i><span class="label">Menu</span></button>
      <div style="flex:1"></div>
      <button class="btn" id="btnPermissions" title="Permissões"><i data-lucide="shield"></i><span class="label">Permissões</span></button>
      <button class="btn" id="btnTheme" title="Tema"><i data-lucide="sun"></i></button>
      <a class="btn btn-primary" href="/nutrihealth/public/?action=create"><i data-lucide="plus"></i> Novo</a>
    </header>
    <main class="content">
      <div class="page-head"><i data-lucide="layout-grid"></i><div><div class="page-title">Usuários</div><div class="page-sub">Gestão de usuários do sistema</div></div></div>

      

    