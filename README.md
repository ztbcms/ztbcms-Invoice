## 使用的流程

#### 一：根据客户的信息进行填写设置
<img src="https://jap-online.oss-cn-shenzhen.aliyuncs.com/d/file/module_upload_images/2020/07/5f0bbc2026179.jpg" alt="PHP: The Right Way"/>

#### 二：根据自己业务逻辑编辑订单信息

<img src="https://jap-online.oss-cn-shenzhen.aliyuncs.com/d/file/module_upload_images/2020/07/5f0bbc48a316f.jpg" alt="PHP: The Right Way"/>

#### 三：调用的Service

```shell
 cofing_id 为配置id可提前在后台设置好，一般为固定信息
 gmf_mc 购买人姓名（购买方的名称）
 gmf_lxfs 接收发票的邮箱（发票成功后，会往该邮箱发送一条电子发票信息）
 order 订单发票数据
    -- xmmc 项目名称 （商品名称）
    -- dw 计量单位（吨）
    -- xmsl 项目数量 
    -- xmdj 项目单价 
    -- spbm 商品编码 （由财务提供）
```

<img src="https://karuike.oss-cn-shenzhen.aliyuncs.com/d/file/module_upload_images/2020/07/5f1ba096184ef.jpg" alt="PHP: The Right Way"/>

### 四：可在ztb_invoice_log表中查询请求记录

<img src="https://jap-online.oss-cn-shenzhen.aliyuncs.com/d/file/module_upload_images/2020/07/5f0bbced5f8f7.jpg" alt="PHP: The Right Way"/>

### 五：请求成功后，填写的邮箱号会接收到电子发票的邮件

<img src="https://karuike.oss-cn-shenzhen.aliyuncs.com/d/file/module_upload_images/2020/07/5f1ba4632a51a.jpg" alt="PHP: The Right Way"/>