<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('User list') );
//	$toolbar->addButton('add',FSText :: _('Add'),'','add.png');
	//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    $filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;
//	ơhongban
$filter_position = array();
$filter_position['title'] = FSText::_('Phòng ban');
if (!empty($task)){
    if ($task == 'list_group_1'){
        $filter_position['list'] = POSITION_GROUP_1;
        $params = ['task' => 'list_group_1'];
    }else if ($task == 'list_group_2'){
        $filter_position['list'] = POSITION_GROUP_2;
        $params = ['task' => 'list_group_2'];
    }
}else{
    $params = ['task' => 'list_group_1'];
}
$fitler_config['filter'][] = $filter_position;

$list_config[] = array('title'=>'Username','field'=>'username', 'type'=>'text','col_width' => '20%','align'=>'left');
    //$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/small/','width'=>'30'));
//    $list_config[] = array('title'=>'Email','field'=>'email', 'type'=>'text','col_width' => '20%','align'=>'left');
    $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>'Nhóm','field'=>'group_company','type'=>'text_status', 'arr_params'=>GROUP_COMPANY );
    if (!empty($task)){
        if ($task == 'list_group_1'){
            $list_config[] = array('title'=>'Phòng ban','field'=>'position_group','type'=>'text_status', 'arr_params'=>POSITION_GROUP_1);
        }else if ($task == 'list_group_2'){
            $list_config[] = array('title'=>'Phòng ban','field'=>'position_group','type'=>'text_status', 'arr_params'=>POSITION_GROUP_2);
        }
    }

//	$list_config[] = array('title'=>'Phân quyền','type'=>'view','module'=>'users','view'=>'users','task'=>'permission','field_value'=>'cid');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
    
    TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination,$params);
?>