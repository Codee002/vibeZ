<div style="width: 600px; margin: auto; backgroud: rgba(22, 24, 35, 0.1); padding: 15px; border-radius: 5px">
    <h3>Xin chào {{ $user->name }}</h3>
    <p>{!! $content !!}</p>
    <a href="{{$token}}">{{$token}}</a>
</div>