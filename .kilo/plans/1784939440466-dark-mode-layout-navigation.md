# Plan: Dark mode for layout, navigation, and quotes index

## Context
- Tailwind uses default `media` strategy (`prefers-color-scheme: dark` media query) — no `darkMode` in `tailwind.config.js`.
- Only `quotes-table.blade.php` has dark mode classes today. All layout chrome renders light regardless of OS theme.
- Goal: extend `dark:` utility classes to the main layout, navigation menu, quotes index page, and related components.

## Files to modify (7 total)

### 1. `resources/views/layouts/app.blade.php`
| Element | Add dark classes |
|---------|-----------------|
| `<div class="min-h-screen bg-gray-100">` | `dark:bg-gray-900` |
| `<header class="bg-white shadow">` | `dark:bg-gray-800 dark:shadow-gray-900/50` |

### 2. `resources/views/navigation-menu.blade.php`
| Element / line | Add dark classes |
|---------------|-----------------|
| `<nav class="bg-white border-b border-gray-100">` (line 1) | `dark:bg-gray-800 dark:border-gray-700` |
| Hamburger `<button>` (line 135) | `dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 dark:focus:text-gray-300` |
| Responsive wrapper `<div>` (line 148) — `pt-4 pb-1 border-t border-gray-200` | `dark:border-gray-700` |
| Profile name `<div>` (line 157) — `text-gray-800` | `dark:text-gray-200` |
| Profile email `<div>` (line 158) — `text-gray-500` | `dark:text-gray-400` |
| Divider `<div class="border-t border-gray-200">` (lines 64, 117, 186, 205) | `dark:border-gray-600` (all 4 instances) |
| Section label `<div class="block px-4 py-2 text-xs text-gray-400">` (lines 47, 66, 188, 207) | `dark:text-gray-500` (all 4 instances) |
| Dropdown trigger buttons — `text-gray-500 bg-white hover:text-gray-700 focus:bg-gray-50 active:bg-gray-50` (lines 34, 90) | `dark:text-gray-300 dark:bg-gray-800 dark:hover:text-gray-100 dark:focus:bg-gray-700 dark:active:bg-gray-700` (2 instances) |

### 3. `resources/views/quotes/index.blade.php`
| Element / line | Add dark classes |
|---------------|-----------------|
| Header `<h2>` (line 3) — `text-gray-800 leading-tight` | `dark:text-gray-100` |
| Content wrapper `<div>` (line 10) — `bg-white overflow-hidden shadow-xl sm:rounded-lg` | `dark:bg-gray-800 dark:shadow-gray-900/50` |

### 4. `resources/views/components/nav-link.blade.php`
| State | Add dark classes |
|-------|-----------------|
| Active (line 5) — `border-indigo-400 text-gray-900` | `dark:border-indigo-300 dark:text-gray-100` |
| Inactive (line 6) — `border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300` | `dark:text-gray-300 dark:hover:text-gray-100 dark:hover:border-gray-400 dark:focus:text-gray-100 dark:focus:border-gray-400` |

### 5. `resources/views/components/responsive-nav-link.blade.php`
| State | Add dark classes |
|-------|-----------------|
| Active (line 5) — `border-indigo-400 text-indigo-700 bg-indigo-50 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700` | `dark:border-indigo-300 dark:text-indigo-300 dark:bg-indigo-900/50 dark:focus:text-indigo-200 dark:focus:bg-indigo-900/70 dark:focus:border-indigo-300` |
| Inactive (line 6) — `border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300` | `dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700/50 dark:hover:border-gray-600 dark:focus:text-gray-100 dark:focus:bg-gray-700/50 dark:focus:border-gray-600` |

### 6. `resources/views/components/dropdown-link.blade.php`
| Element | Add dark classes |
|---------|-----------------|
| `<a>` (line 1) — `text-gray-700 hover:bg-gray-100 focus:bg-gray-100` | `dark:text-gray-300 dark:hover:bg-gray-700/50 dark:focus:bg-gray-700/50` |

### 7. `resources/views/components/dropdown.blade.php`
| Element | Add dark classes |
|---------|-----------------|
| `$contentClasses` default (line 1) — `py-1 bg-white` | `py-1 bg-white dark:bg-gray-700` |
| Dropdown panel `<div>` (line 33) — `ring-1 ring-black ring-opacity-5` | `dark:ring-white/10` |

## Files NOT modified (out of scope)
- `banner.blade.php` — already uses dark-ish background colors (indigo/red/yellow).
- `guest.blade.php` — unauthenticated layout, not requested.
- `switchable-team.blade.php` — delegates to `dropdown-link`/`responsive-nav-link`, fixed transitively.
- `application-mark.blade.php` — logo SVG, no changes needed.
- `confirmation-modal.blade.php`, `danger-button`, `secondary-button`, `checkbox`, pagination views — not requested.

## Validation
1. Run `npm run build` to regenerate CSS with new `dark:` classes.
2. Open the app and verify:
   - With OS light theme: all pages look identical to before.
   - With OS dark theme: layout background is dark (`gray-900`), nav bar is dark (`gray-800`), nav links and dropdowns have dark-appropriate colors, quotes index header and container are dark-styled.
3. Test responsive menu (mobile) hamburger and dropdown in both themes.
