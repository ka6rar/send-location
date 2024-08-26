<?php
// السماح بطلبات من أي نطاق (يمكن تخصيص النطاق إذا لزم الأمر)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// التحقق من أن الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // قراءة بيانات JSON من الطلب
    $data = json_decode(file_get_contents('php://input'), true);

    // تحديد مسار ملف JSON لحفظ البيانات
    $file = 'location.json';

    // فتح الملف في وضع "append" لإضافة بيانات جديدة في نهاية الملف
    $fileHandle = fopen($file, 'a');

    if ($fileHandle) {
        // كتابة البيانات الجديدة كـ JSON وسطر جديد
        fwrite($fileHandle, json_encode($data) . "\n");
        fclose($fileHandle);

        // إرجاع استجابة للمستخدم
        echo json_encode(["status" => "success", "message" => "Location saved successfully."]);
    } else {
        // إذا لم يتمكن من فتح الملف، إرجاع خطأ
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Unable to open the file."]);
    }
} else {
    // إذا كان الطلب ليس POST، إرجاع خطأ 405
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method Not Allowed"]);
}
?>
