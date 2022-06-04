<?php

class FSRoute
{
    var $url;

    function __construct($url)
    {
    }

    static function _($url)
    {
        return FSRoute::enURL($url);
    }

    /*
     * Trả lại tên mã hóa trên URL
     */
    static function get_name_encode($name, $lang)
    {
        $lang_url = array('ct' => 'ce',
        );
        if ($lang == 'vi')
            return $name;
        else
            return $lang_url[$name];
    }

    static function addParameters($params, $value)
    {
        // only filter
        $module = FSInput::get('module');
        $view = FSInput::get('view');
        if ($module == 'products' && $view == 'search') {
            $array_paras_need_get = array('ccode', 'filter', 'manu', 'order', 'status', 'style', 'Itemid', 'keyword');
            $url = 'index.php?module=' . $module . '&view=' . $view;
            foreach ($array_paras_need_get as $item) {
                if ($item != $params) {
                    $value_of_param = FSInput::get($item);
                    if ($value_of_param) {
                        $url .= "&" . $item . "=" . $value_of_param;
                    }
                } else {
                    if ($value)
                        $url .= "&" . $item . "=" . $value;
                }
            }
            return FSRoute:: _($url);
        }
        if ($module == 'products' && $view=='cat') {
            $array_paras_need_get = array('ccode','manu', 'order', 'status', 'style', 'sort', 'Itemid', 'cid', $params);
            $url = 'index.php?module=' . $module . '&view=cat';
            foreach ($array_paras_need_get as $item) {
                if ($item != $params) {
                    $value_of_param = FSInput::get($item);
                    if ($value_of_param) {
                        $url .= "&" . $item . "=" . $value_of_param;
                    }
                } else {
                    if ($value)
                        $url .= "&" . $item . "=" . $value;
                }
            }
            return FSRoute:: _($url);
        }


        return FSRoute:: _($_SERVER['REQUEST_URI']);
    }

    function removeParameters($params)
    {
        // only filter
        $module = FSInput::get('module');
        $view = FSInput::get('view');
        $ccode = FSInput::get('ccode');
        $filter = FSInput::get('filter');
        $manu = FSInput::get('manu');
        $Itemid = FSInput::get('Itemid');

        $url = 'index.php?module=' . $module . '&view=' . $view;
        if ($ccode) {
            $url .= '&ccode=' . $ccode;
        }
        if ($manu) {
            $url .= '&manu=' . $manu;
        }
        if ($filter) {
            $url .= '&filter=' . $filter;
        }
        $url .= '&Itemid=' . $Itemid;
        $url = trim(preg_replace('/&' . $params . '=[0-9a-zA-Z_-]+/i', '', $url));
    }

    /*
     * rewrite
     */
    static function enURL($url)
    {
        if (!$url)
            $url = $_SERVER['REQUEST_URI'];
        if (!IS_REWRITE)
            return URL_ROOT . $url;
        if (strpos($url, 'http://') !== false || strpos($url, 'https://') !== false)
            return $url;
        $url_reduced = substr($url, 10); // width : index.php
        $array_buffer = explode('&', $url_reduced, 10);
        $array_params = array();
        for ($i = 0; $i < count($array_buffer); $i++) {
            $item = $array_buffer[$i];
            $pos_sepa = strpos($item, '=');
            $array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
        }

        $module = isset($array_params['module']) ? $array_params['module'] : '';
        $view = isset($array_params['view']) ? $array_params['view'] : $module;
        $task = isset($array_params['task']) ? $array_params['task'] : 'display';
        $Itemid = isset($array_params['Itemid']) ? $array_params['Itemid'] : 0;

        $languge = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
        $url_first = URL_ROOT;
        $url1 = '';
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
        switch ($module) {
            case 'api':
                switch ($view) {
                    case 'order':
                        switch ($task) {
                            case 'update_deals':
                                return $url_first . FSRoute::get_name_encode('update_bitrix_deals$', $lang);
                        }
                    case 'product':
                        switch ($task) {
//                            case 'log':
//                                return $url_first . FSRoute::get_name_encode('log', $lang);
//                            default:
//                                return URL_ROOT . FSRoute::get_name_encode('trang-ca-nhan', $lang);
                        }
                }
                break;
            case 'members':
                switch ($view) {
                    case 'facebook':
                        switch ($task) {
                            case 'face_login':
                                return $url_first . FSRoute::get_name_encode('login-face', $lang);
                        }
                    case 'google':
                        switch ($task) {
                            case 'google_login':
                                return $url_first . FSRoute::get_name_encode('oauth2callback', $lang);
                        }
                    case 'members':
                        switch ($task) {
                            case 'log':
                                return $url_first . FSRoute::get_name_encode('log', $lang);
                            case 'reg':
                                return $url_first . FSRoute::get_name_encode('reg', $lang);
                            case 'login':
                                return $url_first . FSRoute::get_name_encode('account/login', $lang);
                            case 'register':
                                return $url_first . FSRoute::get_name_encode('account/register', $lang);
                            case 'logout':
                                return $url_first . FSRoute::get_name_encode('dang-xuat', $lang);
                            case 'forgot':
                                return $url_first . FSRoute::get_name_encode('quen-mat-khau', $lang);
                            case 'change_pass':
                                return $url_first . FSRoute::get_name_encode('doi-mat-khau', $lang);
                            case 'activate':
                                $mail = isset($array_params['mail']) ? $array_params['mail'] : '';
                                $code = isset($array_params['code']) ? $array_params['code'] : '';
                                return $url_first . 'activate-' . $mail .'-'.$code;
                            case 'like':
                                return URL_ROOT . FSRoute::get_name_encode('san-pham-yeu-thich', $lang);
                            case 'buy':
                                return URL_ROOT . FSRoute::get_name_encode('san-pham-da-mua', $lang);
                            case 'address':
                                return URL_ROOT . FSRoute::get_name_encode('so-dia-chi', $lang);
                            case 'add_address':
                                return URL_ROOT . FSRoute::get_name_encode('chinh-sua-dia-chi', $lang);
                            case 'order':
                                return URL_ROOT . FSRoute::get_name_encode('quan-ly-don-hang', $lang);
                            case 'remove_wish_list':
                                $id = isset($array_params['id']) ? $array_params['id'] : 0;
                                return $url_first . 'remove-favorite-product-' . $id;
                            default:
                                return URL_ROOT . FSRoute::get_name_encode('trang-ca-nhan', $lang);
                        }
                    default:
                        return URL_ROOT . $url;
                }
                break;
            case 'contact':
                return $url_first . 'he-thong-cua-hang';
            case 'connect':
                return $url_first . 'lien-he';
            case 'points':
                return $url_first . 'tich-diem-thanh-vien';
            case 'autumn':
                return $url_first . 'thu-cu-doi-moi';
            case 'products':
                switch ($view) {
                    case 'amp_product':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . 'amp/' . $code . '-' . FSRoute::get_name_encode('p', $lang) . $id . '.html';
                    case 'product':
                        if ($task == 'display' || $task == '') {
                            $code = isset($array_params['code']) ? $array_params['code'] : '';
                            $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                            $id = isset($array_params['id']) ? $array_params['id'] : '';
                            foreach ($array_params as $key => $value) {
                                if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'code' || $key == 'ccode' || $key == 'id')
                                    continue;
                                $url1 .= '&' . $key . '=' . $value;
                            }
                            return $url_first . $ccode . $url1;
                        } else {
                            return;
                        }
                    case 'cat':
                        $url_filter = '';
                        foreach ($array_params as $i=>$item){
                            if($i!='module' && $i!='view' && $i!='ccode' && $i!='cid' && $i!='Itemid'){
                                if (isset($array_params[$i]) ? $array_params[$i] : '') {
                                    $url_filter = '/' . $array_params[$i];
                                }
                            }
                        }

                        if($url_filter != '')
                            $url_filter = '/filter'.$url_filter;

                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $filter = isset($array_params['filter']) ? $array_params['filter'] : '';

                        return $url_first . $ccode . $url_filter;
                    case 'compare':
                        foreach ($array_params as $key => $value) {
                            if ($key == 'module' || $key == 'view' || $key == 'Itemid')
                                continue;
                            $url1 .= '&' . $key . '=' . $value;
                        }
//                        $cid = isset($array_params['cid']) ? $array_params['cid'] : '';
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $code_compare = isset($array_params['code_compare']) ? $array_params['code_compare'] : '';
//                        return $url_first . 'so-sanh-san-pham/' . $cid . '.html' . $url1;
                        return $url_first . 'so-sanh/' . $code . '-vs-' . $code_compare;
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = URL_ROOT . 'tim-kiem';
                        if ($keyword) {
                            $url .= '/' . $keyword;
                        }
                        return $url;
                    case 'hotdeal':
                        return $url_first . 'xa-hang';
                    case 'sales':
                        return $url_first . 'sales';
                    case 'promotion':
                        return $url_first . 'khuyen-mai.html';
                    case 'cart':
                        switch ($task) {
                            case 'eshopcart2':
                                return $url_first . 'gio-hang.html';
                            case 'baokimapi':
                                $id = isset($array_params['id']) ? $array_params['id'] : 0;
                                return $url_first . 'thanh-toan-bao-kim-' . $id;
                            case 'webhooks':
                                $id = isset($array_params['id']) ? $array_params['id'] : 0;
                                return $url_first . 'webhooks-baokim-' . $id;
                            case 'webhooks_kredivo':
                                $id = isset($array_params['id'])
                                    ? $array_params['id'] : 0;
                                return $url_first . 'webhooks-kredivo-' . $id;
                            case 'order':
                                return $url_first . 'don-hang.html';
                            case 'finished':
                                $id = isset($array_params['id']) ? $array_params['id'] : 0;
                                return $url_first . 'ket-thuc-don-hang-' . $id;
                            default:
                                return $url_first . $url;
                        }
                    case 'zalo_api':
                        switch ($task) {
                            case 'auth':
                                return $url_first . 'auth';
                            default:
                                return $url_first . 'zalo-api';
                        }
                    case 'api':
                        switch ($task) {
                            case 'products_sub':
                                return $url_first . 'api-price-sub';
                            default:
                                return $url_first . 'api-price';
                        }
                    case 'instalment':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : 0;
                        switch ($task) {
                            case 'success':
                                return $url_first . 'ket-thuc-tra-gop-' . $id;
                            case 'webhooks':
                                return $url_first . 'webhooks-' . $id;
//                                return $url_first . 'webhooks.html';
                            default:
                                return $url_first . 'tra-gop/' . $code;
                        }
                    case 'home':
                        foreach ($array_params as $key => $value) {
                            if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'code' || $key == 'ccode' || $key == 'id')
                                continue;
                            $url1 .= '&' . $key . '=' . $value;
                        }
                        return $url_first . 'store.html' . $url1;
                    default:
                        return $url_first . $url;
                }
                break;
            case 'news':
                switch ($view) {
                    case 'amp_news':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        // return $url_first.'amp/'.$code.'-'.FSRoute::get_name_encode('n',$lang).$id.'.html';
                        return $url_first . $ccode . '/amp/' . $code . '-n' . $id;
                    case 'news':
//                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
//                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $ccode;
                    case 'tags':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode;
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode;
                    case 'home':
                        return $url_first . 'blogs/all';
                    case 'search':

                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = URL_ROOT . 'tim-kiem-tin-tuc';
                        if ($keyword) {
                            $url .= '/' . $keyword . '.html';
                        }
                        return $url;
                    default:
                        return $url_first . $url;
                }
                break;
            case 'sales_offline':
                switch ($view) {
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . 'khuyen-mai-hot/' . $ccode;
                    case 'home':
                        return $url_first . 'khuyen-mai-hot';
                    default:
                        return $url_first . $url;
                }
                break;
            case 'contents':
                switch ($view) {
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . 'danh-muc/' . $ccode . '.html';
                    case 'contents':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode;
                }
                break;
            case 'partners':
                return $url_first . 'doi-tac.html';
                break;
            case 'videos':
                switch ($view) {
                    case 'cat':
                        return $url_first . 'videos';
                    case 'video':
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        return $url_first . $code . '-v' . $id;
                }
                break;
            case 'sitemap':
                return $url_first . 'site-map.html';
            case 'users':
                switch ($view) {
                    case 'users':
                        switch ($task) {
                            case 'login':
                                $url1 = '';
                                foreach ($array_params as $key => $value) {
                                    if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'task')
                                        continue;
                                    $url1 .= '&' . $key . '=' . $value;
                                }

                                return URL_ROOT . 'dang-nhap' . $url1;
                            case 'register':
                                $url1 = '';
                                foreach ($array_params as $key => $value) {
                                    if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'task')
                                        continue;
                                    $url1 .= '&' . $key . '=' . $value;
                                }
                                return URL_ROOT . 'dang-ky.html' . $url1;
                            case 'forget':
                                return URL_ROOT . 'quen-mat-khau.html';
                            case 'user_info':
                                return URL_ROOT . 'thong-tin-tai-khoan.html';
                            case 'logout':
                                return URL_ROOT . 'dang-xuat.html';
                            case 'login_register':
                                return URL_ROOT . 'dang-ky-dang-nhap.html';
                            case 'logged':
                                return URL_ROOT . 'thanh-vien.html';
                            case 'accumulation':
                                return URL_ROOT . 'chi-tieu-tich-luy.html';
                            case 'management':
                                return URL_ROOT . 'quan-ly-don-hang.html';
                            case 'warranty':
                                return URL_ROOT . 'tra-cuu-bao-hanh.html';
                            case 'repair':
                                return URL_ROOT . 'tra-cuu-sua-chua.html';
                            default:
                                return URL_ROOT . $url;
                        }
                    default:
                        return URL_ROOT . $url;
                }
                break;

            default:
                return URL_ROOT . $url;
        }
    }

    /*
     * get real url from virtual url
     */
    function deURL($url)
    {
        if (!IS_REWRITE)
            return $url;
        return $url;
        if (strpos($url, URL_ROOT_REDUCE) !== false) {
            $url = substr($url, strlen(URL_ROOT_REDUCE));
        }
        if ($url == 'news.html')
            return 'index.php?module=news&view=home&Itemid=1';
        if (strpos($url, 'news-page') !== false) {
            $f = strpos($url, 'news-page') + 9;
            $l = strpos($url, '.html');
            $page = intval(substr($url, $f, ($l - $f)));
            return "index.php?module=news&view=home&page=$page&Itemid=1";
        }
        $array_url = explode('/', $url);
        $module = isset($array_url[0]) ? $array_url[0] : '';
        switch ($module) {
            case 'news':
                // if cat
                if (preg_match('#news/([^/]*)-c([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $url, $arr)) {
                    return "index.php?module=news&view=cat&id=" . @$arr[2] . "&Itemid=" . @$arr[3] . '&page=' . @$arr[5];
                }
                // if article
                if (preg_match('#news/detail/([^/]*)-i([0-9]*)-it([0-9]*).html#s', $url, $arr)) {
                    return "index.php?module=news&view=news&id=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            case 'companies':
                $str_continue = ($module = isset($array_url[1])) ? $array_url[1] : '';
                if ($str_continue == 'register.html')
                    return "index.php?module=companies&view=company&task=register&Itemid=5";
                if (preg_match('#category-id([0-9]*)-city([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $str_continue, $arr)) {
                    if (isset($arr[5]))
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3] . "&page=" . @$arr[5];
                    else
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            default:
                return $url;
        }

    }

    function get_home_link()
    {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        if ($lang == 'vi') {
            return URL_ROOT;
        } else {
            return URL_ROOT . 'en';
        }
    }

    /*
     * Dịch ngang
     */
    function change_link_by_lang($lang, $link = '')
    {
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        if (!$module || ($module == 'home' && $view == 'home')) {
            if ($lang == 'en') {
//				return URL_ROOT;
            } else {
                return URL_ROOT . 'vi';
            }
        }
        switch ($module) {

            case 'contents':
                switch ($view) {
                    case 'contents':
                        $code = FSInput::get('code');
                        $record = FSRoute::trans_record_by_field($code, 'alias', 'fs_contents', $lang, 'id,alias,category_alias');
                        if (!$record)
                            return;
                        $url = URL_ROOT . FSRoute::get_name_encode('ct', $lang) . '-' . $record->alias;
                        return $url . '.html';
                        return $url;
                }
                break;
            default:
                $url = URL_ROOT . 'ce-about-digiworld';
                return $url . '.html';
        }
    }

    function get_record_by_id($id, $table_name, $lang, $select)
    {
        if (!$id)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name = $fs_table->getTable($table_name);

        $query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    /*
     * Lấy bản ghi dịch ngôn ngữ
     */
    function trans_record_by_field($value, $field = 'alias', $table_name, $lang, $select = '*')
    {
        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE " . $field . " = '" . $value . "' ";

        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $select . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getObject();
        return $rs;
    }

    /*
     * Dịch từ field -> field ( tìm lại id rồi dịch ngược)
     */
    function translate_field($value, $table_name, $field = 'alias')
    {

        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE $field = '" . $value . "' ";
        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $field . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getResult();
        return $rs;
    }
}	