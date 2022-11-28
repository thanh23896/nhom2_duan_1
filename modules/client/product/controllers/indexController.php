<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    $data['notifications'] = get_notification();
    if (is_ss('search')) {
        $value = get_ss('search');
        // remove_ss('search');
        request_login(false);
        $row = get_count_pro_by_value($value);
        $total_records = $row['total'];
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 3;
        // tổng số trang
        $total_page = ceil($total_records / $limit);
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($total_page == 0) {
            push_notification('red', ['không tìm được']);
            header('Location: ?role=client&mod=home');
        } elseif ($current_page > $total_page) {
            $current_page = $total_page;
        } elseif ($current_page < 1) {
            $current_page = 1;
        }

        // Tìm Start
        $start = ($current_page - 1) * $limit;
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
        $data['result'] = get_limit_pro_by_value($start, $limit, $value);
        $data['total_page'] = $total_page;
        $data['current_page'] = $current_page;
    } elseif (isset($_GET['cate_id']) && $_GET['cate_id'] != '') {
        $cate_id = $_GET['cate_id'];
        request_login(false);
        $row = get_count_pro_by_cate_id($cate_id);
        $total_records = $row['total'];
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 3;
        // tổng số trang
        $total_page = ceil($total_records / $limit);
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($total_page == 0) {
            push_notification('red', ['không tìm được']);
            header('Location: ?role=client&mod=home');
        } elseif ($current_page > $total_page) {
            $current_page = $total_page;
        } elseif ($current_page < 1) {
            $current_page = 1;
        }

        // Tìm Start
        $start = ($current_page - 1) * $limit;
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
        $data['result'] = get_limit_pro_by_cate_id($start, $limit, $cate_id);
        $data['total_page'] = $total_page;
        $data['current_page'] = $current_page;
    }
    load_view('index', $data);
}
function indexPostAction()
{
    $value = $_POST['search'];
    push_ss('search', $value);
    header('Location: ?role=client&mod=product');
}
