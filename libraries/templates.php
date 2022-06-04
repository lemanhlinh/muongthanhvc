<?php

class Templates
{
    var $file;
    var $tmpl;
    var $variables;
    var $head_meta_key;
    var $head_meta_des;
    var $title;
    var $style = "";
    var $script_top = "";
    var $script_bottom = "";
    var $array_meta = array();
    var $arr_blocks = array();
    var $display_position = 0;
    var $title_maxlength = 100;
    var $metakey_maxlength = 300;
    var $metadesc_maxlength = 300;
    var $tmpl_name = TEMPLATE;
    var $style_amp = '';
    var $on_amp = '';

    function __construct($file = null, $tmpl = null)
    {
//	    	$global  = new FsGlobal();
        $this->load_all_block();
        global $config;
        global $head_meta_key, $head_meta_des, $title, $array_meta;
        $this->file = $file;
        $this->tmpl = $tmpl;
        $this->tmpl = $tmpl;
        //	        $this->head_meta_key = isset($config['mate_key'])?$config['mate_key']:'';
        $this->head_meta_des = isset ($config ['meta_des']) ? $config ['meta_des'] : '';
        $this->array_meta = $array_meta;
        $this->title = str_replace(chr(13), '', htmlspecialchars($title));
        // default:
        $this->style = array();
        $this->script_top = array();
        $this->script_bottom = array();
        $item_id = FSInput::get('Itemid');
//        array_push($this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/jquery.lazyloadxt.fadein.min.css" . VERSION);
//        if ($item_id != 1) {
//            array_push($this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/bootstrap.min.css" . VERSION);
//            array_push($this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/responsive.css" . VERSION);
//            array_push($this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/theme.css" . VERSION);
//            array_push($this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/font-awesome.min.css" . VERSION);
//        }else {
//            array_push($this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/bootstraphome.css" . VERSION);
//        }
//        array_push($this->script_bottom, URL_ROOT . "libraries/jquery/owlcarousel/owl.carousel.min.js" . VERSION);
//        array_push($this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/jquery.lazyloadxt.js" . VERSION);
//        array_push($this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/bootstrap.min.js" . VERSION);
//        array_push($this->script_bottom, URL_ROOT . "blocks/mainmenu/assets/js/nav.jquery.min.js" . VERSION);
//        array_push($this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/main.js" . VERSION);
//        array_push($this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/form.js" . VERSION);
        $display_position = FSInput::get('tmpl', 0, 'int');
        $this->display_position = $display_position;
    }

    function set_data_seo($data, $page = '')
    {
        $this->variables ['data_seo'] = $data;
        $this->title = $this->set_seo_auto('fields_seo_title', '|');
        if ($page) {
            $this->title = $this->title . ' trang ' . $page;
//            $page_ = ' |Trang ' . $page;
        }
        $this->head_meta_key = $this->set_seo_auto('fields_seo_keyword', '');
        $this->head_meta_des = $this->set_seo_auto('fields_seo_description', '');
    }

    function assign($key, $value)
    {
        $this->variables [$key] = $value;
    }

    function assignRef($key, &$value)
    {
        $this->variables [$key] = &$value;
    }

    function get_variables($key)
    {
        return isset ($this->variables [$key]) ? $this->variables [$key] : '';
    }

    function addStylesheet($file, $folder = "")
    {
        if ($folder == "")
            $folder_css = URL_ROOT . "templates" . "/" . TEMPLATE . "/" . "css" . "/";
        else
            $folder_css = URL_ROOT . $folder . "/";
        $path = $folder_css . $file . ".css" . VERSION;
        array_push($this->style, $path);
    }

    /*
     * H&#1087;&#1111;&#1029;m g?i nguy&#1087;&#1111;&#1029;n c? du?ng d?n
     */
    function addStylesheet2($link)
    {
        array_push($this->style, $link);
    }

    /*
     * H&#1087;&#1111;&#1029;m g?i nguy&#1087;&#1111;&#1029;n c? du?ng d?n
     */
    function addScript2($link, $position = 'bottom')
    {
        if ($position == 'top') {
            array_push($this->script_top, $link);

        } else {
            array_push($this->script_bottom, $link);
        }
    }

    function addScript($file, $folder = "", $position = 'bottom')
    {
        if ($folder == "")
            $folder_js = URL_ROOT . "templates" . "/" . TEMPLATE . "/" . "js" . "/";
        else {
            if (strpos($folder, 'http') !== false) {
                $folder_js = $folder . "/";
            } else {
                $folder_js = URL_ROOT . $folder . "/";
            }
        }
        $path = $folder_js . $file . ".js" . VERSION;

        if ($position == 'top') {
            array_push($this->script_top, $path);

        } else {
            array_push($this->script_bottom, $path);
        }
    }

    /*
         * for site uses multi template
         * get Template from Itemid in table menus_items
         */
    function getTypeTemplate($Itemid = 1)
    {
        $sql = " SELECT template
						FROM fs_menus_items AS a 
						WHERE id = '$Itemid' 
							AND published = 1 ";
        global $db;
        $db->query($sql);
        return $db->getResult();
    }

    /*
         * now die
         */
    function loadTemplate($tmpl_name = 'default')
    {
        ob_start();
        include('templates/' . $tmpl_name . "/index.php");
        ob_end_flush();
    }

    function loadMainModule()
    {

        //  message when redirect
        if (isset ($_SESSION ['msg_redirect'])) {
            $msg_redirect = @$_SESSION ['msg_redirect'];
            $type_redirect = @$_SESSION ['type_redirect'];
            if (!@$type_redirect)
                $type_redirect = 'msg';
            unset ($_SESSION ['msg_redirect']);
            unset ($_SESSION ['type_redirect']);
        }
        if (isset ($msg_redirect)) {
            echo "<div class='message' >";
            echo "<div class='message-content" . $type_redirect . "'>";
            echo $msg_redirect;
            echo "	</div> </div>";
            if (isset ($_SESSION ['have_redirect'])) {
                unset ($_SESSION ['have_redirect']);
            }
        }
        // end message when redirect


        $module = FSInput::get('module');
        if (file_exists(PATH_BASE . DS . 'modules' . DS . $module . DS . $module . '.php')) {
            require 'modules/' . $module . '/' . $module . '.php';
        }
    }

    /*
         * load Module follow position
         * type: xhtml, round,... => show around module.
         */

    function load_position($position = '', $type = '')
    {
        if ($this->display_position) {
            echo 'Position : ' . $position;
            return;
        }
        $arr_block = $this->arr_blocks;
        $block_list = isset ($arr_block [$position]) ? $arr_block [$position] : array();
        $i = 0;
        $contents = '';
        if (!count($block_list))
            return;
        foreach ($block_list as $item) {

            $content = $item->content;
            $showTitle = $item->showTitle;
            $title = $showTitle ? $item->title : '';
            $module_suffix = "";

            // load parameters
            $parameters = '';
            include_once 'libraries/parameters.php';
            $parameters = new Parameters ($item->params);
            $module_suffix = $parameters->getParams('suffix');
            $module_style = $parameters->getParams('style');
            $title = $item->title;
            $title = $item->showTitle ? $item->title : '';
            $func = 'type' . $type;

            if (method_exists('Templates', $func))
                $round = $this->$func ($title, $module_style, $item->module, $module_suffix, $i);
            else
                $round [0] = $round [1] = "";
            if ($item->module == 'contents') {
                echo $round [0];
                echo $content;
                echo $round [1];
            } else {
                if (file_exists(PATH_BASE . DS . 'blocks' . DS . $item->module . DS . 'controllers' . DS . $item->module . '.php')) {
                    ob_start();
                    include_once 'blocks/' . $item->module . '/controllers/' . $item->module . '.php';
                    $c = ucfirst($item->module) . 'BControllers' . ucfirst($item->module);
                    $controller = new $c ();
                    $controller->display($parameters, $item->title, $item->id);
                    $block_content = ob_get_contents();
                    ob_end_clean();
                    if ($block_content) {
                        echo $round [0];
                        echo $block_content;
                        echo $round [1];
                    }
                }
            }
            $i++;
        }

        return $contents;
    }

    /*
         * load direct Block , do not use database
         * this  parameters not use class Paramenters
         */
    function load_direct_blocks($module_name = '', $parameters = array())
    {
        if ($this->display_position) {
            echo 'Block : ' . $module_name;
            return;
        }
        include_once 'libraries/parameters.php';
        $parameters = new Parameters ($parameters, 'array');
        if (file_exists(PATH_BASE . 'blocks' . DS . $module_name . DS . 'controllers' . DS . $module_name . '.php')) {
            require_once 'blocks/' . $module_name . '/controllers/' . $module_name . '.php';
            $c = ucfirst($module_name) . 'BControllers' . ucfirst($module_name);
            $controller = new $c ();
            $controller->display($parameters, $module_name);
        }

        //			if(file_exists(PATH_BASE . DS . 'blocks' . DS . $module_name . DS . $module_name . '.php'))
        //				require 'blocks/'.$module_name.'/'.$module_name.'.php';
    }

    function count_block($position = '')
    {
        if ($this->display_position) {
            return 1;
        }
        $arr_block = $this->arr_blocks;
        if (!isset ($arr_block [$position]))
            return 0;
        $block_list = $arr_block [$position];
        return count($block_list);
    }

    /*
         * Load all block by Itemid
         */
    function load_all_block()
    {
        global $global_class;
        $list = $global_class->get_blocks();
        //		print_r($list);


        //		$table = FSTable::_ ( 'fs_blocks' );
        $Itemid = FSInput::get('Itemid', 1, 'int');
        //		$sql = " SELECT id,title,content, ordering, module, position, showTitle, params ,listItemid
        //						FROM " . $table . " AS a
        //						WHERE published = 1
        //							AND (listItemid = 'all'
        //							OR listItemid like '%,$Itemid,%')
        //							ORDER by ordering";
        //		global $db;
        //		$db->query ( $sql );
        //		$list = $db->getObjectList ();
        $arr_blocks = array();
        foreach ($list as $item) {
            if ($item->listItemid == 'all' || strpos($item->listItemid, ',' . $Itemid . ',') !== false) {
                $module_current = FSInput::get('module');
                $ccode = FSInput::get('ccode');
                if ($module_current == 'news' && $ccode) {
                    if (!$item->news_categories || (strpos($item->news_categories, ',' . $ccode . ',') !== false)) {
                        $arr_blocks [$item->position] [$item->id] = $item;
                    }
                } else if ($module_current == 'contents' && $ccode) {
                    if (!$item->contents_categories || (strpos($item->contents_categories, ',' . $ccode . ',') !== false)) {
                        $arr_blocks [$item->position] [$item->id] = $item;
                    }
                } else {
                    $arr_blocks [$item->position] [$item->id] = $item;
                }
            }
        }
        $this->arr_blocks = $arr_blocks;
    }

    function load_amp($on = 0, $style_body = 0, $style_custom = '', $schema = '', $link_canonical = '', $amphtml = '', $on_amp = 0)
    {
        if (!$on)
            return false;
//                var_dump($amphtml);
        $style_amp = '';
        $style_amp .= $link_canonical ? '<script async src="https://cdn.ampproject.org/v0.js"></script><script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script><link rel="canonical" href="' . $link_canonical . '" hreflang="vi-vn" />' : '';
        $style_amp .= $amphtml ? '<link rel = "amphtml" href = "' . $amphtml . '" >' : '';
        $style_amp .= $schema;
        if ($style_body == 1) {
            $style_amp .= '<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>';
        }
        $style_amp .= $style_custom ? '<style amp-custom>' . $style_custom . '</style>' : '';
        $this->style_amp = $style_amp;
        $this->on_amp = $on_amp;
    }

    function loadHeader()
    {
        global $config, $module_config, $module, $view;
        $title = $this->genarate_standart($this->title, $this->title_maxlength, isset ($module_config->sepa_seo_title) ? sepa_seo_title : ' | ', $config ['title'], $config ['main_title'], $old_sepa = '|');
        $meta_key = $this->genarate_standart($this->head_meta_key, $this->metakey_maxlength, ',', $config ['meta_key'], $config ['main_meta_key']);
        $meta_des = $this->genarate_description($this->head_meta_des, $this->metadesc_maxlength, ',', $config ['meta_des'], $config ['main_meta_des']);
        ?>
        <?php if ($this->on_amp) {
        ?>
        <!doctype html>
        <html amp lang="vi">
        <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <title><?php echo $title; ?></title>
        <meta name="keywords" content="<?php echo $meta_key; ?>"/>
        <meta name="description" content="<?php echo $meta_des; ?>"/>
        <meta name="geo.region" content="VN"/>
        <meta name="geo.placename" content="Hanoi, Vietnam"/>
        <?php echo $this->style_amp; ?>
        <link type='image/x-icon' href='<?php echo URL_ROOT . "/images/favicon.ico"; ?>' rel='icon'/>
        
    <?php } else { ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html lang="vi">
        <head id="Head1" prefix="og: http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Cache-control" content="public"/>
        <title><?php echo $title; ?></title>
        <meta name="robots" content="index,follow"/>
        <meta name="keywords" content="<?php echo $meta_key; ?>"/>
        <meta name="description" content="<?php echo $meta_des; ?>"/>
<?php if (@$this->str_header) { $str_header = str_replace(array('<p>', '</p>', '<br/>', '<br />'), '', $this->str_header); echo $str_header; } ?>
        <meta name='author' content='didongthongminh'/>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
        <?php
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=0">';
        ?>
        <link type='image/x-icon' href='<?php echo URL_ROOT . "images/favicon.ico"; ?>' rel='icon'/>
        <meta property="og:site_name" content="didongthongminh.vn"/>
        <meta property="og:type" content="website"/>
        <meta property="og:locale" content="vi_VN"/>
        <meta itemprop="description" content="<?php echo $meta_des; ?>"/>
        <link itemprop="url" href="https://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
        <meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="<?php echo $title; ?>"/>
        <meta property="og:description" content="<?php echo $meta_des; ?>"/>
<?php if ($this->get_variables('og_image')) { ?>
        <meta property="og:image" content="<?php echo $this->get_variables('og_image'); ?>"/>
<?php }if ($this->get_variables('canonical')): ?>
        <link rel="canonical" href="<?php echo $this->get_variables('canonical'); ?>"  hreflang="vi-vn"/>
<?php endif ?>
        <meta name="distribution" content="Global"/>
        <meta name="RATING" content="GENERAL"/>
        <meta name="Googlebot" content="index,follow"/>
        <meta name="geo.region" content="VN"/>
        <?php
        global $config;
        $array_meta = $this->array_meta;
        if ($array_meta != null) {
            for ($i = 0; $i < count($array_meta); $i++) {
                $item = $array_meta [$i];
                $type = $item [0];
                $content = $item [1];
                if ($type == 'og:image') {
                    echo '<meta property=\'' . $type . '\' content=\'' . $content . '\' />' . "\n";
                } else {
                    echo '<meta name=\'' . $type . '\' content=\'' . $content . '\' />' . "\n";
                }
            }
        }

        $arr_style = array_unique($this->style);

        if (!COMPRESS_CSS) {
            if (count($arr_style)) {
                foreach ($arr_style as $item) {
                    echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"$item\" /> ";
                }
            }
        } else {
            echo
            $this->compress_css($arr_style);
        }
        ?>
        <link rel="alternate" type="application/rss+xml" title="<?php echo $config ['site_name'] ?> Feed" href="<?php echo URL_ROOT; ?>rss.xml"/>
    <?php } ?>
    </head>
        <body>
    <?php }

    function loadFooter()
    {
        $arr_script_bottom = array_unique($this->script_bottom);
        $arr_script_top = $this->script_top;
        $arr_script_bottom = array_diff_assoc($arr_script_bottom, $arr_script_top);
        if (!COMPRESS_JS) {
            if (count($arr_script_bottom)) {
                foreach ($arr_script_bottom as $item) {
                    echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\" ></script>";
                }
            }
        } else {
            echo $this->compress_js($arr_script_bottom);
        }
    }

    function typeRound($module_suffix = '', $special_class = '')
    {
        $class = 'blocks' . $module_suffix . ' blocks' . $special_class;
        // head
        $html [] = "<div class='$class'><div><div>";
        $html [] = "</div></div></div>";
        return $html;
    }

    function typeXHTML($title = '', $module_suffix = '', $module_name = 'contents', $special_class = '', $id = '')
    {
        $class = 'block_' . $module_name . ' ' . $module_name . '_' . $special_class . ' blocks' . $module_suffix . ' blocks' . $special_class;
        $attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
        // head
        $str_top = "<div class='$class block' " . $attr_id . ">";
        if ($title)
            $str_top .= '<div class="block_title"><span>' . $title . '</span></div>';
        $html [] = $str_top;
        $html [] = "</div>";
        return $html;
    }

    function typeXHTML2($title = '', $module_style = '', $module_name = 'contents', $module_suffix = '', $id = '')
    {
        $class = 'block_' . $module_name . ' ' . $module_name . '-' . $module_style . ' ' . $module_name . '_' . $module_suffix;
        $attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
        // head
        $str_top = "<div class='$class block' " . $attr_id . ">";
        if ($title)
            $str_top .= '<h2 class="block_title"><span>' . $title . '</span></h2>';
        $html [] = $str_top;
        $html [] = "</div>";
        return $html;
    }

    function type3Block($title = '', $module_suffix = '', $special_class = '', $id = '')
    {
        $class = 'blocks' . $module_suffix . ' blocks ' . $special_class;
        if ($id % 3 == 0) {
            $class .= ' column_l';
        } else if ($id % 3 == 1) {
            $class .= ' column_c';
        } else {
            $class .= ' column_r';
        }
        // head
        $str_top = "<div class='$class one-column'><div class ='blocks_content'>";
        if ($title)
            $str_top .= '<h2 class="block_title"><span>' . $title . '</span></h2>';
        $html [] = $str_top;
        $html [] = "</div><div class='clear'></div></div>";
        return $html;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    function addTitle($title, $pos = 'pre')
    {
        // 65 characters,  15 words.
        if ($pos != 'pre') {
            $this->title = $this->title ? $this->title . '|' . $title : $title;
        } else {
            $this->title = $this->title ? $title . '|' . $this->title : $title;
        }
    }

    function addHeader($str, $check_exist = 0)
    {
        if ($check_exist) {
            if (mb_strpos($this->str_header, $str) === false) {
                $this->str_header .= $str;
            }
        } else {
            $this->str_header .= $str;
        }

    }

    function addFooter($str)
    {
        $this->str_footer = $str;
    }

    function genarate_standart($str, $max_length, $sepa = ',', $default, $suffix = '', $old_sepa = ',')
    {
        if (!$str) {
            return htmlspecialchars($default);
        }
        $arr = explode($old_sepa, $str);
        if (!$arr) {
            return htmlspecialchars($default);
        }
        $rs = '';
        for ($i = 0; $i < count($arr); $i++) {
            $item = trim($arr [$i]);
            if (!$i) {
                $rs .= $item;
            } else {
                if (mb_strlen($rs, 'UTF-8') + strlen($sepa) + mb_strlen($item, 'UTF-8') > $max_length) {
                    return htmlspecialchars($rs);
                } else {
                    $rs .= $sepa . $item;
                }
            }
        }
        if ($suffix) {
            if (mb_strlen($rs, 'UTF-8') + strlen($sepa) + mb_strlen($default, 'UTF-8') > $max_length) {
                return htmlspecialchars($rs);
            } else {
                $rs .= $sepa . $suffix;
            }
        }
        return htmlspecialchars($rs);
    }

    function genarate_description($str, $max_length, $sepa = ',', $default, $suffix = '', $old_sepa = ',')
    {
        if (!$str) {
            $meta_desc = $default;
        } else {
            if (mb_strlen($str, 'UTF-8') < 140)
                $meta_desc = $str . $sepa . $suffix;
            else
                $meta_desc = $str;
        }
        $meta_desc = get_word_by_length($max_length, $meta_desc);
        return htmlspecialchars($meta_desc);
    }

    function setMetakey($meta_key)
    {
        $this->head_meta_key = $meta_key;
    }

    function setMetades($meta_des)
    {
        $this->head_meta_des = $meta_des;
    }
    // pos: end , begin
    // character: lower
    // $auto_calculate: not use this param
    function addMetakey($meta_key, $pos = 'end', $auto_calculate = 1)
    {
        $meta_key = trim(mb_strtolower($meta_key, 'UTF-8'));
        if ($pos != 'pre') {
            $this->head_meta_key = $this->head_meta_key ? $this->head_meta_key . ',' . $meta_key : $meta_key;
        } else {
            $this->head_meta_key = $this->head_meta_key ? $meta_key . ',' . $this->head_meta_key : $meta_key;
        }
    }

    // pos: end , begin
    function addMetades($meta_des, $pos = 'pre')
    {
        $meta_des = trim(mb_strtolower($meta_des, 'UTF-8'));
        if ($pos != 'pre') {
            $this->head_meta_des = $this->head_meta_des ? $this->head_meta_des . ',' . $meta_des : $meta_des;
        } else {
            $this->head_meta_des = $this->head_meta_des ? $meta_des . ',' . $this->head_meta_des : $meta_des;
        }
    }

    function setMeta($type, $content)
    {

        $array_meta = isset ($this->array_meta) ? $this->array_meta : array();
        $new_meta = array();
        $new_meta [0] = $type;
        $new_meta [1] = $content;
        $array_meta [] = $new_meta;
        $this->array_meta = $array_meta;
    }

    function get_background()
    {
        $sql = " SELECT *
						FROM fs_backgrounds AS a 
						WHERE is_default = 1 
							AND published = 1 ";
        global $db;
        $db->query($sql);
        return $db->getObject();
    }

    function set_title_auto()
    {
        $data_seo = $this->get_variables('data_seo');
        if (!$data_seo)
            return;
        global $module_config;
        $fields_seo = isset ($module_config->fields_seo_title) ? $module_config->fields_seo_title : '';
        if (!$fields_seo)
            return;
        $arr_fields_seo_title = explode('|', $fields_seo);
        $title = array();

        foreach ($arr_fields_seo_title as $data_field_item) {
            $arr_buffer_data_field_item = explode(',', $data_field_item); // array(c?nugate,field_name)
            $field_conjugate = isset ($arr_buffer_data_field_item [0]) ? $arr_buffer_data_field_item [0] : 0;
            $field_name = isset ($arr_buffer_data_field_item [1]) ? $arr_buffer_data_field_item [1] : '';
            $value = isset ($data_seo->$field_name) ? $data_seo->$field_name : '';
            if (!$value)
                continue;
            if ($field_conjugate) {
                $title [] = $value;
            } else {
                if (!$title)
                    $title [] = $value;
            }
        }
        $title = implode('|', $title);
        $this->setTitle($title);
        return $title;
    }

    function set_seo_auto($config_field = 'fields_seo_title', $sepa)
    {
        $data_seo = $this->get_variables('data_seo');
        if (!$data_seo)
            return;
        global $module_config;
        $fields_seo = isset ($module_config->$config_field) ? $module_config->$config_field : '';
        if (!$fields_seo)
            return;
        // echo 1;
        $arr_fields_seo_title = explode('|', $fields_seo);
        $rs = array();

        foreach ($arr_fields_seo_title as $data_field_item) {
            $arr_buffer_data_field_item = explode(',', $data_field_item); // array(c?nugate,field_name)
            $field_conjugate = isset ($arr_buffer_data_field_item [0]) ? $arr_buffer_data_field_item [0] : 0;
            $field_name = isset ($arr_buffer_data_field_item [1]) ? $arr_buffer_data_field_item [1] : '';
            $value = isset ($data_seo->$field_name) ? $data_seo->$field_name : '';
            if (!$value)
                continue;
            if ($field_conjugate == 1) { // ADD
                $rs [] = $value;
            } else {
                if (!count($rs))
                    $rs [] = $value;
            }
        }
        $rs = implode($sepa, $rs);
        //			$this -> setMetakey($rs);
        return $rs;
    }

    function set_seo_special($page = '')
    {
        global $module_config;
        $this->title = FSText::_(@$module_config->value_seo_title);
        $this->head_meta_des = FSText::_(@$module_config->value_seo_description);

        if ($page) {
            $this->title = $this->title . ' trang ' . $page;
            $this->head_meta_des = FSText::_(@$module_config->value_seo_description) . ' trang ' . $page;
        }


        $this->head_meta_key = FSText::_(@$module_config->value_seo_keyword);
    }

    /*
     * N&#1087;&#1111;&#1029;n nhi?u file js l?i th&#1087;&#1111;&#1029;nh 1 file
     */
    public static function compress_js($array_js)
    {
        $contents = '';
        $fsCache = FSFactory::getClass('FSCache');
        $key = '';
        foreach ($array_js as $file) {
            if ($key)
                $key .= ';';
            $key .= $file;
        }
        $key = md5($key);
        if (CACHE_ASSETS) {
            // Ki?m tra xem file cache n&#1087;&#1111;&#1029;y c&#1087;&#1111;&#1029;n ho?t d?ng kh&#1087;&#1111;&#1029;ng
            $check_cache_activated = $fsCache->check_activated($key, 'js/', CACHE_ASSETS, '.js');
            if ($check_cache_activated) {
                echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\"></script>";
            } else {
                foreach ($array_js as $file) {
                    if ($contents)
                        $contents .= ';';
                    $contents .= file_get_contents($file);
                }
                $fsCache->put($key, $contents, 'js/', '.js');
                echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\"></script>";
                FSFactory::include_class('jsmin');
                $minified = JSMin::minify($contents);
                $fsCache->put($key, $minified, 'js/');
            }
        } else {
            foreach ($array_js as $file) {
                if ($contents)
                    $contents .= ';';
                $contents .= file_get_contents($file);
            }
            FSFactory::include_class('jsmin');
            $minified = JSMin::minify($contents);
            $fsCache->put($key, $minified, 'js/', '.js');
            echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\"></script>";
        }
    }

    /*
     * N&#1087;&#1111;&#1029;n nhi?u file css l?i th&#1087;&#1111;&#1029;nh 1 file
     */
    public static function compress_only_css($array_css)
    {
        $contents = '';
        $fsCache = FSFactory::getClass('FSCache');
        $key = '';
        foreach ($array_css as $file) {
            if ($key)
                $key .= ';';
            $key .= $file;
        }
        $key = md5($key);

        foreach ($array_css as $file) {
            if ($contents)
                $contents .= '';
            $content_css = file_get_contents($file);
            if (strpos($file, URL_ROOT) !== false) {
                $pos = strpos($file, '/css/');
                if ($pos !== false) {
                    $path_base_file = substr($file, 0, $pos);
                    $content_css = str_replace('../images/', $path_base_file . '/images/', $content_css);
                }
            }
            $contents .= $content_css;
        }

        echo "<style>" . $contents . "</style>";
    }


    /*
     * N&#1087;&#1111;&#1029;n nhi?u file css l?i th&#1087;&#1111;&#1029;nh 1 file
     */
    public static function compress_css($array_css)
    {

        $contents = '';
        $fsCache = FSFactory::getClass('FSCache');
        $key = '';
        foreach ($array_css as $file) {
            if ($key)
                $key .= ';';
            $key .= $file;
        }
        $key = md5($key);
        if (CACHE_ASSETS) {

            // Ki?m tra xem file cache n&#1087;&#1111;&#1029;y c&#1087;&#1111;&#1029;n ho?t d?ng kh&#1087;&#1111;&#1029;ng
            $check_cache_activated = $fsCache->check_activated($key, 'css/', CACHE_ASSETS, '.css');
            if ($check_cache_activated) {
                echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
            } else {
                foreach ($array_css as $file) {
                    if ($contents)
                        $contents .= '';
                    $content_css = file_get_contents($file, false, stream_context_create(array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    )));
                    $contents .= file_get_contents($file, false, stream_context_create(array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    )));
                    if (strpos($file, URL_ROOT) !== false) {
                        $pos = strpos($file, '/css/');
                        if ($pos !== false) {
                            $path_base_file = substr($file, 0, $pos);
                            $content_css = str_replace('../images/', $path_base_file . '/images/', $content_css);
                        }
                    }
                    $contents .= $content_css;
                }
                $fsCache->put($key, $contents, 'css/', '.css');
                echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";

                FSFactory::include_class('cssmin', 'minifier/');
                $filters = array(
                    "ImportImports" => false,
                    "RemoveComments" => true,
                    "RemoveEmptyRulesets" => true,
                    "RemoveEmptyAtBlocks" => true,
                    "ConvertLevel3AtKeyframes" => false,
                    "ConvertLevel3Properties" => false,
                    "Variables" => true,
                    "RemoveLastDelarationSemiColon" => true
                );
                $minified = CssMin::minify($contents, $filters);
                $fsCache->put($key, $minified, 'css/');
            }
        } else {
            foreach ($array_css as $file) {
                if ($contents)
                    $contents .= '';
                $content_css = file_get_contents($file);
                if (strpos($file, URL_ROOT) !== false) {
                    $pos = strpos($file, '/css/');
                    if ($pos !== false) {
                        $path_base_file = substr($file, 0, $pos);
                        $content_css = str_replace('../images/', $path_base_file . '/images/', $content_css);
                    }
                }
                $contents .= $content_css;
            }
            FSFactory::include_class('cssmin', 'minifier/');
            $minified = CssMin::minify($contents);
            $fsCache->put($key, $minified, 'css/', '.css');
            echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";

        }
    }

    function load_result_e($string, $k)
    {
        $k = sha1($k);
        $strLen = strlen($string);
        $kLen = strlen($k);
        $j = 0;
        $hash = '';
        for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($string, $i, 1));

            if ($j == $kLen) {
                $j = 0;
            }
            $ordKey = ord(substr($k, $j, 1));
            $j++;
            $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
        }
        return $hash;
    }
}

?>