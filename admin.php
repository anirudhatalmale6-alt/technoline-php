<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>פאנל ניהול - טכנוליין</title>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Heebo', sans-serif; background: #f0f2f5; min-height: 100vh; }

        .sidebar {
            position: fixed; right: 0; top: 0; width: 250px; height: 100vh;
            background: #1e3a5f; padding: 20px; color: white;
        }
        .sidebar h1 { font-size: 1.3rem; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a {
            display: block; padding: 12px 15px; color: rgba(255,255,255,0.8);
            text-decoration: none; border-radius: 8px; transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-menu a.active { background: #4fb3d9; }

        .main-content { margin-right: 250px; padding: 30px; }
        .page-header {
            background: white; padding: 20px 30px; border-radius: 10px;
            margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .page-header h2 { color: #1e3a5f; font-size: 1.5rem; }

        .card {
            background: white; border-radius: 10px; padding: 25px;
            margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card h3 {
            color: #1e3a5f; font-size: 1.1rem; margin-bottom: 20px;
            padding-bottom: 10px; border-bottom: 2px solid #f0f2f5;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 12px 15px; border: 2px solid #e0e7ef;
            border-radius: 8px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #4fb3d9; }
        .form-group textarea { min-height: 100px; resize: vertical; }

        .menu-item {
            display: flex; align-items: center; gap: 10px; padding: 12px;
            background: #f8fafc; border-radius: 8px; margin-bottom: 10px;
        }
        .menu-item input { flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; }
        .menu-item .link-input { width: 150px; flex: none; }
        .btn-delete { background: #ff4757; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
        .btn-add { background: #4fb3d9; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px; }

        .btn-save {
            background: linear-gradient(135deg, #1e3a5f, #4fb3d9); color: white; border: none;
            padding: 12px 30px; border-radius: 8px; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(30,58,95,0.3); }

        .btn-view {
            background: #28a745; color: white; border: none; padding: 10px 20px;
            border-radius: 5px; cursor: pointer; text-decoration: none; display: block; text-align: center;
        }

        .section { display: none; }
        .section.active { display: block; }

        .toast {
            position: fixed; bottom: 30px; left: 30px; background: #28a745; color: white;
            padding: 15px 25px; border-radius: 8px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            transform: translateY(100px); opacity: 0; transition: all 0.3s;
        }
        .toast.show { transform: translateY(0); opacity: 1; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-right: 0; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>🎛️ פאנל ניהול</h1>
        <ul class="sidebar-menu">
            <li><a href="#menu" class="active" onclick="showSection('menu')">📋 תפריט</a></li>
            <li><a href="#hero" onclick="showSection('hero')">🎯 באנר ראשי</a></li>
            <li><a href="#about" onclick="showSection('about')">ℹ️ אודות</a></li>
            <li><a href="#contact" onclick="showSection('contact')">📞 יצירת קשר</a></li>
            <li><a href="#footer" onclick="showSection('footer')">📄 פוטר</a></li>
        </ul>
        <div style="position: absolute; bottom: 20px; right: 20px; left: 20px;">
            <a href="index.php" target="_blank" class="btn-view">👁️ צפה באתר</a>
        </div>
    </div>

    <div class="main-content">
        <div class="page-header"><h2>ניהול תוכן האתר</h2></div>

        <!-- Menu Section -->
        <div id="section-menu" class="section active">
            <div class="card">
                <h3>עריכת תפריט</h3>
                <div id="menu-items"></div>
                <button class="btn-add" onclick="addMenuItem()">+ הוסף פריט</button>
            </div>
            <button class="btn-save" onclick="saveMenu()">💾 שמור תפריט</button>
        </div>

        <!-- Hero Section -->
        <div id="section-hero" class="section">
            <div class="card">
                <h3>באנר ראשי</h3>
                <div class="form-group"><label>תגית (Badge)</label><input type="text" id="hero-badge"></div>
                <div class="form-group"><label>כותרת</label><input type="text" id="hero-title"></div>
                <div class="form-group"><label>תיאור</label><textarea id="hero-description"></textarea></div>
                <div class="form-group"><label>טקסט כפתור</label><input type="text" id="hero-button"></div>
            </div>
            <button class="btn-save" onclick="saveHero()">💾 שמור באנר</button>
        </div>

        <!-- About Section -->
        <div id="section-about" class="section">
            <div class="card">
                <h3>עמוד אודות</h3>
                <div class="form-group"><label>כותרת</label><input type="text" id="about-title"></div>
                <div class="form-group"><label>פסקה 1</label><textarea id="about-p1"></textarea></div>
                <div class="form-group"><label>פסקה 2</label><textarea id="about-p2"></textarea></div>
                <div class="form-group"><label>פסקה 3</label><textarea id="about-p3"></textarea></div>
            </div>
            <button class="btn-save" onclick="saveAbout()">💾 שמור אודות</button>
        </div>

        <!-- Contact Section -->
        <div id="section-contact" class="section">
            <div class="card">
                <h3>פרטי יצירת קשר</h3>
                <div class="form-group"><label>טלפון</label><input type="text" id="contact-phone"></div>
                <div class="form-group"><label>אימייל</label><input type="email" id="contact-email"></div>
                <div class="form-group"><label>כתובת</label><input type="text" id="contact-address"></div>
            </div>
            <button class="btn-save" onclick="saveContact()">💾 שמור פרטי קשר</button>
        </div>

        <!-- Footer Section -->
        <div id="section-footer" class="section">
            <div class="card">
                <h3>פוטר</h3>
                <div class="form-group"><label>סלוגן</label><input type="text" id="footer-slogan"></div>
                <div class="form-group"><label>זכויות יוצרים</label><input type="text" id="footer-copyright"></div>
            </div>
            <button class="btn-save" onclick="saveFooter()">💾 שמור פוטר</button>
        </div>
    </div>

    <div class="toast" id="toast">✅ נשמר בהצלחה!</div>

    <script>
        let content = {};

        async function loadContent() {
            try {
                const res = await fetch('api.php');
                content = await res.json();
                populateForm();
            } catch (e) { console.error('Error:', e); }
        }

        function populateForm() {
            document.getElementById('hero-badge').value = content.hero?.badge || '';
            document.getElementById('hero-title').value = content.hero?.title || '';
            document.getElementById('hero-description').value = content.hero?.description || '';
            document.getElementById('hero-button').value = content.hero?.buttonText || '';

            document.getElementById('about-title').value = content.about?.title || '';
            document.getElementById('about-p1').value = content.about?.paragraphs?.[0] || '';
            document.getElementById('about-p2').value = content.about?.paragraphs?.[1] || '';
            document.getElementById('about-p3').value = content.about?.paragraphs?.[2] || '';

            document.getElementById('contact-phone').value = content.contact?.phone || '';
            document.getElementById('contact-email').value = content.contact?.email || '';
            document.getElementById('contact-address').value = content.contact?.address || '';

            document.getElementById('footer-slogan').value = content.footer?.slogan || '';
            document.getElementById('footer-copyright').value = content.footer?.copyright || '';

            renderMenu();
        }

        function renderMenu() {
            const container = document.getElementById('menu-items');
            container.innerHTML = '';
            (content.menu || []).forEach((item, index) => {
                container.innerHTML += `
                    <div class="menu-item">
                        <input type="text" value="${item.name}" placeholder="שם" onchange="updateMenuItem(${index}, 'name', this.value)">
                        <input type="text" class="link-input" value="${item.link}" placeholder="קישור" onchange="updateMenuItem(${index}, 'link', this.value)">
                        <button class="btn-delete" onclick="deleteMenuItem(${index})">🗑️</button>
                    </div>`;
            });
        }

        function addMenuItem() {
            if (!content.menu) content.menu = [];
            content.menu.push({ id: Date.now(), name: 'פריט חדש', link: '#' });
            renderMenu();
        }

        function updateMenuItem(index, field, value) { content.menu[index][field] = value; }
        function deleteMenuItem(index) { content.menu.splice(index, 1); renderMenu(); }

        async function saveSection(section, data) {
            try {
                const res = await fetch('api.php?section=' + section, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                if (res.ok) showToast();
            } catch (e) { console.error('Error:', e); }
        }

        function saveMenu() { saveSection('menu', content.menu); }
        function saveHero() {
            saveSection('hero', {
                badge: document.getElementById('hero-badge').value,
                title: document.getElementById('hero-title').value,
                description: document.getElementById('hero-description').value,
                buttonText: document.getElementById('hero-button').value
            });
        }
        function saveAbout() {
            saveSection('about', {
                title: document.getElementById('about-title').value,
                paragraphs: [
                    document.getElementById('about-p1').value,
                    document.getElementById('about-p2').value,
                    document.getElementById('about-p3').value
                ]
            });
        }
        function saveContact() {
            saveSection('contact', {
                phone: document.getElementById('contact-phone').value,
                email: document.getElementById('contact-email').value,
                address: document.getElementById('contact-address').value
            });
        }
        function saveFooter() {
            saveSection('footer', {
                slogan: document.getElementById('footer-slogan').value,
                copyright: document.getElementById('footer-copyright').value
            });
        }

        function showSection(section) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.sidebar-menu a').forEach(a => a.classList.remove('active'));
            document.getElementById('section-' + section).classList.add('active');
            document.querySelector(`a[href="#${section}"]`).classList.add('active');
        }

        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        loadContent();
    </script>
</body>
</html>
