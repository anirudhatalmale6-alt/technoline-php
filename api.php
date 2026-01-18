<?php
// API for saving and loading content
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);

$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/content.json';

// Default content
$defaultContent = [
    'menu' => [
        ['id' => 1, 'name' => 'אודות החברה', 'link' => '#about'],
        ['id' => 2, 'name' => 'מוצרים', 'link' => '#products'],
        ['id' => 3, 'name' => 'מפתחים', 'link' => '#developers'],
        ['id' => 4, 'name' => 'יצירת קשר', 'link' => '#contact']
    ],
    'hero' => [
        'badge' => 'חדש!',
        'title' => 'בקליק אחד - כל הקהל שומע אותך!',
        'description' => 'מערכת טכנולוגית מתקדמת לניהול מערכות קוליות והפצת מסרים. מתאימה לעמותות, ארגונים ועסקים - להעברת מסרים בצורה ישירה, מהירה ופשוטה.',
        'buttonText' => 'להיכרות ראשונית עם המערכת - לחץ כאן'
    ],
    'about' => [
        'title' => 'טכנוליין - הקול בידיים שלך',
        'paragraphs' => [
            'אנחנו מתמחים בפיתוח פתרונות טכנולוגיים מתקדמים לניהול קווי תוכן ומסרים קוליים.',
            'המערכת שלנו מאפשרת לארגונים, עמותות ועסקים להעביר מסרים בצורה ישירה ויעילה לקהל היעד שלהם.',
            'עם שנים של ניסיון בתחום, אנחנו מציעים פתרון אמין, מהיר ופשוט לתפעול.'
        ]
    ],
    'contact' => [
        'phone' => '03-0000000',
        'email' => 'info@technoline.co.il',
        'address' => 'ישראל'
    ],
    'footer' => [
        'slogan' => 'הקול בידיים שלך',
        'copyright' => '© 2025 טכנוליין. כל הזכויות שמורות.'
    ]
];

// Create data directory if not exists
if (!file_exists($dataDir)) {
    @mkdir($dataDir, 0777, true);
}

// Create default content file if not exists
if (!file_exists($dataFile)) {
    @file_put_contents($dataFile, json_encode($defaultContent, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    @chmod($dataFile, 0666);
}

// If file still doesn't exist, output default content directly
if (!file_exists($dataFile)) {
    echo json_encode($defaultContent, JSON_UNESCAPED_UNICODE);
    exit;
}

// Handle requests
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Return content
    $content = file_get_contents($dataFile);
    echo $content;
}
elseif ($method === 'POST') {
    // Save content
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($data) {
        // Check if updating specific section
        $section = isset($_GET['section']) ? $_GET['section'] : null;

        if ($section) {
            // Update only specific section
            $content = json_decode(file_get_contents($dataFile), true);
            $content[$section] = $data;
            file_put_contents($dataFile, json_encode($content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        } else {
            // Update all content
            file_put_contents($dataFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }

        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
    }
}
?>
