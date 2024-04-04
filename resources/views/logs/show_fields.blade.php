<!-- Http Method Field -->
<div class="col-sm-12">
    {!! Form::label('http_method', 'Http Method:') !!}
    <p>{{ $log->http_method }}</p>
</div>

<!-- Url Field -->
<div class="col-sm-12">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $log->url }}</p>
</div>

<!-- Http Status Field -->
<div class="col-sm-12">
    {!! Form::label('http_status', 'Http Status:') !!}
    <p>{{ $log->http_status }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $log->user_id }}</p>
</div>

<!-- Ip Address Field -->
<div class="col-sm-12">
    {!! Form::label('ip_address', 'Ip Address:') !!}
    <p>{{ $log->ip_address }}</p>
</div>

<!-- User Agent Field -->
<div class="col-sm-12">
    {!! Form::label('user_agent', 'User Agent:') !!}
    <p>{{ $log->user_agent }}</p>
</div>

