@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('logo.svg') }}" class="logo" alt="ID Logistics Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
