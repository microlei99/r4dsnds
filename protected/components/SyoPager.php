<?php
class SyoPager extends CBasePager
{

    public $baseUrl;
    /**
     * @var string the text label for the next page button. Defaults to 'Next &gt;'.
     */
    public $nextPageLabel;
    /**
     * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
     */
    public $prevPageLabel;
    /**
     * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
     */
    public $firstPageLabel;
    /**
     * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
     */
    public $lastPageLabel;

    public $htmlOptions;
    public $header='';
    public $maxButtonCount=10;
    const CSS_FIRST_PAGE='first';
    const CSS_LAST_PAGE='last';
    const CSS_PREVIOUS_PAGE='prenext';
    const CSS_NEXT_PAGE='prenext';
    const CSS_INTERNAL_PAGE='';
    const CSS_HIDDEN_PAGE='hidden';
    const CSS_SELECTED_PAGE='current';




    public function init()
    {

        if($this->nextPageLabel===null)
            $this->nextPageLabel=Yii::t('yii','&raquo;');
        if($this->prevPageLabel===null)
            $this->prevPageLabel=Yii::t('yii','&laquo;');
        if($this->firstPageLabel===null)
            $this->firstPageLabel=Yii::t('yii','&laquo; First');
        if($this->lastPageLabel===null)
            $this->lastPageLabel=Yii::t('yii','Last &gt;&raquo;');
        if($this->header===null)
            $this->header='<span class="pages">Page 1 of 1</span>';

        if(!isset($this->htmlOptions['id']))
            $this->htmlOptions['id']=$this->getId();
        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='pagenavi fr';

    }

    public function run()
    {

        $buttons=$this->createPageButtons();

        if(empty($buttons))
            return;
        echo $this->header;
        echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));

    }

    protected function createPageButtons()
    {
        if(($pageCount=$this->getPageCount())<=1)
            return array();


        list($beginPage,$endPage)=$this->getPageRange();
        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()

        $buttons=array();

        $curr=$currentPage+1;
        //page of
        $buttons[]="<span class='pages'>{$curr} Page of {$this->getPageCount()}</span>";

        // first page
        $buttons[]=$this->createPageButton('First',0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

        // prev page
        if(($page=$currentPage-1)<0)
            $page=0;
        $buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

        // internal pages
        for($i=$beginPage;$i<=$endPage;++$i)
            $buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

        // next page
        if(($page=$currentPage+1)>=$pageCount-1)
            $page=$pageCount-1;
        $buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

        // last page
        $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

        return $buttons;



    }

    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if($hidden || $selected)
            $class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
        if(!$selected)
        {
            return CHtml::link($label,$this->createPageUrl($page),array('class'=>$class));
        }
        else
        {
            return " <span class='{$class}' title='{$page}'>{$label}</span>\n";
        }
    }

    protected function getPageRange()
    {
        $currentPage=$this->getCurrentPage();
        $pageCount=$this->getPageCount();

        $beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));
        if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
        {
            $endPage=$pageCount-1;
            $beginPage=max(0,$endPage-$this->maxButtonCount+1);
        }
        return array($beginPage,$endPage);
    }

    protected function createPageUrl($page)
    {
        $page_code=$page+1;
        if($page!=0)
        {
            return $this->baseUrl . '/'.$page_code;
        }
        else
        {
            return $this->baseUrl;
        }
    }
}

?>
