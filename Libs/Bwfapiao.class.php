<?php

namespace Invoice\Libs;

use Invoice\Model\InvoiceLogModel;


class Bwfapiao
{
    /**
     * 基础配置
     */
    static function confInfo()
    {
        $res['url'] = 'http://kptest.kaipiaoba.cn/bwkp/xzkp';
        return $res;
    }

    /**
     * 发送发票设置
     * @param $invoiceFind
     * @param $invoiceOrderList
     * @return array|bool
     */
    public function sendInvoiceAll($confing = [],$order = [],$gmf_mc = '',$gmf_lxfs = ''){

        if(!$confing['xsf_nsrsbh']) return createReturn(false,'','对不起，销售方纳税人识别号不能为空');
        if(!$confing['xsf_mc']) return createReturn(false,'','对不起，销售方名称不能为空');
        if(!$confing['xsf_dzdhxsf']) return createReturn(false,'','对不起，销售方地址、电话不能为空');
        if(!$confing['xsf_yhzh']) return createReturn(false,'','对不起，销售方银行账号不能为空');
        if(!$confing['xsf_lxfs']) return createReturn(false,'','对不起，销售方移动电话或邮箱不能为空');
        if(!$confing['kpr']) return createReturn(false,'','对不起，开票人不能为空');
        if(!$confing['sl']) return createReturn(false,'','对不起，税率不能为空');
        if(!$gmf_mc) return createReturn(false,'','对不起，购买人姓名不能为空');
        if(!$gmf_lxfs) return createReturn(false,'','对不起，购买人邮箱不能为空');


        //税率（固定为0.03）
        $SL =$confing['sl'];
        if(!$order) return createReturn(false,'','对不起，订单商品不能为空');

        //合计金额
        $JSHJ = 0;
        $HJJE = 0;
        $HJSE = 0;
        $newOrderList = [];
        $orderCount = 0;
        foreach ($order as $k => $v){
            $success_amount = $v['xmsl'] * $v['xmdj'];
            $newOrderList[$k]['XMSL'] = $v['xmsl'];
            $newOrderList[$k]['XMDJ'] = round($v['xmdj'] / (1 + $SL),2);
            $newOrderList[$k]['XMJE'] = round($newOrderList[$k]['XMDJ'] * $v['xmsl'],2);
            $newOrderList[$k]['SL'] = $SL;
            $newOrderList[$k]['SE'] = $success_amount - $newOrderList[$k]['XMJE'];
            $newOrderList[$k]['XMMC'] = $v['xmmc'];
            $newOrderList[$k]['SPBM'] = $v['spbm'];
            $newOrderList[$k]['DW'] = $v['dw'];

            $JSHJ += $newOrderList[$k]['XMJE'];
            $JSHJ += $newOrderList[$k]['SE'];

            $HJJE += $newOrderList[$k]['XMJE'];
            $HJSE += $newOrderList[$k]['SE'];
            $orderCount += 1;
        }

        $order_sn = $this->generateOrderSn();

        $info = self::confInfo();
        $FPXML =
            '<?xml version="1.0" encoding="gbk"?>
        <business id="FPKJ" comment="发票开具">
        <REQUEST_COMMON_FPKJ class="REQUEST_COMMON_FPKJ">
        <COMMON_FPKJ_FPT class="COMMON_FPKJ_FPT">
            <FPQQLSH>'.$order_sn.'</FPQQLSH> //发票请求流水号
            <KPLX>0</KPLX>   // 0-蓝字发票；1-红字发票
            <TSPZ>00</TSPZ>  // 特殊票种  00 普通发票 
            <XSF_NSRSBH>' . $confing['xsf_nsrsbh'] . '</XSF_NSRSBH>
            <XSF_MC>' . $confing['xsf_mc'] . '</XSF_MC>
            <XSF_DZDH>'.$confing['xsf_dzdhxsf'].'</XSF_DZDH>  //销售方电话号码
            <XSF_YHZH>'.$confing['xsf_yhzh'].'</XSF_YHZH>  //销售方银行卡账号
            <XSF_LXFS>'.$confing['xsf_lxfs'].'</XSF_LXFS>  //销售方移动电话或邮箱
            <GMF_NSRSBH></GMF_NSRSBH> //购买方纳税人识别号 （非必填）
            <GMF_MC>'.$gmf_mc.'</GMF_MC> //购买方名称
            <GMF_DZDH></GMF_DZDH> //购买方地址、电话（非必填）
            <GMF_YHZH></GMF_YHZH> //购买方银行账号（非必填）
            <GMF_LXFS>'.$gmf_lxfs.'</GMF_LXFS> //购买方移动电话或邮箱
            <KPR>'.$confing['kpr'].'</KPR> //开票人
            <SKR></SKR> //收款人 （非必填）
            <FHR></FHR> //复核人 （非必填）
            <YFP_DM></YFP_DM> //原发票代码 红字发票时必须
            <YFP_HM></YFP_HM> //原发票号码 红字发票时必须
            <JSHJ>'.$JSHJ.'</JSHJ> // 价税合计 单位：元（2位小数）
            <HJJE>'.$HJJE.'</HJJE> // 合计金额 不含税，单位：元（2位小数）
            <HJSE>'.$HJSE.'</HJSE> // 合计税额 单位：元（2位小数） 
            <BZ></BZ> //备注
            <BMB_BBH>10.0</BMB_BBH> //当version=2.0时必须有此值
        </COMMON_FPKJ_FPT>';

        $FPXML .= "<COMMON_FPKJ_XMXXS size='1' class='COMMON_FPKJ_XMXX'>";

        foreach ($newOrderList as $k => $v){
            $FPXML .= '
                <COMMON_FPKJ_XMXX>
                    <FPHXZ>0</FPHXZ>  // 发票行性质
                    <XMMC>'.$v['XMMC'].'</XMMC>  // 项目名称
                    <GGXH></GGXH> // 规格型号 （非必填）
                    <DW>'.$v['DW'].'</DW> // 计量单位 （非必填）
                    <XMSL>'.$v['XMSL'].'</XMSL> // 项目数量
                    <XMDJ>'.$v['XMDJ'].'</XMDJ> // 项目单价
                    <XMJE>'.$v['XMJE'].'</XMJE> // 项目金额
                    <SL>'.$v['SL'].'</SL> // 税率
                    <SE>'.$v['SE'].'</SE> // 税额
                    <SPBM>'.$v['SPBM'].'</SPBM> // 商品编码
                    <ZXBM></ZXBM>  // 自行编码（非必填）
                    <YHZCBS>0</YHZCBS>  // 优惠政策标识 0未使用，1表示使用
                    <LSLBS></LSLBS> // 0税率标识 空代表无 0：出口退税 1：出口免税和其他免税优惠政策 2：不征增值税 3普通零税率
                    <ZZSTSGL></ZZSTSGL>
                </COMMON_FPKJ_XMXX>';
        }

        $FPXML .= '
         </COMMON_FPKJ_XMXXS>   
         </REQUEST_COMMON_FPKJ>
        </business> ';

        $FPXML = base64_encode($FPXML);
        $business = '<?xml version="1.0" encoding="gbk"?>
            <business comment="电子发票开具" id="DZFPKJ">
            <body yylxdm="1">
            <input>
                <DJBH>'.$order_sn.'</DJBH>
                <FPXML>'.$FPXML.'</FPXML>
            </input>
            </body>
            </business>';

        $business = base64_encode($business);

        $postRes = $this->request_post($info['url'],$business);
        $postRes = base64_decode($postRes);

        //添加发票记录
        $InvoiceLogModel = new InvoiceLogModel();
        $logData['request_url'] = $info['url'];
        $logData['request_data'] = $business;
        $logData['order_sn'] = $order_sn;
        $logData['return_data'] = $postRes;
        $logData['add_time'] = time();
        $InvoiceLogModel->add($logData);

        if(is_string($postRes)) {
            if(strpos($postRes,'程序异常处理') !== false){
                return createReturn(false,'','发送失败');
            } else if(strpos($postRes,'<RETURNCODE>0000</RETURNCODE>') !== false){
                return createReturn(true,['order_sn'=>$order_sn],'发送成功');
            }
        } else {
            return createReturn(false,'','发送失败');
        }
    }


    /**
     * 生成订单号
     */
    function generateOrderSn()
    {
        return date('YmdHis') . rand(1000, 9999);
    }

    /**
     * xml post请求
     * @param string $url
     * @param array $post_data
     */
    function request_post($postUrl = '', $postData = '') {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $postUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$postData,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/xml"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}