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
            <h3 class="panel-title">常规订单管理</h3>
            <p class="panel-subtitle">{{date('Y - m - d')}}</p>
        </div>
        <div class="panel-body">
            <div class="row">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#AddOrderPanel"
                        data-whatever="">+ 添加订单
                </button>

            </div>
            <div class="row">
                <div class="panel">
                    <div class="panel-heading">
                        {{--<h3 class="panel-title">个人客户</h3>--}}
                        {{--<div class="right">--}}
                        {{--</div>--}}
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped" id="recordTable">
                            <thead>
                            <tr>
                                <th>概述</th>
                                <th>时间</th>
                                <th>总价</th>
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
                                    <span>{{$order->orderInfo}}</span>
                                    </label>
                                    </td>
                                    <td>{{$order->time}}</td>
                                    <td>{{$order->totalPrice}}</td>
                                    <td>{{$order->describe}}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="delOrderById(this,{{$order->id}})" >删除</button>
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
                                            <button class="btn btn-sm btn-danger" onclick="delSelectedOrders()">批量删除</button>
{{--                                            <a class="btn btn-sm btn-success" href="{{url('admin/personal/exportClientRecordToExcel/'.$client->id)}}" target="_blank">导出数据</a>--}}
                                        </span>
                                    </label>
                                </td>
                                <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
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
                            <div class="form-group">
                                <label for="orderDescribe">订单备注</label>
                                <textarea name="orderDescribe" id="orderDescribe"  class="form-control"></textarea>
                            </div>
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
                            <div class="form-group">
                                <label for="orderDescribe">订单备注</label>
                                <textarea name="orderDescribeAlter" id="orderDescribeAlter"  class="form-control"></textarea>
                            </div>
                            <table style="margin: 10px auto; border-collapse:separate; border-spacing:10px;" id="orderTableToAlter">
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
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>
                                        <button class="btn btn-default text-success" onclick="addAlterRow()">+</button>
                                    </td>
                                </tr>
                                </tfoot>
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
         * 添加修改行
         * */
        function addAlterRow(){
            var html = "";
            html+='<tr>'+
                '<td><input type="text" class="product"></td>'+
                '<td><input type="text" class="unit"></td>'+
                '<td><input type="text" class="size"></td>'+
                '<td><input type="number" class="unitPrice"></td>'+
                '<td><input type="number" class="count"></td>'+
                '<td><input type="number" class="totalPrice"></td>'+
                '<td><input type="text" class="describe"></td>'+
                '<td><buttone class="btn btn-danger btn-sm" onclick="delAlterRow(this)">X</buttone></td>'+
                '</tr>';
            $("#orderTableToAlter tbody").append(html);
        }

        /**
         * 删除修改行
         * @param t
         */
        function delAlterRow(t) {
            Ewin.confirm({ message: "是否删除？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                var cur_tr = $(t).parent().parent();
                if(!(typeof(cur_tr.attr("id"))=="undefined")){//删除已经存在的
                    $.post("{{url('admin/orders/delOrdinaryRecordById')}}/"+cur_tr.attr('id'),function(data){
                        if(data.status == "success"){
                            cur_tr.remove();
                        }else{
                            alert("删除失败！");
                        }
                    });
                }else{
                    cur_tr.remove();
                }
            });
        }

        /**
         * 提交添加订单记录
         */
        function commitOrder(){
            var orders=[];
            $("#orderTable tbody").find("tr").each(function (_this) {
                var product = $(this).find(".product").val();
                var unit = $(this).find(".unit").val();
                var size = $(this).find(".size").val();
                var unitPrice = $(this).find(".unitPrice").val();
                var count = $(this).find(".count").val();
                var totalPrice = $(this).find(".totalPrice").val();
                var describe = $(this).find(".describe").val();
                orders.push({
                    product:product,
                    unit:unit,
                    size:size,
                    unitPrice:unitPrice,
                    count:count,
                    totalPrice:totalPrice,
                    describe:describe,
                })
            });
            $.post("{{url('admin/orders/addOrdinaryOrder')}}",
                {
                    records:orders,
                    describe:$("#orderDescribe").val()
                },
                function (data) {
                    if(data.status == "success"){
                        location.reload();
                    }else{
                        alert(data.error);
                    }
                }
            );
        }


        /**
         * 根据id删除订单
         * @param t
         * @param recordId
         */
        function delOrderById(t,orderId) {
            Ewin.confirm({ message: "是否删除？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                $.post("{{url('admin/orders/delOrdinaryOrderById')}}/"+orderId,function(data){
                    if(data.status == "success"){
                        $(t).parent().parent().remove();
                    }else{
                        alert("删除失败！");
                    }
                })
            });
        }

        var cur_order = "";

        /**
         * 初始化修改记录
         * */
        function alterRecord(order) {
            cur_order = order;
            $("#orderTableToAlter tbody").html("");
            $("#orderDescribeAlter").val(order.describe);
            $.get('{{url("admin/orders/getOrderRecords")}}',
                {
                    orderId: order.id
                },
                function (data) {
                var html = "";
                console.log(data);
                    for(var key in data){
                        var record = data[key];
                        html+='<tr id="'+data[key].id+'">'+
                                '<td><input type="text" class="product" value="'+(record.product==null?'':record.product)+'"></td>'+
                                '<td><input type="text" class="unit" value="'+(record.unit==null?'':record.unit)+'"></td>'+
                                '<td><input type="text" class="size" value="'+(record.size==null?'':record.size)+'"></td>'+
                                '<td><input type="number" class="unitPrice" value="'+(record.unitPrice==null?'':record.unitPrice)+'"></td>'+
                                '<td><input type="number" class="count" value="'+(record.count==null?'':record.count)+'"></td>'+
                                '<td><input type="number" class="totalPrice" value="'+(record.totalPrice==null?'':record.totalPrice)+'"></td>'+
                                '<td><input type="text" class="describe" value="'+(record.describe==null?'':record.describe)+'"></td>'+
                                '<td><buttone class="btn btn-danger btn-sm" onclick="delAlterRow(this)">X</buttone></td>'+
                                '</tr>';
                    }
                    $("#orderTableToAlter tbody").append(html);
                }
            );
        }

        /**
         * 提交修改订单记录
         */
        function confirmAlter(t) {
            var alter_records=[];
            var new_records = [];
            $("#orderTableToAlter tbody").find("tr").each(function (_this) {
                if(!(typeof($(this).attr("id"))=="undefined")){
                    var id = $(this).attr('id');
                    alter_records.push({
                        id: id,
                        product:$(this).find(".product").val(),
                        unit:$(this).find(".unit").val(),
                        size:$(this).find(".size").val(),
                        unitPrice:$(this).find(".unitPrice").val(),
                        count:$(this).find(".count").val(),
                        totalPrice:$(this).find(".totalPrice").val(),
                        describe:$(this).find(".describe").val(),
                    })
                }else{
                    new_records.push({
                        product:$(this).find(".product").val(),
                        unit:$(this).find(".unit").val(),
                        size:$(this).find(".size").val(),
                        unitPrice:$(this).find(".unitPrice").val(),
                        count:$(this).find(".count").val(),
                        totalPrice:$(this).find(".totalPrice").val(),
                        describe:$(this).find(".describe").val(),
                    })
                }

            });

            $.post("{{url('admin/orders/alterOrderById')}}",
                {
                    alter_records:alter_records,
                    new_records:new_records,
                    orderId:cur_order.id,
                    orderDescribe:$("#orderDescribeAlter").val(),
                },
                function (data) {
                    if(data.status == "success"){
                        console.log(data.info);
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
        function delSelectedOrders() {
            Ewin.confirm({ message: "是否删除选择的订单记录？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                var items = [];
                $("#recordTable tbody").find("input[type='checkbox']:checkbox:checked").each(function(){
                    items.push($(this).attr("id"));
                });
                console.log(items);

                $.post("{{url('admin/orders/delSelectedOrders')}}",
                    {
                        orderIds:items
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