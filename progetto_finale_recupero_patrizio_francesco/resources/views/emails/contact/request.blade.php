<x-mail::message>
# Nuova Richiesta di Contatto Ricevuta

Hai ricevuto un nuovo messaggio dal form di contatto del sito.

**Da:** {{ $data['name'] }}
**Email del Mittente:** {{ $data['email'] }}

---

**Messaggio:**

{{ $data['message'] }}

---

Grazie,
{{ config('app.name') }}
</x-mail::message>