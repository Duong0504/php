<?php
// Thiết lập header để trả về JSON và cho phép CORS (Cross-Origin Resource Sharing)
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Cho phép truy cập từ mọi domain
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Xử lý yêu cầu OPTIONS (thường được trình duyệt gửi trước các yêu cầu PUT, DELETE)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$dataFile = 'products.json';

/**
 * Hàm đọc dữ liệu sản phẩm từ file JSON
 * @return array Danh sách sản phẩm
 */
function getProducts() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return [];
    }
    $jsonData = file_get_contents($dataFile);
    return json_decode($jsonData, true) ?: []; // Trả về mảng rỗng nếu json_decode thất bại
}

/**
 * Hàm ghi dữ liệu sản phẩm vào file JSON
 * @param array $products Danh sách sản phẩm cần ghi
 * @return bool True nếu ghi thành công, False nếu thất bại
 */
function saveProducts($products) {
    global $dataFile;
    $jsonData = json_encode($products, JSON_PRETTY_PRINT);
    if (file_put_contents($dataFile, $jsonData) === false) {
        return false;
    }
    return true;
}

/**
 * Hàm tạo ID mới cho sản phẩm
 * @param array $products Danh sách sản phẩm hiện tại
 * @return int ID mới
 */
function getNextId($products) {
    if (empty($products)) {
        return 1;
    }
    $ids = array_column($products, 'id');
    return max($ids) + 1;
}

// Lấy phương thức HTTP được sử dụng (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Lấy đường dẫn yêu cầu (request path) để xác định ID sản phẩm (nếu có)
$requestUri = $_SERVER['REQUEST_URI'];
$pathParts = explode('/', trim($requestUri, '/'));
// Giả sử cấu trúc URL là /api/index.php/products hoặc /api/index.php/products/1
// Chúng ta cần phần tử sau 'index.php' (nếu có) để làm resource, và sau đó là ID
$scriptNameParts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));

// Tìm vị trí của script name trong request URI để lấy path thực sự
$basePathOffset = count($scriptNameParts);
$resourcePath = array_slice($pathParts, $basePathOffset -1); // Giữ lại phần tên file index.php để dễ hình dung resource

$resource = null;
$productId = null;

if (isset($resourcePath[1])) { // $resourcePath[0] là 'index.php' hoặc tên file của bạn
    $resource = $resourcePath[1]; // 'products'
    if (isset($resourcePath[2])) {
        $productId = (int)$resourcePath[2]; // ID sản phẩm
    }
}


// Xử lý yêu cầu dựa trên phương thức HTTP và resource
if ($resource === 'products') {
    switch ($method) {
        case 'GET':
            $products = getProducts();
            if ($productId !== null) {
                // Tìm sản phẩm theo ID
                $product = null;
                foreach ($products as $p) {
                    if ($p['id'] == $productId) {
                        $product = $p;
                        break;
                    }
                }
                if ($product) {
                    http_response_code(200);
                    echo json_encode($product);
                } else {
                    http_response_code(404); // Not Found
                    echo json_encode(["message" => "Sản phẩm không tồn tại."]);
                }
            } else {
                // Lấy tất cả sản phẩm
                http_response_code(200);
                echo json_encode($products);
            }
            break;

        case 'POST':
            // Lấy dữ liệu từ body của request
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['name']) && isset($data['price'])) {
                $products = getProducts();
                $newProduct = [
                    'id' => getNextId($products),
                    'name' => $data['name'],
                    'price' => (float)$data['price'],
                    'description' => $data['description'] ?? '' // Optional description
                ];
                $products[] = $newProduct;
                if (saveProducts($products)) {
                    http_response_code(201); // Created
                    echo json_encode($newProduct);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(["message" => "Không thể lưu sản phẩm."]);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "Dữ liệu không hợp lệ. Cần 'name' và 'price'."]);
            }
            break;

        case 'PUT':
            if ($productId === null) {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "Cần cung cấp ID sản phẩm để cập nhật."]);
                exit();
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $products = getProducts();
            $productFound = false;
            $updatedProduct = null;

            foreach ($products as $key => $product) {
                if ($product['id'] == $productId) {
                    // Cập nhật thông tin sản phẩm
                    $products[$key]['name'] = $data['name'] ?? $product['name'];
                    $products[$key]['price'] = isset($data['price']) ? (float)$data['price'] : $product['price'];
                    $products[$key]['description'] = $data['description'] ?? $product['description'];
                    $updatedProduct = $products[$key];
                    $productFound = true;
                    break;
                }
            }

            if ($productFound) {
                if (saveProducts($products)) {
                    http_response_code(200); // OK
                    echo json_encode($updatedProduct);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(["message" => "Không thể cập nhật sản phẩm."]);
                }
            } else {
                http_response_code(404); // Not Found
                echo json_encode(["message" => "Sản phẩm không tồn tại để cập nhật."]);
            }
            break;

        case 'DELETE':
            if ($productId === null) {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "Cần cung cấp ID sản phẩm để xóa."]);
                exit();
            }

            $products = getProducts();
            $productFound = false;
            $initialCount = count($products);

            // Lọc ra sản phẩm cần xóa
            $products = array_filter($products, function ($product) use ($productId, &$productFound) {
                if ($product['id'] == $productId) {
                    $productFound = true;
                    return false; // Loại bỏ sản phẩm này
                }
                return true; // Giữ lại sản phẩm này
            });

            // Đảm bảo index của mảng được sắp xếp lại (nếu cần thiết cho json_encode)
            $products = array_values($products);

            if ($productFound) {
                if (saveProducts($products)) {
                    http_response_code(200); // OK (hoặc 204 No Content nếu không trả về body)
                    echo json_encode(["message" => "Sản phẩm đã được xóa."]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(["message" => "Không thể xóa sản phẩm."]);
                }
            } else {
                http_response_code(404); // Not Found
                echo json_encode(["message" => "Sản phẩm không tồn tại để xóa."]);
            }
            break;

        default:
            http_response_code(405); // Method Not Allowed
            echo json_encode(["message" => "Phương thức không được hỗ trợ."]);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint không hợp lệ. Sử dụng /products."]);
}

?>