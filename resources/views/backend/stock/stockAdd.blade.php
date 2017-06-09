@extends('layouts.backend')

@section('css')
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-default/index.css">
    <style type="text/css">
        .el-upload__input{
            display: none!important;
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
                <div v-for="(product,productIndex) in products" class="col-lg-6">
                    <el-form :model="product" label-width="80px" label-position="left" style="margin-top: 30px">
                        <el-form-item label="产品">
                            <el-col :span="6">
                                <el-form-item>
                                    <el-input v-model="product.No" placeholder="编号"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col class="line" style="text-align: center" :span="1">  -  </el-col>
                            <el-col :span="17">
                            <el-form-item>
                                <el-input v-model="product.productName" placeholder="名称"></el-input>
                            </el-form-item>
                            </el-col>
                        </el-form-item>

                        <el-form-item label="单价">
                            <el-col :span="6">
                                <el-form-item>
                                    <el-input v-model="product.unitPrice" placeholder="单价" type="number"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col class="line" style="text-align: center" :span="1">  ￥/  </el-col>
                            <el-col :span="10">
                                <el-form-item>
                                    <el-input v-model="product.unit" placeholder="单位"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="7">
                                <el-form-item>
                                    <el-input v-model="product.size" placeholder="规格尺寸"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-form-item>

                        <el-form-item label="数量">
                            <el-input v-model="product.count" type="number"></el-input>
                        </el-form-item>
                        <el-form-item label="存放位置">
                            <el-input v-model="product.position"></el-input>
                        </el-form-item>
                        <el-form-item label="产品描述">
                            <el-input type="textarea" v-model="product.describe"></el-input>
                        </el-form-item>

                        <el-form-item label="图片">
                        <el-upload
                                action="{{url('admin/stock/imageUpload')}}"
                                list-type="picture-card"
                                :on-preview="handlePictureCardPreview"
                                :on-success="handleUploadSuccess"
                                :data="{productIndex:productIndex}"
                                name="productImage"
                                :on-remove="handleRemove">
                            <i class="el-icon-plus" style="line-height: 5!important;"></i>
                        </el-upload>
                        <el-dialog v-model="dialogVisible" size="tiny">
                            <img width="100%" :src="dialogImageUrl" alt="">
                        </el-dialog>
                        </el-form-item>
                    </el-form>
                </div>
            </div>


            <div class="row">
                <el-form>
                    <el-form-item>
                        <el-button  v-on:click="addProduct">继续添加</el-button>
                        <el-button type="primary" v-on:click="commitProduct">提交</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
@endsection


@section('js-end')
    <script type="text/ecmascript">
        $(function () {
                var app = new Vue({
                    el: "#app",
                    data: {
                        products: [{
                            No: "GY-",
                            productName: "",
                            unit: "",
                            size: "",
                            unitPrice: "",
                            count: 1,
                            describe: "",
                            position: "",
                            imageList: []
                        }],
                        dialogImageUrl: '',
                        dialogVisible: false
                    },
                    methods: {
                        handleRemove: function(file, fileList) {
                            console.log( file.response );
                            //删除服务器端的数据（添加完成商品的时候都要清空的）
                            //删除当前对象的imageList中对应的id
                        },//删除图片
                        handlePictureCardPreview: function(file) {
                            this.dialogImageUrl = file.url;
                            this.dialogVisible = true;
                            console.log(file);
                        },//预览图片
                        handleUploadSuccess: function (response, file, fileList) {
                            console.log(response.productIndex);
                            this.products[response.productIndex].imageList.push(response.imageId);//在imageList添加imageId
                        },//上传成功
                        addProduct: function () {//添加新的
                            this.products.push({
                                No: "",
                                productName: "",
                                unit: "",
                                size: "",
                                unitPrice: "",
                                count: 1,
                                describe: "",
                                position: "",
                                imageList: []
                            })
                        },
                        commitProduct: function () {
                            axios.post("{{url('admin/stock/addProducts')}}",
                                {products:this.products}
                            )
                                .then(function (response) {
                                    if(response.status == "200"){
                                        location.href = "{{url('admin/stock/stockShow')}}"
                                    }
                                }).catch(function (error) {
                                console.log(error)
                            })
                        }
                    },
                    mounted: function () {

                    },
                    created: function () {

                    }
                })
            }
        )
    </script>
@endsection