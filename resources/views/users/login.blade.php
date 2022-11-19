
<!DOCTYPE html>
<html lang="en">
<head>
  <!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<title>Đăng nhập hệ thống</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">

<link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        
<link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css?v=3.2.0">
<script nonce="9ae4675d-4673-4381-9acb-8f43bc32611a">(function(w,d){!function(a,e,t,r){a.zarazData=a.zarazData||{};a.zarazData.executed=[];a.zaraz={deferred:[],listeners:[]};a.zaraz.q=[];a.zaraz._f=function(e){return function(){var t=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:t})}};for(const e of["track","set","debug"])a.zaraz[e]=a.zaraz._f(e);a.zaraz.init=()=>{var t=e.getElementsByTagName(r)[0],z=e.createElement(r),n=e.getElementsByTagName("title")[0];n&&(a.zarazData.t=e.getElementsByTagName("title")[0].text);a.zarazData.x=Math.random();a.zarazData.w=a.screen.width;a.zarazData.h=a.screen.height;a.zarazData.j=a.innerHeight;a.zarazData.e=a.innerWidth;a.zarazData.l=a.location.href;a.zarazData.r=e.referrer;a.zarazData.k=a.screen.colorDepth;a.zarazData.n=e.characterSet;a.zarazData.o=(new Date).getTimezoneOffset();a.zarazData.q=[];for(;a.zaraz.q.length;){const e=a.zaraz.q.shift();a.zarazData.q.push(e)}z.defer=!0;for(const e of[localStorage,sessionStorage])Object.keys(e||{}).filter((a=>a.startsWith("_zaraz_"))).forEach((t=>{try{a.zarazData["z_"+t.slice(7)]=JSON.parse(e.getItem(t))}catch{a.zarazData["z_"+t.slice(7)]=e.getItem(t)}}));z.referrerPolicy="origin";z.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(a.zarazData)));t.parentNode.insertBefore(z,t)};["complete","interactive"].includes(e.readyState)?zaraz.init():a.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,0,"script");})(window,document);</script>


</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="login-logo">
<a href="#">Form Đăng nhập</a>
</div>

<div class="card">
<div class="card-body login-card-body">
<p class="login-box-msg">Sign in to start your session</p>


<form action="{{route('success.index')}}" method="POST">
  @csrf {{ csrf_field('email','password') }} 
  @method('POST')
<div class="input-group mb-3">
<input  type="email" name="email" class="form-control" placeholder="Email">
<div class="input-group-append">
<div class="input-group-text">
<span class="fas fa-envelope"></span>
</div>
</div>
</div>
<div class="input-group mb-3">
<input type="password" id="password" name="password" class="form-control" placeholder="Password">
<div class="input-group-append">
<div class="input-group-text">
<span class="fas fa-lock"></span>
</div>
</div>
</div>
<div class="row">
<div class="col-8">
<div class="icheck-primary">
<input type="checkbox" name="remember" id="remember">
<label for="remember">
Remember Me
</label>
</div>
</div>

<div class="col-4">
<a href="{{route('success.index')}}" type="submit" class="btn btn-primary btn-block">Sign In</a>
</div>

</div>
  
  <input type="hidden" name="_token" value="bGLfJJixkx6BHeM9CsbbwFFxBYTay3hQlHB6WL3L"></form>


<p class="mb-1">
<a href="forgot-password.html">I forgot my password</a>
</p>
<p class="mb-0">
<a href="{{route('register.store')}}" class="text-center">Register a new membership</a>
</p>
</div>

</div>
</div>

<script src="/template/admin/plugins/jquery/jquery.min.js"></script>

<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="/template/admin/dist/js/adminlte.min.js?v=3.2.0"></script>




</body>
</html>
