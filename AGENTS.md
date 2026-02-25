# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

Static website for **Selitec Capacitación**, a Chilean OTEC (Organismo Técnico de Capacitación) offering SENCE-certified technical courses. The site is conversion-focused (WhatsApp, phone, contact form) with an SEO-first multi-page architecture. Hosted via GitHub Pages at `selitec.mattias.cl`.

## Build & Dev Commands

```
npm run dev        # Start Vite dev server (local development)
npm run build      # Build for production (output to dist/)
npm run preview    # Preview production build locally
```

### Course Page Generation

Course pages under `curso/` and the catalog data file `cursos-data.js` are **auto-generated** from `.docx` temarios. Do NOT edit these files manually.

```
python generate_courses.py   # Requires python-docx: pip install python-docx
```

This reads from `assets/temarios/` and outputs:
- Individual HTML pages in `curso/{slug}/index.html`
- The `cursos-data.js` file (consumed by the catalog filter on `cursos/index.html`)

## Architecture

### Tech Stack
- **HTML5 + CSS + Vanilla JS** — no frameworks, no bundler for the HTML/CSS (Vite is used only for dev server/build)
- **CSS**: Single `styles.css` with design tokens in `:root` variables
- **JS**: Single `app.js` with all client-side behavior
- **Python**: `generate_courses.py` for static page generation from DOCX source files

### Page Structure (multi-page, each has its own `index.html`)
- `/` — Landing page (`index.html`)
- `/cursos/` — Course catalog with client-side filters (search, category, modality)
- `/curso/{slug}/` — Individual course pages (auto-generated, do NOT edit manually)
- `/programacion/` — Monthly schedule
- `/nivelacion/` — Study leveling
- `/empresa/` — Company info
- `/clientes/` — Client logos/carousel
- `/contacto/` — Contact form (mailto fallback)

### Key Data Flow
1. Source of truth for courses: **`.docx` files in `assets/temarios/`** organized by category folders
2. `generate_courses.py` parses these files → generates `curso/*/index.html` pages + `cursos-data.js`
3. `cursos-data.js` exposes `CURSOS_DATA` array globally, consumed by catalog filter logic in `app.js`
4. `app.js` renders course cards dynamically into `#courses-grid` on the catalog page

### app.js Sections
0. TypeWriter effect (hero)
1. Mobile menu toggle (supports two header styles: `.site-header` and `.header`)
2. Smooth scroll for anchor links
3. Accessible accordion (aria-expanded/aria-controls)
4. Catalog filters — checkbox-based category/modality filtering + text search; supports URL param `?category=` for deep-linking
5. Contact form → mailto fallback
6. Client logo carousel with auto-play

### CSS Organization
`styles.css` follows a token-first approach with sections numbered in comments:
1. Design tokens & variables (`:root`)
2. Reset & base styles
3. Utilities & layout (container, grid, section)
4. Components (buttons, cards, badges, etc.)

### Course Categories (used in filters and generation)
- `mantencion` — Mantención y Producción
- `maquinas` — Máquinas y Equipos
- `seguridad` — Seguridad y Prevención de Riesgos
- `computacion` — Computación

## Design Constraints (from copilot-instructions.md)

### Brand Colors (do not invent new primaries)
- Primary: `#262262`, Secondary: `#38ACD8`
- UI blues: `#099AD1`, `#2EA4D1`, `#1382AE`
- Accents: `#E7964B`, `#F9B44E`, `#ECAC63`
- All tokens defined in `:root` in `styles.css`

### Non-negotiables
- **SEO-first**: one unique H1 per page, clean titles/meta, structured data (Organization, Course, BreadcrumbList, FAQPage)
- **Accessibility**: WCAG 2.2 AA — visible focus states, keyboard nav, proper headings, labels, ARIA only when needed, sufficient contrast
- **Performance**: no heavy libraries, lazy-load below fold, reserve image dimensions, minimal JS
- **PDF policy**: PDFs are optional downloads only; schedule and course core content must be native HTML
- **Audience**: adult/older learners — base font ≥ 16px, high contrast, large touch targets, simple UX
- **Responsiveness**: must work well across mobile, tablet, desktop, and large monitors

### Shared Layout
Every page repeats the same top-bar (contact info + trust badges), header/nav, and footer. When modifying these, update all pages consistently. The nav has 8 items: Inicio, Cursos, Programación Mensual, Nivelación de Estudios, Empresa, Clientes, Contacto, Aula Virtual.

### WordPress Readiness
Structure components cleanly so they can become WP templates later. No page builder assumptions.

## Structured Data
- **Organization** schema on every page
- **Course** schema on each `curso/` page (auto-generated)
- **BreadcrumbList** on course pages
- **FAQPage** on catalog page
- **WebSite** with SearchAction on homepage

## Hosting & Config
- GitHub Pages via CNAME (`selitec.mattias.cl`)
- `_headers` — Cloudflare/Netlify-style security + cache headers
- `.htaccess` — Apache security headers, gzip, and cache rules
- `sitemap.xml` and `robots.txt` present at root
