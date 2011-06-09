<div id="attributeGrid">
    <?php
    $this->widget('TradeGrid', array(
        'dataProvider' => $model->search(),
        'filter' => $model,
        'htmlOptions' => array(
            'class' => 'hor-scroll',
        ),
        'columns' => array(
            array(
                'header' => '客户ID',
                'name' => 'customer_id',
                'filter' => false,
            ),
            array(
                'header' => 'Email',
                'name' => 'customer_email',
                'type' => 'raw',
                'value' => 'CHtml::link($data->customer_email,"/backend/customer/update/id/".$data->customer_id)',
            ),
            array(
                'header' => '客户组',
                'name' => 'customer_group',
                'value' => '$data->group->group_name',
                'filter' => CustomerGroup::items(),
            ),
            array(
                'header' => '订阅',
                'name' => 'customer_newsletter',
                'filter' => array(1 => 'Yes', 0 => 'No'),
            ),
            array(
                'header' => '状态',
                'name' => 'customer_active',
                'filter' => array(1 => 'Yes', 0 => 'No'),
            ),
            array(
                'header' => '角色',
                'name' => 'customer_role',
                'value' => '$data->lookup->lookup_code',
                'filter' => Lookup::items('customer_role'),
            ),
            array(
                'header' => 'IP',
                'name' => 'customer_ip',
            ),
            array(
                'header' => '登陆时间',
                'name' => 'customer_login',
                'value' => 'date(\'Y-m-j H:i:s\',strtotime($data->customer_login))',
                'filter' => false,
            ),
            array(
                'header' => '登陆次数',
                'name' => 'customer_visit_count',
                'filter' => false,
            ),
            array(
                'header' => '最后更新',
                'name' => 'customer_last_update',
                'filter' => false,
            ),
            array(
                'header' => '创建时间',
                'name' => 'customer_create_at',
                'filter' => false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}{update} {delete}',
                'viewButtonLabel'=>'统计信息',
            ),
        )
    ));
    ?>
</div>