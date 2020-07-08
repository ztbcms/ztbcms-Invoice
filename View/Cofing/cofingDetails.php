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

                            <el-form-item label="销售方纳税人识别号" required>
                                <el-input v-model="form.xsf_nsrsbh" size="small"
                                          style="width: 350px;" placeholder="销售方纳税人识别号">
                                </el-input>
                            </el-form-item>

                            <el-form-item label="销售方名称" required>
                                <el-input v-model="form.xsf_mc" size="small"
                                          style="width: 350px;" placeholder="销售方名称">
                                </el-input>
                            </el-form-item>

                            <el-form-item label="销售方地址、电话" required>
                                <el-input v-model="form.xsf_dzdhxsf" size="small"
                                          style="width: 350px;" placeholder="销售方地址、电话">
                                </el-input>
                            </el-form-item>

                            <el-form-item label="销售方银行账号" required>
                                <el-input v-model="form.xsf_yhzh" size="small"
                                          style="width: 350px;" placeholder="销售方银行账号">
                                </el-input>
                            </el-form-item>

                            <el-form-item label="销售方移动电话或邮箱" required>
                                <el-input v-model="form.xsf_lxfs" size="small"
                                          style="width: 350px;" placeholder="销售方移动电话或邮箱">
                                </el-input>
                            </el-form-item>

                            <el-form-item label="开票人" required>
                                <el-input v-model="form.kpr" size="small"
                                          style="width: 350px;" placeholder="开票人">
                                </el-input>
                            </el-form-item>

                            <el-form-item label="税率" required>
                                <el-input v-model="form.sl" type="number" size="small"
                                          style="width: 350px;" placeholder="税率">
                                </el-input>
                            </el-form-item>

                            <el-form-item>
                                <el-button size="small" type="primary" @click="onSubmit">提交</el-button>
                                <el-button size="small" type="danger" @click="onCancel">关闭</el-button>
                            </el-form-item>

                        </el-form>
                    </div>
                </el-col>
                <el-col :span="16"><div class="grid-content"></div></el-col>
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
                        id : "{$_GET['id']}",
                        xsf_nsrsbh : '554433221100001',
                        xsf_mc : '广东百望测试2',
                        xsf_dzdhxsf : '0763-3372702',
                        xsf_yhzh : '580009201000888',
                        xsf_lxfs : '0763-3372702',
                        kpr : '系统开票',
                        sl : '0.03',
                    },
                },
                watch: {},
                filters: {

                },
                methods: {
                    getDetails: function(){
                        var that = this;
                        var url = '{:U("cofingDetails")}';
                        that.httpGet(url, {id: that.id}, function(res){
                            if(res.status){
                                that.form = res.data;
                            }
                        });
                    },
                    onSubmit: function(){
                        var that = this;
                        var url = '{:U("addEditCofing")}';
                        var data = that.form;
                        that.httpPost(url, data, function(res){
                            if(res.status){
                                layer.msg('提交成功', {time: 1000}, function(){
                                    parent.layer.closeAll();
                                });
                            }else{
                                layer.msg(res.msg, {time: 1000});
                            }
                        });
                    },
                    onCancel: function(){
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                },
                mounted: function () {
                    var that = this;
                    if(that.id){
                        that.getDetails();
                    }
                }
            })
        })
    </script>
</block>