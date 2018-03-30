<?php 
//pr($paginatorArr);
$paginatorArr = $this->Paginator->params();
if($paginatorArr['pageCount']>1){
?>
<div class="paginator">
    <ul class="pagination centerPaginate">
        <?php 
            echo $this->Paginator->params['count'];
            echo $this->Paginator->first(' << ');
            echo $this->Paginator->prev('Prev');
            echo $this->Paginator->numbers();
            echo $this->Paginator->next('Next');
            echo $this->Paginator->last(' >> ');
        ?>
    </ul>
</div>
<?php }?>
