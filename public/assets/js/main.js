document.addEventListener('DOMContentLoaded', function() {
    // 1. Password visibility toggle
    const toggleButtons = document.querySelectorAll('.password-toggle-btn');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            if (targetInput) {
                if (targetInput.type === 'password') {
                    targetInput.type = 'text';
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg> Hide
                    `;
                } else {
                    targetInput.type = 'password';
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Show
                    `;
                }
            }
        });
    });

    // 2. Age Auto-calculation
    const birthdateInput = document.getElementById('birthdate');
    const ageInput = document.getElementById('age');
    
    if (birthdateInput && ageInput) {
        // Trigger calculation on input change
        birthdateInput.addEventListener('change', function() {
            const birthdateVal = this.value;
            if (birthdateVal) {
                const birthdate = new Date(birthdateVal);
                const today = new Date();
                
                let age = today.getFullYear() - birthdate.getFullYear();
                const m = today.getMonth() - birthdate.getMonth();
                
                // Adjust if birth month/day hasn't occurred yet this year
                if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
                    age--;
                }
                
                ageInput.value = age >= 0 ? age : 0;
            } else {
                ageInput.value = '';
            }
        });

        // Trigger on page load if birthdate is already prefilled
        if (birthdateInput.value) {
            birthdateInput.dispatchEvent(new Event('change'));
        }
    }

    // 3. Highlight Active Menu Items
    const currentUrl = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link, .admin-nav-link');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentUrl.endsWith(href)) {
            link.classList.add('active');
        }
    });

    // 4. Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // 5. Admin Sidebar toggle
    const sidebarToggle = document.getElementById('admin-sidebar-toggle');
    const adminSidebar = document.querySelector('.admin-sidebar');
    
    if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (window.innerWidth > 992) {
                adminSidebar.classList.toggle('collapsed');
            } else {
                adminSidebar.classList.toggle('active');
            }
        });
    }

    // 6. Animated counters on the landing page
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = Number(counter.getAttribute('data-target')) || 0;
        const duration = 1200;
        const startTime = performance.now();

        const updateCounter = (timestamp) => {
            const progress = Math.min((timestamp - startTime) / duration, 1);
            const current = Math.floor(progress * target);
            counter.textContent = current.toString();
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toString();
            }
        };

        requestAnimationFrame(updateCounter);
    });

    // 7. FAQ accordion interaction
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const button = item.querySelector('.faq-question');
        if (!button) return;

        button.addEventListener('click', () => {
            faqItems.forEach(other => {
                other.classList.toggle('active', other === item);
            });
        });
    });
});
