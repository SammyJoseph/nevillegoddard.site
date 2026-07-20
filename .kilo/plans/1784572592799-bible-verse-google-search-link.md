# Plan: Enlace de búsqueda en Google para versículo bíblico

## Objetivo
Hacer clicable el `<h3>` de `bible_verse` (línea 39 de `quote-display.blade.php`) para que abra una búsqueda de Google en el navegador externo.

## Contexto
- La app NO tiene PWA manifest ni service worker registrado.
- `target="_blank"` en un enlace `<a>` abre el navegador externo del dispositivo, no la misma pestaña.
- Google bloquea iframes (`X-Frame-Options: SAMEORIGIN`), así que modal con iframe queda descartado.

## Cambio

### Archivo: `resources/views/livewire/quote-display.blade.php`

**Línea 39 actual:**
```blade
<h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular">{{ $quote->bible_verse }}</h3>
```

**Reemplazar por:**
```blade
<a href="https://www.google.com/search?q={{ urlencode($quote->bible_verse) }}" target="_blank" rel="noopener noreferrer">
    <h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular hover:underline">{{ $quote->bible_verse }}</h3>
</a>
```

- `urlencode($quote->bible_verse)`: escapa correctamente caracteres especiales para la URL (espacios → `+` o `%20`, dos puntos, etc.).
- `target="_blank"`: abre en nueva pestaña/navegador externo.
- `rel="noopener noreferrer"`: seguridad, evita que la nueva página acceda a `window.opener`.
- `hover:underline`: feedback visual sutil de que es un enlace.

### Archivo: `resources/views/livewire/quote-display.blade.php` (else branch, línea 50)

El `<h3>` vacío del `@else` (cuando no hay quote) no necesita enlace porque no tiene valor de `bible_verse`.

## Riesgos
- **Ninguno.** Es un cambio aditivo, no rompe nada existente. Las animaciones de Alpine.js siguen funcionando porque el `<h3>` mantiene el mismo `x-ref` e `id`.

## Validación
1. Verificar que al hacer clic en el versículo se abra `https://www.google.com/search?q=...` en una nueva pestaña.
2. Verificar que las animaciones de fade-in sigan funcionando correctamente tras refrescar quote.
3. Verificar que en móvil (PWA o navegador) se abra en navegador externo.
