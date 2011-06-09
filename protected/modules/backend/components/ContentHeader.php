<?php
Yii::import('zii.widgets.CPortlet');
class ContentHeader extends CPortlet
{
    public $active=0;
    public $htmlOption=array();

    protected function renderContent()
    {
        $this->htmlOption = $this->controller->htmlOption;
        echo ' <table cellspacing="0">              <tr>';

        if(isset($this->htmlOption['class']))
            echo " <td><h3 class='{$this->htmlOption['class']}'>";
        else
            echo " <td><h3 class='head-dashboard'>";

        if(isset($this->htmlOption['header']))
            echo $this->htmlOption['header'] . '</h3></td>';
        else
            echo 'Dashboard</h3></td>';

        if(isset($this->htmlOption['button']) && is_array($this->htmlOption['button']))
        {
            echo '<td class="a-right">';
            foreach ($this->htmlOption['button'] as $item)
            {
                if(isset($item['click']))
                    echo   "<button class='{$item['class']}' type='button' id='{$item['id']}' onclick=\"{$item['click']}\"><span>{$item['header']}</span></button>";
                else
                   echo   "<button class='{$item['class']}' type='button' id='{$item['id']}'\"><span>{$item['header']}</span></button>";
            }

            echo '</td>';
        }
        echo ' </tr></table>';
    }
}
