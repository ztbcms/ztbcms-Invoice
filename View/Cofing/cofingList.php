<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <div class="filter-container">

                <div>
                    <el-button @click="Details()" size="small" type="primary">
                        添加
                    </el-button>

                    <span> 注：添加时默认填写河沙项目的测试数据</span>
                </div>
            </div>

            <el-table
                :key="tableKey"
                :data="list"
                border
                fit
                highlight-current-row
                style="width: 100%;"
            >

                <el-table-column label="ID" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.id }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="销售方纳税人识别号" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.xsf_nsrsbh }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="销售方名称" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.xsf_mc }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="销售方地址、电话" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.xsf_dzdhxsf }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="销售方银行账号" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.xsf_yhzh }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="销售方移动电话或邮箱" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.xsf_lxfs }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="开票人" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.kpr }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="税率" align="center">
                    <template slot-scope="{row}">
                        <span>{{ row.sl }}</span>
                    </template>
                </el-table-column>


                <el-table-column label="管理" align="center" width="270" class-name="small-padding fixed-width">
                    <template slot-scope="{row}">
                        <div style="margin-bottom: 5px;">
                            <el-button type="primary" size="mini" @click="Details(row.id)">编辑</el-button>

                            <el-button type="danger" size="mini" @click="delDetails(row.id)">删除</el-button>
                        </div>

                        <div style="margin-bottom: 5px;">
                            <el-button type="success" size="mini" @click="sendInvoice(row.id)">测试发送</el-button>
                        </div>
                    </template>
                </el-table-column>

            </el-table>

            <div class="pagination-container">
                <el-pagination
                    background
                    layout="prev, pager, next, jumper"
                    :total="total"
                    v-show="total>0"
                    :current-page.sync="listQuery.page"
                    :page-size.sync="listQuery.limit"
                    @current-change="getList"
                >
                </el-pagination>
            </div>
        </el-card>
    </div>

    <style>
        .filter-container {
            padding-bottom: 10px;
        }
        .pagination-container {
            padding: 32px 16px;
        }
    </style>

    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    form: {},
                    tableKey: 0,
                    list: [],
                    total: 0,
                    listQuery: {
                        page: 1,
                        limit: 20,
                    },
                    props: {
                        lazy: true
                    },
                    cate_list : [],
                    multipleSelectionFlag:false,
                    multiDeleteVisible:false,
                    multipleSelection:''
                },
                watch: {},
                filters: {

                },
                methods: {
                    getList: function() {
                        var that = this;
                        var url = '{:U("cofingList")}';
                        var data = that.listQuery;
                        that.httpGet(url, data, function(res){
                            if(res.status){
                                that.list = res.data.items;
                                that.page = res.data.page;
                                that.total = parseInt(res.data.total_items);
                                that.page_count = res.data.total_pages;
                                that.postData = res.data.postData;
                            }else{
                                layer.msg(res.msg, {time: 1000});
                            }
                        });
                    },
                    Details:function (id) {
                        var that = this;
                        var url = "{:U('cofingDetails')}";
                        if(id) url += '&id=' +  id;
                        that.__link(url);
                    },
                    __link : function (url) {
                        var that = this;
                        layer.open({
                            type: 2,
                            title: ['管理'],
                            content: url,
                            area: ['90%', '90%'],
                            end:function(){
                                that.getList();
                            }
                        })
                    },
                    delDetails: function(id){
                        var that = this;
                        var url = '{:U("updateTable")}';
                        layer.confirm('您确定需要删除？', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var data = {
                                table: 'invoice_config', field: 'is_delete', value: 1,
                                where_name : 'id',where_value : id
                            };
                            that.httpPost(url, data, function(res){
                                if(res.status){
                                    layer.msg('操作成功', {icon: 1});
                                    that.getList();
                                }
                            });
                        });
                    },
                    sendInvoice : function (id){
                        var that = this;
                        var url = "{:U('sendInvoice')}";
                        if(id) url += '&id=' +  id;
                        that.__link(url);
                    }
                },
                mounted: function () {
                    this.getList();
                }
            })
        })
    </script>
</block>