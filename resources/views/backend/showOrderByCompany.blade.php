@extends('layouts.backend')

@section('css')
    <style type="text/css">
        td input{
            width:100%;
        }
        .hover{
            cursor: pointer!important;
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
            <h3 class="panel-title">{{$company->company}}--订单管理</h3>
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
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped" id="recordTable">
                            <thead>
                            <tr>
                                <th>物品名称</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>总价</th>
                                <th>购买时间</th>
                                <th>备注</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="{{$order->id}}">
                                            <span>{{$order->product}}@if($order->size!="")({{$order->size}})@endif</span>
                                        </label>
                                    </td>
                                    <td>￥{{$order->unitPrice.' / '.$order->unit}}</td>
                                    <td>{{$order->count}}</td>
                                    <td>￥{{$order->totalPrice}}</td>
                                    <td>{{$order->time}}</td>
                                    <td>{{$order->describe}}</td>
                                    <td class="hover" onclick="changeStatus('{{$order->id}}',this)" data-value="{{$order->isDone}}">@if($order->isDone)<span class="label label-success">已完成</span>@else<span class="label label-danger">未完成</span>'@endif</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="delRecordById(this,'{{$order->id}}')" >删除</button>
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
                                        <span>全选&nbsp;&nbsp;
                                            <button class="btn btn-sm btn-danger" onclick="delSelectedRecord()">删除</button>
                                            <a class="btn btn-sm btn-success" href="{{url('admin/exportCompanyToExcel/'.$company->id)}}" target="_blank">导出</a>
                                        </span>
                                    </label>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td><td></td><td></td><td></td><td></td>
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
                                    <th>状态</th>
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
                                        <td>
                                            <select class="isDone">
                                                <option value="0" selected>未完成</option>
                                                <option value="1">已完成</option>
                                            </select>
                                        </td>
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
                                    <td>
                                        <select id="isDone">
                                            <option value="0" selected>未完成</option>
                                            <option value="1">已完成</option>
                                        </select>
                                    </td>
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
                '<td><select  class="isDone"><option value="0" selected>未完成</option><option value="1">已完成</option></select></td>'+
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
                var isDone = $(this).find(".isDone").val();
                var myDate = new Date();
                var dateTime = myDate.Format("yyyy-MM-dd hh:mm:ss");
                console.log(dateTime);
                orders.push({
                    product:product,
                    unit:unit,
                    size:size,
                    unitPrice:unitPrice,
                    count:count,
                    totalPrice:totalPrice,
                    companyId:'{{$company->id}}',
                    describe:describe,
                    time:dateTime,
                    _number:myDate.getTime(),
                    isDone:isDone,
                })
            });
            $.post("{{url('admin/addCompanyRecord/'.$company->id)}})}}",
                {
                    records:orders
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
         * 根据id删除记录
         * @param t
         * @param recordId
         */
        function delRecordById(t,recordId) {
            Ewin.confirm({ message: "是否删除？" ,btnok:"确认",btncl:"取消"}).on(function (e) {//弹窗确认
                if (!e) {
                    return;
                }
                $.post("{{url('admin/delRecordById')}}/"+recordId,function(data){
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
            $("#isDone").val(record.isDone);
        }

        /**
         * 提交修改订单记录
         */
        function confirmAlter(t) {
            $.post("{{url('admin/alterRecordById')}}",
                {
                    recordId: cur_record.id,
                    product:  $("#product").val(),
                    unit:  $("#unit").val(),
                    size:  $("#size").val(),
                    unitPrice:  $("#unitPrice").val(),
                    count:  $("#count").val(),
                    totalPrice:  $("#totalPrice").val(),
                    describe:  $("#describe").val(),
                    isDone: $("#isDone").val()
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

                $.post("{{url('admin/delSelectedRecord')}}",
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

        function changeStatus(orderId,t){
            var isDone = $(t).attr("data-value");
            $.post("{{url('admin/changeOrderStatus')}}",
                {
                    isDone: isDone,
                    orderId: orderId
                },
                function (data) {
                    if(data.status == "success"){
                        if(isDone == 1){//修改为未完成
                            console.log(isDone);
                            console.log("修改为未完成");
                            $(t).find("span").removeClass("label-success").addClass('label-danger').html('未完成');
                        }else{
                            console.log(isDone);
                            console.log("修改为已完成");
                            $(t).find("span").removeClass("label-danger").addClass('label-success').html('已完成');
                        }
                        $(t).attr('data-value',isDone==0?1:0);
                    }else{
                        alert(data.info);
                    }
                }
            )
        }

    </script>

@endsection

@section('js-end')
    <script type="text/javascript" src="{{asset('backend/js/dialog.js')}}"></script>
@endsection