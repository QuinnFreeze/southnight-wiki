document.querySelectorAll('#year').forEach(el=>el.textContent=new Date().getFullYear());
const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('visible');observer.unobserve(entry.target)}}),{threshold:.12});
document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));

const pages=[
 {href:'index.html',label:'首页',short:'首页'},
 {href:'about.html',label:'关于我们',short:'关于'},
 {href:'research.html',label:'研究与实践',short:'研究'},
 {href:'leadership.html',label:'组织成员',short:'成员'},
 {href:'principles.html',label:'愿景与原则',short:'理念'}
];
const current=(location.pathname.split('/').pop()||'index.html').toLowerCase();
const index=Math.max(0,pages.findIndex(p=>p.href===current));
const main=document.querySelector('main');
if(main){
 const pager=document.createElement('nav'); pager.className='page-switcher'; pager.setAttribute('aria-label','页面切换');
 const prev=pages[(index-1+pages.length)%pages.length],next=pages[(index+1)%pages.length];
 pager.innerHTML=`<a href="${prev.href}"><small>← 上一页</small><strong>${prev.label}</strong></a><a href="${next.href}"><small>下一页 →</small><strong>${next.label}</strong></a>`;
 main.appendChild(pager);
}
const mobile=document.createElement('nav'); mobile.className='mobile-tabs'; mobile.setAttribute('aria-label','手机端主导航');
mobile.innerHTML=pages.map((p,i)=>`<a href="${p.href}"${i===index?' class="active" aria-current="page"':''}><span>${['⌂','○','◇','◎','✦'][i]}</span>${p.short}</a>`).join('');
document.body.appendChild(mobile);
