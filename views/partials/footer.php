</main>
  </div>
    

  
  <div class="modal-permissions" id="modalPermissions">
    <div class="modal-content-perm">
      <div class="modal-header-perm">
        <h2>🔐 Sistema de Permissões</h2>
        <button class="btn-close-modal" id="btnCloseModal">
          <i data-lucide="x" style="width: 24px; height: 24px;"></i>
        </button>
      </div>
      <div class="modal-body-perm">
        <div class="profile-selector-modal">
          <div class="profile-btn-modal active" data-profile="admin">
            <h3>🔑 Administrador</h3>
            <div class="count">Acesso Total</div>
          </div>
          <div class="profile-btn-modal" data-profile="nutricionista">
            <h3>👨‍⚕️ Nutricionista</h3>
            <div class="count">Acesso Clínico</div>
          </div>
          <div class="profile-btn-modal" data-profile="usuario">
            <h3>👤 Usuário Geral</h3>
            <div class="count">Acesso Básico</div>
          </div>
        </div>

        <div class="permissions-table-modal">
          <table>
            <thead>
              <tr>
                <th>Módulo</th>
                <th class="action-col">Create</th>
                <th class="action-col">Read</th>
                <th class="action-col">Update</th>
                <th class="action-col">Delete</th>
              </tr>
            </thead>
            <tbody id="permissionsBody">
            </tbody>
          </table>
        </div>

        <div class="legend-modal">
          <div class="legend-item">
            <span class="legend-badge create">C</span>
            <span>Create (Criar)</span>
          </div>
          <div class="legend-item">
            <span class="legend-badge read">R</span>
            <span>Read (Ler)</span>
          </div>
          <div class="legend-item">
            <span class="legend-badge update">U</span>
            <span>Update (Atualizar)</span>
          </div>
          <div class="legend-item">
            <span class="legend-badge delete">D</span>
            <span>Delete (Excluir)</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    

    // === CÓDIGO DO MODAL DE PERMISSÕES ===
    var permissions = {
      admin: {
        'Cadastro de Pacientes': [true, true, true, true],
        'Anamnese Paciente': [true, true, true, true],
        'Prontuário Eletrônico': [true, true, true, true],
        'Agenda de Consultas': [true, true, true, true],
        'Planos Alimentares Personalizados': [true, true, true, true],
        'Relatórios': [true, true, true, true]
      },
      nutricionista: {
        'Cadastro de Pacientes': [false, true, false, false],
        'Anamnese Paciente': [true, true, true, true],
        'Prontuário Eletrônico': [true, true, true, true],
        'Agenda de Consultas': [false, true, false, false],
        'Planos Alimentares Personalizados': [true, true, true, true],
        'Relatórios': [true, true, true, true]
      },
      usuario: {
        'Cadastro de Pacientes': [true, true, true, true],
        'Anamnese Paciente': [false, false, false, false],
        'Prontuário Eletrônico': [true, true, true, true],
        'Agenda de Consultas': [true, true, true, true],
        'Planos Alimentares Personalizados': [false, false, false, false],
        'Relatórios': [false, false, true, false]
      }
    };

    function renderPermissions(profile) {
      var tbody = document.getElementById('permissionsBody');
      tbody.innerHTML = '';
      var profilePerms = permissions[profile];
      var checkIcon = '✓';
      var crossIcon = '✕';
      for (var module in profilePerms) {
        if (profilePerms.hasOwnProperty(module)) {
          var perms = profilePerms[module];
          var row = document.createElement('tr');
          var html = '<td>' + module + '</td>';
          for (var i = 0; i < 4; i++) {
            var hasPermission = perms[i];
            var iconClass = hasPermission ? 'granted' : 'denied';
            var icon = hasPermission ? checkIcon : crossIcon;
            html += '<td class="action-cell"><div class="permission-icon ' + iconClass + '">' + icon + '</div></td>';
          }
          row.innerHTML = html;
          tbody.appendChild(row);
        }
      }
    }

    var modal = document.getElementById('modalPermissions');
    var btnOpenModal = document.getElementById('btnPermissions');
    var btnCloseModal = document.getElementById('btnCloseModal');
    
    btnOpenModal.addEventListener('click', function() {
      modal.classList.add('show');
      renderPermissions('admin');
      setTimeout(function() { lucide.createIcons(); }, 50);
    });
    
    btnCloseModal.addEventListener('click', function() {
      modal.classList.remove('show');
    });
    
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.classList.remove('show');
      }
    });

    var profileBtns = document.querySelectorAll('.profile-btn-modal');
    profileBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        profileBtns.forEach(function(b) {
          b.classList.remove('active');
        });
        this.classList.add('active');
        var profile = this.getAttribute('data-profile');
        renderPermissions(profile);
      });
    });

    lucide.createIcons();
    const sidebar=document.getElementById('sidebar'),overlay=document.getElementById('overlay'),btnSidebar=document.getElementById('btnSidebar');
    const btnTheme=document.getElementById('btnTheme');
    function isDesktop(){return window.matchMedia('(min-width:1024px)').matches;}
    function openMobile(){sidebar.classList.add('open');overlay.classList.add('show');document.body.classList.add('sidebar-open');}
    function closeMobile(){sidebar.classList.remove('open');overlay.classList.remove('show');document.body.classList.remove('sidebar-open');}
    btnSidebar.addEventListener('click',()=>{if(isDesktop()){document.body.classList.toggle('sidebar-collapsed');}else{if(sidebar.classList.contains('open'))closeMobile();else openMobile();}});
    overlay.addEventListener('click',closeMobile);
    sidebar.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{if(!isDesktop())closeMobile();}));
    // Theme toggle
    const THEME_KEY='nh_theme'; const mm=window.matchMedia('(prefers-color-scheme: dark)');
    function applyTheme(pref){
      document.documentElement.classList.remove('theme-dark','theme-light');
      if(pref==='dark'){document.documentElement.classList.add('theme-dark');btnTheme.innerHTML='<i data-lucide="moon"></i>';}
      else if(pref==='light'){document.documentElement.classList.add('theme-light');btnTheme.innerHTML='<i data-lucide="sun"></i>';}
      else {btnTheme.innerHTML=mm.matches?'<i data-lucide="moon-star"></i>':'<i data-lucide="sun-medium"></i>';}
      lucide.createIcons();
    }
    function cycleTheme(){const cur=localStorage.getItem(THEME_KEY)||'system';const next=cur==='system'?'dark':(cur==='dark'?'light':'system');localStorage.setItem(THEME_KEY,next);applyTheme(next);}
    btnTheme.addEventListener('click',cycleTheme);
    mm.addEventListener('change',()=>{if((localStorage.getItem(THEME_KEY)||'system')==='system')applyTheme('system');});
    (function init(){applyTheme(localStorage.getItem(THEME_KEY)||'system');})();
    // SweetAlert via ?msg= e limpar URL
    (function alertsFromQuery(){const usp=new URLSearchParams(location.search);const msg=usp.get('msg');if(msg==='success'){Swal.fire({icon:'success',title:'Sucesso!',text:'Registro salvo com sucesso.'});}else if(msg==='deleted'){Swal.fire({icon:'info',title:'Excluído!',text:'Registro removido com sucesso.'});}if(msg)history.replaceState(null,'',location.pathname);})();
  </script>
</body>
</html>