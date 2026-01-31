import os
import re

# --- CONFIGURATION ---

ROOT_DIR = os.getcwd()
ASSETS_DIR = os.path.join(ROOT_DIR, "assets", "temarios")
OUTPUT_DIR = os.path.join(ROOT_DIR, "curso")

CATEGORIES = {
    "Computacion": {
        "slug": "computacion",
        "name": "Computación",
        "image": "../../assets/temario_computacion.jpg"
    },
    "Mantencion y Produccion": {
        "slug": "mantencion",
        "name": "Mantención y Producción",
        "image": "../../assets/temario_mantencionYproduccion.jpg"
    },
    "Maquinas y Equipos": {
        "slug": "maquinas",
        "name": "Máquinas y Equipos",
        "image": "../../assets/temario_maquinasYequipos.jpg"
    },
    "Seguridad y Prevencion de riesgos": {
        "slug": "seguridad",
        "name": "Seguridad y Prevención de Riesgos",
        "image": "../../assets/temario_seguridadYprevencion.jpg"
    }
}

# --- TEMPLATE ---
# Based on the user provided attachment (complete structure)
TEMPLATE = """<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title_meta} | Selitec Capacitación</title>
    <meta name="description" content="{desc_meta}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles.css">

    <!-- Structured Data: Course + Organization + Breadcrumbs -->
    <script type="application/ld+json">
    {{
  "@context": "https://schema.org",
  "@graph": [
    {{
      "@type": "Organization",
      "@id": "https://www.selitec.cl/#organization",
      "name": "Selitec Capacitación",
      "url": "https://www.selitec.cl",
      "logo": {{
        "@type": "ImageObject",
        "url": "https://www.selitec.cl/assets/logo_selitec.jpg"
      }}
    }},
    {{
      "@type": "Course",
      "name": "{course_name_json}",
      "description": "{course_desc_json}",
      "provider": {{
        "@id": "https://www.selitec.cl/#organization"
      }},
      "courseCode": "{course_code}",
      "educationalLevel": "Profesional",
      "timeRequired": "{time_required}",
      "inLanguage": "es-CL",
      "availableLanguage": "es",
      "hasCourseInstance": {{
        "@type": "CourseInstance",
        "courseMode": "{mode_json}",
        "courseWorkload": "{time_required}",
        "instructor": {{
          "@type": "Organization",
          "@id": "https://www.selitec.cl/#organization"
        }}
      }},
      "about": {{
        "@type": "Thing",
        "name": "{category_name}"
      }},
      "offers": {{
        "@type": "Offer",
        "category": "Paid",
        "availability": "https://schema.org/InStock",
        "priceCurrency": "CLP"
      }}
    }},
    {{
      "@type": "BreadcrumbList",
      "itemListElement": [
        {{
          "@type": "ListItem",
          "position": 1,
          "name": "Inicio",
          "item": "https://www.selitec.cl/"
        }},
        {{
          "@type": "ListItem",
          "position": 2,
          "name": "Cursos",
          "item": "https://www.selitec.cl/cursos/"
        }},
        {{
          "@type": "ListItem",
          "position": 3,
          "name": "{category_name}",
          "item": "https://www.selitec.cl/cursos/?category={category_slug}"
        }},
        {{
          "@type": "ListItem",
          "position": 4,
          "name": "{course_short_name}",
          "item": "https://www.selitec.cl/curso/{slug}/"
        }}
      ]
    }}
  ]
}}
    </script>
</head>
<body>
    
    <!-- Barra Superior -->
    <div class="top-bar">
        <div class="container top-bar__content">
            <div class="top-bar__contact">
                <a href="tel:+56226385307" aria-label="Llamar a Selitec"><i class="fas fa-phone-alt" aria-hidden="true"></i> +56 2 2638 5307</a>
                <a href="tel:+56226397059" aria-label="Llamar a Selitec"><i class="fas fa-phone-alt" aria-hidden="true"></i> +56 2 2639 7059</a>
                <a href="mailto:contacto@selitec.cl" aria-label="Enviar correo a Selitec"><i class="fas fa-envelope" aria-hidden="true"></i> contacto@selitec.cl</a>
            </div>
            <div class="top-bar__trust">
                <span class="trust-badge"><i class="fas fa-check-circle" aria-hidden="true"></i> Certificación NCh 2728</span>
                <span class="trust-badge"><i class="fas fa-certificate" aria-hidden="true"></i> Certificado por Sence</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="site-header">
        <div class="container site-header__inner">
            <div class="site-logo">
                <a href="../../" aria-label="Volver al inicio">
                    <img src="../../assets/logo_selitec.jpg" alt="SELITEC" class="site-logo__img">
                </a>
            </div>

            <button class="mobile-menu-toggle" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="main-nav">
                <span class="hamburger-icon"></span>
            </button>

            <nav id="main-nav" class="main-nav">
                <ul class="main-nav__list">
                    <li><a href="../../" class="main-nav__link">Inicio</a></li>
                    <li><a href="../../cursos/" class="main-nav__link active">Cursos</a></li>
                    <li><a href="../../programacion/" class="main-nav__link">Programación Mensual</a></li>
                    <li><a href="../../nivelacion/" class="main-nav__link">Nivelación de Estudios</a></li>
                    <li><a href="../../empresa/" class="main-nav__link">Empresa</a></li>
                    <li><a href="../../clientes/" class="main-nav__link">Clientes</a></li>
                    <li><a href="../../contacto/" class="main-nav__link">Contacto</a></li>
                    <li><a href="https://www.selitec.cl/elearning" class="main-nav__link main-nav__link--highlight">Aula Virtual</a></li>
                </ul>
            </nav>
        </div>
    </header>


    <main class="course-page">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <div class="container">
                <ol>
                    <li><a href="../../index.html">Inicio</a></li>
                    <li><a href="../../cursos/">Cursos</a></li>
                    <li><a href="../../cursos/?category={category_slug}">{category_name}</a></li>
                    <li aria-current="page">{course_short_name}</li>
                </ol>
            </div>
        </nav>

        <section class="course-hero">
            <div class="container">
                <div class="course-hero__content">
                    <div class="course-hero__badges">
                        <span class="badge badge--technical">{category_name}</span>
                        <span class="badge badge--presencial">{modality}</span>
                    </div>
                    <h1 class="course-hero__title">{title}</h1>
                    <p class="course-hero__duration"><i class="fas fa-clock"></i> {hours} horas</p>
                    <p class="course-hero__description">
                        {description_short}
                    </p>
                </div>
                <div class="course-hero__image">
                    <img src="{hero_image}" alt="{title}">
                </div>
            </div>
        </section>

        <section class="course-content">
            <div class="container">
                <div class="course-content__grid">
                    <div class="course-content__main">
                        <div class="course-description mb-8">
                            <h2>Descripción del Curso</h2>
                            <p>
                                {description_long}
                            </p>
                        </div>

                        <div class="course-objectives mb-8">
                            <h2>Objetivos Generales</h2>
                            <p>
                                {objectives}
                            </p>
                        </div>

                        <div class="course-syllabus">
                            <h2>Contenido del Curso</h2>
                            <div class="syllabus-content">
                                <h3>Temario Detallado</h3>
                                <ul>
                                    {syllabus_li}
                                </ul>
                            </div>
                        </div>
                    </div>

                    <aside class="course-sidebar">
                        <div class="cta-box">
                            <h3>¿Te interesa este curso?</h3>
                            <a href="tel:+56225809262" class="btn btn--phone">
                                <i class="fas fa-phone"></i> Llamar ahora
                            </a>
                            <a href="../../contacto/" class="btn btn--secondary">
                                <i class="fas fa-envelope"></i> Enviar consulta
                            </a>
                        </div>

                        <div class="course-info-box">
                            <h3>Información del Curso</h3>
                            <ul>
                                <li>
                                    <i class="fas fa-clock"></i>
                                    <span><strong>Duración:</strong> {hours} horas</span>
                                </li>
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <span><strong>Categoría:</strong> {category_name}</span>
                                </li>
                                <li>
                                    <i class="fas fa-certificate"></i>
                                    <span><strong>Certificación:</strong> Disponible</span>
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><strong>Modalidad:</strong> {modality}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="download-box">
                            <h3>Descargar Temario</h3>
                            <a href="{pdf_link}" class="btn btn--download" {pdf_attr}>
                                <i class="fas fa-file-pdf"></i> {pdf_text}
                            </a>
                        </div>

                        <div class="related-courses">
                            <h3>Cursos Relacionados</h3>
                            <ul>
                                {related_courses_li}
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer__container">
            <div class="footer__column">
                <h3>Selitec Capacitación</h3>
                <p>Centro de capacitación técnica profesional con más de 20 años de experiencia.</p>
                <div class="footer__social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer__column">
                <h3>Cursos</h3>
                <ul>
                    <li><a href="../../cursos/?category=mantencion">Mantención y Producción</a></li>
                    <li><a href="../../cursos/?category=computacion">Computación</a></li>
                    <li><a href="../../cursos/?category=maquinas">Maquinas y Equipos</a></li>
                    <li><a href="../../cursos/?category=seguridad">Seguridad y Prevención</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h3>Contacto</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +56 2 2580 9262</li>
                    <li><i class="fas fa-envelope"></i> contacto@selitec.cl</li>
                    <li><i class="fas fa-map-marker-alt"></i> Santiago, Chile</li>
                </ul>
            </div>
            <div class="footer__column">
                <h3>Información</h3>
                <ul>
                    <li><a href="../../empresa/">Sobre Nosotros</a></li>
                    <li><a href="../../programacion/">Programación del Mes</a></li>
                    <li><a href="../../contacto/">Contacto</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <p>&copy; 2026 Selitec Capacitación. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../../app.js"></script>
</body>
</html>"""

# --- MAIN LOGIC: Process files from /temarios/ ONLY ---
def extract_hours_from_filename(filename):
    """Extract hours from filename like '(40 horas)' or '(35 Horas)'"""
    match = re.search(r'\((\d+)\s*[Hh]oras?\)', filename)
    if match:
        return match.group(1)
    return "Consultar"

def clean_title(raw_name):
    """Remove file extension and hours from title"""
    title = os.path.splitext(raw_name)[0].strip()
    # Remove (XX horas) from title
    title = re.sub(r'\s*\(\d+\s*[Hh]oras?\)\s*', '', title)
    return title.strip()

def generate_slug(title):
    """Generate SEO-friendly slug"""
    slug = title.lower()
    # Remove accents
    replacements = {
        'á': 'a', 'é': 'e', 'í': 'i', 'ó': 'o', 'ú': 'u',
        'ñ': 'n', 'ü': 'u'
    }
    for old, new in replacements.items():
        slug = slug.replace(old, new)
    # Replace spaces with hyphens
    slug = re.sub(r'\s+', '-', slug)
    # Remove special chars except hyphens
    slug = re.sub(r'[^a-z0-9-]', '', slug)
    # Remove multiple consecutive hyphens
    slug = re.sub(r'-+', '-', slug)
    return slug.strip('-')

def process_category(cat_folder, cat_config):
    """Process all course files in a category folder from /temarios/"""
    folder_path = os.path.join(ASSETS_DIR, cat_folder)
    if not os.path.exists(folder_path):
        print(f"⚠️  Category folder not found: {folder_path}")
        return []

    # Get all valid course files (exclude system files)
    all_files = os.listdir(folder_path)
    files = [f for f in all_files
             if f.lower().endswith(('.docx', '.doc', '.pdf')) 
             and not f.startswith('~$')
             and not f.startswith('.')
             and f != '.DS_Store']
    
    courses = []
    
    for filename in files:
        # Extract order from numeric prefix (MUST match at start)
        match = re.match(r'^(\d+)[-.\s]+(.*)$', filename)
        if match:
            order_idx = int(match.group(1))
            raw_name = match.group(2)
        else:
            # No number = goes to end, use alphabetical with high number
            order_idx = 10000
            raw_name = filename
        
        # Extract metadata from filename
        hours = extract_hours_from_filename(raw_name)
        title = clean_title(raw_name)
        slug = generate_slug(title)
        
        # Build course data
        course_data = {
            'order': order_idx,
            'filename': filename,
            'slug': slug,
            'title': title,
            'category': cat_config,
            'cat_folder_name': cat_folder,
            'hours': hours,
            'modality': 'Presencial',  # Default
            'desc_short': f"Curso técnico especializado en {cat_config['name']}.",
            'desc_long': f"El curso de <strong>{title}</strong> está diseñado para entregar competencias técnicas específicas en el área de {cat_config['name']}, orientado a la práctica profesional y el cumplimiento de normativas vigentes.",
            'objectives': f"Al finalizar este curso, los participantes serán capaces de aplicar las técnicas y conocimientos adquiridos de manera efectiva en su desempeño laboral, cumpliendo con los estándares de calidad y seguridad requeridos."
        }
        
        courses.append(course_data)
    
    # Sort by order number, then alphabetically
    courses.sort(key=lambda x: (x['order'], x['title']))
    
    return courses

def generate_html(courses):
    """Generate HTML pages for all courses"""
    
    for i, course in enumerate(courses):
        # Calculate related courses (3 closest in order within same category)
        related = []
        same_category = [c for c in courses if c['category']['slug'] == course['category']['slug']]
        current_idx = same_category.index(course)
        
        # Get 3 related: next 2 and previous 1 (or variations)
        if len(same_category) > 1:
            for offset in [1, 2, -1]:
                idx = (current_idx + offset) % len(same_category)
                if idx != current_idx and same_category[idx] not in related:
                    related.append(same_category[idx])
                if len(related) >= 3:
                    break
        
        # Build metadata
        title = course['title']
        hours = course['hours']
        title_meta = f"{title} ({hours} Horas)" if hours != "Consultar" else title
        slug = course['slug']
        
        # Create output directory
        out_path = os.path.join(OUTPUT_DIR, slug)
        os.makedirs(out_path, exist_ok=True)
        
        # Generate course code
        cat_abbrev = {
            'computacion': 'COMP',
            'mantencion': 'MP',
            'maquinas': 'ME',
            'seguridad': 'SPR'
        }
        course_code = f"SELITEC-{cat_abbrev.get(course['category']['slug'], 'GEN')}-{course['order']:03d}"
        
        # PDF link
        pdf_file = course['filename']
        pdf_path_rel = f"../../assets/temarios/{course['cat_folder_name']}/{pdf_file}"
        
        # Related courses HTML
        rel_html = ""
        for r in related:
            rel_html += f'                                <li><a href="../{r["slug"]}/">{r["title"]}</a></li>\n'
        
        if not rel_html:
            rel_html = "                                <li>Consulte nuestro catálogo completo</li>\n"
        
        # Time required for JSON-LD
        time_required = f"PT{hours}H" if hours.isdigit() else "PT0H"
        
        # Escape quotes for JSON
        desc_json = course['desc_short'].replace('"', '\\"')
        
        # Generate HTML
        html = TEMPLATE.format(
            title_meta=title_meta,
            desc_meta=course['desc_short'],
            course_name_json=title,
            course_desc_json=desc_json,
            course_code=course_code,
            time_required=time_required,
            mode_json="onsite",
            category_name=course['category']['name'],
            category_slug=course['category']['slug'],
            course_short_name=title,
            slug=slug,
            title=title,
            hours=hours,
            description_short=course['desc_short'],
            hero_image=course['category']['image'],
            description_long=course['desc_long'],
            objectives=course['objectives'],
            syllabus_li="<li>Contenido técnico especializado</li>\n                                    <li>Prácticas aplicadas al entorno laboral</li>\n                                    <li>Normativas y estándares vigentes</li>\n                                    <li>Evaluación de competencias</li>",
            modality=course['modality'],
            pdf_link=pdf_path_rel,
            pdf_text="Descargar PDF",
            pdf_attr="download",
            related_courses_li=rel_html.rstrip('\n')
        )
        
        # Write HTML file
        with open(os.path.join(out_path, "index.html"), "w", encoding='utf-8') as f:
            f.write(html)
    
    return courses

# --- EXECUTE ---
print("=" * 60)
print("GENERADOR DE CURSOS - Fuente: /temarios/ únicamente")
print("=" * 60)

all_courses_flat = []

for folder, config in CATEGORIES.items():
    print(f"\n📁 Procesando categoría: {config['name']}")
    processed = process_category(folder, config)
    print(f"   ✓ {len(processed)} cursos encontrados")
    all_courses_flat.extend(processed)

print(f"\n📊 Total de cursos: {len(all_courses_flat)}")
print("\n🔨 Generando páginas HTML...")
generate_html(all_courses_flat)

# Generate cursos-data.js
print("\n📝 Actualizando cursos-data.js...")
with open('cursos-data.js', 'w', encoding='utf-8') as f:
    f.write("// Auto-generated from /temarios/ - DO NOT EDIT MANUALLY\n")
    f.write("// Source of truth: assets/temarios/\n\n")
    f.write("const CURSOS_DATA = [\n")
    for i, c in enumerate(all_courses_flat):
        f.write(f"    {{\n")
        f.write(f"        'id': {i+1},\n")
        f.write(f"        'slug': '{c['slug']}',\n")
        f.write(f"        'category': '{c['category']['slug']}',\n")
        f.write(f"        'title': '{c['title']}',\n")
        f.write(f"        'shortTitle': '{c['title']}',\n")
        f.write(f"        'modality': '{c['modality'].lower()}',\n")
        f.write(f"        'hours': '{c['hours']}',\n")
        desc_safe = c['desc_short'].replace("'", "\\'").replace('\n', ' ').replace('\r', '')
        f.write(f"        'desc': '{desc_safe}',\n")
        pdf_path = f"../assets/temarios/{c['cat_folder_name']}/{c['filename']}"
        f.write(f"        'pdf': '{pdf_path}',\n")
        img_path = c['category']['image'].replace("../../", "../")
        f.write(f"        'image': '{img_path}'\n")
        f.write(f"    }}")
        if i < len(all_courses_flat) - 1:
            f.write(",")
        f.write("\n")
    f.write("];\n")

print("\n✅ GENERACIÓN COMPLETA")
print(f"   • {len(all_courses_flat)} páginas HTML creadas en /curso/")
print(f"   • cursos-data.js actualizado")
print("\n" + "=" * 60)
