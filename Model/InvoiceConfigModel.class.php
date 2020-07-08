<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2018/5/23
 * Time: 10:37
 */

namespace Invoice\Model;

use Common\Model\RelationModel;

class InvoiceConfigModel extends RelationModel {

    protected $tableName = 'invoice_config';

    /**
     * 关联表
     *
     * @var array
     */
    protected $_link = array();


    /**
     * 数据校验
     * @param array $post
     * @return array
     */
    public function checkData($post = []){
        if(!$post['xsf_nsrsbh']) return createReturn(false,'','销售方纳税人识别号不能为空');
        if(!$post['xsf_mc']) return createReturn(false,'','销售方名称不能为空');
        if(!$post['xsf_dzdhxsf']) return createReturn(false,'','销售方地址、电话不能为空');
        if(!$post['xsf_yhzh']) return createReturn(false,'','销售方银行账号不能为空');
        if(!$post['xsf_lxfs']) return createReturn(false,'','销售方移动电话或邮箱不能为空');
        if(!$post['kpr']) return createReturn(false,'','开票人不能为空');
        if(!$post['sl']) return createReturn(false,'','税率不能为空');

        $content['xsf_nsrsbh'] = $post['xsf_nsrsbh'];
        $content['xsf_mc'] = $post['xsf_mc'];
        $content['xsf_dzdhxsf'] = $post['xsf_dzdhxsf'];
        $content['xsf_yhzh'] = $post['xsf_yhzh'];
        $content['xsf_lxfs'] = $post['xsf_lxfs'];
        $content['kpr'] = $post['kpr'];
        $content['sl'] = $post['sl'];
        $content['edit_time'] = time();

        return createReturn(true,$content,'校验成功');
    }
}