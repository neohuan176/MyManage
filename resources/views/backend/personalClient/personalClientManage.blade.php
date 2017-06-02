@extends('layouts.backend')

@section('css')
    <style type="text/css">
        .form-group{
            margin-bottom: 10px!important;
        }
    </style>
@endsection

@section('js-start')
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=ed1fafa0307bb4991da41f54d8a88b46"></script>
    <script src="{{asset('backend/js/bootstrap.AMapPositionPicker.js')}}"></script>
    <script src="{{asset('backend/js/bootstrapValidator.js')}}"></script>
    {{--<script src="{{asset('backend/js/vue.min.js')}}"></script>--}}
@endsection


@section('content')
    <!-- OVERVIEW -->
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">个人客户管理</h3>
            <p class="panel-subtitle">{{date("Y 年 m 月 d 日")}}</p>
        </div>
        <div class="panel-body" id="app">
            <div class="row">
                <button class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#addPersonalClientPanel" data-whatever="neo" onclick="resetForm()">+ 添加个人客户</button>
                <form action="{{url('admin/personal/personalClientManage')}}" method="get">
                <div class="input-group col-lg-6" style="margin-top: 15px">
                    <div class="input-group-btn">
                        <button type="button" id="type-selected" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($type == 2 || $type==1)姓名@endif
                            @if($type == 3)手机号@endif
                            @if($type == 4)地址@endif
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            {{--<li><a href="javascript:void(0)" onclick="changeType(1,this)">显示全部</a></li>--}}
                            <li><a href="javascript:void(0)" onclick="changeType(2,this)">姓名</a></li>
                            <li><a href="javascript:void(0)" onclick="changeType(3,this)">手机号</a></li>
                            <li><a href="javascript:void(0)" onclick="changeType(4,this)">地址</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                    <input type="hidden" value="2" name="type" id="type">
                    <input type="text" value="{{$searchInput}}" id="searchInput" name="searchInput" class="form-control" placeholder="Search ...">
                    <span class="input-group-btn"><button type="submit" class="btn btn-primary">查找</button></span>

                </div>
                </form>

            </div>
            <div class="row">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人客户<a type="button" style="font-size: 12px;color: #333;" class="label" href="{{url('admin/personal/personalClientManage?type=1')}}">显示全部</a></h3>
                        <div class="right">
                        </div>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>性别</th>
                                <th>联系电话</th>
                                <th>地址</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as  $client)
                            <tr>
                                <td><a href="{{url('admin/personal/showClientInfo/'.$client->id)}}">{{$client->name}}</a></td>
                                <td>{{$client->sex==0?'先生':($client->sex==1?'小姐':'保密')}}</td>
                                <td>{{$client->phone}} </td>
                                <td>{{$client->address}}</td>
                                <td><span class="label label-success">{{$client->describe}}</span></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{url('admin/personal/showOrderByPersonalClient/'.$client->id)}}">查看订单</a>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPersonalClientPanel" onclick="alterCompany({{$client}},this)">修改信息</button>
                                    <button class="btn btn-primary btn-sm" onclick="deleteClient('{{$client->id}}',this)">删除</button>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <div class="pull-right">
                                {{$clients->render('')}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                    </div>
                </div>

            </div>


            <div class="modal fade" id="addPersonalClientPanel" tabindex="-1" role="dialog" aria-labelledby="addPersonalClientPanel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="_title">添加客户</h4>
                        </div>
                        <div class="modal-body">
                            <form id="clientForm">
                                <input class="form-control" type="hidden" id="clientId" name="clientId">

                                <div class="form-group">
                                    <label for="Cno" class="control-label">姓名</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">性别</label>
                                    <div class="input-group" style="display:flex">
                                        <label class="fancy-radio">
                                            <input name="sex" type="radio" value="0">
                                            <span><i></i>先生</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input name="sex" type="radio" value="1">
                                            <span><i></i>小姐</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">手机号</label>
                                    <input class="form-control" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">邮箱</label>
                                    <input class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">传真</label>
                                    <input class="form-control" id="fax" name="fax">
                                </div>
                                <div class="form-group">
                                    <label for="describe" class="control-label">备注</label>
                                    <textarea class="form-control"  id="describe" name="describe"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="choosePosition">导航位置</label>
                                    <div class="input-group" id="choosePosition">
                                        <input type="text" id="positionAddress" class="form-control">
                                        <span class="input-group-addon lnr lnr-map-marker"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label">详细地址</label>
                                    <input class="form-control" id="address" name="address">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="resetBtn">重置</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" id="confirm-btn" onclick="submitForm()">添加</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <script type="text/javascript">

        //地图选择初始化
        var position = $("#choosePosition").AMapPositionPicker();

        $(function () {
            //表单重置
            $('#resetBtn').click(function() {
                $('#clientForm').data('bootstrapValidator').resetForm(true);
            });

        })

        /**
         * 提交表单
         * */
        function submitForm(){
            $('#clientForm').bootstrapValidator('validate');
            if($(".form-group").hasClass('has-error')){

            }else{
                var positionData = position.AMapPositionPicker('position');
                console.log(positionData);
                $.post("{{url('admin/personal/addPersonalClient')}}",
                    {
                        clientId: $("#clientId").val(),
                        name: $("#name").val(),
                        sex: $("input[name='sex']:checked").val(),
                        phone: $("#phone").val(),
                        fax: $("#fax").val(),
                        email: $("#email").val(),
                        address: $("#address").val(),
                        describe: $("#describe").val(),
                        position: $("#positionAddress").val(),
                        lng: positionData.longitude,
                        lat: positionData.latitude,
                    },
                    function(data){
                        console.log(data);
                        if(data.status == "success"){
                            //关闭弹窗
                            $("#addPersonalClientPanel .modal-backdrop").fadeOut();
//                            $(".modal-backdrop").fadeOut();
                        location.reload();
                        }
                        else{
                            console.log(data.info);
                        }
                    })
            }
        }

        /**
         * 修改查找类型
         * @param type
         * @param t
         */
        function changeType(type,t){
            $('#type').val(type);
            $("#type-selected").html($(t).html()+"<span class='caret'></span>");
        }

        /**
         * 删除
         * @param courseId
         */
        function deleteClient(clientId,t){
            Ewin.confirm({ message: "是否删除？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                $.post("{{url('admin/personal')}}/deletePersonalClient/"+clientId,function(data){
                    if(data.status == "success"){
                        $(t).parent().parent().remove();
                    }else{
                        alert(data.info);
                    }
                })
            });
        }

//        重置添加公司表单
        function resetForm() {
            $("#_title").html("添加客户");
            $("#resetBtn").show();
            $("#confirm-btn").html("添加");
            $('#clientForm').data('bootstrapValidator').resetForm(true);
            $('#clientId').val("");
            $('#positionAddress').val("");
            position=null;
            position = $("#choosePosition").AMapPositionPicker();
            console.log();
        }

        /**
         * 修改客户个人信息
         * @param clientInfo
         * @param t
         */
        function alterCompany(clientInfo,t) {
            position =  $("#choosePosition").AMapPositionPicker();
            console.log(position);
            $("#_title").html("修改客户信息");
            $("#resetBtn").hide();
            $("#confirm-btn").html("确认");
            $("#positionAddress").val(clientInfo.position);
            $('#clientId').val(clientInfo.id);
            $("#name").val(clientInfo.name);
            $("input:radio[name='sex'][value='"+clientInfo.sex+"']").prop("checked","checked");
            $("#phone").val(clientInfo.phone);
            $("#fax").val(clientInfo.fax);
            $("#email").val(clientInfo.email);
            $("#address").val(clientInfo.address);
            $("#describe").val(clientInfo.describe);
        }
    </script>

{{--验证 --}}
    <script type="text/javascript">
        $('#clientForm').bootstrapValidator({
            message: '请输入正确的数据',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name:{
                    validators: {
                    notEmpty: {
                        message: '姓名不能为空'
                    }
                }},
                phone:{},
                fax:{},
                email:{
                    validators: {
                        emailAddress: {
                            message: '邮箱地址不正确'
                        }
                    }
                },
                address:{},
                describe:{}
            }
        });
    </script>
@endsection

@section('js-end')
    <script type="text/javascript" src="{{asset('backend/js/dialog.js')}}"></script>
@endsection