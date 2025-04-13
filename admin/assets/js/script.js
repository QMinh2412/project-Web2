document.addEventListener('DOMContentLoaded', () => {
    const menu      = document.getElementById('left-menu');
    const toggleBtn = document.getElementById('admin-menu-icon');
    const mobileBtn = document.getElementById('mobile-menu-toggle');
    const mobileBtnIcon = document.getElementById('mobile-menu-toggle-i');
    const KEY       = 'sidebarState';
  
    if (!menu) return;
  
    // 1) Load trạng thái từ localStorage
    if (localStorage.getItem(KEY) === '1') {
      menu.classList.add('collapsed');
    }
  
    // 2) Toggle bằng nút trên desktop
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        const isCollapsed = menu.classList.toggle('collapsed');
        localStorage.setItem(KEY, isCollapsed ? '1' : '0');
      });
    }
  
    // 3) Toggle bằng nút hamburger trên mobile
    if (mobileBtn) {
        mobileBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // tránh click bubble
            const isOpen = menu.classList.toggle('open');
            mobileBtn.classList.toggle('active', isOpen);
        });
    
        // Click ngoài menu để đóng lại (mobile only)
        document.addEventListener('click', (e) => {
            if (
                window.innerWidth <= 600 &&
                menu.classList.contains('open') &&
                !menu.contains(e.target) &&
                !mobileBtn.contains(e.target)
            ) {
                menu.classList.remove('open');
                mobileBtn.classList.remove('active');
            }
        });
    }

    const onResize = () => {
        if (window.innerWidth <= 600) {
            menu.classList.remove('collapsed');
        }
        if (window.innerWidth > 600 && window.innerWidth <= 950) {
            const isCollapsed = menu.classList.toggle('collapsed');
            localStorage.setItem(KEY, isCollapsed, 0);
            menu.classList.add('collapsed');
            toggleBtn.style.display = 'none';
        }
        else {
            // restore desktop collapsed từ localStorage
            if (localStorage.getItem(KEY) === '1') {
                menu.classList.add('collapsed');
            }
        }
    };
      
    window.addEventListener('resize', onResize);
    onResize();
});