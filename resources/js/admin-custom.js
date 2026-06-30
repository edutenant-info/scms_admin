
$(function(){
  $('#login-form').on('submit',function(e){e.preventDefault();var $b=$('#login-btn');$b.find('.btn-text').hide();$b.find('.spinner').css('display','block');$b.css('pointer-events','none');setTimeout(function(){$('#login-page').fadeOut(300,function(){$('#dashboard-page').fadeIn(400);animChart();});},1000);});
  $('#logout-btn').on('click',function(){$('#dashboard-page').fadeOut(300,function(){var $b=$('#login-btn');$b.find('.btn-text').show();$b.find('.spinner').hide();$b.css('pointer-events','auto');$('#login-page').fadeIn(400);});});
  function go(v){$('.vs').removeClass('active');$('#v-'+v).addClass('active');$('.ni').removeClass('active');$('.ni[data-view="'+v+'"]').addClass('active');$('.nch').removeClass('active');}
  $(document).on('click','.ni[data-view]',function(){go($(this).data('view'));});
  $(document).on('click','.nav-to',function(e){e.preventDefault();go($(this).data('view'));});
  $(document).on('click','.inst-cfg',function(){go('inst-detail');});
  $(document).on('click','.ni.hc',function(){var id=$(this).data('toggle');$('#'+id).toggleClass('open');$(this).find('.ntog').toggleClass('open');});
  $('#hamburger').on('click',function(){$('#sidebar').toggleClass('open');});
  $(document).on('click','.tab',function(){var t=$(this).data('tab');$(this).siblings().removeClass('active');$(this).addClass('active');$('.tbc').removeClass('active');$('#'+t).addClass('active');});
  var M={boards:{t:'Boards',d:['CBSE|CBSE','ICSE|ICSE','State Board|SB','IB|IB','IGCSE|IGCSE','Cambridge|CAM']},subjects:{t:'Subjects',d:['Mathematics|MATH','English|ENG','Physics|PHY','Chemistry|CHEM','Biology|BIO','Computer Science|CS','Hindi|HIN','History|HIST','Geography|GEO','Economics|ECO']},streams:{t:'Streams',d:['Science|SCI','Commerce|COM','Arts|ART','Humanities|HUM']},combinations:{t:'Combinations',d:['PCM|PCM','PCB|PCB','PCMB|PCMB','Commerce+Math|CM']},standards:{t:'Standards',d:['1st|S1','2nd|S2','3rd|S3','4th|S4','5th|S5','6th|S6','7th|S7','8th|S8','9th|S9','10th|S10','11th|S11','12th|S12']},semesters:{t:'Semesters',d:['Semester 1|SEM1','Semester 2|SEM2','Semester 3|SEM3','Semester 4|SEM4','Semester 5|SEM5','Semester 6|SEM6','Semester 7|SEM7','Semester 8|SEM8']},sections:{t:'Sections',d:['Section A|A','Section B|B','Section C|C','Section D|D','Section E|E']},'academic-years':{t:'Academic Years',d:['2025-2026|AY2526','2024-2025|AY2425','2023-2024|AY2324','2026-2027|AY2627']},'inst-types':{t:'Institution Types',d:['Primary School|PRI','High School|HS','Junior College|JC','Engineering|ENG','Medical|MED','University|UNI','Coaching|CC','Polytechnic|POL']},'modules-master':{t:'Modules Master',d:['Admissions|ADM','Fee Mgmt|FEE','Attendance|ATT','Exams|EXM','Timetable|TT','Library|LIB','Transport|TRN','Hostel|HST','HR & Payroll|HR','Analytics|ANA']},'fee-types':{t:'Fee Types',d:['Tuition|TUI','Lab|LAB','Library|LIB','Transport|TRN','Hostel|HST','Exam|EXM','Sports|SPT','Activity|ACT']},'master-category':{t:'Master Category',d:['General|GEN','OBC|OBC','SC|SC','ST|ST','EWS|EWS','PH|PH']},'general-category':{t:'General Category',d:['Regular|REG','Management|MGT','NRI|NRI','Sports Quota|SPQ','Staff Quota|STQ']},caste:{t:'Caste',d:['Brahmin|BRA','Kshatriya|KSH','Vaishya|VAI','SC|SC','ST|ST','OBC|OBC','General|GEN']},religion:{t:'Religion',d:['Hindu|HIN','Muslim|MUS','Christian|CHR','Sikh|SIK','Buddhist|BUD','Jain|JAI','Other|OTH']},'blood-group':{t:'Blood Group',d:['A+|AP','A-|AN','B+|BP','B-|BN','O+|OP','O-|ON','AB+|ABP','AB-|ABN']},nationality:{t:'Nationality',d:['Indian|IND','NRI|NRI','Foreign|FOR','PIO|PIO','OCI|OCI']},languages:{t:'Languages',d:['English|EN','Hindi|HI','Kannada|KN','Tamil|TA','Telugu|TE','Malayalam|ML','Marathi|MR','Bengali|BN','Gujarati|GU','Urdu|UR','Sanskrit|SA','French|FR']}};
  function renderM(k){var m=M[k];if(!m)return;$('#mc-bc').text(m.t);$('#mc-title').text(m.t);$('#mc-sub').text('Manage '+m.t.toLowerCase());$('#mc-add-l').text('Add '+m.t.replace(/s$/,''));var h='';$.each(m.d,function(i,x){var p=x.split('|');h+='<tr><td>'+(i+1)+'</td><td style="font-weight:500;color:var(--t1);">'+p[0]+'</td><td><code style="font-size:11px;color:var(--cyn);">'+p[1]+'</code></td><td><span class="bdg bg-act">Active</span></td><td style="color:var(--t3);">Jan 2024</td><td><div class="ta"><button class="bi"><i class="fa-solid fa-pen"></i></button><button class="bi dng"><i class="fa-solid fa-trash-can"></i></button></div></td></tr>';});$('#mc-tbody').html(h);go('master');$('.nch').removeClass('active');$('.nch[data-master="'+k+'"]').addClass('active');}
  $(document).on('click','.nch[data-master]',function(){renderM($(this).data('master'));});
  $('#mc-add').on('click',function(){$('#crud-modal-title').text($('#mc-add-l').text());$('#crud-modal').addClass('open');$('#crud-name,#crud-code,#crud-desc').val('');});
  $('#crud-close').on('click',function(){$('#crud-modal').removeClass('open');});
  $('#crud-save').on('click',function(){$('#crud-modal').removeClass('open');});
  function animChart(){var mo=['Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb'],d1=[45,52,58,64,60,72,78,82,75,88,92,96],d2=[30,38,42,48,45,55,60,64,58,68,72,78],$c=$('#echart');$c.empty();$.each(mo,function(i,m){$c.append('<div class="cbg"><div class="cbs"><div class="cbar sec" style="height:0" data-h="'+(d2[i]/100*160)+'"></div><div class="cbar pri" style="height:0" data-h="'+(d1[i]/100*160)+'"></div></div><div class="clb">'+m+'</div></div>');});setTimeout(function(){$('.cbar').each(function(i){var $b=$(this);setTimeout(function(){$b.css('height',$b.data('h')+'px');},i*35);});},200);}
  var step=1,total=4;
  function upStep(){for(var i=1;i<=total;i++){var $s=$('#s'+i);$s.removeClass('done cur');if(i<step)$s.addClass('done');else if(i===step)$s.addClass('cur');}$('.os').removeClass('active');$('#os'+step).addClass('active');$('#ob-prev').toggle(step>1);$('#ob-next').html(step===total?'<i class="fa-solid fa-check"></i> Complete':'Continue <i class="fa-solid fa-arrow-right"></i>');}
  $(document).on('click','.open-ob',function(){
    if ($(this).is('a[href]')) return;
    step=1;upStep();$('#ob-modal').addClass('open');
  });
  $('#ob-close').on('click',function(){$('#ob-modal').removeClass('open');});
  $('#ob-modal').on('click',function(e){if($(e.target).is('#ob-modal'))$('#ob-modal').removeClass('open');});
  $('#ob-next').on('click',function(){if(step<total){step++;upStep();}else{$('#ob-modal').removeClass('open');}});
  $('#ob-prev').on('click',function(){if(step>1){step--;upStep();}});
  $('#add-inst').on('click',function(){$('#inst-rows').append('<div class="ir"><div class="fg"><label>Name</label><input type="text" class="fi noi" placeholder="Institution name"></div><div class="fg"><label>Type</label><select class="fs"><option>Primary</option><option>High School</option><option>Jr. College</option><option>Engg</option><option>University</option></select></div><button class="irm"><i class="fa-solid fa-trash-can"></i></button></div>');});
  $(document).on('click','.irm',function(){if($('#inst-rows .ir').length>1)$(this).closest('.ir').fadeOut(200,function(){$(this).remove();});});
  $(document).on('change','.mcd .sw input',function(){var $c=$(this).closest('.mcd');$c.toggleClass('en',this.checked).toggleClass('dis',!this.checked);});
  $('#notif-trigger').on('click',function(){$('#np').addClass('open');$('#novo').addClass('open');});
  $('#np-close,#novo').on('click',function(){$('#np').removeClass('open');$('#novo').removeClass('open');});
  // Topbar notification dropdown (#notif-trigger / #notif-menu)
  $('#notif-trigger').on('click',function(e){e.stopPropagation();$('#notif-menu').toggleClass('open');});
  $('#notif-menu').on('click',function(e){e.stopPropagation();});
  $(document).on('click',function(){$('#notif-menu').removeClass('open');});
  $('#notif-mark-all').on('click',function(e){e.stopPropagation();$('#notif-menu .nit').removeClass('ur');$('#notif-trigger .nd').hide();});
  $('#open-nc').on('click',function(){$('#notif-compose-modal').addClass('open');});
  $(document).on('click','.rt',function(){$(this).closest('.mptag').fadeOut(150,function(){$(this).remove();});});
  $('#mc-search').on('input',function(){var q=$(this).val().toLowerCase();$('#mc-tbody tr').each(function(){$(this).toggle($(this).text().toLowerCase().indexOf(q)>-1);});});

  /* ============================================================
     GLOBAL SEARCH (⌘K / topbar) — modules, students, menus, etc.
     ============================================================ */
  // Per-type presentation (icon + theme colour token).
  var SM_TYPES = {
    module:       { label: 'Module',       icon: 'fa-puzzle-piece',    c: 'vio' },
    menu:         { label: 'Menu',         icon: 'fa-compass',         c: 'cyn' },
    student:      { label: 'Student',      icon: 'fa-user-graduate',   c: 'grn' },
    staff:        { label: 'Staff',        icon: 'fa-user-tie',        c: 'amb' },
    organisation: { label: 'Organisation', icon: 'fa-school',          c: 'acc' },
    institution:  { label: 'Institution',  icon: 'fa-building-columns', c: 'cyn' }
  };

  // Searchable dataset. `nav` is invoked on open: {view} → sidebar view,
  // {master} → master-data table, else the modal just closes.
  var SM_DATA = [
    // Modules (also surfaced as the default "list of modules").
    { t:'module', name:'Admissions',     sub:'Enquiries, applications & enrolment', nav:{master:'modules-master'} },
    { t:'module', name:'Fee Management',  sub:'Fee structures, invoices & payments', nav:{master:'modules-master'} },
    { t:'module', name:'Attendance',      sub:'Daily & period-wise attendance',      nav:{master:'modules-master'} },
    { t:'module', name:'Examinations',    sub:'Exams, grading & report cards',       nav:{master:'modules-master'} },
    { t:'module', name:'Timetable',       sub:'Class & teacher scheduling',          nav:{master:'modules-master'} },
    { t:'module', name:'Library',         sub:'Catalogue, issue & returns',          nav:{master:'modules-master'} },
    { t:'module', name:'Transport',       sub:'Routes, vehicles & tracking',         nav:{master:'modules-master'} },
    { t:'module', name:'Hostel',          sub:'Rooms, allocation & wardens',         nav:{master:'modules-master'} },
    { t:'module', name:'HR & Payroll',    sub:'Staff records & salary',              nav:{master:'modules-master'} },
    { t:'module', name:'Analytics',       sub:'Dashboards & insights',               nav:{master:'modules-master'} },

    // Menus (navigation targets).
    { t:'menu', name:'Dashboard',         sub:'Overview', nav:{view:'dashboard'} },
    { t:'menu', name:'Boards',            sub:'Master data', nav:{master:'boards'} },
    { t:'menu', name:'Subjects',          sub:'Master data', nav:{master:'subjects'} },
    { t:'menu', name:'Streams',           sub:'Master data', nav:{master:'streams'} },
    { t:'menu', name:'Standards',         sub:'Master data', nav:{master:'standards'} },
    { t:'menu', name:'Sections',          sub:'Master data', nav:{master:'sections'} },
    { t:'menu', name:'Academic Years',    sub:'Master data', nav:{master:'academic-years'} },
    { t:'menu', name:'Institution Types', sub:'Master data', nav:{master:'inst-types'} },
    { t:'menu', name:'Modules Master',    sub:'Master data', nav:{master:'modules-master'} },
    { t:'menu', name:'Fee Types',         sub:'Master data', nav:{master:'fee-types'} },

    // Students (sample directory).
    { t:'student', name:'Aarav Sharma',   sub:'Class 10-A · Sunrise Academy' },
    { t:'student', name:'Diya Patel',     sub:'Class 8-B · St. Xavier’s' },
    { t:'student', name:'Vivaan Reddy',   sub:'Class 12-C · DPS Bangalore' },
    { t:'student', name:'Ananya Iyer',    sub:'Class 9-A · Vidya Bharathi' },
    { t:'student', name:'Kabir Nair',     sub:'Class 11-B · Sunrise Academy' },

    // Staff.
    { t:'staff', name:'Meera Krishnan',   sub:'Principal · St. Xavier’s' },
    { t:'staff', name:'Rohan Gupta',      sub:'Mathematics · DPS Bangalore' },
    { t:'staff', name:'Sunita Rao',       sub:'Accounts · Sunrise Academy' },

    // Organisations.
    { t:'organisation', name:'Sunrise Academy Group', sub:'4 institutions · Active' },
    { t:'organisation', name:'St. Xavier’s Trust', sub:'2 institutions · Active' },
    { t:'organisation', name:'DPS Education Society',  sub:'7 institutions · Active' },

    // Institutions.
    { t:'institution', name:'Sunrise Academy — Main Campus', sub:'CBSE · Bangalore' },
    { t:'institution', name:'St. Xavier’s High School',  sub:'ICSE · Mumbai' },
    { t:'institution', name:'DPS Junior College',            sub:'State Board · Hyderabad' }
  ];

  var $modal = $('#search-modal'), $input = $('#sm-input'), $body = $('#sm-body');
  var smCat = 'all', smActive = -1;

  function smIcon(t){ return (SM_TYPES[t] || {}).icon || 'fa-circle'; }
  function smColor(t){ return (SM_TYPES[t] || {}).c || 'acc'; }
  function smLabel(t){ return (SM_TYPES[t] || {}).label || t; }

  // Result row markup (used for filtered queries).
  function smRow(item, i){
    var c = smColor(item.t);
    return '<div class="sm-ri" data-i="'+i+'">'+
      '<div class="sm-ri-ic" style="background:var(--'+c+'s);color:var(--'+c+');"><i class="fa-solid '+smIcon(item.t)+'"></i></div>'+
      '<div class="sm-ri-info"><div class="sm-ri-name">'+item.name+'</div><div class="sm-ri-sub">'+(item.sub||'')+'</div></div>'+
      '<span class="sm-ri-type" style="background:var(--'+c+'s);color:var(--'+c+');">'+smLabel(item.t)+'</span>'+
    '</div>';
  }

  // Quick-link tile markup (used for the default modules grid).
  function smTile(item, i){
    var c = smColor(item.t);
    return '<a class="sm-ql-item sm-ri" data-i="'+i+'">'+
      '<div class="sm-ql-ic" style="background:var(--'+c+'s);color:var(--'+c+');"><i class="fa-solid '+smIcon(item.t)+'"></i></div>'+
      '<div><div class="sm-ql-name">'+item.name+'</div><div class="sm-ql-desc">'+(item.sub||'')+'</div></div>'+
    '</a>';
  }

  // Build the visible result set + render the body. Stores the active list
  // on $body via .data('list') so keyboard nav and Enter can resolve rows.
  function smRender(){
    var q = $.trim($input.val()).toLowerCase();
    smActive = -1;
    var pool = SM_DATA.filter(function(d){ return smCat === 'all' || d.t === smCat; });

    // Empty query: show the modules list (as requested), then quick menus.
    if (!q){
      var modules = pool.filter(function(d){ return d.t === 'module'; });
      var html = '';
      if (modules.length){
        html += '<div class="sm-sec-label">Modules</div>';
        html += '<div class="sm-ql-grid">';
        $.each(modules, function(_, m){ html += smTile(m, SM_DATA.indexOf(m)); });
        html += '</div>';
      }
      // When a non-module category is selected, list its entries instead.
      var rest = pool.filter(function(d){ return d.t !== 'module'; });
      if (smCat !== 'all' && smCat !== 'module'){
        html = '<div class="sm-sec-label">'+smLabel(smCat)+'s</div>';
        $.each(rest, function(_, m){ html += smRow(m, SM_DATA.indexOf(m)); });
      } else if (rest.length){
        html += '<div class="sm-sec-label">Quick navigation</div>';
        $.each(rest.filter(function(d){ return d.t === 'menu'; }), function(_, m){ html += smRow(m, SM_DATA.indexOf(m)); });
      }
      $body.html(html || smEmpty(q));
      $body.data('list', pool);
      return;
    }

    var matches = pool.filter(function(d){
      return (d.name + ' ' + (d.sub||'')).toLowerCase().indexOf(q) > -1;
    });
    if (!matches.length){ $body.html(smEmpty(q)); $body.data('list', []); return; }

    var out = '';
    $.each(matches, function(idx, m){ out += smRow(m, idx); });
    $body.html(out);
    $body.data('list', matches);
  }

  function smEmpty(q){
    return '<div class="sm-empty"><i class="fa-solid fa-magnifying-glass"></i>No results for “'+
      (q||'') + '”</div>';
  }

  function smOpen(){
    $modal.addClass('open');
    smCat = 'all'; smActive = -1;
    $('.sm-cat').removeClass('active');
    $('.sm-cat[data-cat="all"]').addClass('active');
    $input.val('');
    smRender();
    setTimeout(function(){ $input.trigger('focus'); }, 30);
  }
  function smClose(){ $modal.removeClass('open'); }

  function smGo(item){
    smClose();
    if (!item || !item.nav) return;
    if (item.nav.master && typeof renderM === 'function'){ renderM(item.nav.master); }
    else if (item.nav.view && typeof go === 'function'){ go(item.nav.view); }
  }

  // Keyboard highlight management.
  function smRows(){ return $body.find('.sm-ri'); }
  function smHighlight(n){
    var $rows = smRows();
    if (!$rows.length) return;
    smActive = (n + $rows.length) % $rows.length;
    $rows.removeClass('active');
    var $r = $rows.eq(smActive).addClass('active');
    var el = $r[0]; if (el && el.scrollIntoView) el.scrollIntoView({ block:'nearest' });
  }

  // Open triggers: topbar box click / focus and ⌘K / Ctrl+K.
  $('#search-trigger').on('click', smOpen);
  $('#search-trigger').on('keydown', function(e){ if (e.key === 'Enter' || e.key === ' '){ e.preventDefault(); smOpen(); } });
  $(document).on('keydown', function(e){
    if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K')){ e.preventDefault(); $modal.hasClass('open') ? smClose() : smOpen(); }
    if (e.key === 'Escape' && $modal.hasClass('open')){ smClose(); }
  });

  // Close on overlay click.
  $modal.on('click', function(e){ if (e.target === this) smClose(); });

  // Live search + category filter.
  $input.on('input', smRender);
  $(document).on('click', '.sm-cat', function(){
    $('.sm-cat').removeClass('active');
    $(this).addClass('active');
    smCat = $(this).data('cat');
    smRender();
  });

  // Open a result (mouse).
  $body.on('click', '.sm-ri', function(){
    var list = $body.data('list') || [];
    var i = parseInt($(this).attr('data-i'), 10);
    // Default view rows carry the SM_DATA index; filtered rows carry list index.
    var item = ($input.val().trim()) ? list[i] : SM_DATA[i];
    smGo(item);
  });

  // Keyboard navigation within the modal.
  $input.on('keydown', function(e){
    if (e.key === 'ArrowDown'){ e.preventDefault(); smHighlight(smActive + 1); }
    else if (e.key === 'ArrowUp'){ e.preventDefault(); smHighlight(smActive - 1); }
    else if (e.key === 'Enter'){
      e.preventDefault();
      var $rows = smRows();
      if (!$rows.length) return;
      $rows.eq(smActive < 0 ? 0 : smActive).trigger('click');
    }
  });

  /* ============================================================
     FILE UPLOAD DROPZONE (.fup — <x-form.file-upload>)
     Drag & drop, click-to-browse, selected-file list with
     per-file removal. Delegated, so it works on injected markup.
     ============================================================ */
  function fupFmtSize(b){
    if (b < 1024) return b + ' B';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
    return (b / 1048576).toFixed(1) + ' MB';
  }

  function fupRender($fup){
    var input = $fup.find('input[type="file"]')[0];
    var $list = $fup.find('[data-fup-files]');
    if (!input || !$list.length) return;
    $list.empty();
    Array.prototype.forEach.call(input.files, function(f){
      $list.append(
        '<li class="fup-file">' +
          '<i class="fa-solid fa-file-lines"></i>' +
          '<span class="fup-file-name">' + $('<div>').text(f.name).html() + '</span>' +
          '<span class="fup-file-size">' + fupFmtSize(f.size) + '</span>' +
          '<button type="button" class="fup-file-remove" title="Remove"><i class="fa-solid fa-xmark"></i></button>' +
        '</li>'
      );
    });
  }

  $(document).on('dragover', '.fup', function(e){ e.preventDefault(); $(this).addClass('dragover'); });
  $(document).on('dragleave', '.fup', function(e){ e.preventDefault(); $(this).removeClass('dragover'); });
  $(document).on('drop', '.fup', function(e){
    e.preventDefault();
    $(this).removeClass('dragover');
    var input = $(this).find('input[type="file"]')[0];
    var dropped = e.originalEvent && e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files;
    if (!input || !dropped || !dropped.length) return;
    // Respect single-file inputs: only keep the first dropped file.
    if (!input.multiple && dropped.length > 1){
      var dt = new DataTransfer();
      dt.items.add(dropped[0]);
      input.files = dt.files;
    } else {
      input.files = dropped;
    }
    $(input).trigger('change');
  });

  $(document).on('change', '.fup input[type="file"]', function(){
    fupRender($(this).closest('.fup'));
  });

  $(document).on('click', '.fup-file-remove', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $fup = $(this).closest('.fup');
    var input = $fup.find('input[type="file"]')[0];
    if (!input) return;
    var idx = $(this).closest('.fup-file').index();
    var dt = new DataTransfer();
    Array.prototype.forEach.call(input.files, function(f, i){ if (i !== idx) dt.items.add(f); });
    input.files = dt.files;
    fupRender($fup);
  });
});
