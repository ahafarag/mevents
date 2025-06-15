<?php
// upload.php — Handle Excel uploads for employees and prizes
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

if (!isset($_FILES['file']) || !isset($_POST['type'])) {
    http_response_code(400);
    echo "Missing file or type";
    exit;
}

$type = $_POST['type']; // 'employees' or 'prizes'
$validTypes = ['employees', 'prizes'];
if (!in_array($type, $validTypes)) {
    http_response_code(400);
    echo "Invalid type";
    exit;
}

$spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
$sheet = $spreadsheet->getActiveSheet();
$data = $sheet->toArray(null, true, true, true);

// Remove header
$header = array_shift($data);

$inserted = 0;
if ($type === 'employees') {
    $stmt = $pdo->prepare("INSERT INTO employees (full_name, position, rank, hire_date) VALUES (?, ?, ?, ?)");
    foreach ($data as $row) {
        $fullName = $row['A'] ?? '';
        $position = $row['B'] ?? '';
        $rank     = $row['C'] ?? '';
        $hireDate = $row['D'] ?? '';
        if ($fullName && $hireDate) {
            $stmt->execute([$fullName, $position, $rank, $hireDate]);
            $inserted++;
        }
    }
} elseif ($type === 'prizes') {
    $stmt = $pdo->prepare("INSERT INTO prizes (prize_name, category) VALUES (?, ?)");
    foreach ($data as $row) {
        $name     = $row['A'] ?? '';
        $category = $row['B'] ?? '';
        if ($name && in_array($category, ['Expensive', 'Medium', 'Modest'])) {
            $stmt->execute([$name, $category]);
            $inserted++;
        }
    }
}

echo "Uploaded $inserted records to $type table.";
