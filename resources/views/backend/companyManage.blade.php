@extends('layouts.backend')

@section('css')
    <style type="text/css">
        .form-group{
            margin-bottom: 10px!important;
        }
    </style>
@endsection

@section('js-start')
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=380b21940d6607f172278d1a8977c397"></script>
    <script src="{{asset('backend/js/bootstrap.AMapPositionPicker.js')}}"></script>
    <script src="{{asset('backend/js/bootstrapValidator.js')}}"></script>
    {{--<script src="{{asset('backend/js/vue.min.js')}}"></script>--}}
@endsection


@section('content')
    <!-- OVERVIEW -->
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">公司客户管理</h3>
            <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
        </div>
        <div class="panel-body" id="app">
            <div class="row">
                <button class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#addCompanyPanel" data-whatever="neo" onclick="resetForm()">+ 添加公司客户</button>
                <form action="{{url('admin/companyManage')}}" method="get">
                <div class="input-group col-lg-6" style="margin-top: 15px">
                    <div class="input-group-btn">
                        <button type="button" id="type-selected" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($type == 2 || $type==1)公司名称@endif
                            @if($type == 3)联系人@endif
                            @if($type == 4)手机号@endif
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            {{--<li><a href="javascript:void(0)" onclick="changeType(1,this)">显示全部</a></li>--}}
                            <li><a href="javascript:void(0)" onclick="changeType(2,this)">公司名称</a></li>
                            <li><a href="javascript:void(0)" onclick="changeType(3,this)">联系人</a></li>
                            <li><a href="javascript:void(0)" onclick="changeType(4,this)">手机号</a></li>
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
                        <h3 class="panel-title">公司客户<a type="button" style="font-size: 12px;color: #333;" class="label" href="{{url('admin/companyManage?type=1')}}">显示全部</a></h3>
                        <div class="right">
                        </div>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>公司名称</th>
                                <th>联系人</th>
                                <th>联系电话</th>
                                <th>地址</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as  $company)
                            <tr>
                                <td><a href="{{url('admin/showCompanyInfo/'.$company->id)}}">{{$company->company}}</a></td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->mobilePhone}} </td>
                                <td>{{$company->address}}</td>
                                <td><span class="label label-success">{{$company->describe}}</span></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{url('admin/showOrderByCompany/'.$company->id)}}">查看订单</a>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCompanyPanel" onclick="alterCompany({{$company}},this)">修改信息</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteCompany('{{$company->id}}',this)">删除</button>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <div class="pull-right">
                                {{$companies->render('')}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                    </div>
                </div>

            </div>

            <div class="modal fade" id="addCompanyPanel" tabindex="-1" role="dialog" aria-labelledby="addCompanyPanel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="_title">添加客户</h4>
                        </div>
                        <div class="modal-body">
                            <form id="companyForm">
                                <input class="form-control" type="hidden" id="companyId" name="companyId">

                                <div class="form-group">
                                    <label for="Cno" class="control-label">公司名称</label>
                                    <input type="text" class="form-control" id="company" name="company">
                                </div>

                                <div class="form-group">
                                    <label for="Cname" class="control-label">联系人姓名</label>
                                    <input class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="mobilePhone" class="control-label">联系电话</label>
                                    <div class="input-group" style="display:flex">
                                    <select class="form-control" style="flex: 1;" id="connectType" name="connectType">
                                        <option value="0" disabled selected>选择联系人类型</option>
                                        <option value="1">老板</option>
                                        <option value="2">经理</option>
                                        <option value="3">员工</option>
                                        <option value="4">其他</option>
                                    </select>
                                    <input style="flex: 2;" class="form-control" id="mobilePhone" name="mobilePhone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group" style="display:flex;align-items: center">
                                        <label for="Address" style="width: 100px">固话</label>
                                        <input class="form-control" id="phone" name="phone">
                                        <label for="fax" style="width: 100px;margin-left: 10px">传真</label>
                                        <input class="form-control" id="fax" name="fax">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">邮箱</label>
                                    <input class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="website" class="control-label">网站</label>
                                    <input class="form-control" id="website" name="website">
                                </div>
                                <div class="form-group">
                                    <label for="describe" class="control-label">描述</label>
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
        //添加公司弹窗
        $('#coursePositionPanel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('添加公司 ' + recipient)
            modal.find('.modal-body input').val()
        });
        //地图选择初始化
        var position = $("#choosePosition").AMapPositionPicker();

        $(function () {
            //添加公司表单重置
            $('#resetBtn').click(function() {
                $('#companyForm').data('bootstrapValidator').resetForm(true);
            });

        })

        /**
         * 提交表单
         * */
        function submitForm(){
            $('#companyForm').bootstrapValidator('validate');
            if($(".form-group").hasClass('has-error')){

            }else{
                var positionData = position.AMapPositionPicker('position');
                console.log(positionData);
                $.post("{{url('admin/addCompany')}}",
                    {
                        company: $("#company").val(),
                        companyId: $("#companyId").val(),
                        name: $("#name").val(),
                        connectType: $("#connectType").val(),
                        phone: $("#phone").val(),
                        mobilePhone: $("#mobilePhone").val(),
                        fax: $("#fax").val(),
                        email: $("#email").val(),

                        website: $("#website").val(),
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
                            $("#addCompanyPanel").fadeOut();
                            $(".modal-backdrop").fadeOut();
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
         * 删除课程
         * @param courseId
         */
        function deleteCompany(companyId,t){
            Ewin.confirm({ message: "是否删除？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                $.post("{{url('admin')}}/deleteCompany/"+companyId,function(data){
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
            $('#companyForm').data('bootstrapValidator').resetForm(true);
            $('#connectType').val(0);
            $('#companyId').val("");
            $('#positionAddress').val("");
            position=null;
            position = $("#choosePosition").AMapPositionPicker();
            console.log(position);
        }

        function alterCompany(companyInfo,t) {
            position =  $("#choosePosition").AMapPositionPicker();
            console.log(position)
            $("#_title").html("修改客户信息");
            $("#resetBtn").hide();
            $("#confirm-btn").html("确认");
            console.log(companyInfo.connectType);
            $("#positionAddress").val(companyInfo.position);
            $('#companyId').val(companyInfo.id);
            $("#company").val(companyInfo.company);
            $("#name").val(companyInfo.name);
            $("#connectType").val(companyInfo.connectType);
            $("#phone").val(companyInfo.phone);
            $("#mobilePhone").val(companyInfo.mobilePhone);
            $("#fax").val(companyInfo.fax);
            $("#email").val(companyInfo.email);
            $("#website").val(companyInfo.website);
            $("#address").val(companyInfo.address);
            $("#describe").val(companyInfo.describe);
        }
    </script>

{{--验证 --}}
    <script type="text/javascript">
        $('#companyForm').bootstrapValidator({
//        live: 'disabled',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                company: {
                    validators: {
                        notEmpty: {
                            message: '公司名称不能为空'
                        }
                    }
                },
                name:{},
                connectType:{},
                phone:{},
                mobilePhone:{},
                fax:{},
                email:{
                    validators: {
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    }
                },
                website:{},
                address:{},
                describe:{}
            }
        });
    </script>
@endsection

@section('js-end')
    <script type="text/javascript" src="{{asset('backend/js/dialog.js')}}"></script>
@endsection