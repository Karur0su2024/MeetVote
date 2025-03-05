@props(['vote'])
@php

$hasPermission = request()->get('isPollAdmin', false) || (!is_null($vote['user_id']) && (Auth::id() === $vote['user_id']));

@endphp


<tr>
    <td>{{ $vote['voter_name'] }}</td>
    <td>{{ $vote['updated_at'] }}</td>
    <td>
        @if ($hasPermission)
            <button class="btn btn-warning" wire:click='loadVote({{$vote['id']}})'>Edit vote</button>
        @endif
    </td>
    <td>
        @if ($hasPermission)
            <button class="btn btn-danger" wire:click='deleteVote({{$vote['id']}})'>Delete vote</button>
        @endif
    </td>
</tr>