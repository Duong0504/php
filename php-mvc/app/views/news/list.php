<h1>DANH SÁCH TIN TỨC</h1>
{{ $new_title }}<br/>
{{ $new_content }}<br/>
{{ 'Unicode' }}<br/>
{{toSlug('Tiêu đề bài viết')}}<br/>
{! $new_author !}<br/>
{{!empty($page_title)?$page_title:'Không có gì'}}<br/>
{{md5('123456')}}<br/>
@if (!empty($new_author))
<p>Tên tác giả: {{$new_author}}</p>
@else
<p>Không có gì</p>
@endif
@php
    $number = 1;
@endphp
{{$number}}

@for ($i =1; $i<= 5; $i++)
    <p>{{$i}}</p>
@endfor

@php
$i = 0;
@endphp
@while ($i<=10)
<p>{{$i}}</p>
@php
$i++
@endphp
@endwhile

@php 
    $data = [
        'Item 1',
        'Item 2',
        'Item 3'
    ];
@endphp
@foreach ($data as $key=>$value)
<p>Key = {{$key}} - Value = {{$value}}</p>
@endforeach