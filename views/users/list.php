<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Usuários</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { font-family: 'Segoe UI', sans-serif; margin: 24px; background: #f9f9f9; }
    table { border-collapse: collapse; width: 100%; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    th, td { border-bottom: 1px solid #eee; padding: 10px 12px; text-align: left; }
    th { background: #fafafa; color: #555; font-weight: 600; }
    .actions a, .actions button {
      display: inline-flex; align-items: center; gap: 6px;
      border: none; padding: 6px 10px; border-radius: 6px;
      text-decoration: none; font-size: 14px; cursor: pointer;
      transition: 0.2s ease;
    }
    .btn-edit { background: #2563eb; color: white; }
    .btn-edit:hover { background: #1e40af; }
    .btn-delete { background: #dc2626; color: white; }
    .btn-delete:hover { background: #991b1b; }
  </style>
</head>
<meta charset="UTF-8">
<title>Usuários</title>
<style>
  body{font-family:Arial,Helvetica,sans-serif;margin:24px}
  table{border-collapse:collapse;width:100%}
  th,td{border:1px solid #ccc;padding:8px;text-align:left}
  th{background:#f2f2f2}
  a.button{display:inline-block;padding:8px 12px;border:1px solid #333;text-decoration:none}
</style>
</head>
<body>

<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Captura o parâmetro msg da URL
  const urlParams = new URLSearchParams(window.location.search);
  const msg = urlParams.get('msg');

  if (msg === 'success') {
    Swal.fire({
      icon: 'success',
      title: 'Sucesso!',
      text: 'Usuário gravado com sucesso!',
      confirmButtonColor: '#3085d6'
    });
  }

  if (msg === 'deleted') {
    Swal.fire({
      icon: 'info',
      title: 'Excluído!',
      text: 'Usuário removido com sucesso!',
      confirmButtonColor: '#3085d6'
    });
  }
  (function cleanUrl() {
    const hasQuery = window.location.search.length > 0 || window.location.hash;
    if (!hasQuery) return;

    // Opção A: manter apenas o path (/nutrihelth/public)
    history.replaceState(null, '', window.location.pathname);

    // // Opção B: se quiser manter algum parâmetro, ex.: action=index
    // const url = new URL(window.location);
    // url.searchParams.delete('msg'); // remove só o 'msg'
    // history.replaceState(null, '', url.pathname + (url.search ? url.search : ''));
  })();
</script>

<h2>Lista de Usuários</h2>
<p><a class="button" href="?action=create">Novo Usuário</a></p>
<table>
  <tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Ações</th></tr>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= htmlspecialchars((string)$u->id) ?></td>
      <td><?= htmlspecialchars($u->name) ?></td>
      <td><?= htmlspecialchars($u->email) ?></td>
      <td>
        <?php
          echo $u->typeUser === 'A' ? 'Administrador' :
               ($u->typeUser === 'N' ? 'Nutricionista' : 'Usuário');
        ?>
      </td>
      <td class="actions">
        <a href="?action=edit&id=<?= (int)$u->id ?>" class="btn-edit"><i data-lucide="edit-3"></i> Editar</a>
        <button class="btn-delete" onclick="confirmDelete(<?= (int)$u->id ?>)">
          <i data-lucide="trash-2"></i> Excluir
        </button>
               
      <script>
        function confirmDelete(id) {
          Swal.fire({
            title: 'Tem certeza?',
            text: 'Esta ação não poderá ser desfeita!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `?action=delete&id=${id}`;
            }
          });
        }
      </script>

      </td>
    </tr>
  <?php endforeach; ?>
</table>
<script> lucide.createIcons(); </script>
</body>
</html>
