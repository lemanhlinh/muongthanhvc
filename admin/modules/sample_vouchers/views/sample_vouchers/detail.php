<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'name',@$data -> name);
	TemplateHelper::dt_edit_selectbox(FSText::_('Loại voucher'),'type_voucher_id',@$data->type_voucher_id,0,TYPE_VOUCHER);
	TemplateHelper::dt_edit_file('File','file',@$data->file,'.pdf');
	TemplateHelper::dt_edit_image('Image','image',str_replace('/original/', '/resized/', URL_ROOT . @$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	$this -> dt_form_end(@$data,1,0);

?>
