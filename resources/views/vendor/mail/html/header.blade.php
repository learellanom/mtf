@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="/img/AdminLTELogo.png" class="logo" alt="TioAmmi">
@if (trim($slot) === 'Laravel')

@else
{{ $slot }}
@endif
</a>
</td>
</tr>