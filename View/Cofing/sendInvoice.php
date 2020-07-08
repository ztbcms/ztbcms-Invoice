<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <style>
        .imgListItem {
            height: 120px;
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            display: inline-flex;
            margin-right: 10px;
            margin-bottom: 10px;
            position: relative;
            cursor: pointer;
            vertical-align: top;
        }

        .deleteMask {
            position: absolute;
            top: 0;
            left: 0;
            width: 120px;
            height: 120px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 40px;
            opacity: 0;
        }

        .deleteMask:hover {
            opacity: 1;
        }
    </style>
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <el-row>
                <el-col :span="24">
                    <div class="grid-content">
                        <el-form ref="form" :model="form" label-width="180px">

                            <el-form-item label="购买人姓名" required>
                                <el-input v-model="form.gmf_mc" style="width: 250px;" size="small"
                                          placeholder="购买人姓名"></el-input>
                            </el-form-item>

                            <el-form-item label="接收邮箱" required>
                                <el-input v-model="form.gmf_lxfs" style="width: 250px;" size="small"
                                          placeholder="填写邮箱地址"></el-input>
                            </el-form-item>

                            <el-form-item label="发票商品参数" required>
                                <div>
                                    <span>项目名称 :</span>
                                    <el-input v-model="xmmc" style="width: 150px;" size="small"
                                              placeholder="项目名称"></el-input>
                                    <br>
                                    <span>计量单位 :</span>
                                    <el-input v-model="dw" style="width: 150px;" size="small"
                                              placeholder="计量单位"></el-input>
                                    <br>
                                    <span>项目数量 :</span>
                                    <el-input v-model="xmsl" style="width: 100px;" size="small"
                                              placeholder="项目数量"></el-input>
                                    <br>
                                    <span>项目单价 :</span>
                                    <el-input v-model="xmdj" style="width: 100px;" size="small"
                                              placeholder="项目单价"></el-input>
                                    <br>
                                    <span>商品编码 :</span>
                                    <el-input v-model="spbm" style="width: 250px;" size="small"
                                              placeholder="商品编码"></el-input>
                                    <br>
                                    <el-button type="primary" size="small" @click="addOrder()">添加</el-button>
                                    <span>注：默认使用河沙的测试数据</span>
                                </div>

                                <div style="margin-top: 5px;">
                                    <el-row style="margin-top: 5px;" v-for="(item,k) in form.order">
                                        <span>项目名称 :</span>
                                        <el-input
                                                readonly unselectable="on"
                                                v-model="item.xmmc" style="width: 150px;" size="small"></el-input>
                                        <br>
                                        <span>计量单位 :</span>
                                        <el-input
                                                readonly unselectable="on"
                                                v-model="item.dw" style="width: 150px;" size="small"></el-input>
                                        <br>
                                        <span>项目数量 :</span>
                                        <el-input
                                                readonly unselectable="on"
                                                v-model="item.xmsl" style="width: 100px;" size="small"></el-input>
                                        <br>
                                        <span>项目单价 :</span>
                                        <el-input
                                                readonly unselectable="on"
                                                v-model="item.xmdj" style="width: 100px;" size="small"></el-input>
                                        <br>
                                        <span>商品编码 :</span>
                                        <el-input
                                                readonly unselectable="on"
                                                v-model="item.spbm" style="width: 250px;" size="small"></el-input>
                                        <br>

                                        <el-button class="el-button el-button--danger" size="small"
                                                   @click="delOrder(k)">删除
                                        </el-button>
                                    </el-row>
                                </div>
                            </el-form-item>

                            <el-form-item>
                                <el-button size="small" type="primary" @click="onSubmit">发送测试数据</el-button>
                                <el-button size="small" type="danger" @click="onCancel">关闭</el-button>
                            </el-form-item>

                        </el-form>
                    </div>
                </el-col>
                <el-col :span="16">
                    <div class="grid-content"></div>
                </el-col>
            </el-row>
        </el-card>
    </div>

    <script>
        $(document).ready(function () {
            window.__app = new Vue({
                el: '#app',
                data: {
                    id: '{:I("get.id")}',
                    form: {
                        'cofing_id' : "{$_GET['id']}",
                        'order' : [],
                        'gmf_mc' : '',
                        'gmf_lxfs' : ''
                    },
                    xmmc: '装砂订单',
                    dw: '吨',
                    xmsl: '5',
                    xmdj: '100',
                    spbm: '1020504070000000000'
                },
                watch: {},
                filters: {},
                methods: {

                    addOrder: function () {
                        var that = this;
                        if (!that.xmmc || !that.dw || !that.xmsl || !that.xmdj || !that.spbm) {
                            layer.msg('参数不能为空');
                            return;
                        }
                        var data = {
                            xmmc: that.xmmc,
                            dw: that.dw,
                            xmsl: that.xmsl,
                            xmdj: that.xmdj,
                            spbm: that.spbm,
                        };
                        this.form.order.push(data);
                    }, delOrder: function (k) {
                        this.form.order.splice(k, 1);
                    },
                    onSubmit: function () {
                        var that = this;
                        var url = '{:U("sendInvoice")}';
                        var data = that.form;
                        that.httpPost(url, data, function (res) {
                            if (res.status) {
                                layer.msg(res.msg, {time: 1000}, function () {
                                    parent.layer.closeAll();
                                });
                            } else {
                                layer.msg(res.msg, {time: 1000});
                            }
                        });
                    },
                    onCancel: function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                },
                mounted: function () {

                }
            })
        })
    </script>
</block>