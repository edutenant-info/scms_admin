
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
});
