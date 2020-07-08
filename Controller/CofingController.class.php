<?php

namespace Invoice\Controller;

use Common\Controller\AdminBase;
use Invoice\Service\InvoiceConfigService;

class CofingController extends AdminBase
{

    /**
     * 发票列表
     */
    public function cofingList()
    {
        if (IS_AJAX) {
            $page = I('page', '1', 'trim');
            $limit = I('limit', '20', 'trim');
            $res = InvoiceConfigService::getInvoiceConfigList([], 'id desc', $page, $limit);
            $this->ajaxReturn($res);
        } else {
            $this->display();
        }
    }

    /**
     * 发票详情
     */
    public function cofingDetails()
    {
        if (IS_AJAX) {
            $id = I('id', '', 'trim');
            $res = InvoiceConfigService::getInvoiceConfigDetails($id);
            $this->ajaxReturn($res);
        } else {
            $this->display();
        }
    }

    /**
     * 添加或者编辑发票信息
     */
    public function addEditCofing()
    {
        $post = I('post.');
        $res = InvoiceConfigService::addEditCofing($post);
        $this->ajaxReturn($res);
    }

    /**
     * 公共修改
     */
    public function updateTable()
    {
        $table = I('table', '', 'trim'); //表
        $field = I('field', '', 'trim'); //字段
        $value = I('value', '', 'trim'); //值
        $where_name = I('where_name', 'trim'); //条件名称
        $where_value = I('where_value', '', 'trim'); //添加的内容
        $save[$field] = $value;
        $where[$where_name] = $where_value;
        M($table)->where($where)->save($save);
        $this->ajaxReturn(self::createReturn(true, '', '保存成功'));
    }

    /**
     * 发送测试数据
     */
    public function sendInvoice()
    {
        if(IS_AJAX) {
            $cofing_id = I('cofing_id','','trim');
            $order = I('order','','trim');
            $gmf_mc = I('gmf_mc','','trim');
            $gmf_lxfs = I('gmf_lxfs','','trim');
            $res = InvoiceConfigService::sendInvoice($cofing_id,$order,$gmf_mc,$gmf_lxfs);
            $this->ajaxReturn($res);
        } else {
            $this->display();
        }
    }

}