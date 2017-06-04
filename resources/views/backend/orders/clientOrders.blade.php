@extends('layouts.backend')

@section('css')
    <style type="text/css">
        td input{
            width:100%;
        }
        .comm_check{margin:2px 2px 0 30px; float:left; vertical-align:middle;margin-top:3px!important ;margin-top:0px;}
    </style>

@endsection

@section('js-start')
@endsection


@section('content')
    <!-- OVERVIEW -->
    <div class="panel panel-headline" id="app">
        <div class="panel-heading">
            <h3 class="panel-title">个人订单管理</h3>
            <p class="panel-subtitle">{{date('Y - m - d')}}</p>
        </div>
        <div class="panel-body">
            <div class="row">
                <form action="{{url('admin/orders/clientOrdersManage')}}" method="get">
                    <div class="input-group col-lg-6" style="margin-top: 15px">
                        <div class="input-group-btn">
                            <button type="button" id="type-selected" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($type == 2 || $type==1)客户姓名@endif
                                @if($type == 3)产品名称@endif
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" onclick="changeType(2,this)">客户姓名</a></li>
                                <li><a href="javascript:void(0)" onclick="changeType(3,this)">产品名称</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                        <input type="hidden" value="2" name="type" id="type">
                        <input type="text" value="{{$searchInput}}" id="searchInput" name="searchInput" class="form-control" placeholder="Search ...">
                        <span class="input-group-btn"><button type="submit" class="btn btn-primary">查找</button></span>
                        <span class="input-group-btn"><a  class="btn btn-default" href="{{url('admin/orders/clientOrdersManage?type=1')}}">显示全部</a></span>

                    </div>
                </form>
            </div>
            <div class="row">
                <div class="panel">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped" id="recordTable">
                            <thead>
                            <tr>
                                <th>订单号</th>
                                <th>公司名称</th>
                                <th>物品名称</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>总价</th>
                                <th>购买时间</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="{{$order->id}}">
                                            <span>{{$order->_number}}</span>
                                        </label>
                                    </td>
                                    <td><a href="{{route('admin.personal.showClientInfo',[$order->clientId])}}">{{$order->clientInfo->name}}</a></td>
                                    <td>{{$order->product}}@if($order->size!="")({{$order->size}})@endif</td>
                                    <td>￥{{$order->unitPrice.' / '.$order->unit}}</td>
                                    <td>{{$order->count}}</td>
                                    <td>￥{{$order->totalPrice}}</td>
                                    <td>{{$order->time}}</td>
                                    <td>{{$order->describe}}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="delRecordById(this,{{$order->id}})" >删除</button>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#alterRecord" onclick="alterRecord({{$order}})">修改</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" onclick="selectToggle(this)">
                                        <span>全选 &nbsp; &nbsp;
                                            <button class="btn btn-sm btn-danger" onclick="delSelectedRecord()">批量删除</button>
                                            <a class="btn btn-sm btn-success" href="{{url('admin/orders/exportCompanyOrderToExcel/')}}" target="_blank">导出数据</a>
                                        </span>
                                    </label>
                                </td>
                                <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                            </tfoot>
                        </table>
                        <div>
                            <div class="pull-right">
                                {{$orders->render('')}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                    </div>
                </div>

            </div>

            {{--添加--}}
            <div class="modal fade" id="AddOrderPanel" tabindex="-1" role="dialog" aria-labelledby="AddOrderPanel">
                <div class="modal-dialog" style="width: 80%" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="_title">添加订单</h4>
                        </div>
                        <div class="modal-body">
                            <table style="margin: 10px auto; border-collapse:separate; border-spacing:10px;" id="orderTable">
                                <thead>
                                    <th>名称</th>
                                    <th>单位</th>
                                    <th>规格尺寸</th>
                                    <th>单价</th>
                                    <th>数量</th>
                                    <th>总价</th>
                                    <th>描述</th>
                                    <th>操作</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="product"></td>
                                        <td><input type="text" class="unit"></td>
                                        <td><input type="text" class="size"></td>
                                        <td><input type="number" class="unitPrice"></td>
                                        <td><input type="number" class="count"></td>
                                        <td><input type="number" class="totalPrice"></td>
                                        <td><input type="text" class="describe"></td>
                                        <td><buttone class="btn btn-danger btn-sm" onclick="delRow(this)">X</buttone></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                        <button class="btn btn-default text-success" onclick="addRow()">+</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" id="confirm-btn" onclick="commitOrder()">提交</button>
                        </div>
                    </div>
                </div>
            </div>


            {{--修改--}}
            <div class="modal fade" id="alterRecord" tabindex="-1" role="dialog" aria-labelledby="alterRecord">
                <div class="modal-dialog" style="width: 60%" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="_title">修改订单</h4>
                        </div>
                        <div class="modal-body">
                            <table style="margin: 10px auto;" id="orderTableToAlter">
                                <thead>
                                <th>名称</th>
                                <th>单位</th>
                                <th>规格尺寸</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>总价</th>
                                <th>描述</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" id="product"></td>
                                    <td><input type="text" id="unit"></td>
                                    <td><input type="text" id="size"></td>
                                    <td><input type="number" id="unitPrice"></td>
                                    <td><input type="number" id="count"></td>
                                    <td><input type="number" id="totalPrice"></td>
                                    <td><input type="text" id="describe"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="confirmAlter(this)">确定</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        //添加公司弹窗
        $('#AddOrderPanel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('添加订单 ' + recipient)
            modal.find('.modal-body input').val()
        });

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
         * 添加行
         * */
        function addRow(){
            var html = "";
                 html+='<tr>'+
               '<td><input type="text" class="product"></td>'+
                '<td><input type="text" class="unit"></td>'+
                '<td><input type="text" class="size"></td>'+
                '<td><input type="number" class="unitPrice"></td>'+
                '<td><input type="number" class="count"></td>'+
                '<td><input type="number" class="totalPrice"></td>'+
                '<td><input type="text" class="describe"></td>'+
                '<td><buttone class="btn btn-danger btn-sm" onclick="delRow(this)">X</buttone></td>'+
                '</tr>';
                $("#orderTable").append(html);
        }
        /**
         * 删除行
         * @param t
         */
        function delRow(t) {
            $(t).parent().parent().remove();
        }


        /**
         * 根据id删除记录
         * @param t
         * @param recordId
         */
        function delRecordById(t,recordId) {
            Ewin.confirm({ message: "是否删除？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                $.post("{{url('admin/personal/delRecordById')}}/"+recordId,function(data){
                    if(data.status == "success"){
                        $(t).parent().parent().remove();
                    }else{
                        alert("删除失败！");
                    }
                })
            });
        }

        var cur_record = "";

        /**
         * 初始化修改记录
         * */
        function alterRecord(record) {
            cur_record = record;
            $("#product").val(record.product);
            $('#unit').val(record.unit);
            $('#size').val(record.size);
            $("#unitPrice").val(record.unitPrice);
            $("#count").val(record.count);
            $("#totalPrice").val(record.totalPrice);
            $("#describe").val(record.describe);
        }

        /**
         * 提交修改订单记录
         */
        function confirmAlter(t) {
            $.post("{{url('admin/personal/alterRecordById')}}",
                {
                    recordId: cur_record.id,
                    product:  $("#product").val(),
                    unit:  $("#unit").val(),
                    size:  $("#size").val(),
                    unitPrice:  $("#unitPrice").val(),
                    count:  $("#count").val(),
                    totalPrice:  $("#totalPrice").val(),
                    describe:  $("#describe").val()
                },
                function (data) {
                if(data.status == "success"){
                    location.reload();
                }else{
                    alert(data.info);
                }
                }
            )
        }

        /**
         * 全选 全部选
         * @param t
         */
        function selectToggle(t){
            if($(t).is(":checked")){
                $("#recordTable tbody").find("input[type='checkbox']").each(function () {
                    if(!$(this).is(":checked")){//没被选中的才点击
                        $(this).click();
                    }
                })
            }else{
                $("#recordTable tbody").find("input[type='checkbox']").each(function () {
                    if($(this).is(":checked")){//被选中的才点击
                        $(this).click();
                    }
                });
            }
        }

        /**
         * 批量删除
         */
        function delSelectedRecord() {
            Ewin.confirm({ message: "是否删除选择的订单记录？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }

                var items = [];
                $("#recordTable tbody").find("input[type='checkbox']:checkbox:checked").each(function(){
                    items.push($(this).attr("id"));
                });
                console.log(items);

                $.post("{{url('admin/personal/delSelectedRecord')}}",
                    {
                        items:items
                    },
                    function(data){
                            if(data.status == "success"){
                                $("#recordTable tbody").find("input[type='checkbox']:checkbox:checked").each(function(){
                                    $(this).parent().parent().parent().remove();
                                });
                            }else{
                                alert("删除失败！请选择需要删除的订单");
                            }
                        }
                );
            });
        }

    </script>

@endsection

@section('js-end')
    <script type="text/javascript" src="{{asset('backend/js/dialog.js')}}"></script>
@endsection