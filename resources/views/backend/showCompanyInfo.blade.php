@extends('layouts.backend')

@section('css')
 @endsection

@section('js-start')
    <script src="{{asset('backend/js/vue.min.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {{--<script src="{{asset('backend/js/vue-axios.es5.js')}}"></script>--}}
@endsection


@section('content')
    <!-- OVERVIEW -->
    <div class="panel panel-headline" id="app" style="min-height: 100%;">
        <div class="panel-heading">
            <h3 class="panel-title text-center" v-text="company.company"></h3>
            <p class="panel-subtitle text-center">{{date('Y - m - d')}}</p>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="profile col-lg-6 col-lg-offset-3 col-xs-12">
                    <!-- PROFILE HEADER -->
                    <div class="profile-header">
                        <div class="overlay"></div>
                        <div class="profile-main">
                            <img class="img-circle" alt="Avatar" src="{{asset('backend/image/user-medium.png')}}">
                            <h3 class="name" v-text="company.name"></h3>
                            <span class="online-status status-available">@{{company.connectType==1?'老板':(company.connectType==2?'经理':(company.connectType==3?'员工':'其他联系人类型'))}}</span>
                        </div>
                        <div class="profile-stat">
                            <div class="row">
                                <div class="col-md-4 stat-item">
                                    传真 <span v-text="company.fax"></span>
                                </div>
                                <div class="col-md-4 stat-item">
                                    手机号 <span><a href="tel:@{{company.mobilePhone}}" style="color: #fff;" v-text="company.mobilePhone"></a></span>
                                </div>
                                <div class="col-md-4 stat-item">
                                    固话 <span v-text="company.phone"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE HEADER -->
                    <!-- PROFILE DETAIL -->
                    <div class="profile-detail">
                        <div class="profile-info">
                            <h4 class="heading">基本信息</h4>
                            <ul class="list-unstyled list-justify">
                                <li>邮箱 <span v-text="company.email"></span></li>
                                <li>详细地址 <span v-text="company.address"></span></li>
                                <li>网站 <span><a href="javascript:;" onclick="window.open('{{"http://".$company->website}}')" target="_blank" v-text="company.website"></a></span></li>
                            </ul>
                        </div>
                        <div class="profile-info">
                            <h4 class="heading" v-on:click="reDirectToMap" style="cursor: pointer"><span v-text="company.position"></span>  &nbsp; &nbsp;&nbsp;
                                    <span class=" lnr lnr-map-marker" ></span>
                            </h4>
                        </div>
                        <div class="profile-info">
                            <h4 class="heading">描述</h4>
                            <p v-text="company.describe"></p>
                        </div>
                        <div class="text-center"><a class="btn btn-primary" href="#">修改资料</a></div>
                    </div>
                    <!-- END PROFILE DETAIL -->
                </div>
            </div>
        </div>
    </div>
@endsection
<script type="text/ecmascript">
  window.onload = function () {
      var app = new Vue({
          el: '#app',
          data: {
              message: 'Hello Vue!',
              company: ""
          },
          methods: {
              fetchData: function () {
                  axios.get("{{url("admin/getDataTest/".$company->id)}}")
                      .then(function (response) {
                          app.company = response.data.company;
                      }).catch(function (error) {
                      console.log(error)
                  })
              },
              reDirectToMap: function () {
                  if(app.company.position != ""){
                      var hrefStr = "http://m.amap.com/navi/?start=&amp;dest="+app.company.lng+","+app.company.lat+"&amp;destName="+app.company.position+"&amp;naviBy=car&amp;key=380b21940d6607f172278d1a8977c397";
                        window.open(hrefStr);
                  }else{
                      alert("没有目的地");
                  }
              }
          },
          mounted: function () {
              this.fetchData();
          }
      })
  }

</script>

@section('js-end')

@endsection