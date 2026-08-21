<?php

require_once "../config/condb.php";

$url = "https://www.tlalatex.org/th/price";

// ============================
// 1. ดึง HTML
// ============================

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

$html = curl_exec($ch);

if ($html === false) {
    die("CURL Error: " . curl_error($ch));
}

curl_close($ch);


// ============================
// 2. DOMDocument
// ============================

libxml_use_internal_errors(true);

$dom = new DOMDocument();
$dom->loadHTML($html);

libxml_clear_errors();


// ============================
// 3. หา Table
// ============================

$tables = $dom->getElementsByTagName("table");

$latestDate = null;
$latestPrice = null;


// ============================
// 4. อ่านข้อมูลทุกแถว
// ============================

foreach ($tables as $table) {

    $rows = $table->getElementsByTagName("tr");

    foreach ($rows as $row) {

        $cells = $row->getElementsByTagName("td");

        if ($cells->length < 2) {
            continue;
        }

        $dateText = trim($cells->item(0)->textContent);
        $priceText = trim($cells->item(1)->textContent);


        // ----------------------------
        // แยก วันที่ เดือน ปี
        // ----------------------------

        if (!preg_match(
            '/(\d{1,2})\s+([ก-ฮ]+)\s+(\d{4})/',
            $dateText,
            $matches
        )) {
            continue;
        }

        $day = $matches[1];
        $monthThai = $matches[2];
        $yearThai = $matches[3];


        // ============================
        // แปลงเดือนภาษาไทย
        // ============================

        $months = [
            "มกราคม" => "01",
            "กุมภาพันธ์" => "02",
            "มีนาคม" => "03",
            "เมษายน" => "04",
            "พฤษภาคม" => "05",
            "มิถุนายน" => "06",
            "กรกฎาคม" => "07",
            "สิงหาคม" => "08",
            "กันยายน" => "09",
            "ตุลาคม" => "10",
            "พฤศจิกายน" => "11",
            "ธันวาคม" => "12"
        ];

        if (!isset($months[$monthThai])) {
            continue;
        }

        $month = $months[$monthThai];


        // ============================
        // พ.ศ. → ค.ศ.
        // ============================

        $year = $yearThai - 543;

        $date = sprintf(
            "%04d-%02d-%02d",
            $year,
            $month,
            $day
        );


        // ============================
        // แปลงราคา
        // ============================

        $price = str_replace(",", "", $priceText);

        if (!is_numeric($price)) {
            continue;
        }

        $price = (float)$price;


        // ============================
        // หา "วันที่ล่าสุด"
        // ============================

        if (
            $latestDate === null ||
            $date > $latestDate
        ) {

            $latestDate = $date;
            $latestPrice = $price;
        }
    }

    // ถ้ามีข้อมูลแล้ว ไม่จำเป็นต้องอ่าน table อื่น
    if ($latestDate !== null) {
        break;
    }
}


// ============================
// 5. ตรวจสอบข้อมูล
// ============================

if ($latestDate === null) {

    die("ไม่พบข้อมูลราคา");

}


// ============================
// 6. แสดงข้อมูลล่าสุด
// ============================

echo "วันที่ล่าสุด: " . $latestDate . "<br>";
echo "ราคาล่าสุด: " . $latestPrice . " บาท/กก.<br>";


// ============================
// 7. บันทึกลง Database
// ============================

$factory = "สมาคมน้ำยางข้นไทย";
$province = "สงขลา";
$rubberType = "น้ำยางสด";
$unit = "บาท/กก.";


$sql = "
    INSERT INTO rubber_prices
    (
        price_date,
        factory,
        province,
        rubber_type,
        price,
        unit
    )
    VALUES (?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        price = VALUES(price),
        unit = VALUES(unit)
";

$stmt = mysqli_prepare($con, $sql);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($con));
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssds",
    $latestDate,
    $factory,
    $province,
    $rubberType,
    $latestPrice,
    $unit
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

echo "บันทึกข้อมูลลง Database สำเร็จ";