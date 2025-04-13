document.addEventListener('DOMContentLoaded', () => {
    const menu       = document.getElementById('left-menu');
    const closeBtn   = document.getElementById('admin-menu-icon');      // nút close trong menu (mobile)
    const mobileBtn  = document.getElementById('mobile-menu-toggle');   // nút hamburger (mobile)
  
    if (!menu) return;
  
    // === Resize handler: ép trạng thái theo width ===
    function adjustByWidth() {
        const w = window.innerWidth;
        if (w > 1050) {
            // Desktop lớn: luôn mở rộng
            menu.classList.remove('collapsed', 'open');
            closeBtn?.removeAttribute('style');
            mobileBtn?.removeAttribute('style');
        } else if (w > 600) {
            // Tablet: luôn collapsed, không off-canvas
            menu.classList.add('collapsed');
            menu.classList.remove('open');
            closeBtn?.removeAttribute('style');
            mobileBtn?.removeAttribute('style');
        } else {
            // Mobile: off-canvas, ẩn collapsed
            menu.classList.remove('collapsed');
            menu.classList.remove('open');
            closeBtn?.removeAttribute('style');
            mobileBtn?.removeAttribute('style');
        }
    }
  
    window.addEventListener('resize', adjustByWidth);
    adjustByWidth();
  
    // === Mobile: open/close off‑canvas ===
    mobileBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = menu.classList.toggle('open');
        // icon hamburger ↔ close không cần đổi vì chúng là 2 nút khác nhau
    });
  
    // === Mobile: click ngoài để đóng ===
    document.addEventListener('click', (e) => {
        if (
            window.innerWidth <= 600 &&
            menu.classList.contains('open') &&
            !menu.contains(e.target) &&
            e.target !== mobileBtn
        ) {
            menu.classList.remove('open');
        }
    });
  
    // === Mobile: nút close bên trong menu ===
    closeBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.remove('open');
    });
});
  