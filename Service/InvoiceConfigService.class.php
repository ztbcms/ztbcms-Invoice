<?php

namespace Invoice\Service;

use Invoice\Model\InvoiceConfigModel;
use System\Service\BaseService;
use Invoice\Libs\Bwfapiao;

class InvoiceConfigService extends BaseService
{

    /**
     * 获取列表信息
     * @param array $where
     * @param string $order
     * @param int $page
     * @param int $limit
     * @return array
     */
    static function getInvoiceConfigList($where = [],$order = '',$page = 1,$limit = 20){
        $where['is_delete'] = 0;
        $res = self::select('invoice_config',$where,$order,$page,$limit);
        return $res;
    }

    /**
     * 获取详情信息
     * @param int $id
     * @return mixed
     */
    static function getInvoiceConfigDetails($id = 0){
        $res = self::find('invoice_config',['id'=>$id]);
        return $res;
    }

    /**
     * 添加或者滨技详细信息
     * @param array $post
     * @return array
     */
    static function addEditCofing($post = []){
        $InvoiceConfigModel = new InvoiceConfigModel();
        $checkRes = $InvoiceConfigModel->checkData($post);
        if(!$checkRes['status']) return $checkRes;
        $content = $checkRes['data'];
        $id = $post['id'];
        if($id) {
            $InvoiceConfigModel->where(['id'=>$id])->save($content);
        } else {
            $content['is_delete'] = 0;
            $content['add_time'] = time();
            $id = $InvoiceConfigModel->add($content);
        }
        return createReturn(true,['id' => $id],'操作成功');
    }

    /**
     * 发送测试数据
     * @param int $cofing_id
     * @param array $order
     * @param string $gmf_mc
     * @param string $gmf_lxfs
     * @return array|bool
     */
    static function sendInvoice($cofing_id = 0,$order = [],$gmf_mc = '',$gmf_lxfs = ''){

        $InvoiceConfigModel = new InvoiceConfigModel();
        $confing = $InvoiceConfigModel->where(['id'=>$cofing_id])
            ->field('xsf_nsrsbh,xsf_mc,xsf_dzdhxsf,xsf_yhzh,xsf_lxfs,kpr,sl')
            ->find();

        $Bwfapiao = new Bwfapiao();
        $res = $Bwfapiao->sendInvoiceAll($confing,$order,$gmf_mc,$gmf_lxfs);
        return $res;
    }

}