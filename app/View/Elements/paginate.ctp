<?php 
$currentModel = isset($model)?$model:$this->Paginator->defaultModel();
$pagingParams = $this->Paginator->params($currentModel);

if($pagingParams['pageCount'] > 1):?>
<ul class="pagination" id="<?php if(isset($id)):echo $id;else:echo strtolower($currentModel).'Pager';endif;?>">
<?php 
    echo $this->Paginator->prev('&laquo;',array('escape'=>false,'tag'=>'li','disabledTag'=>'a'), null, array('escape'=>false,'tag'=>'li','class' => 'inactive','disabledTag'=>'a'));
    echo $this->Paginator->numbers(array('separator'=>"",'tag'=>'li','currentClass'=>'active','currentTag'=>'a','model'=>$currentModel)); 
	echo $this->Paginator->next('&raquo;',array('escape'=>false,'tag'=>'li'), null, array('escape'=>false,'tag'=>'li','class' => 'inactive','disabledTag'=>'a'));?>
</ul>
<?php endif;?>
