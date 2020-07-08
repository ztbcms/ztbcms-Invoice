<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2018/5/23
 * Time: 10:37
 */

namespace Invoice\Model;

use Common\Model\RelationModel;

class InvoiceLogModel extends RelationModel
{

    protected $tableName = 'invoice_log';

    /**
     * 关联表
     *
     * @var array
     */
    protected $_link = array();


}