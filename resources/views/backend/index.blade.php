@extends('layouts.backend')

@section('css')
@endsection


@section('content')
    <div class="panel panel-headline" id="app" style="min-height: 100%;">
        <div class="panel-heading">
            <h3 class="panel-title text-center" v-text="company.company">这些数据都是假的，还没做。。。</h3>
            <p class="panel-subtitle text-center">{{date('Y - m - d')}}</p>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-download"></i></span>
                        <p>
                            <span class="number">1,252</span>
                            <span class="title">下载</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                        <p>
                            <span class="number">203</span>
                            <span class="title">营业额</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-eye"></i></span>
                        <p>
                            <span class="number">274,678</span>
                            <span class="title">咩啊</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-bar-chart"></i></span>
                        <p>
                            <span class="number">35%</span>
                            <span class="title">不知道</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="ct-chart" id="headline-chart"><svg xmlns="http://www.w3.org/2000/svg" class="ct-chart-line" style="width: 100%; height: 300;" width="100%" height="300" xmlns:ct="http://gionkunz.github.com/chartist-js/ct"><g class="ct-grids"><line class="ct-grid ct-vertical" x1="50" y1="265" x2="1200.14" y2="265" /><line class="ct-grid ct-vertical" x1="50" y1="229.286" x2="1200.14" y2="229.286" /><line class="ct-grid ct-vertical" x1="50" y1="193.571" x2="1200.14" y2="193.571" /><line class="ct-grid ct-vertical" x1="50" y1="157.857" x2="1200.14" y2="157.857" /><line class="ct-grid ct-vertical" x1="50" y1="122.143" x2="1200.14" y2="122.143" /><line class="ct-grid ct-vertical" x1="50" y1="86.4286" x2="1200.14" y2="86.4286" /><line class="ct-grid ct-vertical" x1="50" y1="50.7143" x2="1200.14" y2="50.7143" /><line class="ct-grid ct-vertical" x1="50" y1="15" x2="1200.14" y2="15" /></g><g><g class="ct-series ct-series-a"><path class="ct-area" d="M 50 265 L 50 172.143 L 241.69 129.286 L 433.38 165 L 625.07 50.714 L 816.76 157.857 L 1008.45 165 L 1200.14 86.429 L 1200.14 265 Z" /></g><g class="ct-series ct-series-b"><path class="ct-area" d="M 50 265 L 50 236.429 L 241.69 157.857 L 433.38 207.857 L 625.07 93.571 L 816.76 129.286 L 1008.45 65 L 1200.14 22.143 L 1200.14 265 Z" /></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="50" y="270" width="191.69" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 192px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Mon</span></foreignObject><foreignObject style="overflow: visible;" x="241.69" y="270" width="191.69" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 192px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Tue</span></foreignObject><foreignObject style="overflow: visible;" x="433.38" y="270" width="191.69" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 192px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Wed</span></foreignObject><foreignObject style="overflow: visible;" x="625.07" y="270" width="191.69" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 192px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Thu</span></foreignObject><foreignObject style="overflow: visible;" x="816.76" y="270" width="191.69" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 192px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Fri</span></foreignObject><foreignObject style="overflow: visible;" x="1008.45" y="270" width="191.69" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 192px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Sat</span></foreignObject><foreignObject style="overflow: visible;" x="1200.14" y="270" width="30" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 30px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Sun</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="229.286" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">10</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="193.571" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">15</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="157.857" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">20</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="122.143" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">25</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="86.4286" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">30</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="50.7143" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">35</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="15" width="30" height="35.7143"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">40</span></foreignObject><foreignObject style="overflow: visible;" x="10" y="-15" width="30" height="30"><span class="ct-label ct-vertical ct-start" style="height: 30px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">45</span></foreignObject></g></svg></div>
                </div>
                <div class="col-md-3">
                    <div class="weekly-summary text-right">
                        <span class="number">2,315</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span>
                        <span class="info-label">总销售额</span>
                    </div>
                    <div class="weekly-summary text-right">
                        <span class="number">$5,758</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 23%</span>
                        <span class="info-label">月销售额</span>
                    </div>
                    <div class="weekly-summary text-right">
                        <span class="number">$65,938</span> <span class="percentage"><i class="fa fa-caret-down text-danger"></i> 8%</span>
                        <span class="info-label">总数量</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection