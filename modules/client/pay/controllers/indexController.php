<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    request_login(true);
    if (!is_ss('cart')) {
        push_ss('cart', []);
    }
    $data['notifications'] = get_notification();
    $data['products'] = get_ss('cart');
    load_view('index', $data);
}
