<x-mail::message>
# {{ $contact->subject }}

**{{ $contact->name }}** · {{ $contact->email }}

{{ $contact->body }}

Language: {{ strtoupper($contact->locale ?? '') }}
</x-mail::message>
