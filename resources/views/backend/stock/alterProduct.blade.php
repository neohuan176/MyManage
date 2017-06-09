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

                <el-form :model="product"  label-width="80px" label-position="left" style="margin-top: 30px">
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
                            action="{{url('admin/stock/alter/imageUpload/'.$productId)}}"
                            list-type="picture-card"
                            :on-preview="handlePictureCardPreview"
                            :on-success="handleUploadSuccess"
                            name="productImage"
                            :on-remove="handleRemove">
                            <i class="el-icon-plus" style="line-height: 5!important;"></i>
                        </el-upload>
                        <el-dialog v-model="dialogVisible" size="tiny">
                            <img width="100%" :src="dialogImageUrl" alt="">
                        </el-dialog>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" v-on:click="saveProduct">提交</el-button>
                    </el-form-item>
                </el-form>

        </div>


        <div class="row">

            <ul class="el-upload-list el-upload-list--picture-card">
                <li class="el-upload-list__item" v-for="(image,index) in imageList">
                    <img :src="['{{asset('productImage/')}}/'+image.fileRealName]" alt="" class="el-upload-list__item-thumbnail">
                    <a class="el-upload-list__item-name"><i class="el-icon-document"></i>2.jpg</a>
                    <label class="el-upload-list__item-status-label"><i class="el-icon-upload-success el-icon-check"></i></label>
                        <i class="el-icon-close"></i><span class="el-upload-list__item-actions">
                        {{--<span class="el-upload-list__item-preview"><i class="el-icon-view"></i></span>--}}
                        <span class="el-upload-list__item-delete" v-on:click="delImageById(image.id,index)"><i class="el-icon-delete2"></i></span>
                    </span>
                </li>
            </ul>

        </div>
    </div>
</div>
@endsection

<script type="text/ecmascript">
    window.onload = function () {
        var app = new Vue({
            el: "#app",
            data: {
                product: "",
                dialogImageUrl: '',
                dialogVisible: false,
                imageList: ""
            },
            methods: {
                handleRemove: function(file, fileList) {//删除图片回调函数
                    console.log( file.response );
                    axios.post("{{url('admin/stock/alter/delProductImage')}}",
                        {imageId:file.response.imageId}
                    )
                        .then(function (response) {
                            if(response.status == "200"){
                            }
                        }).catch(function (error) {
                        console.log(error)
                    })
                },
                handlePictureCardPreview: function(file) {//预览
                    this.dialogImageUrl = file.url;
                    this.dialogVisible = true;
                    console.log(file);
                },//预览图片
                handleUploadSuccess: function (response, file, fileList) {//图片上传成功回调函数

                },//上传成功
                saveProduct: function () {//提交修改
                    axios.post("{{url('admin/stock/alterProduct')}}",
                        {product:this.product}
                    ).then(function (response) {
                            if(response.data.status == "success"){
                                location.href = "{{url('admin/stock/stockShow')}}"
                            }
                        }).catch(function (error) {
                        console.log(error)
                    })
                },
                fetchProducts: function () {//获取初始化数据
                    _this = this;
                    console.log(this.dialogVisible);
                    axios.get("{{url('admin/stock/getProduct/'.$productId)}}")
                        .then(function (response) {
                            if(response.status == "200"){
                                _this.product = response.data.product;
                                _this.imageList = response.data.imageList;
                                console.log(_this.imageList);
                            }
                        }).catch(function (error) {
                        console.log(error);
                    })
                },
                delImageById: function(imageId,index) {//删除图片回调函数
                    _this = this;
                    console.log( index );
                    axios.post("{{url('admin/stock/alter/delProductImage')}}",
                        {imageId:imageId}
                    ).then(function (response) {
                            if(response.status == "200"){
                                _this.imageList.splice(index,1);
                            }
                        }).catch(function (error) {
                        console.log(error)
                    })
                },
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