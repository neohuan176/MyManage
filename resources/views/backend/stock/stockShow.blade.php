@extends('layouts.backend')

@section('css')
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-default/index.css">
    <style type="text/css">
        .el-select .el-input {
            width: 110px;
        }

        .el-table .info-row {
            background: #c9e5f5;
        }

        #top {
            background:#20A0FF;
            padding:5px;
            overflow:hidden
        }
    </style>
@endsection

@section('js-start')
    <script src="{{asset('backend/js/vue.min.js')}}"></script>
    <!-- 引入组件库 -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection


@section('content')
    <!-- OVERVIEW -->
    <div class="panel panel-headline" id="app" style="min-height: 100%;">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <div class="row">
                <a class="btn btn-primary btn-lg" href="{{route('admin.stock.stockAdd')}}">+ 添加库存</a>
            </div>
            <el-row style="margin-top: 30px;">
                <el-input placeholder="请输入内容" v-model="criteria" style="padding-bottom:10px;">
                    <el-select v-model="type"  slot="prepend" placeholder="请选择">
                        <el-option label="编号" value="1"></el-option>
                        <el-option label="名称" value="2"></el-option>
                    </el-select>

                    <el-button slot="append" icon="search" v-on:click="search"></el-button>
                </el-input>

                <template>
                    <el-table
                            :data="products"
                            style="width: 100%">
                        <el-table-column type="expand">
                            <template scope="props">
                                <el-form label-position="left" inline class="demo-table-expand">
                                    <el-form-item label="描述">
                                        <span>@{{ props.row.describe }}</span>
                                    </el-form-item>
                                    <el-row>
                                        <el-col :span="4" v-for="(image, index) in props.row.imageList" >
                                            <el-card :body-style="{ padding: '0px' }">
                                                <img style="width: 100%" :src="['{{asset('productImage/')}}/'+image.fileRealName]" class="image">
                                            </el-card>
                                        </el-col>
                                    </el-row>
                                </el-form>
                            </template>
                        </el-table-column>

                        <el-table-column
                                label="商品编号"
                                prop="No">
                        </el-table-column>
                        <el-table-column
                                label="商品名称"
                                >
                            <template scope="scope">
                                @{{scope.row.productName}} <span v-if="scope.row.size">(@{{ scope.row.size }})</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                                label="单价"
                                >
                            <template scope="scope">
                                @{{scope.row.unitPrice}} <span v-if="scope.row.unit">/(@{{ scope.row.unit }})</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                                label="存放位置"
                                prop="position">
                        </el-table-column>
                        <el-table-column
                                label="库存"
                        >
                            <template scope="scope">
                            <el-input v-model="scope.row.count" placeholder="0" type="number" v-on:blur="changeCount(scope.$index, scope.row)"></el-input>
                            </template>
                        </el-table-column>
                        <el-table-column
                                label="操作"
                        >
                            <template scope="scope">
                                <el-button
                                        size="small"
                                v-on:click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                                <el-button
                                        size="small"
                                        type="danger"
                                v-on:click="handleDelete(scope.$index, scope.row)">删除</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </template>
                <div align="center">
                    <el-pagination
                    v-on:size-change="handleSizeChange"
                    v-on:current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[10, 20, 40, 80]"
                    :page-size="pagesize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="totalCount">
                    </el-pagination>
                </div>
            </el-row>

        </div>
    </div>
@endsection
<script type="text/ecmascript">
    window.onload = function () {
        var app = new Vue({
            el: "#app",
            data: {
                products: "",
                criteria: "",//搜索条件
                type: "",//下拉选项
                //默认每页数据量
                pagesize: 10,

                //当前页码
                currentPage: 1,

                //查询的页码
                start: 1,

                //默认数据总数
                totalCount: {{$total}}
            },
            methods: {
                fetchProducts: function () {
                    _this = this;
                    console.log(_this.type);
                    axios.post("{{url('admin/stock/getAllProducts')}}",{
                        type:_this.type,
                        criteria: _this.criteria,
                        currentPage: _this.currentPage,
                        pagesize: _this.pagesize
                    })
                        .then(function (response) {
                            if(response.status == "200"){
                                _this.products = response.data.products;
                                console.log(_this.products);
                            }
                        }).catch(function (error) {
                        console.log(error);
                    })
                },
                //每页显示数据量变更
                handleSizeChange: function(val) {
                    this.pagesize = val;
                    this.fetchProducts(this.criteria, this.currentPage, this.pagesize);
                },

                //页码变更
                handleCurrentChange: function(val) {
                    this.currentPage = val;
                    this.fetchProducts(this.criteria, this.currentPage, this.pagesize);
                },
                search: function(){
                    this.fetchProducts();
                },
                handleDelete: function (index,row) {
                    var _this = this;
                    axios.post("{{url('admin/stock/delProduct')}}",{
                        productId: row.id
                    })
                        .then(function (response) {
                            if(response.status == "200"){
                                _this.products.splice(index,1);
                            }
                        }).catch(function (error) {
                        console.log(error);
                    })
                },
                changeCount: function (index,row) {
                    console.log(row);
                    axios.post("{{url('admin/stock/changeCount')}}",{
                        productId: row.id,
                        count: row.count
                    })
                        .then(function (response) {
                            if(response.status == "200"){
                                console.log("修改库存成功！");
                            }
                        }).catch(function (error) {
                        console.log(error);
                    })
                }
            },
            mounted: function () {
                this.fetchProducts();
            },
            created: function () {

            }
        })
    }
</script>



@section('js-end')

@endsection