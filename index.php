<?php
// Load content from JSON file
$dataFile = __DIR__ . '/data/content.json';
$content = [];

// Create data directory if not exists
if (!file_exists(__DIR__ . '/data')) {
    @mkdir(__DIR__ . '/data', 0755, true);
}

if (file_exists($dataFile)) {
    $jsonContent = file_get_contents($dataFile);
    $content = json_decode($jsonContent, true);
    if ($content === null) {
        $content = []; // Reset if JSON is invalid
    }
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>טכנוליין - הקול בידיים שלך</title>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Heebo', sans-serif;
            background: #f8fafc;
            color: #1e3a5f;
            line-height: 1.6;
        }

        /* Navigation */
        nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .logo {
            height: 50px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #1e3a5f;
            font-weight: 500;
            transition: color 0.3s;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
        }

        .nav-links a:hover, .nav-links a.active {
            color: #4fb3d9;
            border-bottom-color: #4fb3d9;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #4fb3d9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 20px 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/><circle cx="50" cy="50" r="30" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/><circle cx="50" cy="50" r="20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></svg>');
            background-size: 200px;
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }

        .hero-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .hero h1 {
            color: white;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 20px rgba(0,0,0,0.2);
        }

        .hero p {
            color: rgba(255,255,255,0.9);
            font-size: 1.3rem;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            background: white;
            color: #1e3a5f;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        /* About Section */
        .section {
            padding: 80px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #1e3a5f;
            margin-bottom: 50px;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #4fb3d9, #1e3a5f);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        /* About */
        #about {
            background: white;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-text h3 {
            font-size: 1.8rem;
            color: #1e3a5f;
            margin-bottom: 20px;
        }

        .about-text p {
            color: #5a6f85;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .about-image {
            text-align: center;
        }

        .about-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(30,58,95,0.15);
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .feature-card {
            background: #f8fafc;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(30,58,95,0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4fb3d9, #1e3a5f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-icon svg {
            width: 35px;
            height: 35px;
            fill: white;
        }

        .feature-card h4 {
            color: #1e3a5f;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #5a6f85;
            font-size: 0.95rem;
        }

        /* Products Section */
        #products {
            background: linear-gradient(180deg, #f8fafc 0%, #e8f4f8 100%);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(30,58,95,0.08);
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(30,58,95,0.15);
        }

        .product-card h3 {
            color: #1e3a5f;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .product-card p {
            color: #5a6f85;
            margin-bottom: 20px;
        }

        .product-card ul {
            list-style: none;
            margin-bottom: 20px;
        }

        .product-card li {
            padding: 8px 0;
            color: #5a6f85;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-card li::before {
            content: '✓';
            color: #4fb3d9;
            font-weight: bold;
        }

        /* Developers Section */
        #developers {
            background: #1e3a5f;
            color: white;
        }

        #developers .section-title {
            color: white;
        }

        #developers .section-title::after {
            background: linear-gradient(90deg, #4fb3d9, white);
        }

        .api-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .api-text p {
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .api-features {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
        }

        .api-feature {
            background: rgba(255,255,255,0.1);
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
        }

        .code-block {
            background: #0d1f30;
            border-radius: 15px;
            padding: 25px;
            overflow-x: auto;
        }

        .code-block pre {
            color: #4fb3d9;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            direction: ltr;
            text-align: left;
        }

        /* Contact Section */
        #contact {
            background: white;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }

        .contact-form {
            background: #f8fafc;
            padding: 40px;
            border-radius: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e3a5f;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e7ef;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4fb3d9;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, #1e3a5f, #4fb3d9);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(30,58,95,0.3);
        }

        .contact-info {
            padding: 40px;
        }

        .contact-info h3 {
            font-size: 1.8rem;
            color: #1e3a5f;
            margin-bottom: 20px;
        }

        .contact-info p {
            color: #5a6f85;
            margin-bottom: 30px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4fb3d9, #1e3a5f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-icon svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

        /* Footer */
        footer {
            background: #0d1f30;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .footer-logo {
            height: 40px;
            margin-bottom: 15px;
            filter: brightness(0) invert(1);
        }

        .footer-slogan {
            color: #4fb3d9;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #4fb3d9;
        }

        .copyright {
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
        }

        .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background: #1e3a5f;
            margin: 5px 0;
            transition: all 0.3s;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .about-content,
            .api-info,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .features {
                grid-template-columns: repeat(2, 1fr);
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                gap: 0;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                padding: 15px 0;
                border-bottom: 1px solid #eee;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <img src="images/logo.jpg" alt="טכנוליין" class="logo">
            <button class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <?php if (!empty($content['menu'])): ?>
                    <?php foreach ($content['menu'] as $item): ?>
                        <li><a href="<?= htmlspecialchars($item['link']) ?>"><?= htmlspecialchars($item['name']) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#about" class="active">אודות החברה</a></li>
                    <li><a href="#products">מוצרים</a></li>
                    <li><a href="#developers">מפתחים</a></li>
                    <li><a href="#contact">יצירת קשר</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <span class="hero-badge"><?= htmlspecialchars($content['hero']['badge'] ?? 'חדש!') ?></span>
            <h1><?= htmlspecialchars($content['hero']['title'] ?? 'בקליק אחד - כל הקהל שומע אותך!') ?></h1>
            <p><?= htmlspecialchars($content['hero']['description'] ?? 'מערכת טכנולוגית מתקדמת לניהול מערכות קוליות והפצת מסרים. מתאימה לעמותות, ארגונים ועסקים - להעברת מסרים בצורה ישירה, מהירה ופשוטה.') ?></p>
            <a href="#contact" class="cta-button"><?= htmlspecialchars($content['hero']['buttonText'] ?? 'להיכרות ראשונית עם המערכת - לחץ כאן') ?></a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <h2 class="section-title">אודות החברה</h2>
            <div class="about-content">
                <div class="about-text">
                    <h3><?= htmlspecialchars($content['about']['title'] ?? 'טכנוליין - הקול בידיים שלך') ?></h3>
                    <p><?= htmlspecialchars($content['about']['paragraphs'][0] ?? 'אנחנו מתמחים בפיתוח פתרונות טכנולוגיים מתקדמים לניהול קווי תוכן ומסרים קוליים.') ?></p>
                    <p><?= htmlspecialchars($content['about']['paragraphs'][1] ?? 'המערכת שלנו מאפשרת לארגונים, עמותות ועסקים להעביר מסרים בצורה ישירה ויעילה לקהל היעד שלהם.') ?></p>
                    <p><?= htmlspecialchars($content['about']['paragraphs'][2] ?? 'עם שנים של ניסיון בתחום, אנחנו מציעים פתרון אמין, מהיר ופשוט לתפעול.') ?></p>
                </div>
                <div class="about-image">
                    <img src="images/logo.jpg" alt="טכנוליין">
                </div>
            </div>

            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <h4>פשוט לתפעול</h4>
                    <p>ממשק ידידותי ונוח שמאפשר ניהול מלא של המערכת בקלות</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M13 2.05v2.02c3.95.49 7 3.85 7 7.93 0 3.21-1.92 6-4.72 7.28L13 17v5l5-5h-2.28c2.52-1.48 4.28-4.15 4.28-7.28 0-5.17-4.36-9.32-9.5-9.67zm-2 0C6.05 2.56 2 6.94 2 12c0 4.07 2.58 7.54 6.22 8.87L10 17v5l-5-5h2.28C4.58 15.54 3 13.27 3 10.72c0-4.41 3.58-8 8-8v-.67z"/></svg>
                    </div>
                    <h4>מהיר ואמין</h4>
                    <p>הפצת מסרים מיידית עם אמינות מקסימלית ודיווחים בזמן אמת</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    </div>
                    <h4>מאובטח</h4>
                    <p>אבטחת מידע ברמה הגבוהה ביותר לשמירה על פרטיות המשתמשים</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="section">
        <div class="container">
            <h2 class="section-title">המוצרים שלנו</h2>
            <div class="products-grid">
                <div class="product-card">
                    <h3>מערכת הודעות קוליות</h3>
                    <p>שליחת הודעות קוליות אוטומטיות לרשימות תפוצה</p>
                    <ul>
                        <li>הקלטה וניהול הודעות</li>
                        <li>תזמון שליחה אוטומטי</li>
                        <li>דוחות סטטיסטיים מפורטים</li>
                        <li>ניהול רשימות תפוצה</li>
                    </ul>
                </div>
                <div class="product-card">
                    <h3>קווי מידע אוטומטיים</h3>
                    <p>הקמה וניהול של קווי מידע עם תפריטים קוליים</p>
                    <ul>
                        <li>בניית תפריטים מותאמים</li>
                        <li>עדכון תוכן בזמן אמת</li>
                        <li>סטטיסטיקות שיחות</li>
                        <li>הקלטת שיחות</li>
                    </ul>
                </div>
                <div class="product-card">
                    <h3>ניהול שיחות נכנסות</h3>
                    <p>מערכת מתקדמת לניהול שיחות נכנסות וניתובן</p>
                    <ul>
                        <li>ניתוב חכם של שיחות</li>
                        <li>תורים וירטואליים</li>
                        <li>זיהוי מתקשר</li>
                        <li>אינטגרציה עם CRM</li>
                    </ul>
                </div>
                <div class="product-card">
                    <h3>API למפתחים</h3>
                    <p>ממשק תכנות לשילוב המערכת באפליקציות חיצוניות</p>
                    <ul>
                        <li>תיעוד מלא ומקיף</li>
                        <li>דוגמאות קוד</li>
                        <li>תמיכה טכנית</li>
                        <li>סביבת פיתוח</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Developers Section -->
    <section id="developers" class="section">
        <div class="container">
            <h2 class="section-title">למפתחים</h2>
            <div class="api-info">
                <div class="api-text">
                    <p>ה-API שלנו מאפשר לכם לשלב את יכולות המערכת הקולית באפליקציות שלכם בקלות.</p>
                    <p>תיעוד מקיף, דוגמאות קוד בשפות שונות, וצוות תמיכה שזמין לעזור.</p>
                    <div class="api-features">
                        <span class="api-feature">REST API</span>
                        <span class="api-feature">Webhooks</span>
                        <span class="api-feature">SDK</span>
                        <span class="api-feature">תיעוד מלא</span>
                        <span class="api-feature">סביבת בדיקות</span>
                    </div>
                </div>
                <div class="code-block">
                    <pre>
// דוגמה לשליחת הודעה קולית
const technoline = require('technoline-sdk');

const client = new technoline.Client({
    apiKey: 'YOUR_API_KEY'
});

await client.voice.send({
    to: '0501234567',
    message: 'recordings/welcome.mp3',
    callback: 'https://your-server.com/webhook'
});
                    </pre>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <h2 class="section-title">יצירת קשר</h2>
            <div class="contact-grid">
                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <label>שם מלא</label>
                            <input type="text" placeholder="הזן את שמך">
                        </div>
                        <div class="form-group">
                            <label>טלפון</label>
                            <input type="tel" placeholder="050-0000000">
                        </div>
                        <div class="form-group">
                            <label>אימייל</label>
                            <input type="email" placeholder="your@email.com">
                        </div>
                        <div class="form-group">
                            <label>הודעה</label>
                            <textarea placeholder="כתוב את הודעתך כאן..."></textarea>
                        </div>
                        <button type="submit" class="submit-btn">שלח הודעה</button>
                    </form>
                </div>
                <div class="contact-info">
                    <h3>נשמח לשמוע ממך</h3>
                    <p>השאר פרטים ונחזור אליך בהקדם, או צור קשר ישירות באחת הדרכים הבאות:</p>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        </div>
                        <div>
                            <strong>טלפון</strong><br>
                            <span><?= htmlspecialchars($content['contact']['phone'] ?? '03-0000000') ?></span>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </div>
                        <div>
                            <strong>אימייל</strong><br>
                            <span><?= htmlspecialchars($content['contact']['email'] ?? 'info@technoline.co.il') ?></span>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        </div>
                        <div>
                            <strong>כתובת</strong><br>
                            <span><?= htmlspecialchars($content['contact']['address'] ?? 'ישראל') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <img src="images/logo.jpg" alt="טכנוליין" class="footer-logo">
        <p class="footer-slogan"><?= htmlspecialchars($content['footer']['slogan'] ?? 'הקול בידיים שלך') ?></p>
        <div class="footer-links">
            <a href="#about">אודות</a>
            <a href="#products">מוצרים</a>
            <a href="#developers">מפתחים</a>
            <a href="#contact">יצירת קשר</a>
        </div>
        <p class="copyright"><?= htmlspecialchars($content['footer']['copyright'] ?? '© 2025 טכנוליין. כל הזכויות שמורות.') ?></p>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('active');
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu
                    document.getElementById('navLinks').classList.remove('active');
                }
            });
        });

        // Active link on scroll
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-links a');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (pageYOffset >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Content is loaded via PHP - no JavaScript API needed
    </script>
</body>
</html>
